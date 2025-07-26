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