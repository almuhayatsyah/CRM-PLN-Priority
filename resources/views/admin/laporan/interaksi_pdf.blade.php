<!DOCTYPE html>
<html>

<head>
  <title>Laporan Interaksi</title>
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
  <h2>Laporan Interaksi</h2>
  <p>Tanggal Laporan: {{ Carbon\Carbon::now()->format('d F Y') }}</p>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Pelanggan</th>
        <th>Jenis</th>
        <th>Deskripsi</th>
        <th>Tanggal</th>
        <th>Oleh</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>@foreach($data as $item)<tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
        <td>{{ $item->jenis_interaksi }}</td>
        <td>{{ $item->deskripsi }}</td>
        <td>{{ Carbon\Carbon::parse($item->tanggal_interaksi)->format('d-m-Y H:i') }}</td>
        <td>{{ $item->user->name ?? 'N/A' }}</td>
        <td>{{ $item->status_interaksi }}</td>
      </tr>@endforeach</tbody>
  </table>
</body>

</html>