<x-layout title="Home">

<div class="container py-5">

    <div class="row align-items-center">

        <div class="col-lg-6">

            <small class="text-uppercase text-secondary">
                Premium Anime Experience
            </small>

            <h1 class="display-3 fw-bold mt-3">
                Watch Anime
                <span style="color:#ff1493">
                    Beyond Reality
                </span>
            </h1>

            <p class="text-secondary mt-3">
                Discover thousands of anime series and movies.
            </p>

            <a href="/anime" class="btn btn-pink me-2">
                Watch Now
            </a>

            <a href="/anime" class="btn btn-outline-light">
                Explore Anime
            </a>

        </div>

        <div class="col-lg-6 text-center">

            <img
                src="https://images.unsplash.com/photo-1578632767115-351597cf2477"
                class="img-fluid rounded"
                alt="Anime Banner"
            >

        </div>

    </div>

</div>

<div class="container">

    <h2 class="mb-4">
        Trending Anime
    </h2>

    <div class="row g-4">

        @foreach($animes as $anime)

        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="card rounded-5 overflow-hidden bg-dark border-0 h-100 shadow">

                <div class="img-wrapper text-center">

                    <img
                        src="{{ filter_var($anime->gambar, FILTER_VALIDATE_URL) ? $anime->gambar : asset('storage/' . $anime->gambar) }}"
                        alt="{{ $anime->judul_anime }}"
                        width="225"
                        height="318"
                        style="object-fit: cover;"
                    >

                </div>

                <div class="card-body">

                    <h5 class="card-title fw-bold text-white">
                        {{ $anime->judul_anime }}
                    </h5>

                    <a
                        href="/anime/{{ $anime->id }}"
                        class="btn btn-outline-light w-100"
                    >
                        Detail
                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

</x-layout>