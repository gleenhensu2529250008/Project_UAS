<x-layout title="Favorite Anime">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="text-white fw-bold">
                ❤️ Favorite Anime
            </h1>

            <p class="text-secondary mb-0">
                Daftar anime favoritmu
            </p>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table align-middle anime-table">

            <thead>

                <tr>
                    <th width="70">#</th>
                    <th>Anime</th>
                    <th width="120">Studio</th>
                    <th width="120">Genre</th>
                    <th width="80">Episode</th>
                    <th width="80">Rating</th>
                    <th width="220">Action</th>
                </tr>

            </thead>

            <tbody>

                @forelse($favorites as $favorite)
                <tr>

                    <!-- Nomor -->
                    <td class="text-center fw-bold text-secondary">
                        {{ $loop->iteration }}
                    </td>

                    <!-- Anime -->
                    <td>

                        <div class="d-flex gap-3 align-items-start">

                            <img
                                src="{{ filter_var($favorite->anime->gambar, FILTER_VALIDATE_URL) ? $favorite->anime->gambar : asset('storage/'.$favorite->anime->gambar) }}"
                                width="90"
                                height="130"
                                style="object-fit:cover;border-radius:10px"
                            >

                            <div>

                                <h5 class="text-white fw-bold">
                                    {{ $favorite->anime->judul_anime }}
                                </h5>

                                <small class="text-secondary">
                                    {{ Str::limit($favorite->anime->sinopsis, 120) }}
                                </small>

                            </div>

                        </div>

                    </td>

                    <!-- Studio -->
                    <td class="text-white">
                        {{ $favorite->anime->studio }}
                    </td>

                    <!-- Genre -->
                    <td class="text-white">
                        {{ $favorite->anime->genre }}
                    </td>

                    <!-- Episode -->
                    <td class="text-white">
                        {{ $favorite->anime->episode }}
                    </td>

                    <!-- Rating -->
                     <td class="text-center">

                        ⭐ {{ $favorite->anime->rating }}

                    </td>

                    <!-- Action -->
                    <td>

                        <div class="d-flex gap-2">

                            <!-- Detail -->
                            <a
                                href="{{ route('anime.show', $favorite->anime_id) }}"
                                class="btn btn-info btn-sm"
                            >
                                Detail
                            </a>

                            <!-- Unfavorite -->
                            <form action="{{ route('favorite.destroy', $favorite->id) }}"
      method="POST">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-danger btn-sm">
        ❤️ Remove
    </button>

</form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center py-5">

                        <h4 class="text-secondary">
                            Belum ada anime favorit
                        </h4>

                    </td>

                </tr>

@endforelse

            </tbody>

        </table>

    </div>

</div>

<style>

.anime-table{
    background:#161616;
    border-radius:15px;
    overflow:hidden;
}

.anime-table thead{
    background:#ff1493;
}

.anime-table thead th{
        background: #ff1493 !important;
    color:white;
    border:none;
}

.anime-table td{
    background:#1b1b1b;
    border-color:#333;
        color: white !important;
}

.btn-info{
    background:#0dcaf0;
    border:none;
}

.btn-danger{
    background:#ff1493;
    border:none;
}

.btn-danger:hover{
    background:#ff3aad;
}

</style>

</x-layout>