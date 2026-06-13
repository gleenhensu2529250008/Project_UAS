<x-layout title="Kelola User">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-white border-start border-4 border-pink ps-3">
                Kelola User & Hak Akses
            </h2>
            <p class="text-secondary mb-0">Daftar pengguna terdaftar dan pengaturan status Admin.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- User List Table -->
        <div class="col-lg-8">
            <div class="card bg-dark border-0 shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-white fw-bold mb-0">Daftar Pengguna</h5>
                    
                    <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex gap-2" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control form-control-sm search-box" placeholder="Cari nama/email..." value="{{ $search }}">
                        @if($search)
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        @endif
                        <button type="submit" class="btn btn-pink btn-sm">Cari</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle user-table">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Pengguna</th>
                                <th>Tanggal Lahir</th>
                                <th>Role</th>
                                <th width="180" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <!-- No -->
                                <td class="text-center fw-bold text-secondary">
                                    {{ $loop->iteration }}
                                </td>

                                <!-- User Info -->
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="https://i.pravatar.cc/100?u={{ $user->id }}" class="profile-img-small" alt="Avatar">
                                        <div>
                                            <div class="text-white fw-bold">{{ $user->name }}</div>
                                            <small class="text-secondary">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>

                                <!-- Birthdate -->
                                <td class="text-white">
                                    {{ $user->birthdate ? date('d-m-Y', strtotime($user->birthdate)) : '-' }}
                                </td>

                                <!-- Role Badge -->
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge bg-warning text-dark fw-bold">ADMIN</span>
                                    @else
                                        <span class="badge bg-secondary">USER</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="text-center">
                                    @if($user->id === Auth::id())
                                        <span class="text-secondary small italic">Anda (Logged In)</span>
                                    @else
                                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm w-100 {{ $user->is_admin ? 'btn-outline-danger' : 'btn-pink' }}">
                                                {{ $user->is_admin ? '❌ Cabut Admin' : '⭐ Jadikan Admin' }}
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">
                                    Tidak ada pengguna ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add User Form -->
        <div class="col-lg-4">
            <div class="card bg-dark border-0 shadow-lg p-4">
                <h4 class="text-white fw-bold mb-3">Tambah User Baru</h4>
                <p class="text-secondary small mb-4">Buat akun baru secara instan dan pilih hak aksesnya.</p>
                
                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama -->
                    <div class="mb-3">
                        <label class="form-label text-white-50 small">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control custom-input" required value="{{ old('name') }}">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label text-white-50 small">Alamat Email</label>
                        <input type="email" name="email" class="form-control custom-input" required value="{{ old('email') }}">
                    </div>

                    <!-- Birthdate -->
                    <div class="mb-3">
                        <label class="form-label text-white-50 small">Tanggal Lahir</label>
                        <input type="date" name="birthdate" class="form-control custom-input" required value="{{ old('birthdate') }}">
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label text-white-50 small">Password</label>
                        <div class="position-relative">
                            <input type="password" id="admin_password" name="password" class="form-control custom-input pe-5" placeholder="Min 6 karakter" required>
                            <button class="toggle-pw" type="button" onclick="togglePw('admin_password', this)" tabindex="-1">👁</button>
                        </div>
                    </div>

                    <!-- Is Admin Checkbox -->
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_admin" name="is_admin" value="1">
                        <label class="form-check-label text-white small" for="is_admin">Jadikan User ini Admin</label>
                    </div>

                    <button type="submit" class="btn btn-pink w-100 py-2 fw-bold">
                        💾 Simpan User
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
.border-pink {
    border-color: #ff1493 !important;
}

.profile-img-small {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ff1493;
}

.user-table {
    background: #161616;
    border-radius: 15px;
    overflow: hidden;
}

.user-table thead {
    background: #ff1493;
}

.user-table thead th {
    background: #ff1493 !important;
    color: white;
    border: none;
    padding: 12px;
}

.user-table td {
    background: #1b1b1b;
    border-color: #333;
    color: white !important;
    padding: 12px;
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

.search-box {
    background: #1e1e1e;
    border: 1px solid #444;
    color: white;
}

.search-box:focus {
    background: #1e1e1e;
    color: white;
    border-color: #ff1493;
    box-shadow: none;
}

.btn-pink {
    background: #ff1493;
    color: white;
    border: none;
}

.btn-pink:hover {
    background: #ff2fa8;
    color: white;
}

.btn-outline-danger {
    border-color: #dc3545;
    color: #dc3545;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
}

.form-check-input:checked {
    background-color: #ff1493;
    border-color: #ff1493;
}
</style>
<script>
    function togglePw(id, btn) {
        const inp = document.getElementById(id);
        inp.type = inp.type === 'password' ? 'text' : 'password';
        btn.textContent = inp.type === 'password' ? '👁' : '🙈';
    }
</script>
</x-layout>
