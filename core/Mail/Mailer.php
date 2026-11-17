<?php

namespace Sakuci\Mail;

/**
 * Pengirim email ringan tanpa Composer.
 *
 * - MAIL_HOST terisi  -> kirim lewat SMTP (SSL / STARTTLS + AUTH LOGIN).
 * - MAIL_HOST kosong  -> pakai mail() bawaan PHP.
 *
 * Mailer::send() tidak pernah melempar exception: hasilnya true/false dan
 * alasan gagal bisa dibaca lewat Mailer::lastError(), supaya kegagalan email
 * tidak merusak proses utama (mis. persetujuan akun).
 */
class Mailer
{
    protected static string $lastError = '';

    /** @var resource|null */
    protected $socket = null;

    protected array $config;

    public function __construct(?array $config = null)
    {
        $this->config = $config ?? (array) config('mail', []);
    }

    public static function lastError(): string
    {
        return static::$lastError;
    }

    public static function send(string $to, string $subject, string $html, ?string $text = null, ?array $config = null): bool
    {
        static::$lastError = '';

        try {
            (new static($config))->deliver($to, $subject, $html, $text);

            return true;
        } catch (\Throwable $e) {
            static::$lastError = $e->getMessage();
            error_log('[Mailer] Gagal kirim ke ' . $to . ': ' . $e->getMessage());

            return false;
        }
    }

    /* ------------------------------------------------------------------ */

    protected function deliver(string $to, string $subject, string $html, ?string $text): void
    {
        $to = $this->cleanHeader($to);

        if (! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Alamat email tujuan tidak valid.');
        }

        $from = $this->cleanHeader((string) ($this->config['from_address'] ?? ''));

        if ($from === '') {
            $from = $this->cleanHeader((string) ($this->config['username'] ?? ''));
        }

        if (! filter_var($from, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('MAIL_FROM_ADDRESS belum diatur di .env.');
        }

        $fromName = $this->cleanHeader((string) ($this->config['from_name'] ?? ''));
        $text   ??= trim(html_entity_decode(strip_tags(preg_replace('#<br\s*/?>|</p>#i', "\n", $html)), ENT_QUOTES, 'UTF-8'));

        $boundary = 'b' . bin2hex(random_bytes(12));
        $subjectH = $this->encodeHeader($this->cleanHeader($subject));
        $fromH    = ($fromName !== '' ? $this->encodeHeader($fromName) . ' ' : '') . '<' . $from . '>';

        $headers = [
            'Date: ' . date('r'),
            'From: ' . $fromH,
            'Message-ID: <' . bin2hex(random_bytes(10)) . '@' . (substr(strrchr($from, '@'), 1) ?: 'localhost') . '>',
            'MIME-Version: 1.0',
            'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
        ];

        $body = '--' . $boundary . "\r\n"
            . "Content-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
            . chunk_split(base64_encode($text)) . "\r\n"
            . '--' . $boundary . "\r\n"
            . "Content-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
            . chunk_split(base64_encode($html)) . "\r\n"
            . '--' . $boundary . "--\r\n";

        if (($this->config['host'] ?? '') === '') {
            $this->viaMail($to, $subjectH, $headers, $body);

            return;
        }

        $this->viaSmtp($from, $to, array_merge($headers, ['To: <' . $to . '>', 'Subject: ' . $subjectH]), $body);
    }

    protected function viaMail(string $to, string $subjectH, array $headers, string $body): void
    {
        if (! function_exists('mail')) {
            throw new \RuntimeException('Fungsi mail() tidak tersedia; isi MAIL_HOST untuk memakai SMTP.');
        }

        if (! @mail($to, $subjectH, $body, implode("\r\n", $headers))) {
            throw new \RuntimeException('mail() gagal mengirim; isi MAIL_HOST untuk memakai SMTP.');
        }
    }

    protected function viaSmtp(string $from, string $to, array $headers, string $body): void
    {
        $host       = (string) $this->config['host'];
        $port       = (int) ($this->config['port'] ?? 587);
        $encryption = strtolower((string) ($this->config['encryption'] ?? ''));
        $timeout    = (int) ($this->config['timeout'] ?? 15);
        $ehlo       = gethostname() ?: 'localhost';

        $remote = ($encryption === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . $port;
        $this->socket = @stream_socket_client($remote, $errno, $errstr, $timeout);

        if (! $this->socket) {
            throw new \RuntimeException("Tidak bisa terhubung ke SMTP {$host}:{$port} ({$errstr})");
        }

        stream_set_timeout($this->socket, $timeout);

        try {
            $this->expect(220);
            $this->command('EHLO ' . $ehlo, 250);

            if ($encryption === 'tls') {
                $this->command('STARTTLS', 220);

                if (! stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    throw new \RuntimeException('Gagal mengaktifkan enkripsi TLS.');
                }

                $this->command('EHLO ' . $ehlo, 250);
            }

            if (($this->config['username'] ?? '') !== '') {
                $this->command('AUTH LOGIN', 334);
                $this->command(base64_encode((string) $this->config['username']), 334);
                $this->command(base64_encode((string) ($this->config['password'] ?? '')), 235);
            }

            $this->command('MAIL FROM:<' . $from . '>', 250);
            $this->command('RCPT TO:<' . $to . '>', [250, 251]);
            $this->command('DATA', 354);

            // Dot-stuffing: baris yang diawali "." harus digandakan.
            $message = implode("\r\n", $headers) . "\r\n\r\n" . $body;
            $message = preg_replace('/^\./m', '..', str_replace(["\r\n", "\r"], "\n", $message));
            $message = str_replace("\n", "\r\n", $message);

            $this->command($message . "\r\n.", 250);
            $this->write('QUIT');
        } finally {
            if (is_resource($this->socket)) {
                fclose($this->socket);
            }

            $this->socket = null;
        }
    }

    /** Kirim satu perintah SMTP lalu pastikan kode balasannya sesuai. */
    protected function command(string $line, int|array $expected): string
    {
        $this->write($line);

        return $this->expect($expected);
    }

    protected function write(string $line): void
    {
        if (@fwrite($this->socket, $line . "\r\n") === false) {
            throw new \RuntimeException('Koneksi SMTP terputus saat mengirim data.');
        }
    }

    /** Baca balasan (bisa multi-baris "250-...") dan cek kodenya. */
    protected function expect(int|array $expected): string
    {
        $expected = (array) $expected;
        $response = '';

        while (($line = fgets($this->socket, 1024)) !== false) {
            $response .= $line;

            if (strlen($line) < 4 || $line[3] === ' ') {
                break;
            }
        }

        $code = (int) substr($response, 0, 3);

        if (! in_array($code, $expected, true)) {
            throw new \RuntimeException('SMTP: ' . (trim($response) ?: 'tidak ada balasan dari server'));
        }

        return $response;
    }

    /** Cegah header injection. */
    protected function cleanHeader(string $value): string
    {
        return trim(str_replace(["\r", "\n", "\0"], '', $value));
    }

    protected function encodeHeader(string $value): string
    {
        return preg_match('/[^\x20-\x7E]/', $value)
            ? '=?UTF-8?B?' . base64_encode($value) . '?='
            : $value;
    }
}
