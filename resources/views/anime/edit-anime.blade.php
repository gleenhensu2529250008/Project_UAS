<x-layout title="Edit Anime: {{ $anime->judul_anime }}">

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card bg-dark border-0 shadow">

                <div class="card-header bg-transparent border-bottom border-secondary">

                    <h2 class="text-white mb-0">
                        Edit Anime
                    </h2>

                </div>

                <div class="card-body">

                    <form
                        action="{{ route('anime.update', $anime->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf
                        @method('PUT')

                        <!-- Judul Anime -->
                        <div class="mb-3">

                            <label class="form-label text-white">
                                Judul Anime
                            </label>

                            <input
                                type="text"
                                name="judul_anime"
                                class="form-control custom-input"
                                value="{{ old('judul_anime', $anime->judul_anime) }}"
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
                                value="{{ old('studio', $anime->studio) }}"
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
                                value="{{ old('genre', $anime->genre) }}"
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
                                value="{{ old('episode', $anime->episode) }}"
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
                                value="{{ old('rating', $anime->rating) }}"
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
                            >{{ old('sinopsis', $anime->sinopsis) }}</textarea>

                        </div>

                        <!-- Current Poster Display -->
                        <div class="mb-3">
                            <label class="form-label text-white d-block">
                                Poster Saat Ini
                            </label>
                            @if($anime->gambar)
                                <img src="{{ filter_var($anime->gambar, FILTER_VALIDATE_URL) ? $anime->gambar : asset('storage/'.$anime->gambar) }}" 
                                     alt="Current Poster" 
                                     class="rounded-3" 
                                     style="width: 120px; height: 170px; object-fit: cover; border: 2px solid #ff1493;" />
                            @else
                                <span class="text-secondary small">Tidak ada poster</span>
                            @endif
                        </div>

                        <!-- New Poster Upload -->
                        <div class="mb-4">

                            <label class="form-label text-white">
                                Ganti Poster Anime (Opsional)
                            </label>

                            <input
                                type="file"
                                name="gambar"
                                class="form-control custom-input"
                                accept="image/*"
                            >
                            <small class="text-secondary">Biarkan kosong jika tidak ingin mengganti poster.</small>

                        </div>

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-pink"
                            >
                                Simpan Perubahan
                            </button>

                            <a
                                href="{{ route('anime.show', $anime->id) }}"
                                class="btn btn-outline-light"
                            >
                                Batal
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

</x-layout>
