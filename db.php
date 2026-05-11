<?php
// Ustawiamy dane dostępowe do naszego serwera MySQL w XAMPP
$host = 'localhost'; // Adres serwera bazy danych (w naszym przypadku to nasz własny komputer, czyli "lokalny host")
$user = 'root'; // Domyślny użytkownik w XAMPP, który ma najwyższe uprawnienia (tzw. korzeń/administrator)
$pass = ''; // Hasło dla użytkownika 'root' (w czystym, świeżym XAMPP zawsze jest puste)
$dbname = 'vod_platform_db'; // Nazwa naszej konkretnej bazy danych, z której chcemy pobierać filmy

// Tworzy nowe połączenie z bazą przy użyciu zorientowanego obiektowo interfejsu MySQLi
// Zmienna $conn (od słowa 'connection') będzie od teraz używana w całym projekcie do komunikacji z bazą
$conn = new mysqli($host, $user, $pass, $dbname);

// Sprawdza, czy wystąpił jakikolwiek błąd podczas próby połączenia (np. wyłączony moduł MySQL w XAMPP lub zła nazwa bazy)
if ($conn->connect_error) {
    // Funkcja die() natychmiast zatrzymuje ładowanie reszty strony (zabija skrypt) i wypisuje dokładną przyczynę błędu na ekranie
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}

// Ustawienie kodowania znaków na UTF-8 (a dokładnie utf8mb4, które jest nowsze i bezpieczniejsze). 
// Dzięki temu polskie znaki z bazy (ą, ę, ł, ś) wyświetlają się poprawnie i nie zamieniają się w "krzaczki" ().
$conn->set_charset("utf8mb4");
?>
