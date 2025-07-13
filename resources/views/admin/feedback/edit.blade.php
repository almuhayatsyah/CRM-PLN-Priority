@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Edit Feedback Pelanggan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.feedback.index') }}">Feedback</a></li>
    <li class="breadcrumb-item active">Edit</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Form Edit Feedback
    </div>
    <div class="card-body">
      <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Penting untuk metode HTTP PUT --}}

        <div class="mb-3">
          <label for="pelanggan_id" class="form-label">Pelanggan</label>
          <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id" required {{-- disable jika tidak boleh diubah --}}>
            <option value="">Pilih Pelanggan</option>
            @foreach ($pelanggans as $pelanggan)
            <option value="{{ $pelanggan->id }}" {{ (old('pelanggan_id', $feedback->pelanggan_id) == $pelanggan->id) ? 'selected' : '' }}>
              {{ $pelanggan->nama_perusahaan }} ({{ $pelanggan->nama }})
            </option>
            @endforeach
          </select>
          @error('pelanggan_id')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="skor" class="form-label">Skor (1-5 Bintang)</label>
          <select class="form-select @error('skor') is-invalid @enderror" id="skor" name="skor" required>
            <option value="">Pilih Skor</option>
            @for ($i = 1; $i <= 5; $i++)
              <option value="{{ $i }}" {{ (old('skor', $feedback->skor) == $i) ? 'selected' : '' }}>{{ $i }} Bintang</option>
              @endfor
          </select>
          @error('skor')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="komentar" class="form-label">Komentar</label>
          <textarea class="form-control @error('komentar') is-invalid @enderror" id="komentar" name="komentar" rows="3" required>{{ old('komentar', $feedback->komentar) }}</textarea>
          @error('komentar')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="Baru" {{ (old('status', $feedback->status) == 'Baru') ? 'selected' : '' }}>Baru</option>
            <option value="Sedang Ditangani" {{ (old('status', $feedback->status) == 'Sedang Ditangani') ? 'selected' : '' }}>Sedang Ditangani</option>
            <option value="Selesai" {{ (old('status', $feedback->status) == 'Selesai') ? 'selected' : '' }}>Selesai</option>
          </select>
          @error('status')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Feedback</button>
        <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection