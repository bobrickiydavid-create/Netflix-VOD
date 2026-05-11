<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Jeśli masz hasło w XAMPP, wpisz je tutaj
$dbname = 'vod_platform_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}
// Ustawienie kodowania znaków na UTF-8 (dla polskich znaków)
$conn->set_charset("utf8mb4");
?>