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