<?php
// Helper koneksi database cPanel Sakuci
$dbHost = 'localhost';
$dbPort = 3306;
$dbName = 'db_perpus_ukk';
$dbUser = 'db_perpus_ukk_f572d';
$dbPass = 'f9af87db8b4cc8b10e85419c';

try {
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}
