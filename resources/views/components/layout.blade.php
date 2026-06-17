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

        .search-suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #141414;
            border: 1px solid #ff1493;
            border-top: none;
            border-radius: 0 0 8px 8px;
            z-index: 9999;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0 4px 12px rgba(255, 20, 147, 0.25);
        }

        .suggestion-item {
            padding: 10px 15px;
            color: #ccc;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
            text-align: left;
        }

        .suggestion-item:hover, .suggestion-item.active {
            background: #ff1493;
            color: white;
        }

        .suggestion-item:not(:last-child) {
            border-bottom: 1px solid #222;
        }

        .suggestion-header {
            padding: 8px 15px;
            font-size: 11px;
            color: #ff1493;
            font-weight: bold;
            background: #1c1c1c;
            border-bottom: 1px solid #222;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
                <form action="{{ route('anime.index') }}" method="GET" class="d-flex ms-auto me-4 position-relative" style="width: 250px;">
                    <div class="position-relative w-100">
                        <input
                            type="search"
                            name="search"
                            id="nav-search-input"
                            class="form-control search-box w-100"
                            placeholder="Search Anime..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                        <div id="search-suggestions" class="search-suggestions-dropdown d-none"></div>
                    </div>
                </form>

                <!-- User -->
                <div class="d-flex align-items-center gap-2">

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::check() ? Auth::user()->name : 'Guest') }}&background=ff1493&color=fff"
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
            Tempat Terbaik untuk Info Anime
        </small>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('nav-search-input');
        const suggestionsDropdown = document.getElementById('search-suggestions');
        if (!searchInput || !suggestionsDropdown) return;

        let animeList = [];
        let activeIndex = -1;

        // Fetch the list of anime titles from our new API route
        fetch("{{ route('api.anime.titles') }}")
            .then(response => response.json())
            .then(data => {
                animeList = data;
            })
            .catch(err => console.error('Error fetching anime list:', err));

        // Simple Levenshtein distance implementation in JS
        function getLevenshteinDistance(a, b) {
            if (a.length === 0) return b.length;
            if (b.length === 0) return a.length;

            const matrix = [];
            for (let i = 0; i <= b.length; i++) {
                matrix[i] = [i];
            }
            for (let j = 0; j <= a.length; j++) {
                matrix[0][j] = j;
            }

            for (let i = 1; i <= b.length; i++) {
                for (let j = 1; j <= a.length; j++) {
                    if (b.charAt(i - 1) === a.charAt(j - 1)) {
                        matrix[i][j] = matrix[i - 1][j - 1];
                    } else {
                        matrix[i][j] = Math.min(
                            matrix[i - 1][j - 1] + 1, // substitution
                            matrix[i][j - 1] + 1,     // insertion
                            matrix[i - 1][j] + 1      // deletion
                        );
                    }
                }
            }
            return matrix[b.length][a.length];
        }

        function calculateJsSimilarity(query, title) {
            query = query.toLowerCase().trim();
            title = title.toLowerCase().trim();

            if (query === title) return 1.0;
            if (title.includes(query)) {
                return 0.8 + (query.length / title.length) * 0.2;
            }
            if (query.includes(title)) {
                return 0.8 + (title.length / query.length) * 0.2;
            }

            const distance = getLevenshteinDistance(query, title);
            const maxLen = Math.max(query.length, title.length);
            const fullScore = maxLen > 0 ? (1 - (distance / maxLen)) : 0;

            // Word-level matching
            const queryWords = query.split(/[\s,.:;!?_-]+/).filter(Boolean);
            const titleWords = title.split(/[\s,.:;!?_-]+/).filter(Boolean);

            const wordScores = [];
            for (const qw of queryWords) {
                let bestWordScore = 0;
                for (const tw of titleWords) {
                    let score = 0;
                    if (qw === tw) {
                        score = 1.0;
                    } else if (tw.includes(qw)) {
                        score = 0.8 * (qw.length / tw.length);
                    } else if (qw.includes(tw)) {
                        score = 0.8 * (tw.length / qw.length);
                    } else {
                        const wDist = getLevenshteinDistance(qw, tw);
                        const wMax = Math.max(qw.length, tw.length);
                        score = wMax > 0 ? (1 - (wDist / wMax)) : 0;
                    }
                    if (score > bestWordScore) {
                        bestWordScore = score;
                    }
                }
                wordScores.push(bestWordScore);
            }

            const avgWordScore = wordScores.length > 0 ? (wordScores.reduce((sum, s) => sum + s, 0) / wordScores.length) : 0;

            return Math.max(fullScore, avgWordScore);
        }

        // Handle input event to show suggestions
        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();
            if (query.length < 1) {
                suggestionsDropdown.innerHTML = '';
                suggestionsDropdown.classList.add('d-none');
                activeIndex = -1;
                return;
            }

            // Calculate scores for all anime titles
            const scoredAnime = animeList.map(anime => {
                return {
                    ...anime,
                    score: calculateJsSimilarity(query, anime.judul_anime)
                };
            });

            // Filter and sort by score
            const matches = scoredAnime
                .filter(item => item.score >= 0.3)
                .sort((a, b) => b.score - a.score)
                .slice(0, 5); // Limit to top 5 suggestions

            if (matches.length === 0) {
                suggestionsDropdown.innerHTML = '';
                suggestionsDropdown.classList.add('d-none');
                activeIndex = -1;
                return;
            }

            // Render matches
            let html = '<div class="suggestion-header">Suggestions</div>';
            matches.forEach((item, index) => {
                const isTypoCorrection = item.score >= 0.5 && !item.judul_anime.toLowerCase().includes(query.toLowerCase());
                const displayLabel = isTypoCorrection ? `${item.judul_anime} <small class="text-white-50 opacity-75 d-block" style="font-size:10px;">Did you mean?</small>` : item.judul_anime;
                html += `<div class="suggestion-item" data-title="${item.judul_anime.replace(/"/g, '&quot;')}" data-index="${index}">${displayLabel}</div>`;
            });

            suggestionsDropdown.innerHTML = html;
            suggestionsDropdown.classList.remove('d-none');
            activeIndex = -1;

            // Add click listener to suggestion items
            document.querySelectorAll('.suggestion-item').forEach(item => {
                item.addEventListener('click', function() {
                    searchInput.value = this.getAttribute('data-title');
                    suggestionsDropdown.classList.add('d-none');
                    searchInput.form.submit();
                });
            });
        });

        // Handle keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = document.querySelectorAll('.suggestion-item');
            if (items.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = (activeIndex + 1) % items.length;
                highlightItem(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = (activeIndex - 1 + items.length) % items.length;
                highlightItem(items);
            } else if (e.key === 'Enter') {
                if (activeIndex > -1 && items[activeIndex]) {
                    e.preventDefault();
                    searchInput.value = items[activeIndex].getAttribute('data-title');
                    suggestionsDropdown.classList.add('d-none');
                    searchInput.form.submit();
                }
            } else if (e.key === 'Escape') {
                suggestionsDropdown.classList.add('d-none');
                activeIndex = -1;
            }
        });

        function highlightItem(items) {
            items.forEach((item, idx) => {
                if (idx === activeIndex) {
                    item.classList.add('active');
                    item.scrollIntoView({ block: 'nearest' });
                } else {
                    item.classList.remove('active');
                }
            });
        }

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsDropdown.contains(e.target)) {
                suggestionsDropdown.classList.add('d-none');
                activeIndex = -1;
            }
        });
    });
    </script>
</body>
</html>
```
