<x-layout title="Pengaturan Akun">

<div class="container py-5">

    <div class="row g-4">

        <!-- Left Column: User Card & Logout -->
        <div class="col-lg-4">

            <div class="card bg-dark border-0 shadow text-center p-4 rounded-4">

                <div class="mb-3">
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ff1493&color=fff&size=120"
                        class="rounded-circle border border-3 border-pink shadow"
                        alt="{{ Auth::user()->name }}"
                        style="width: 120px; height: 120px; object-fit: cover;"
                    >
                </div>

                <h3 class="text-white fw-bold mb-1">
                    {{ Auth::user()->name }}
                </h3>

                <p class="text-secondary mb-3">
                    {{ Auth::user()->email }}
                </p>

                <div class="mb-4">
                    @if(Auth::user()->isAdmin())
                        <span class="badge bg-warning text-dark px-3 py-2 fw-bold" style="font-size: 13px;">ADMINISTRATOR</span>
                    @else
                        <span class="badge bg-secondary px-3 py-2 fw-bold" style="font-size: 13px;">MEMBER</span>
                    @endif
                </div>

                <hr class="border-secondary my-4">

                <!-- User Details Info -->
                <div class="text-start mb-4">
                    <div class="mb-2">
                        <small class="text-secondary d-block">Tanggal Lahir</small>
                        <span class="text-white fw-semibold">
                            {{ \Carbon\Carbon::parse(Auth::user()->birthdate)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <div>
                        <small class="text-secondary d-block">Bergabung Sejak</small>
                        <span class="text-white fw-semibold">
                            {{ Auth::user()->created_at->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>

                <!-- Logout Button moved here -->
                <form action="/logout" method="POST" class="d-grid mt-auto">
                    @csrf
                    <button
                        type="submit"
                        class="btn btn-danger py-2.5 fw-bold rounded-3"
                    >
                        🚪 Logout dari Akun
                    </button>
                </form>

            </div>

        </div>

        <!-- Right Column: Settings Forms -->
        <div class="col-lg-8">

            <div class="card bg-dark border-0 shadow p-4 rounded-4">

                <!-- Nav Tabs -->
                <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist" style="border-bottom: 1px solid #333;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-white" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-pane" type="button" role="tab" aria-controls="info-pane" aria-selected="true" style="background: transparent; border: none; border-bottom: 2px solid #ff1493; border-radius: 0; padding-bottom: 12px; font-weight: 600;">
                            ⚙️ Informasi Umum
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-secondary" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-pane" type="button" role="tab" aria-controls="password-pane" aria-selected="false" style="background: transparent; border: none; border-radius: 0; padding-bottom: 12px; font-weight: 600;">
                            🔒 Ubah Password
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="profileTabsContent">
                    
                    <!-- Tab 1: Info Umum -->
                    <div class="tab-pane fade show active" id="info-pane" role="tabpanel" aria-labelledby="info-tab" tabindex="0">
                        
                        <form action="/user/profile-information" method="POST">
                            @csrf
                            @method('PUT')

                            @if($errors->updateProfileInformation->any())
                                <div class="alert alert-danger py-2 px-3 mb-4" style="font-size: 14px; border-radius: 8px;">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->updateProfileInformation->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="profile_name" class="form-label text-secondary fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control text-white custom-input" id="profile_name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="profile_email" class="form-label text-secondary fw-semibold">Alamat Email</label>
                                <input type="email" class="form-control text-white custom-input" id="profile_email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="profile_birthdate" class="form-label text-secondary fw-semibold">Tanggal Lahir</label>
                                <input type="date" class="form-control text-white custom-input" id="profile_birthdate" name="birthdate" value="{{ old('birthdate', Auth::user()->birthdate) }}" required>
                            </div>

                            <button type="submit" class="btn btn-pink px-4 py-2 fw-semibold">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    <!-- Tab 2: Ubah Password -->
                    <div class="tab-pane fade" id="password-pane" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                        
                        <form action="/user/password" method="POST">
                            @csrf
                            @method('PUT')

                            @if($errors->updatePassword->any())
                                <div class="alert alert-danger py-2 px-3 mb-4" style="font-size: 14px; border-radius: 8px;">
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->updatePassword->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="current_password" class="form-label text-secondary fw-semibold">Password Saat Ini</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control text-white custom-input pe-5" id="current_password" name="current_password" required>
                                    <button class="toggle-pw" type="button" onclick="togglePw('current_password', this)" tabindex="-1">👁</button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-secondary fw-semibold">Password Baru</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control text-white custom-input pe-5" id="password" name="password" required>
                                    <button class="toggle-pw" type="button" onclick="togglePw('password', this)" tabindex="-1">👁</button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label text-secondary fw-semibold">Konfirmasi Password Baru</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control text-white custom-input pe-5" id="password_confirmation" name="password_confirmation" required>
                                    <button class="toggle-pw" type="button" onclick="togglePw('password_confirmation', this)" tabindex="-1">👁</button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-pink px-4 py-2 fw-semibold">
                                Perbarui Password
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
.border-pink {
    border-color: #ff1493 !important;
}

.custom-input {
    background: #1e1e1e;
    border: 1px solid #444;
    color: white;
}

.toggle-pw {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #888;
    cursor: pointer;
    font-size: 16px;
    padding: 0;
    line-height: 1;
    z-index: 5;
    transition: color 0.2s;
}

.toggle-pw:hover {
    color: #ff1493;
}

.custom-input:focus {
    background: #1e1e1e;
    color: white;
    border-color: #ff1493;
    box-shadow: 0 0 0 0.2rem rgba(255, 20, 147, .25);
}

.btn-pink {
    background: #ff1493;
    color: white;
    border: none;
    transition: 0.2s;
}

.btn-pink:hover {
    background: #ff2fa8;
    color: white;
}
</style>

<script>
    function togglePw(id, btn) {
        const inp = document.getElementById(id);
        inp.type = inp.type === 'password' ? 'text' : 'password';
        btn.textContent = inp.type === 'password' ? '👁' : '🙈';
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Switch to password tab if password errors exist
        @if($errors->updatePassword->any())
            var triggerEl = document.querySelector('#password-tab');
            var tab = new bootstrap.Tab(triggerEl);
            tab.show();
        @endif

        // Enhance tab active styling visually
        var tabLinks = document.querySelectorAll('#profileTabs button');
        tabLinks.forEach(function(btn) {
            btn.addEventListener('shown.bs.tab', function (event) {
                // Remove active styles from all
                tabLinks.forEach(function(b) {
                    b.classList.remove('text-white');
                    b.classList.add('text-secondary');
                    b.style.borderBottom = 'none';
                });
                // Add active styles to current
                event.target.classList.add('text-white');
                event.target.classList.remove('text-secondary');
                event.target.style.borderBottom = '2px solid #ff1493';
            });
        });
    });
</script>

</x-layout>
