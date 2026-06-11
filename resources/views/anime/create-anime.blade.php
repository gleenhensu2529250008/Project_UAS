<x-layout title="Tambah Anime">

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card bg-dark border-0 shadow">

                <div class="card-header bg-transparent border-bottom border-secondary">

                    <h2 class="text-white mb-0">
                        Tambah Anime
                    </h2>

                </div>

                <div class="card-body">

                    <!-- Auto-Fill Search Box -->
                    <div class="p-3 mb-4 rounded-3" style="background: #1a1a1a; border: 1px dashed #ff1493;">
                        <h5 class="text-white fw-bold mb-2">⚡ Cari & Isi Otomatis via MyAnimeList</h5>
                        <p class="text-secondary small mb-3">Masukkan nama anime saja, bot akan mengambil detail poster, rating, studio, genre, dan sinopsis secara otomatis.</p>
                        <div class="input-group">
                            <input type="text" id="mal_search_query" class="form-control custom-input" placeholder="Masukkan judul anime (misal: Solo Leveling)...">
                            <button type="button" id="btn_mal_search" class="btn btn-pink px-4">
                                <span id="search_spinner" class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                                Cari & Isi
                            </button>
                        </div>
                        <div id="mal_search_status" class="small mt-2 d-none"></div>
                    </div>

                    <form
                        action="{{ route('anime.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf
                        <input type="hidden" name="gambar_url" id="gambar_url">

                        <!-- Judul Anime -->
                        <div class="mb-3">

                            <label class="form-label text-white">
                                Judul Anime
                            </label>

                            <input
                                type="text"
                                name="judul_anime"
                                class="form-control custom-input"
                                required
                            >

                        </div>

                        <!-- Studio -->
                        <div class="mb-3">

                            <label class="form-label text-white">
                                Studio
                            </label>

                            <input
                                type="text"
                                name="studio"
                                class="form-control custom-input"
                                required
                            >

                        </div>

                        <!-- Genre -->
                        <div class="mb-3">

                            <label class="form-label text-white">
                                Genre
                            </label>

                            <input
                                type="text"
                                name="genre"
                                class="form-control custom-input"
                                required
                            >

                        </div>

                        <!-- Episode -->
                        <div class="mb-3">

                            <label class="form-label text-white">
                                Episode
                            </label>

                            <input
                                type="number"
                                name="episode"
                                class="form-control custom-input"
                                required
                            >

                        </div>

                        <!-- Rating -->
                        <div class="mb-3">

                            <label class="form-label text-white">
                                Rating
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                max="10"
                                name="rating"
                                class="form-control custom-input"
                                required
                            >

                        </div>

                        <!-- Sinopsis -->
                        <div class="mb-3">

                            <label class="form-label text-white">
                                Sinopsis
                            </label>

                            <textarea
                                name="sinopsis"
                                rows="5"
                                class="form-control custom-input"
                                required
                            ></textarea>

                        </div>

                        <!-- Poster -->
                        <div class="mb-4">

                            <label class="form-label text-white fw-semibold">
                                Poster Anime
                            </label>

                            <input
                                type="file"
                                name="gambar"
                                class="form-control custom-input mb-2"
                                accept="image/*"
                                required
                            >
                            <small class="text-secondary d-block mb-2">Pilih file gambar jika ingin mengunggah secara manual. (Optional jika menggunakan cari otomatis)</small>

                            <!-- Scraped Poster Preview -->
                            <div id="poster_preview_container" class="mt-3 d-none">
                                <small class="text-secondary d-block mb-1">Preview Poster:</small>
                                <img id="poster_preview" src="" alt="Scraped Poster" class="rounded shadow border border-secondary" style="max-height: 220px; object-fit: cover;">
                                <div id="poster_preview_text"></div>
                            </div>

                        </div>

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-pink"
                            >
                                Simpan Anime
                            </button>

                            <a
                                href="{{ route('anime.index') }}"
                                class="btn btn-outline-light"
                            >
                                Kembali
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.custom-input{
    background:#1e1e1e;
    border:1px solid #444;
    color:white;
}

.custom-input:focus{
    background:#1e1e1e;
    color:white;
    border-color:#ff1493;
    box-shadow:0 0 0 0.2rem rgba(255,20,147,.25);
}

.btn-pink{
    background:#ff1493;
    color:white;
    border:none;
}

.btn-pink:hover{
    background:#ff2fa8;
    color:white;
}

.card{
    border-radius:20px;
}

</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('btn_mal_search').addEventListener('click', function() {
        const query = document.getElementById('mal_search_query').value.trim();
        if (!query) {
            alert('Silakan masukkan nama anime terlebih dahulu!');
            return;
        }

        const btn = document.getElementById('btn_mal_search');
        const spinner = document.getElementById('search_spinner');
        const statusText = document.getElementById('mal_search_status');

        // Show loading
        btn.disabled = true;
        spinner.classList.remove('d-none');
        statusText.className = 'text-warning mt-2 small';
        statusText.textContent = '⏳ Menghubungi database MyAnimeList...';
        statusText.classList.remove('d-none');

        fetch(`https://api.jikan.moe/v4/anime?q=${encodeURIComponent(query)}&limit=1`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal menghubungi MyAnimeList API.');
                }
                return response.json();
            })
            .then(result => {
                if (!result.data || result.data.length === 0) {
                    throw new Error('Anime tidak ditemukan di database MyAnimeList.');
                }
                const anime = result.data[0];

                // Fill form fields
                document.querySelector('input[name="judul_anime"]').value = anime.title || anime.title_english || '';
                
                // Studio
                let studioName = 'Unknown';
                if (anime.studios && anime.studios.length > 0) {
                    studioName = anime.studios[0].name;
                }
                document.querySelector('input[name="studio"]').value = studioName;

                // Genres
                let genres = [];
                if (anime.genres) {
                    genres = anime.genres.map(g => g.name);
                }
                document.querySelector('input[name="genre"]').value = genres.join(', ');

                // Episode
                document.querySelector('input[name="episode"]').value = anime.episodes || 0;

                // Rating
                document.querySelector('input[name="rating"]').value = anime.score || 0;

                // Sinopsis
                document.querySelector('textarea[name="sinopsis"]').value = anime.synopsis || '';

                // Image URL
                let imageUrl = '';
                if (anime.images && anime.images.jpg) {
                    imageUrl = anime.images.jpg.large_image_url || anime.images.jpg.image_url || '';
                }
                
                document.getElementById('gambar_url').value = imageUrl;

                // Show poster preview
                const previewContainer = document.getElementById('poster_preview_container');
                const previewImg = document.getElementById('poster_preview');
                const previewText = document.getElementById('poster_preview_text');
                
                previewImg.src = imageUrl;
                previewImg.classList.remove('d-none');
                previewText.textContent = 'Poster berhasil didapatkan dari MyAnimeList!';
                previewText.className = 'text-success mt-1 small';
                previewContainer.classList.remove('d-none');

                // Make file upload optional since we have a URL
                document.querySelector('input[name="gambar"]').required = false;

                // Done
                btn.disabled = false;
                spinner.classList.add('d-none');
                statusText.className = 'text-success mt-2 fw-semibold small';
                statusText.textContent = '✨ Data anime berhasil didapatkan & diisi secara otomatis!';
            })
            .catch(err => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                statusText.className = 'text-danger mt-2 small';
                statusText.textContent = '❌ Error: ' + err.message;
            });
    });
});
</script>

</x-layout>