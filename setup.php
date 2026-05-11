<?php
require 'db.php';

echo "<body style='background:#141414; color:white; font-family:sans-serif; text-align:center; padding-top:50px;'>";
echo "<h2>Trwa pobieranie obrazków...</h2>";

// Создаем папку img, если её нет
if (!file_exists('img')) {
    mkdir('img', 0777, true);
}

// Очищаем старую базу
$conn->query("TRUNCATE TABLE movies");

// Настройки для обхода блокировок при скачивании
$context = stream_context_create([
    "ssl" => ["verify_peer" => false, "verify_peer_name" => false],
    "http" => ["header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"]
]);

$movies = [
    ['Skazani na Shawshank', 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dENHA.jpg', 'm1.jpg', 'https://www.youtube.com/watch?v=6hB3S9bIaco', 'Dwóch uwięzionych mężczyzn zaprzyjaźnia się na przestrzeni lat, znajdując ukojenie i ostateczne odkupienie.'],
    ['Ojciec chrzestny', 'https://image.tmdb.org/t/p/w500/3bhkrj58Vtu7enYsRolD1fZdja1.jpg', 'm2.jpg', 'https://www.youtube.com/watch?v=sY1S34973zA', 'Starzejący się patriarcha dynastii przestępczej przekazuje kontrolę nad swoim imperium niechętnemu synowi.'],
    ['Mroczny Rycerz', 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'm3.jpg', 'https://www.youtube.com/watch?v=EXeTwQWrcwY', 'Batman musi zmierzyć się z nowym przestępcą znanym jako Joker.'],
    ['Władca Pierścieni', 'https://image.tmdb.org/t/p/w500/6oom5QYQ2yQTMJIbnvbkBL9cHo6.jpg', 'm4.jpg', 'https://www.youtube.com/watch?v=V75dMMIW2B4', 'Niezwykła drużyna wyrusza w podróż, by zniszczyć Jedyny Pierścień i pokonać Władcę Ciemności.'],
    ['Pulp Fiction', 'https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPbOYKQmG_8.jpg', 'm5.jpg', 'https://www.youtube.com/watch?v=s7EdQ4FqbhY', 'Losy dwóch płatnych morderców, boksera i żony gangstera splotą się w brutalnej opowieści.'],
    ['Forrest Gump', 'https://image.tmdb.org/t/p/w500/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg', 'm6.jpg', 'https://www.youtube.com/watch?v=bLvqoHBptjg', 'Historia życia mężczyzny o niskim IQ, który bierze udział w najważniejszych wydarzeniach XX wieku.'],
    ['Incepcja', 'https://image.tmdb.org/t/p/w500/oYuLEt3zVCKq57qu2F8dT7NIa6f.jpg', 'm7.jpg', 'https://www.youtube.com/watch?v=YoHD9XEInc0', 'Złodziej wykrada sekrety z podświadomości podczas snu.'],
    ['Matrix', 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg', 'm8.jpg', 'https://www.youtube.com/watch?v=vKQi3bBA1y8', 'Haker Neo dowiaduje się, że świat jest symulacją komputerową.'],
    ['Interstellar', 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 'm9.jpg', 'https://www.youtube.com/watch?v=zSWdZVtXT7E', 'Grupa astronautów wyrusza w podróż przez tunel czasoprzestrzenny.'],
    ['Gladiator', 'https://image.tmdb.org/t/p/w500/ty8TGRuvJLPUmAR1H1nRIsgwvim.jpg', 'm10.jpg', 'https://www.youtube.com/watch?v=owK1qxDselE', 'Rzymski generał zostaje zdradzony i zredukowany do roli gladiatora.'],
    ['Diuna', 'https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg', 'm11.jpg', 'https://www.youtube.com/watch?v=n9xhKvEQ7eU', 'Szlachetny ród Atrydów przybywa na pustynną planetę Arrakis.'],
    ['Avatar', 'https://image.tmdb.org/t/p/w500/t6HIqrNDIGGLt306YqQvH8FmXJ3.jpg', 'm12.jpg', 'https://www.youtube.com/watch?v=d9MyW72ELq0', 'Jake Sully i Neytiri muszą opuścić swój dom i chronić rodzinę na Pandorze.'],
    ['Spider-Man', 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1Z1K70222k3PqI.jpg', 'm13.jpg', 'https://www.youtube.com/watch?v=rt-2cxAiPJk', 'Tożsamość Spider-Mana zostaje ujawniona. Peter prosi o pomoc Doktora Strangea.'],
    ['Deadpool', 'https://image.tmdb.org/t/p/w500/y2eN1vI8gG5Dk2ZkC5z0wZ3h0Wp.jpg', 'm14.jpg', 'https://www.youtube.com/watch?v=ONHBaC-pfsk', 'Były żołnierz zyskuje zdolność samouzdrawiania i wyrusza na łowy.'],
    ['Top Gun: Maverick', 'https://image.tmdb.org/t/p/w500/62HCnUTziyWcpDaBO2i1DX17ljH.jpg', 'm15.jpg', 'https://www.youtube.com/watch?v=giXcoVnwVjU', 'Maverick wraca, by wyszkolić nowe pokolenie pilotów do niebezpiecznej misji.'],
    ['Wilk z Wall Street', 'https://image.tmdb.org/t/p/w500/vW1yHGYIikZALu3mRjZ1gC887u9.jpg', 'm16.jpg', 'https://www.youtube.com/watch?v=iszwuX1AK6A', 'Prawdziwa historia Jordana Belforta i jego imperium na Wall Street.'],
    ['Harry Potter', 'https://image.tmdb.org/t/p/w500/wuMc08IPKEe0t4A1P8C2A028T1.jpg', 'm17.jpg', 'https://www.youtube.com/watch?v=VyHV0BRtdxo', 'Chłopiec dowiaduje się, że jest czarodziejem i trafia do Hogwartu.'],
    ['Gwiezdne wojny', 'https://image.tmdb.org/t/p/w500/6FfCtAuVAW8XJjZ7eWeLibRLWTw.jpg', 'm18.jpg', 'https://www.youtube.com/watch?v=vZ734NWnAHA', 'Luke Skywalker łączy siły, by ocalić galaktykę przed Imperium.'],
    ['Park Jurajski', 'https://image.tmdb.org/t/p/w500/oU7Oq2kFAAlGqbU4VoAE36g4hoI.jpg', 'm19.jpg', 'https://www.youtube.com/watch?v=QcgJIGzcZVw', 'Park rozrywki z dinozaurami wymyka się spod kontroli.'],
    ['Terminator 2', 'https://image.tmdb.org/t/p/w500/5M0j0B18X3d069l0IeX7Q9H5rW9.jpg', 'm20.jpg', 'https://www.youtube.com/watch?v=CRRlbK5w8AE', 'Cyborg chroni młodego Johna Connora przed potężniejszym modelem.'],
    ['Powrót do przyszłości', 'https://image.tmdb.org/t/p/w500/fNOH9f1aA7XRTzl1sAON9kXzMEe.jpg', 'm21.jpg', 'https://www.youtube.com/watch?v=qvsgGtivCgs', 'Nastolatek przenosi się w czasie do 1955 roku.'],
    ['Avengers: Koniec gry', 'https://image.tmdb.org/t/p/w500/or06FN3Dka5PeKU0B3fONc81oKz.jpg', 'm22.jpg', 'https://www.youtube.com/watch?v=TcMBFSGVi1c', 'Superbohaterowie jednoczą siły, by cofnąć działania Thanosa.'],
    ['Joker', 'https://image.tmdb.org/t/p/w500/udDclJoHjfpt8NcCG5TBUev20.jpg', 'm23.jpg', 'https://www.youtube.com/watch?v=zAGVQLHvwOY', 'Ignorowany przez społeczeństwo komik powoli popada w obłęd.'],
    ['Mad Max', 'https://image.tmdb.org/t/p/w500/hA2ple9q4cbBUGgG4MNDqI2YntB.jpg', 'm24.jpg', 'https://www.youtube.com/watch?v=hEJnMQG9ev8', 'W postapokaliptycznym świecie kobieta buntuje się przeciwko tyranowi.']
];

$stmt = $conn->prepare("INSERT INTO movies (title, image_url, trailer_url, description) VALUES (?, ?, ?, ?)");

foreach ($movies as $m) {
    $title = $m[0];
    $url = $m[1];
    $local_path = 'img/' . $m[2]; // Путь к локальной картинке (например, img/m1.jpg)
    $trailer = $m[3];
    $desc = $m[4];
    
    // Скачиваем картинку
    $image_data = @file_get_contents($url, false, $context);
    if ($image_data !== false) {
        file_put_contents($local_path, $image_data);
    }
    
    // Записываем в базу локальный путь
    $stmt->bind_param("ssss", $title, $local_path, $trailer, $desc);
    $stmt->execute();
}

echo "<h1 style='color:#E50914;'>Gotowe! 🔥</h1>";
echo "<p>Wszystkie 24 obrazki zostały pobrane do folderu 'img'.</p>";
echo "<a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:white; color:black; text-decoration:none; font-weight:bold; border-radius:5px;'>Wróć do strony głównej</a>";
echo "</body>";
?>