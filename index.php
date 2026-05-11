<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"> <title>Mój Netflix</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div id="preloader">
        <div class="logo">NETFLIX</div>
    </div>

    <?php
    require 'db.php'; // Łączy tę stronę z bazą danych (wczytuje plik db.php)
    
    // WYSZUKIWARKA: Sprawdza, czy w pasku adresu jest parametr 'search' (np. index.php?search=Batman)
    // Funkcja trim() usuwa niepotrzebne spacje na początku i końcu wpisanego tekstu.
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    // Jeśli ktoś coś wpisał w szukajkę, tworzymy fragment zapytania SQL z filtrem (WHERE).
    // real_escape_string() to super ważne zabezpieczenie przed atakami hakerskimi (SQL Injection).
    $where_clause = $search ? "WHERE title LIKE '%" . $conn->real_escape_string($search) . "%'" : "";
    
    // Pełne zapytanie SQL: pobiera wszystkie filmy, opcjonalnie filtruje po nazwie ($where_clause) i sortuje od najnowszego (DESC)
    $query = "SELECT * FROM movies $where_clause ORDER BY id DESC";
    $result = $conn->query($query); // Wykonuje zapytanie i zapisuje wynik do zmiennej $result

    // GŁÓWNY BANER (HERO): Chcemy pobrać tylko jeden, najnowszy film z bazy
    $hero_query = "SELECT * FROM movies ORDER BY id DESC LIMIT 1"; // LIMIT 1 oznacza "pobierz tylko jeden rekord"
    $hero_res = $conn->query($hero_query);
    $hero = $hero_res->fetch_assoc(); // Zapisuje dane tego jednego filmu do tablicy $hero
    ?>

    <header id="main-header">
        <a href="index.php" class="logo">NETFLIX</a>
        
        <form class="search-form" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Szukaj filmu..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn-search">🔍</button>
        </form>
        <nav>
            <a href="admin.php">Panel Admina</a> </nav>
    </header>

    <?php if ($hero && !$search): ?>
    <section class="hero" style="background-image: linear-gradient(to right, rgba(20,20,20,0.95), rgba(20,20,20,0)), url('<?php echo htmlspecialchars($hero['image_url']); ?>');">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo htmlspecialchars($hero['title']); ?></h1>
            <p class="hero-desc"><?php echo htmlspecialchars($hero['description']); ?></p>
            
            <button class="hero-btn" onclick="openModal('<?php echo $hero['id']; ?>', '<?php echo addslashes($hero['title']); ?>', '<?php echo addslashes($hero['description']); ?>', '<?php echo $hero['trailer_url']; ?>', '<?php echo htmlspecialchars($hero['image_url']); ?>')">▶ Oglądaj zwiastun</button>
        </div>
    </section>
    
    <h2 style="padding: 0 50px; margin-top: 30px; position: relative; z-index: 20; color: white;">Moja Lista</h2>
    <div id="my-list-container" class="movie-grid" style="margin-top: 10px; padding-top: 10px; padding-bottom: 20px;">
        </div>
    
    <h2 style="padding: 0 50px; margin-top: 10px; position: relative; z-index: 20; color: white;">Wszystkie filmy</h2>
    <?php endif; // Koniec bloku, który ukrywa baner i sekcję "Moja Lista" w trakcie wyszukiwania ?>

    <main class="movie-grid <?php if($search) echo 'search-active'; ?>" <?php if($search) echo 'style="padding-top: 150px !important; margin-top: 0 !important;"'; ?>>
        <?php
        // Sprawdza, czy baza zwróciła jakiekolwiek filmy (czy są wyniki)
        if ($result && $result->num_rows > 0) {
            // Pętla 'while' - wykonuje się dla każdego filmu znalezionego w bazie
            while($row = $result->fetch_assoc()) {
                // Jeśli w bazie brakuje linku do obrazka, wstawiamy zastępczy "Brak Plakatu"
                $img_src = !empty($row["image_url"]) ? htmlspecialchars($row["image_url"]) : 'https://via.placeholder.com/200x300/181818/E50914?text=Brak+Plakatu';
                
                // Generuje "kafelek" filmu w HTML. Po kliknięciu uruchamia odtwarzacz wideo (openModal)
                echo '<div class="movie-card" onclick="openModal(\''.$row['id'].'\', \''.addslashes($row['title']).'\', \''.addslashes($row['description']).'\', \''.$row['trailer_url'].'\', \''.$img_src.'\')">';
                echo '    <img src="' . $img_src . '" alt="Plakat filmu ' . htmlspecialchars($row['title']) . '">'; // Renderuje plakat
                echo '</div>';
            }
        } else {
            // Komunikaty, jeśli baza jest pusta lub wyszukiwarka nic nie znalazła
            if ($search) echo "<p style='grid-column: 1/-1; text-align:center; color:#aaa; margin-top:50px;'>Nie znaleziono filmów: <b>" . htmlspecialchars($search) . "</b></p>";
            else echo "<p style='grid-column: 1/-1; text-align:center; color:#aaa;'>Brak filmów w bazie danych.</p>";
        }
        ?>
    </main>

    <div id="movie-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span> <div id="video-container">
                <iframe id="trailer-video" width="100%" height="450" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            <div style="padding: 30px;">
                <h2 id="modal-title" style="margin-top:0; color:white; font-size:30px;"></h2> <div style="margin-bottom: 15px;">
                    <button id="add-list-btn" onclick="toggleMyList()" style="background: #333; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold; font-size: 16px; transition: 0.3s;"></button>
                </div>
                <p id="modal-desc" style="color: #aaa; line-height: 1.6; font-size:16px;"></p> </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
