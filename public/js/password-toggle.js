/*
| Tombol mata untuk melihat / menyembunyikan password.
*/
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.password-field').forEach(function (field) {
        var input = field.querySelector('input');
        var tombol = field.querySelector('.password-toggle');
        if (!input || !tombol) {
            return;
        }

        tombol.addEventListener('click', function () {
            var tampilkan = input.type === 'password';

            input.type = tampilkan ? 'text' : 'password';
            field.classList.toggle('is-shown', tampilkan);
            tombol.setAttribute('aria-pressed', tampilkan ? 'true' : 'false');
            tombol.setAttribute('aria-label', tampilkan ? 'Sembunyikan password' : 'Tampilkan password');
            input.focus();
        });
    });
});