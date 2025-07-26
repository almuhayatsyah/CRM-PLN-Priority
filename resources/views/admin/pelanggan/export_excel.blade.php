<table>
  <thead>
    <tr>
      <th>No</th>
      <th>ID Pel</th>
      <th>Kode PLN</th>
      <th>Nama Perusahaan</th>
      <th>Email</th>
      <th>Nama PIC</th>
      <th>Kontak</th>
      <th>Kapasitas Daya</th>
      <th>Sektor</th>
      <th>Peruntukan</th>
      <th>UP3</th>
      <th>ULP</th>
      <th>Kriteria Prioritas</th>
    </tr>
  </thead>
  <tbody>@foreach($data as $item)<tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $item->id_pel }}</td>
      <td>{{ $item->kode_PLN }}</td>
      <td>{{ $item->nama_perusahaan }}</td>
      <td>{{ $item->user->email ?? '-' }}</td>
      <td>{{ $item->nama }}</td>
      <td>{{ $item->kontak }}</td>
      <td>{{ $item->kapasitas_daya }} kWh</td>
      <td>{{ $item->sektor }}</td>
      <td>{{ $item->peruntukan }}</td>
      <td>{{ $item->up3 }}</td>
      <td>{{ $item->ulp }}</td>
      <td>{{ $item->kriteria_prioritas }}</td>
    </tr>@endforeach</tbody>
</table>