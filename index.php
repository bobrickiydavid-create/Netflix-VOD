<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mój Netflix</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div id="preloader">
        <div class="logo">NETFLIX</div>
    </div>

    <?php
    require 'db.php';
    
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $where_clause = $search ? "WHERE title LIKE '%" . $conn->real_escape_string($search) . "%'" : "";
    $query = "SELECT * FROM movies $where_clause ORDER BY id DESC";
    $result = $conn->query($query);

    // Hero banner (najnowszy film)
    $hero_query = "SELECT * FROM movies ORDER BY id DESC LIMIT 1";
    $hero_res = $conn->query($hero_query);
    $hero = $hero_res->fetch_assoc();
    ?>

    <header id="main-header">
        <a href="index.php" class="logo">NETFLIX</a>
        <form class="search-form" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Szukaj filmu..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn-search">🔍</button>
        </form>
        <nav>
            <a href="admin.php">Panel Admina</a>
        </nav>
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
    <?php endif; ?>

    <main class="movie-grid <?php if($search) echo 'search-active'; ?>" <?php if($search) echo 'style="padding-top: 150px !important; margin-top: 0 !important;"'; ?>>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $img_src = !empty($row["image_url"]) ? htmlspecialchars($row["image_url"]) : 'https://via.placeholder.com/200x300/181818/E50914?text=Brak+Plakatu';
                
                echo '<div class="movie-card" onclick="openModal(\''.$row['id'].'\', \''.addslashes($row['title']).'\', \''.addslashes($row['description']).'\', \''.$row['trailer_url'].'\', \''.$img_src.'\')">';
                echo '    <img src="' . $img_src . '" alt="Plakat filmu ' . htmlspecialchars($row['title']) . '">';
                echo '</div>';
            }
        } else {
            if ($search) echo "<p style='grid-column: 1/-1; text-align:center; color:#aaa; margin-top:50px;'>Nie znaleziono filmów: <b>" . htmlspecialchars($search) . "</b></p>";
            else echo "<p style='grid-column: 1/-1; text-align:center; color:#aaa;'>Brak filmów w bazie danych.</p>";
        }
        ?>
    </main>

    <div id="movie-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="video-container">
                <iframe id="trailer-video" width="100%" height="450" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            <div style="padding: 30px;">
                <h2 id="modal-title" style="margin-top:0; color:white; font-size:30px;"></h2>
                <div style="margin-bottom: 15px;">
                    <button id="add-list-btn" onclick="toggleMyList()" style="background: #333; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold; font-size: 16px; transition: 0.3s;"></button>
                </div>
                <p id="modal-desc" style="color: #aaa; line-height: 1.6; font-size:16px;"></p>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>