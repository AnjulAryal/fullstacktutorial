//Assiging Variables
const API_URL = 'http://localhost:3000/movies';
const movieListDiv = document.getElementById('movie-list');
const searchInput = document.getElementById('search-input');
const form = document.getElementById('add-movie-form');

let allMovies = []; // Global store for movies

//Render Movies
function renderMovies(movies) {
    movieListDiv.innerHTML = '';

    if (movies.length === 0) {
        movieListDiv.innerHTML = '<p>No movies found.</p>';
        return;
    }

    movies.forEach(movie => {
        const movieDiv = document.createElement('div');
        movieDiv.classList.add('movie-item');
        movieDiv.innerHTML = `
            <p><strong>${movie.title}</strong> (${movie.year}) - ${movie.genre}</p>
            <button class="edit-btn">Edit</button>
            <button class="delete-btn">Delete</button>
        `;

        // Edit button
        movieDiv.querySelector('.edit-btn').addEventListener('click', () => {
            editMoviePrompt(movie.id, movie.title, movie.year, movie.genre);
        });

        // Delete button
        movieDiv.querySelector('.delete-btn').addEventListener('click', () => {
            deleteMovie(movie.id);
        });

        movieListDiv.appendChild(movieDiv);
    });
}

//fetch movies (Read)

function fetchMovies() {
    fetch(API_URL)
        .then(res => res.json())
        .then(movies => {
            allMovies = movies;
            renderMovies(allMovies);
        })
        .catch(err => console.error('Error fetching movies:', err));
}

fetchMovies();


//Search Funconality 
searchInput.addEventListener('input', () => {
    const searchTerm = searchInput.value.toLowerCase();
    const filtered = allMovies.filter(movie =>
        movie.title.toLowerCase().includes(searchTerm) ||
        movie.genre.toLowerCase().includes(searchTerm)
    );
    renderMovies(filtered);
});


//POST METHOD
form.addEventListener('submit', (event) => {
    event.preventDefault();
    const newMovie = {
        title: document.getElementById('title').value,
        genre: document.getElementById('genre').value,
        year: parseInt(document.getElementById('year').value)
    };

    fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(newMovie)
    })
    .then(res => {
        if (!res.ok) throw new Error('Failed to add movie');
        return res.json();
    })
    .then(() => {
        form.reset();
        fetchMovies();
    })
    .catch(err => console.error('Error adding movie:', err));
});


//PUT METHOD
function editMoviePrompt(id, currentTitle, currentYear, currentGenre) {
    const newTitle = prompt('Enter new Title:', currentTitle);
    const newYear = prompt('Enter new Year:', currentYear);
    const newGenre = prompt('Enter new Genre:', currentGenre);

    if (newTitle && newYear && newGenre) {
        const updatedMovie = {
            id,
            title: newTitle,
            year: parseInt(newYear),
            genre: newGenre
        };
        updateMovie(id, updatedMovie);
    }
}

function updateMovie(id, updatedMovie) {
    fetch(`${API_URL}/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updatedMovie)
    })
    .then(res => {
        if (!res.ok) throw new Error('Failed to update movie');
        return res.json();
    })
    .then(() => fetchMovies())
    .catch(err => console.error('Error updating movie:', err));
}


//deLETE mOVIE
function deleteMovie(id) {
    if (!confirm('Are you sure you want to delete this movie?')) return;

    fetch(`${API_URL}/${id}`, {
        method: 'DELETE'
    })
    .then(res => {
        if (!res.ok) throw new Error('Failed to delete movie');
        fetchMovies();
    })
    .catch(err => console.error('Error deleting movie:', err));
}


