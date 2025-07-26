@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Manajemen User</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i> Tambah User
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
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
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit">
                            ✏️ Edit
                        </a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">
                                🗑️ Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $users->links() }}
        </div>
    </div>

    {{-- flash message --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

</div>
@endsection