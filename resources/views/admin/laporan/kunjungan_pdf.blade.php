<!DOCTYPE html>
<html>

<head>
  <title>Laporan Kunjungan</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
    }

    h2 {
      text-align: center;
    }
  </style>
</head>

<body>
  <h2>Laporan Kunjungan</h2>
  <p>Tanggal Laporan: {{ Carbon\Carbon::now()->format('d F Y') }}</p>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Pelanggan</th>
        <th>Staff</th>
        <th>Tanggal Jadwal</th>
        <th>Tujuan</th>
        <th>Hasil</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>@foreach($data as $item)<tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
        <td>{{ $item->user->name ?? 'N/A' }}</td>
        <td>{{ Carbon\Carbon::parse($item->tanggal_jadwal)->format('d-m-Y H:i') }}</td>
        <td>{{ $item->tujuan }}</td>
        <td>{{ $item->hasil ?? '-' }}</td>
        <td>{{ $item->status }}</td>
      </tr>@endforeach</tbody>
  </table>
</body>

</html>