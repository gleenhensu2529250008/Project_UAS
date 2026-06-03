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

                    <form
                        action="{{ route('anime.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf

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

                            <label class="form-label text-white">
                                Poster Anime
                            </label>

                            <input
                                type="file"
                                name="gambar"
                                class="form-control custom-input"
                                accept="image/*"
                                required
                            >

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

</x-layout>