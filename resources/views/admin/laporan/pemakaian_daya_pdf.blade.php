<!DOCTYPE html>
<html>

<head>
  <title>Laporan Pemakaian Daya</title>
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
  <h2>Laporan Pemakaian Daya</h2>
  <p>Tanggal Laporan: {{ Carbon\Carbon::now()->format('d F Y') }}</p>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Pelanggan</th>
        <th>Bulan & Tahun</th>
        <th>Pemakaian Kwh</th>
        <th>Beban Anomali</th>
        <th>Flag Anomali</th>
      </tr>
    </thead>
    <tbody>@foreach($data as $item)<tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->pelanggan->nama_perusahaan ?? 'N/A' }}</td>
        <td>{{ $item->bulan_tahun }}</td>
        <td>{{ number_format($item->pemakaian_Kwh, 2) }}</td>
        <td>{{ number_format($item->beban_anomali, 2) ?? '-' }}</td>
        <td>{{ $item->flag_anomali == 1 ? 'Anomali' : 'Normal' }}</td>
      </tr>@endforeach</tbody>
  </table>
</body>

</html>