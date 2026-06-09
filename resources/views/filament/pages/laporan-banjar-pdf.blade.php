<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $judulLaporan }}</title>

    <style>
        @page {
            size: A4 portrait;
            margin:18px;
            margin-top:0px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* HEADER */
        .header-table {
            margin-bottom: 8px;
        }

        .header-table td {
            border: 0;
            vertical-align: middle;
        }

        .logo {
            width: 75px;
        }

        .header-title {
            text-align: center;
            padding-right: 70px;
        }

        .header-title h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .header-title h2 {
            margin: 3px 0;
            font-size: 14px;
            font-weight: bold;
        }

        .header-title p {
            margin: 2px 0;
            font-size: 12px;
        }

        .line-top {
            border-top: 3px solid #000;
            margin-top: 8px;
        }

        .line-bottom {
            border-top: 1px solid #000;
            margin-top: 2px;
            margin-bottom: 18px;
        }

        /* TITLE */
        .report-title {
            text-align: center;
            margin-bottom: 16px;
        }

        .report-title h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .periode {
            margin-top: 6px;
            font-size: 11px;
        }

        /* TABLE */
        .main-table {
            margin-top: 10px;
        }

        .main-table th {
            background-color: #eaeaea;
            border: 1px solid #555;
            padding: 8px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .main-table td {
            border: 1px solid #777;
            padding: 7px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge-masuk {
            color: #0a7d22;
            font-weight: bold;
        }

        .badge-keluar {
            color: #c1121f;
            font-weight: bold;
        }
        .badge-info {
            color: #2695ef;
            font-weight: bold;
        }

        /* SUMMARY */
        .summary {
            width: 42%;
            margin-left: auto;
            margin-top: 18px;
        }

        .summary th,
        .summary td {
            border: 1px solid #666;
            padding: 8px;
        }

        .summary th {
            background: #f3f3f3;
            text-align: left;
            width: 60%;
        }

        .saldo {
            background: #ececec;
            font-weight: bold;
        }

        /* FOOTER */
        .footer {
            margin-top: 65px;
            width: 100%;
        }

        .footer-table {
            width: 100%;
        }

        .footer-table td {
            border: 0;
            text-align: center;
            vertical-align: top;
        }

        .ttd-space {
            height: 100px;
        }

        .nama-pejabat {
            font-weight: bold;
            text-decoration: underline;
        }

        .jabatan {
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td width="90">
                <img
                    src="{{ public_path('images/logo-banjar2.png') }}"
                    class="logo"
                >
            </td>

            <td class="header-title">
                <h1>BANJAR ADAT MINGGIR</h1>
                <h2>DESA ADAT PADANGSAMBIAN</h2>
                <p>
                    JL. Gn. Sanghyang Gang Mertagangga No. 1 Kecamatan Denpasar Barat – Bali
                </p>
            </td>
        </tr>
    </table>

    <div class="line-top"></div>
    <div class="line-bottom"></div>

    <!-- TITLE -->
    <div class="report-title">
        <h3>{{ $judulLaporan }}</h3>

        <div class="periode">
            <strong>{{ $periode?->nama ?? '-' }}</strong>

            <br>

            {{ $periode?->tanggal_mulai?->translatedFormat('d F Y') ?? '-' }}
            s/d
            {{ $periode?->tanggal_selesai?->translatedFormat('d F Y') ?? '-' }}
        </div>
    </div>

    <!-- TABLE -->
    <table class="main-table">
        <thead>
            <tr>
                <th width="10%">Tanggal</th>
                <th width="13%">Kategori</th>
                <th>Judul</th>
                <th width="15%">Tipe</th>
                <th width="15%">Nominal</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $item->kategoriDanaBanjar->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $item->judul }}
                    </td>

                    <td class="text-center">
                        @if($item->tipe === 'kas-awal')
                            <span class="badge-info">
                                Kas Awal
                            </span>
                        @elseif($item->tipe === 'pemasukan')
                            <span class="badge-masuk">
                                Pemasukan
                            </span>
                        @else
                            <span class="badge-keluar">
                                Pengeluaran
                            </span>
                        @endif
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Tidak ada data laporan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SUMMARY -->

    <div style="margin-top:20px; margin-bottom:10px;">
        <strong>Jenis Laporan:</strong>
        {{ $judulLaporan }}
    </div>

    <table class="summary">
        <tr>
            <th>Saldo Awal</th>
            <td class="text-right">
                Rp {{ number_format($totalKasAwal, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <th>Total Pemasukan</th>
            <td class="text-right">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <th>Total Pengeluaran</th>
            <td class="text-right">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </td>
        </tr>

        <tr class="saldo">
            <th>Saldo Akhir</th>
            <td class="text-right">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">

        <table class="footer-table">
            <tr>
                <td width="50%">
                    Mengetahui,<br>
                    <span class="jabatan">
                        Kelihan Adat Banjar Minggir
                    </span>

                    <div class="ttd-space"></div>

                    <div class="nama-pejabat">
                        I Ketut Sumarna, S.Pd., M.Si.
                    </div>
                </td>

                <td width="50%">
                    Denpasar, 
                    {{ now()->translatedFormat('d F Y') }}
                    <br>

                    <span class="jabatan">
                        Bendahara Banjar Minggir
                    </span>

                    <div class="ttd-space"></div>

                    <div class="nama-pejabat">
                        I Made Sudiarta, S.Kom.
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>