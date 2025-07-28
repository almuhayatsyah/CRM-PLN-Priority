<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Profil
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4 space-y-6" enctype="multipart/form-data"> {{-- PENTING: Tambahkan enctype --}}
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="profile_photo" class="form-label">Foto Profil (Opsional)</label>
            @if ($user->profile_photo_path)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto Profil" class="img-thumbnail rounded-circle" style="max-width: 150px; max-height: 150px; object-fit: cover;">
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo" value="1">
                <label class="form-check-label" for="remove_photo">Hapus Foto Profil</label>
            </div>
            @endif
            <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" id="profile_photo" name="profile_photo">
            @error('profile_photo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input id="nama_lengkap" name="nama_lengkap" type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required autofocus autocomplete="name" />
            @error('nama_lengkap')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    Alamat email Anda belum terverifikasi.
                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-success">
                    Tautan verifikasi baru telah dikirim ke alamat email Anda.
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            @if (session('status') === 'profile-updated')
            <p class="text-sm text-gray-600">Disimpan.</p>
            @endif
        </div>
    </form>
</section>