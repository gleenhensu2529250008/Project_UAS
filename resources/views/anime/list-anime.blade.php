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
                                width="100"
                                height="140"
                                style="object-fit:cover"
                                class="rounded me-3"
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
                    <td class="text-center">

                        <a
                            href="/anime/{{ $anime->id }}"
                            class="btn btn-outline-light"
                        >
                            Detail
                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<style>

table{
    background:#161616;
    color:white;
}

thead{
    background:#ff1493;
}

.text-pink{
    color:#ff1493;
}

tbody tr{
    border-bottom:1px solid #333;
}

tbody tr:hover{
    background:#202020;
}

</style>

</x-layout>