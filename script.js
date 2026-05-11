// Pamięć podręczna dla "Mojej Listy"
let currentMovie = {}; // Pusta zmienna, która będzie przechowywać dane obecnie klikniętego filmu
// Pobiera zapisaną listę ulubionych z pamięci przeglądarki (Local Storage). Jeśli nic tam nie ma, tworzy pustą tablicę []
let myList = JSON.parse(localStorage.getItem('netflix_my_list')) || [];

// Kiedy cała strona (HTML) się załaduje, od razu uruchom funkcję rysującą "Moją Listę"
document.addEventListener('DOMContentLoaded', renderMyList);

// FUNKCJA OTWIERAJĄCA OKIENKO Z FILMEM (MODAL)
function openModal(id, title, desc, url, img) {
    // Zapisuje przekazane dane (z PHP) do naszej globalnej zmiennej
    currentMovie = { id, title, desc, url, img };
    
    // Podmienia tekst w HTML na tytuł i opis klikniętego filmu
    document.getElementById('modal-title').innerText = title;
    document.getElementById('modal-desc').innerText = desc;
    
    updateListButton(); // Sprawdza, jak ma wyglądać przycisk (czy film jest już na liście, czy nie)
    
    // Logika wyciągania ID filmu z YouTube (żeby odtwarzacz działał poprawnie)
    let videoId = '';
    // Sprawdza różne formaty linków YouTube i "wycina" z nich tylko unikalny kod filmu (ID)
    if (url.includes('v=')) {
        videoId = url.split('v=')[1].split('&')[0];
    } else if (url.includes('youtu.be/')) {
        videoId = url.split('youtu.be/')[1].split('?')[0];
    } else if (url.includes('embed/')) {
        videoId = url.split('embed/')[1].split('?')[0];
    }
    
    // Jeśli udało się znaleźć ID, podmienia link w ramce iframe (dodaje ?autoplay=1, żeby wideo ruszyło samo)
    if (videoId) {
        document.getElementById('trailer-video').src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
    } else {
        document.getElementById('trailer-video').src = '';
    }
    
    // Zmienia styl okienka z 'none' (ukryte) na 'flex' (widoczne)
    document.getElementById('movie-modal').style.display = 'flex';
}

// FUNKCJA ZAMYKAJĄCA OKIENKO
function closeModal() {
    document.getElementById('movie-modal').style.display = 'none'; // Ukrywa okienko
    document.getElementById('trailer-video').src = ''; // BARDZO WAŻNE: Czyści link do wideo, żeby dźwięk przestał grać w tle po zamknięciu
}

// ZAMYKANIE KLIKNIĘCIEM W TŁO
window.addEventListener('click', function(e) {
    const modal = document.getElementById('movie-modal');
    // Jeśli użytkownik kliknął w czarne, przezroczyste tło (poza samym filmem), zamknij okienko
    if (e.target === modal) closeModal();
});

// ZMIANA WYGLĄDU MENU PRZY SKROULOWANIU (Efekt z Netflixa)
window.onscroll = function() {
    // Jeśli zjechaliśmy w dół o więcej niż 50 pikseli, dodaj klasę 'scrolled' (zmienia tło paska na całkowicie czarne w CSS)
    if (window.pageYOffset > 50) document.getElementById('main-header').classList.add('scrolled');
    else document.getElementById('main-header').classList.remove('scrolled');
};

// --- LOGIKA "MOJEJ LISTY" (Ulubione filmy) ---

function toggleMyList() {
    // Szuka, czy aktualnie otwarty film znajduje się już w naszej tablicy 'myList'
    const index = myList.findIndex(m => m.id === currentMovie.id);
    
    if (index > -1) {
        // Jeśli film już tam jest (index większy niż -1), USUŃ GO (wytnij 1 element z tablicy)
        myList.splice(index, 1);
    } else {
        // Jeśli go nie ma, DODAJ GO na koniec tablicy
        myList.push(currentMovie);
    }
    
    // Zapisz zaktualizowaną listę z powrotem do Local Storage przeglądarki (żeby przetrwała odświeżenie strony)
    localStorage.setItem('netflix_my_list', JSON.stringify(myList));
    
    updateListButton(); // Odśwież wygląd przycisku
    renderMyList(); // Odśwież sekcję "Moja Lista" na stronie głównej
}

// ZMIANA WYGLĄDU PRZYCISKU W OKIENKU
function updateListButton() {
    const btn = document.getElementById('add-list-btn');
    const exists = myList.find(m => m.id === currentMovie.id); // Sprawdza, czy film jest ulubiony
    
    if (exists) {
        btn.innerText = "✓ Usuń z Mojej Listy";
        btn.style.background = "#E50914"; // Czerwony kolor
    } else {
        btn.innerText = "+ Dodaj do Mojej Listy";
        btn.style.background = "#333"; // Ciemnoszary kolor
    }
}

// RYSOWANIE "MOJEJ LISTY" NA STRONIE GŁÓWNEJ
function renderMyList() {
    const container = document.getElementById('my-list-container');
    if (!container) return; // Zabezpieczenie: jeśli nie ma kontenera (np. jesteśmy w panelu admina), przerwij
    
    // Jeśli lista jest pusta, wyświetl szary komunikat
    if (myList.length === 0) {
        container.innerHTML = '<p style="color: #555; padding: 0 50px; grid-column: 1 / -1; margin: 0;">Brak filmów na liście.</p>';
        return;
    }
    
    container.innerHTML = ''; // Wyczyść obecną zawartość
    
    // Pętla przechodząca przez każdy film zapisany w ulubionych
    myList.forEach(movie => {
        // Zabezpiecza apostrofy w tytułach (np. "Grey's Anatomy"), zapobiegając błędom w kodzie JS
        const safeTitle = movie.title.replace(/'/g, "\\'");
        const safeDesc = movie.desc.replace(/'/g, "\\'");
        
        // Wkleja kod HTML plakatu z podpiętą funkcją openModal (dokładnie tak jak robi to PHP dla wszystkich filmów)
        container.innerHTML += `
        <div class="movie-card" onclick="openModal('${movie.id}', '${safeTitle}', '${safeDesc}', '${movie.url}', '${movie.img}')">
            <img src="${movie.img}" alt="Plakat">
        </div>`;
    });
}

// --- EKRAN ŁADOWANIA (Preloader) ---
window.addEventListener('load', function() {
    // Ustawia opóźnienie, żeby animacja nie zniknęła za szybko (800 milisekund)
    setTimeout(function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.opacity = '0'; // Płynnie robi ekran przezroczystym (dzięki CSS)
            // Po kolejnych 500ms fizycznie usuwa go z widoku, żeby można było klikać w stronę
            setTimeout(() => preloader.style.display = 'none', 500);
        }
    }, 800); 
});
