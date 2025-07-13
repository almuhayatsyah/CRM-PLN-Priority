<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Data Pelanggan Prioritas PLN UID ACEH</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      font-size: 12px;
      color: #333;
      margin: 0;
      padding: 15px;
    }

    .header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 3px solid #F9A01B;
      padding-bottom: 10px;
    }

    .pln-title {
      color: #003366;
      font-size: 16px;
      font-weight: bold;
      margin: 5px 0;
    }

    .document-title {
      color: #F9A01B;
      font-size: 14px;
      font-weight: bold;
      margin: 10px 0;
    }

    .address {
      font-size: 11px;
      margin-bottom: 5px;
    }


    table {
      width: 100%;
      border-collapse: collapse;
      margin: 10px 0;
      page-break-inside: auto;
      table-layout: fixed;
      font-size: 10px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 4px 3px;
      text-align: left;
      word-break: break-word;
      vertical-align: top;
    }

    th {
      background-color: #003366;
      color: white;
      text-align: center;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f8f8f8;
    }

    .footer {
      margin-top: 20px;
      text-align: right;
      font-size: 10px;
      color: #666;
      border-top: 1px solid #ddd;
      padding-top: 8px;
    }

    .pln-stamp {
      text-align: right;
      margin-top: 15px;
    }

    .stamp {
      display: inline-block;
      border: 2px solid #F9A01B;
      padding: 5px 15px;
      color: #003366;
      font-weight: bold;
      font-size: 12px;
    }
  </style>
</head>

<body>
  <div class="header">
    <div class="logo">
      <img src="{{ public_path('images/pln_logo.png') }}" alt="Logo PLN" style="height:60px;">
    </div>
    <div class="pln-title">PT PLN (PERSERO) UNIT INDUK DISTRIBUSI ACEH</div>
    <div class="document-title">DATA PELANGGAN PRIORITAS</div>
    <div class="address">Jl. Tgk. Moh. Daud Beureueh No.172, Bandar Baru, Kec. Kuta Alam, Kota Banda Aceh, Aceh 24415
 </div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:4%">No</th>
        <th style="width:15%">ID Pelanggan</th>
        <th style="width:12%">Nama</th>
        <th style="width:14%">Perusahaan</th>
        <th style="width:10%">Kontak</th>
        <th style="width:8%">Daya (kVA)</th>
        <th style="width:9%">Sektor</th>
        <th style="width:12%">Peruntukan</th>
        <th style="width:9%">UP3</th>
        <th style="width:10%">ULP</th>
        <th style="width:20%">Kriteria Prioritas</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pelanggan as $i => $p)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $p->id_pel }}</td>
        <td>{{ $p->nama }}</td>
        <td>{{ $p->nama_perusahaan }}</td>
        <td>{{ $p->kontak }}</td>
        <td>{{ $p->kapasitas_daya }}</td>
        <td>{{ $p->sektor }}</td>
        <td>{{ $p->peruntukan }}</td>
        <td>{{ $p->up3 }}</td>
        <td>{{ $p->ulp }}</td>
        <td>{{ $p->kriteria_prioritas }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="pln-stamp">
    <div class="stamp">PLN UID ACEH</div>
  </div>

  <div class="footer">
    Dokumen ini dicetak pada {{ date('d F Y H:i:s') }} oleh Sistem CRM PAE PLN UID ACEH
  </div>
</body>

</html>
