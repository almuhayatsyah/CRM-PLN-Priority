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