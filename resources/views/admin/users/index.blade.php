@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Manajemen User</h1> {{-- Gunakan h1 untuk judul utama --}}
        <ol class="breadcrumb mb-0"> {{-- Breadcrumb untuk navigasi --}}
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Manajemen User</li>
        </ol>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Form Filter dan Tambah User --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i> Filter User
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="nama_cari" class="form-label">Cari Nama / Email</label>
                        <input type="text" class="form-control" id="nama_cari" name="nama_cari" value="{{ request('nama_cari') }}" placeholder="Cari nama atau email...">
                    </div>
                    <div class="col-md-4">
                        <label for="role_filter" class="form-label">Filter Role</label>
                        <select class="form-select" id="role_filter" name="role_filter">
                            <option value="">Semua Role</option>
                            @foreach ($allRoles as $role) {{-- allRoles akan dilewatkan dari Controller --}}
                            <option value="{{ $role->name }}" {{ request('role_filter') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 text-end d-flex align-items-end justify-content-end"> {{-- Align tombol ke bawah --}}
                        <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Filter</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2"><i class="fas fa-sync-alt me-1"></i> Reset</a>
                        @role('admin')
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success"> {{-- Mengubah warna tombol jadi success --}}
                            <i class="fas fa-user-plus me-1"></i> Tambah User
                        </a>
                        @endrole
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel User --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data User
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th style="width: 80px;">Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="min-width: 150px;">Login Terakhir</th>
                            <th style="min-width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allUsers as $user) {{-- UBAH: Gunakan $allUsers sesuai Controller --}}
                        <tr>
                            <td>{{ ($allUsers->currentPage() - 1) * $allUsers->perPage() + $loop->iteration }}</td>
                            <td>
                                @if ($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto" class="img-thumbnail rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <i class="fas fa-user-circle fa-2x text-muted"></i>
                                @endif
                            </td>
                            <td>{{ $user->nama_lengkap }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                $roleColors = [
                                'admin' => 'bg-primary text-white',
                                'manajer' => 'bg-success text-white',
                                'staff' => 'bg-warning text-dark',
                                'pelanggan' => 'bg-info text-dark',
                                ];
                                @endphp
                                @foreach($user->roles as $role)
                                <span class="badge {{ $roleColors[$role->name] ?? 'bg-secondary text-white' }}">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                            </td>
                            <td>{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('d-m-Y H:i') : '-' }}</td>
                            <td>
                                <div class="d-flex gap-2"> {{-- Gunakan d-flex gap-2 untuk tombol --}}
                                    @role('admin') {{-- Hanya Admin yang bisa edit/hapus --}}
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada user.</td> {{-- colspan 7 --}}
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $allUsers->appends(request()->query())->links() }} {{-- Tambahkan appends untuk filter di pagination --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection