<x-layout title="List Anime">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white border-start border-4 border-pink ps-3">
            Top Anime Series
        </h2>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('anime.create') }}" class="btn btn-pink btn-sm py-2 px-3 fw-bold">
                ➕ Tambah Anime
            </a>
        @endif
    </div>

    <!-- Horizontal scrollable list (List ke Samping) -->
    <div class="anime-horizontal-scroll py-2 mb-5">
        <div class="d-flex flex-nowrap gap-4 overflow-auto pb-3" style="scrollbar-width: thin; scrollbar-color: #ff1493 #1a1a1a;">
            @foreach($animes as $anime)
            <div class="anime-card-item flex-shrink-0" style="width: 220px;">
                <div class="anime-poster-card shadow position-relative rounded-4 overflow-hidden" style="height: 310px; transition: transform 0.3s ease;">
                    
                    <!-- Rank Badge -->
                    <span class="rank-badge">#{{ $loop->iteration }}</span>

                    <!-- Rating Badge -->
                    <span class="rating-badge">⭐ {{ number_format($anime->rating, 1) }}</span>

                    <!-- Poster Image -->
                    @if($anime->gambar)
                        <img src="{{ filter_var($anime->gambar, FILTER_VALIDATE_URL) ? $anime->gambar : asset('storage/'.$anime->gambar) }}" 
                             alt="{{ $anime->judul_anime }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover;" />
                    @else
                        <!-- Blank / Empty state -->
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark text-secondary">
                            <span>No Image</span>
                        </div>
                    @endif

                    <!-- Detail Overlay on Hover -->
                    <div class="anime-card-overlay p-3">
                        <div class="small text-pink mb-1 fw-bold">{{ $anime->studio }}</div>
                        <div class="small text-light mb-2 text-truncate" style="font-size: 11px;">{{ $anime->genre }}</div>
                        <p class="text-white-50 mb-3" style="font-size: 11px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                            {{ $anime->sinopsis }}
                        </p>
                        
                        <div class="d-flex gap-1 mt-auto flex-wrap w-100">
                            <a href="{{ route('anime.show', $anime->id) }}" class="btn btn-pink btn-sm py-1 px-2 flex-grow-1 text-center" style="font-size: 11px; font-weight: 600;">
                                Detail
                            </a>
                            
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('anime.edit', $anime->id) }}" class="btn btn-warning btn-sm py-1 px-2 text-center" style="font-size: 11px; font-weight: 600;">
                                Edit
                            </a>
                            @endif

                            <form action="{{ route('favorite.store') }}" method="POST" class="m-0 flex-grow-1">
                                @csrf
                                <input type="hidden" name="anime_id" value="{{ $anime->id }}">
                                <button type="submit" class="btn btn-danger btn-sm py-1 px-2 w-100 text-center" style="font-size: 11px; font-weight: 600;">
                                    ❤️
                                </button>
                            </form>

                            @if(Auth::user()->isAdmin())
                            <form action="{{ route('anime.destroy', $anime->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-sm py-1 px-2 text-center" onclick="return confirm('Yakin ingin menghapus anime ini?')">
                                    🗑️
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Title & Info below poster -->
                <div class="mt-3">
                    <h5 class="fw-bold text-white text-truncate mb-1" style="font-size: 16px;" title="{{ $anime->judul_anime }}">
                        {{ $anime->judul_anime }}
                    </h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary" style="font-size: 13px;">{{ $anime->episode }} Episodes</span>
                        <span class="badge bg-secondary text-truncate" style="font-size: 10px; background: #ff1493 !important; max-width: 100px;">{{ $anime->studio }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<style>
.border-pink {
    border-color: #ff1493 !important;
}

.anime-poster-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 20px rgba(255, 20, 147, 0.3) !important;
}

.rank-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(255, 20, 147, 0.95);
    color: white;
    padding: 3px 8px;
    font-size: 12px;
    font-weight: bold;
    border-radius: 6px;
    z-index: 5;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}

.rating-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.75);
    color: #ffc107;
    padding: 3px 8px;
    font-size: 12px;
    font-weight: bold;
    border-radius: 6px;
    z-index: 5;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.anime-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(13, 13, 13, 0.95) 40%, rgba(13, 13, 13, 0.7) 70%, rgba(13, 13, 13, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 10;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.anime-poster-card:hover .anime-card-overlay {
    opacity: 1;
}

/* Custom Scrollbar */
.overflow-auto::-webkit-scrollbar {
    height: 8px;
}
.overflow-auto::-webkit-scrollbar-track {
    background: #111;
    border-radius: 10px;
}
.overflow-auto::-webkit-scrollbar-thumb {
    background: #ff1493;
    border-radius: 10px;
}
.overflow-auto::-webkit-scrollbar-thumb:hover {
    background: #ff3fa8;
}
</style>

</x-layout>