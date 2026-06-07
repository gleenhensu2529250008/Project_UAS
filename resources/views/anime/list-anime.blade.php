<x-layout title="List Anime">

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">


        <h2 class="fw-bold text-white">
            Top Anime Series
        </h2>

        <a
            href="{{ route('anime.create') }}"
            class="btn btn-pink"
        >
            + Tambah Anime
        </a>

    </div>

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr class="text-center">

                    <th width="80">Rank</th>
                    <th>Anime</th>
                    <th width="120">Rating</th>
                    <th width="150">Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($animes as $anime)

                <tr>

                    <!-- Rank -->
                    <td class="text-center fs-1 fw-bold text-secondary">

                        {{ $loop->iteration }}

                    </td>

                    <!-- Anime -->
                    <td>

                        <div class="d-flex">

                            <img
    src="{{ asset('storage/'.$anime->gambar) }}"
    width="90"
    height="130"
    style="object-fit:cover;border-radius:10px;"
    class="me-3 shadow"
>

                            <div>

                                <h4 class="fw-bold text-pink">

                                    {{ $anime->judul_anime }}

                                </h4>

                                <div class="text-secondary">

                                    Episode :
                                    {{ $anime->episode }}

                                </div>

                                <div class="text-secondary">

                                    Genre :
                                    {{ $anime->genre }}

                                </div>

                                <div class="text-secondary">

                                    Studio :
                                    {{ $anime->studio }}

                                </div>

                                <div class="mt-2">

                                    {{ Str::limit($anime->sinopsis,150) }}

                                </div>

                            </div>

                        </div>

                    </td>

                    <!-- Rating -->
                    <td class="text-center">

                        ⭐ {{ $anime->rating }}

                    </td>

                    <!-- Button -->
                    <td>

    <div class="d-flex flex-wrap gap-2 justify-content-center">

        <!-- Detail -->
        <a href="{{ route('anime.show', $anime->id) }}"
           class="btn btn-info btn-sm">
            Detail
        </a>

        <!-- Edit -->
        <a href="{{ route('anime.edit', $anime->id) }}"
           class="btn btn-warning btn-sm">
            Edit
        </a>

        <!-- Favorite -->
        <form action="{{ route('favorite.store') }}"
      method="POST">

    @csrf

    <input type="hidden"
           name="anime_id"
           value="{{ $anime->id }}">

    <button type="submit"
            class="btn btn-danger btn-sm">
        ❤️
    </button>

</form>
        <!-- Hapus -->
        <form action="{{ route('anime.destroy', $anime->id) }}"
              method="POST">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-secondary btn-sm"
                    onclick="return confirm('Yakin ingin menghapus anime ini?')">
                Hapus
            </button>

        </form>

    </div>

</td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<style>

.table{
    background: transparent !important;
    color: white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 0 20px rgba(255,20,147,.15);
}

.table th{
    background: #ff1493 !important;
    color: white !important;
    border: none;
}

.table td{
    background: #161616 !important;
    color: white !important;
    border-color: #333 !important;
}

.table tbody tr:hover td{
    background: #202020 !important;
}

.text-pink{
    color: #ff1493;
}

</style>

</x-layout>