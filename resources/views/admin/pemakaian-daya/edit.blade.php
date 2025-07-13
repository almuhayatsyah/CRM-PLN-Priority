@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h1 class="mt-4">Tambah Pemakaian Daya Baru</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.pemakaian-daya.index') }}">Pemakaian Daya</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      Form Pemakaian Daya
    </div>
    <div class="card-body">
      <form action="{{ route('admin.pemakaian-daya.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="pelanggan_id" class="form-label">Pelanggan</label>
          <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id" required>
            <option value="">Pilih Pelanggan</option>
            @foreach ($pelanggans as $pelanggan)
            <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
              {{ $pelanggan->nama_perusahaan }} ({{ $pelanggan->nama }})
            </option>
            @endforeach
          </select>
          @error('pelanggan_id')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="bulan_tahun" class="form-label">Bulan & Tahun</label>
          {{-- Input type="month" akan menghasilkan format YYYY-MM --}}
          <input type="month" class="form-control @error('bulan_tahun') is-invalid @enderror" id="bulan_tahun" name="bulan_tahun" value="{{ old('bulan_tahun', Carbon\Carbon::now()->format('Y-m')) }}" required>
          @error('bulan_tahun')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="pemakaian_Kwh" class="form-label">Pemakaian Kwh</label>
          <input type="number" step="0.01" class="form-control @error('pemakaian_Kwh') is-invalid @enderror" id="pemakaian_Kwh" name="pemakaian_Kwh" value="{{ old('pemakaian_Kwh') }}" required>
          @error('pemakaian_Kwh')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="beban_anomali" class="form-label">Beban Anomali (Opsional)</label>
          <input type="number" step="0.01" class="form-control @error('beban_anomali') is-invalid @enderror" id="beban_anomali" name="beban_anomali" value="{{ old('beban_anomali') }}">
          @error('beban_anomali')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="flag_anomali" class="form-label">Flag Anomali</label>
          <select class="form-select @error('flag_anomali') is-invalid @enderror" id="flag_anomali" name="flag_anomali" required>
            <option value="0" {{ old('flag_anomali') == '0' ? 'selected' : '' }}>Normal</option>
            <option value="1" {{ old('flag_anomali') == '1' ? 'selected' : '' }}>Anomali</option>
          </select>
          @error('flag_anomali')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pemakaian Daya</button>
        <a href="{{ route('admin.pemakaian-daya.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection