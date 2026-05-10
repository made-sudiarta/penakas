<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Banjar - Tabel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Banjar - Tabel</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Tipe</th>
                <th>Nominal</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ htmlspecialchars($item->kategoriDanaBanjar->nama ?? '-', ENT_QUOTES, 'UTF-8') }}</td>
                    <td>{{ htmlspecialchars($item->judul, ENT_QUOTES, 'UTF-8') }}</td>
                    <td>{{ ucfirst($item->tipe) }}</td>
                    <td>{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>
                        @if($item->foto_nota)
                            <img src="{{ public_path('storage/' . $item->foto_nota) }}" alt="Nota" width="50">
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>