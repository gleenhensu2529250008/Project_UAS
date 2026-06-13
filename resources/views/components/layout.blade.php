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

        .dropdown-item:hover{
            background:#ff1493 !important;
            color:white !important;
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
                🌸
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
                            class="nav-link {{ (request()->routeIs('anime.*') || request()->is('anime*')) ? 'active-link' : '' }}"
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

                    @if(Auth::check() && Auth::user()->isAdmin())
                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('admin.users.index') ? 'active-link' : '' }}"
                            href="{{ route('admin.users.index') }}"
                        >
                            👥 Kelola User
                        </a>
                    </li>
                    @endif

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
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Guest') }}&background=ff1493&color=fff"
                        class="profile-img"
                        alt=""
                    >

                    @auth
                    <a
                        href="/profile"
                        class="text-white text-decoration-none fw-semibold"
                        style="transition: color 0.2s;"
                        onmouseover="this.style.color='#ff1493'"
                        onmouseout="this.style.color='white'"
                    >
                        {{ Auth::user()->name }}
                        @if(Auth::user()->isAdmin())
                            <span class="badge bg-warning text-dark ms-1" style="font-weight: bold; font-size: 11px; vertical-align: middle;">ADMIN</span>
                        @endif
                    </a>
                    @else
                    <span class="text-white">Guest</span>
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

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('status') === 'profile-information-updated')
            <div class="alert alert-success">
                Profil berhasil diperbarui!
            </div>
        @endif

        @if(session('status') === 'password-updated')
            <div class="alert alert-success">
                Password berhasil diperbarui!
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
