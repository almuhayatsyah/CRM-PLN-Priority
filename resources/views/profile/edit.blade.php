@extends('layouts.app') {{-- Menggunakan layout utama Anda --}}

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Profil Pengguna</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Profil</li>
    </ol>

    @if (session('status') === 'profile-updated')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Profil berhasil diperbarui.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session('status') === 'password-updated')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Password berhasil diperbarui.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    {{-- Anda bisa hapus bagian ini jika tidak ingin user bisa menghapus akun mereka sendiri --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection