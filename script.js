// Pamięć podręczna dla "Mojej Listy"
let currentMovie = {};
let myList = JSON.parse(localStorage.getItem('netflix_my_list')) || [];

document.addEventListener('DOMContentLoaded', renderMyList);

function openModal(id, title, desc, url, img) {
    currentMovie = { id, title, desc, url, img };
    
    document.getElementById('modal-title').innerText = title;
    document.getElementById('modal-desc').innerText = desc;
    
    updateListButton();
    
    // Logika wyciągania ID filmu z YouTube
    let videoId = '';
    if (url.includes('v=')) {
        videoId = url.split('v=')[1].split('&')[0];
    } else if (url.includes('youtu.be/')) {
        videoId = url.split('youtu.be/')[1].split('?')[0];
    } else if (url.includes('embed/')) {
        videoId = url.split('embed/')[1].split('?')[0];
    }
    
    if (videoId) {
        document.getElementById('trailer-video').src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
    } else {
        document.getElementById('trailer-video').src = '';
    }
    
    document.getElementById('movie-modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('movie-modal').style.display = 'none';
    document.getElementById('trailer-video').src = ''; 
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('movie-modal');
    if (e.target === modal) closeModal();
});

// Zmiana przezroczystości menu przy scrollowaniu
window.onscroll = function() {
    if (window.pageYOffset > 50) document.getElementById('main-header').classList.add('scrolled');
    else document.getElementById('main-header').classList.remove('scrolled');
};

// --- LOGIKA MOJEJ LISTY ---

function toggleMyList() {
    const index = myList.findIndex(m => m.id === currentMovie.id);
    if (index > -1) {
        myList.splice(index, 1);
    } else {
        myList.push(currentMovie);
    }
    localStorage.setItem('netflix_my_list', JSON.stringify(myList));
    updateListButton();
    renderMyList();
}

function updateListButton() {
    const btn = document.getElementById('add-list-btn');
    const exists = myList.find(m => m.id === currentMovie.id);
    
    if (exists) {
        btn.innerText = "✓ Usuń z Mojej Listy";
        btn.style.background = "#E50914"; 
    } else {
        btn.innerText = "+ Dodaj do Mojej Listy";
        btn.style.background = "#333"; 
    }
}

function renderMyList() {
    const container = document.getElementById('my-list-container');
    if (!container) return;
    
    if (myList.length === 0) {
        container.innerHTML = '<p style="color: #555; padding: 0 50px; grid-column: 1 / -1; margin: 0;">Brak filmów na liście.</p>';
        return;
    }
    
    container.innerHTML = '';
    myList.forEach(movie => {
        const safeTitle = movie.title.replace(/'/g, "\\'");
        const safeDesc = movie.desc.replace(/'/g, "\\'");
        
        container.innerHTML += `
        <div class="movie-card" onclick="openModal('${movie.id}', '${safeTitle}', '${safeDesc}', '${movie.url}', '${movie.img}')">
            <img src="${movie.img}" alt="Plakat">
        </div>`;
    });
}

// --- EKRAN ŁADOWANIA (Preloader) ---
window.addEventListener('load', function() {
    setTimeout(function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => preloader.style.display = 'none', 500);
        }
    }, 800); // Ekran znika po niecałej sekundzie
});