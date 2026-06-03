<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'WibuDesu' }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    @vite([])

    <style>

        body{
            background:#0d0d0d;
            color:white;
        }

        .navbar{
            background:#141414 !important;
            border-bottom:2px solid #ff1493;
        }

        .navbar-brand{
            color:#ff1493 !important;
            font-size:28px;
            font-weight:bold;
        }

        .nav-link{
            color:white !important;
            transition:.3s;
        }

        .nav-link:hover{
            color:#ff1493 !important;
        }

        .active-link{
            color:#ff1493 !important;
            font-weight:bold;
        }

        .search-box{
            width:250px;
            background:#222;
            border:none;
            color:white;
        }

        .search-box:focus{
            background:#222;
            color:white;
            box-shadow:none;
        }

        .profile-img{
            width:40px;
            height:40px;
            border-radius:50%;
            object-fit:cover;
            border:2px solid #ff1493;
        }

        .btn-pink{
            background:#ff1493;
            border:none;
            color:white;
        }

        .btn-pink:hover{
            background:#ff2fa8;
            color:white;
        }

        footer{
            background:#141414;
            border-top:1px solid #333;
            padding:20px;
            text-align:center;
            margin-top:50px;
        }

    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow">

        <div class="container">

            <a class="navbar-brand" href="/home">
                WibuDesu
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-4">

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('home') ? 'active-link' : '' }}"
                            href="/home"
                        >
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('anime.index') ? 'active-link' : '' }}"
                            href="/anime"
                        >
                            Anime
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('favorite') ? 'active-link' : '' }}"
                            href="/favorite"
                        >
                            ❤️ Favorite
                        </a>
                    </li>

                </ul>

                <!-- Search -->
                <form class="d-flex ms-auto me-4">

                    <input
                        type="search"
                        class="form-control search-box"
                        placeholder="Search Anime..."
                    >

                </form>

                <!-- User -->
                <div class="d-flex align-items-center gap-2">

                    <img
                        src="https://i.pravatar.cc/100"
                        class="profile-img"
                        alt="Profile"
                    >

                    <span>
                        {{ Auth::user()->name ?? 'Guest' }}
                    </span>

                    @auth

                    <form action="/logout" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                        >
                            Logout
                        </button>

                    </form>

                    @else

                    <a
                        href="/login"
                        class="btn btn-pink btn-sm"
                    >
                        Login
                    </a>

                    @endauth

                </div>

            </div>

        </div>

    </nav>

    <!-- Main Content -->
    <main class="container py-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}

    </main>

    <!-- Footer -->
    <footer>

        <h5 class="text-white">
            WibuDesu
        </h5>

        <small class="text-secondary">
            Tempat terbaik membaca Manga, Anime, dan Light Novel.
        </small>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
```
