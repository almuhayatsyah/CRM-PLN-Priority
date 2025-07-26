<!DOCTYPE html>
<html>

<head>
  <title>Laporan Feedback</title>
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
  <h2>Laporan Feedback</h2>
  <p>Tanggal Laporan: {{ Carbon\Carbon::now()->format('d F Y') }}</p>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Pelanggan</th>
        <th>Skor</th>
        <th>Komentar</th>
        <th>Status</th>
        <th>Tanggal Masuk</th>
      </tr>
    </thead>
    <tbody>@foreach($data as $item)<tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
        <td>{{ $item->skor }}</td>
        <td>{{ $item->komentar }}</td>
        <td>{{ $item->status }}</td>
        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
      </tr>@endforeach</tbody>
  </table>
</body>

</html>