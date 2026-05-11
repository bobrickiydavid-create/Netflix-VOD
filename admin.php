<?php
session_start(); // Rozpoczyna sesję (pozwala przeglądarce zapamiętać, że admin jest zalogowany)
require 'db.php'; // Dołącza plik z połączeniem do bazy danych, żebyśmy mogli na niej operować

$password_admin = "admin123"; // Ustawia stałe hasło dostępu do panelu administratora

// LOGOWANIE
if (isset($_POST['login'])) { // Sprawdza, czy formularz logowania został wysłany (czy kliknięto "Zaloguj")
    if ($_POST['pass'] == $password_admin) $_SESSION['auth'] = true; // Jeśli wpisane hasło zgadza się z naszym, tworzy zmienną sesyjną 'auth' (autoryzacja)
    else $error = "Błędne hasło!"; // W przeciwnym razie ustawia komunikat o błędzie
}

// WYLOGOWYWANIE
if (isset($_GET['logout'])) { // Sprawdza, czy w adresie URL jest parametr ?logout=1 (kliknięto link "Wyloguj")
    session_destroy(); // Całkowicie niszczy sesję, usuwając status zalogowania
    header("Location: admin.php"); // Przekierowuje użytkownika z powrotem na stronę logowania
}

// OCHRONA STRONY (BLOKADA DLA NIEZALOGOWANYCH)
if (!isset($_SESSION['auth'])) { // Jeśli zmienna 'auth' NIE istnieje (czyli ktoś nie podał poprawnego hasła)
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS dla formularza logowania (wygląd okienka, przycisków itp.) */
        .login-box { width: 300px; margin: 150px auto; background: #222; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.5); }
        input { width: 90%; padding: 12px; margin: 10px 0; background: #333; color: white; border: 1px solid #444; border-radius: 4px; outline: none; }
        button { width: 98%; padding: 12px; background: #E50914; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-size: 16px; transition: 0.3s; }
        button:hover { background: #f40612; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="color:white; margin-top:0;">Panel Admina</h2>
        <?php if(isset($error)) echo "<p style='color:#E50914'>$error</p>"; ?>
        
        <form method="POST">
            <input type="password" name="pass" placeholder="Wpisz hasło" required>
            <button type="submit" name="login">Zaloguj</button>
        </form>
        <a href="index.php" style="color:#aaa; display:block; margin-top:20px; text-decoration:none;">Wróć do strony głównej</a>
    </div>
</body>
</html>
<?php
exit; // BARDZO WAŻNE: Zatrzymuje dalsze wykonywanie kodu. Jeśli ktoś nie jest zalogowany, zobaczy tylko kod powyżej, a to co poniżej w ogóle się nie wczyta.
}

// ====================================================================
// TUTAJ ZACZYNA SIĘ WŁAŚCIWY PANEL ADMINA (DOSTĘPNY TYLKO PO ZALOGOWANIU)
// ====================================================================

$message = ''; // Pusta zmienna, do której będziemy przypisywać komunikaty o sukcesie lub błędzie

// DODAWANIE FILMU
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_movie'])) { // Sprawdza, czy wysłano formularz z dodawaniem filmu
    // Przygotowuje bezpieczne zapytanie SQL. Znaki zapytania chronią nas przed atakami typu SQL Injection
    $stmt = $conn->prepare("INSERT INTO movies (title, image_url, trailer_url, description) VALUES (?, ?, ?, ?)");
    
    // Podpina dane z formularza w miejsce znaków zapytania ("ssss" oznacza, że wstawiamy 4 zmienne typu String/Tekst)
    $stmt->bind_param("ssss", $_POST['title'], $_POST['image_url'], $_POST['trailer_url'], $_POST['description']);
    
    // Wykonuje zapytanie SQL w bazie
    if ($stmt->execute()) $message = "<p style='color: #46d369;'>✅ Film dodany pomyślnie!</p>"; 
}

// USUWANIE FILMU
if (isset($_GET['delete_id'])) { // Sprawdza, czy w linku przekazano ID filmu do usunięcia (np. ?delete_id=5)
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?"); // Przygotowuje zapytanie usuwające konkretny rekord
    $stmt->bind_param("i", $_GET['delete_id']); // Podpina przekazane ID w miejsce znaku zapytania ("i" oznacza Integer/Liczbę całkowitą)
    $stmt->execute(); // Wykonuje usuwanie w bazie
    $message = "<p style='color: #E50914;'>🗑️ Film został usunięty!</p>";
}

// POBIERANIE LISTY FILMÓW DO WYŚWIETLENIA W PANELU
// Zwykłe zapytanie (bez znaków zapytania, bo nie używamy tu danych od użytkownika). ORDER BY id DESC sortuje filmy od najnowszego.
$result = $conn->query("SELECT * FROM movies ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zarządzanie - Mój Netflix</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Proste style specjalnie dla panelu administracyjnego */
        .admin-container { max-width: 800px; margin: 80px auto; background: #181818; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.6); }
        .movie-item { display: flex; justify-content: space-between; align-items: center; background: #222; padding: 15px; margin: 10px 0; border-radius: 4px; }
        .btn-delete { color: #fff; background: #E50914; text-decoration: none; font-weight: bold; padding: 8px 15px; border-radius: 4px; transition: 0.3s; }
        .btn-delete:hover { background: #f40612; }
        input, textarea { width: 95%; margin-bottom: 15px; background: #333; color: white; border: 1px solid #444; padding: 12px; border-radius: 4px; }
        .btn-add { background: #E50914; color: white; border: none; padding: 15px; width: 98%; cursor: pointer; border-radius: 4px; font-weight: bold; font-size: 16px; }
    </style>
</head>
<body>
    <header id="main-header" style="background: #141414;">
        <a href="index.php" class="logo">NETFLIX</a>
        <nav><a href="?logout=1" style="color: #aaa;">Wyloguj</a></nav> </header>

    <div class="admin-container">
        <h2>Dodaj nowy film</h2>
        <?php echo $message; ?> <form method="POST">
            <input type="hidden" name="add_movie" value="1"> <input type="text" name="title" placeholder="Tytuł filmu" required>
            <input type="text" name="image_url" placeholder="Link do plakatu (lokalny np. img/m1.jpg)" required>
            <input type="text" name="trailer_url" placeholder="Link do zwiastuna (YouTube)" required>
            <textarea name="description" placeholder="Opis filmu" rows="4" required></textarea>
            <button type="submit" class="btn-add">Dodaj Film</button>
        </form>

        <hr style="border: 1px solid #333; margin: 40px 0;">
        <h2>Zarządzaj bazą filmów</h2>
        
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="movie-item">
                <span style="font-size: 16px; font-weight: bold;"><?php echo htmlspecialchars($row['title']); ?></span>
                
                <a href="?delete_id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Na pewno chcesz usunąć ten film?')">Usuń</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
