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