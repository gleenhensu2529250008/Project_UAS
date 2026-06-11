<x-layout title="{{ $anime->judul_anime }} - Detail">

<div class="container py-5">
    
    <!-- Breadcrumb / Kembali -->
    <div class="mb-4">
        <a href="{{ route('anime.index') }}" class="btn btn-outline-light btn-sm px-3 py-2 rounded-3">
            ⬅️ Kembali ke List
        </a>
    </div>

    @php
        $favoriteRecord = \App\Models\Favorite::where('anime_id', $anime->id)->first();
    @endphp

    <div class="card bg-dark border-0 shadow-lg rounded-5 overflow-hidden">
        <div class="row g-0">
            
            <!-- Poster Column -->
            <div class="col-md-4 text-center p-4 d-flex flex-column align-items-center justify-content-start bg-black-opacity">
                <div class="poster-frame shadow-lg rounded-4 overflow-hidden mb-4" style="width: 100%; max-width: 300px; aspect-ratio: 2/3;">
                    @if($anime->gambar)
                        <img src="{{ filter_var($anime->gambar, FILTER_VALIDATE_URL) ? $anime->gambar : asset('storage/'.$anime->gambar) }}" 
                             alt="{{ $anime->judul_anime }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover;" />
                    @else
                        <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center text-white">
                            <span>No Image</span>
                        </div>
                    @endif
                </div>

                <!-- Favorite Toggle -->
                <div class="w-100 px-3">
                    @if($favoriteRecord)
                        <form action="{{ route('favorite.destroy', $favoriteRecord->id) }}" method="POST" class="w-100">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 py-2.5 fw-bold rounded-3">
                                ❤️ Hapus dari Favorit
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favorite.store') }}" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="anime_id" value="{{ $anime->id }}">
                            <button type="submit" class="btn btn-outline-danger w-100 py-2.5 fw-bold rounded-3">
                                🤍 Tambah Ke Favorit
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Details Column -->
            <div class="col-md-8 p-5 d-flex flex-column justify-content-between">
                <div>
                    <!-- Studio & Genre Badges -->
                    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                        <span class="badge bg-pink px-3 py-2 fw-semibold rounded-pill">{{ $anime->studio }}</span>
                        
                        @foreach(explode(',', $anime->genre) as $g)
                            <span class="badge bg-secondary px-3 py-2 fw-normal rounded-pill">{{ trim($g) }}</span>
                        @endforeach
                    </div>

                    <!-- Title -->
                    <h1 class="display-4 fw-bold text-white mb-4">
                        {{ $anime->judul_anime }}
                    </h1>

                    <!-- Rating and Episodes Details Grid -->
                    <div class="row g-3 mb-4 text-white-50">
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-black-opacity rounded-4 text-center">
                                <div class="small text-secondary mb-1">Rating</div>
                                <div class="fs-4 fw-bold text-warning">⭐ {{ number_format($anime->rating, 1) }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-black-opacity rounded-4 text-center">
                                <div class="small text-secondary mb-1">Episode</div>
                                <div class="fs-4 fw-bold text-white">{{ $anime->episode }} EP</div>
                            </div>
                        </div>
                    </div>

                    <!-- Sinopsis -->
                    <div class="mb-5">
                        <h4 class="text-white fw-bold mb-3 border-start border-3 border-pink ps-2">Sinopsis</h4>
                        <p class="text-white-50 lh-lg" style="text-align: justify; white-space: pre-line;">
                            {{ $anime->sinopsis }}
                        </p>
                    </div>
                </div>

                <!-- Admin Action Buttons -->
                @if(Auth::check() && Auth::user()->isAdmin())
                    <div class="pt-4 border-top border-secondary d-flex gap-3">
                        <a href="{{ route('anime.edit', $anime->id) }}" class="btn btn-warning px-4 py-2.5 fw-bold rounded-3">
                            ✏️ Edit Anime
                        </a>

                        <form action="{{ route('anime.destroy', $anime->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anime ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-dark-red px-4 py-2.5 fw-bold rounded-3">
                                🗑️ Hapus Anime
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

<style>
.bg-pink {
    background-color: #ff1493 !important;
    color: white;
}

.bg-black-opacity {
    background-color: rgba(0, 0, 0, 0.25);
}

.poster-frame {
    border: 3px solid #ff1493;
    transition: transform 0.3s ease;
}

.poster-frame:hover {
    transform: scale(1.02);
}

.border-pink {
    border-color: #ff1493 !important;
}

.btn-danger {
    background-color: #ff1493;
    border-color: #ff1493;
}

.btn-danger:hover {
    background-color: #ff2fa8;
    border-color: #ff2fa8;
}

.btn-outline-danger {
    color: #ff1493;
    border-color: #ff1493;
}

.btn-outline-danger:hover {
    background-color: #ff1493;
    color: white;
    border-color: #ff1493;
}

.btn-dark-red {
    background-color: #5a0c1a;
    border: 1px solid #7c1224;
    color: #ffcdd2;
}

.btn-dark-red:hover {
    background-color: #7c1224;
    color: white;
}

.card {
    background-color: #141414 !important;
}
</style>

</x-layout>
