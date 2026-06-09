<x-filament-panels::page>
   <div>
    <h1 style="font-size:32px;font-weight:bold;margin-bottom:8px;">
        {{ $this->judul }}
    </h1>

    <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">

        <label>Jenis Laporan:</label>

        <select
            wire:model.live="jenis_laporan"
            style="
                padding:8px 12px;
                border-radius:8px;
                border:1px solid #666;
            "
        >
            <option value="banjar">Keuangan Banjar</option>
            <option value="prajuru">Keuangan Prajuru</option>
            <option value="gabungan">Gabungan</option>
        </select>

    </div>
</div>

<!-- SUMMARY -->
<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:16px;
">

    <div style="
        border:1px solid #22c55e;
        border-radius:12px;
        padding:20px;
    ">
        <div>Total Aset</div>

        <div style="
            font-size:28px;
            font-weight:bold;
            margin-top:10px;
        ">
            Rp {{ number_format($this->totalAset,0,',','.') }}
        </div>
    </div>

    <div style="
        border:1px solid #3b82f6;
        border-radius:12px;
        padding:20px;
    ">
        <div>Total Pendapatan</div>

        <div style="
            font-size:28px;
            font-weight:bold;
            margin-top:10px;
        ">
            Rp {{ number_format($this->totalPendapatan,0,',','.') }}
        </div>
    </div>

    <div style="
        border:1px solid #ef4444;
        border-radius:12px;
        padding:20px;
    ">
        <div>Total Beban</div>

        <div style="
            font-size:28px;
            font-weight:bold;
            margin-top:10px;
        ">
            Rp {{ number_format($this->totalBeban,0,',','.') }}
        </div>
    </div>

</div>

<!-- ASET -->
<div style="
    border:1px solid #444;
    border-radius:12px;
    padding:20px;
">

    <h2 style="
        font-size:22px;
        font-weight:bold;
        margin-bottom:16px;
    ">
        ASET
    </h2>

    <table style="width:100%;">

        <thead>
            <tr>
                <th align="left">Kode</th>
                <th align="left">Nama Akun</th>
                <th align="right">Saldo</th>
            </tr>
        </thead>

        <tbody>

            @foreach($this->aset as $row)
                <tr>
                    <td>
                        {{ $row->kode }}
                    </td>

                    <td>
                        {{ $row->nama }}
                    </td>

                    <td align="right">
                        Rp {{ number_format($row->total,0,',','.') }}
                    </td>
                </tr>
            @endforeach

        </tbody>

        <tfoot>
            <tr style="font-weight:bold;">
                <td colspan="2">
                    TOTAL ASET
                </td>

                <td align="right">
                    Rp {{ number_format($this->totalAset,0,',','.') }}
                </td>
            </tr>
        </tfoot>

    </table>

</div>

<!-- PENDAPATAN -->
<div style="
    border:1px solid #444;
    border-radius:12px;
    padding:20px;
">

    <h2 style="
        font-size:22px;
        font-weight:bold;
        margin-bottom:16px;
    ">
        PENDAPATAN
    </h2>

    <table style="width:100%;">

        @foreach($this->pendapatan as $row)

            <tr>
                <td width="100">
                    {{ $row->akun?->kode }}
                </td>

                <td>
                    {{ $row->akun?->nama }}
                </td>

                <td align="right">
                    Rp {{ number_format($row->total,0,',','.') }}
                </td>
            </tr>

        @endforeach

        <tr style="font-weight:bold;">
            <td colspan="2">
                TOTAL PENDAPATAN
            </td>

            <td align="right">
                Rp {{ number_format($this->totalPendapatan,0,',','.') }}
            </td>
        </tr>

    </table>

</div>

<!-- BEBAN -->
<div style="
    border:1px solid #444;
    border-radius:12px;
    padding:20px;
">

    <h2 style="
        font-size:22px;
        font-weight:bold;
        margin-bottom:16px;
    ">
        BEBAN
    </h2>

    <table style="width:100%;">

        @foreach($this->beban as $row)

            <tr>
                <td width="100">
                    {{ $row->akun?->kode }}
                </td>

                <td>
                    {{ $row->akun?->nama }}
                </td>

                <td align="right">
                    Rp {{ number_format($row->total,0,',','.') }}
                </td>
            </tr>

        @endforeach

        <tr style="font-weight:bold;">
            <td colspan="2">
                TOTAL BEBAN
            </td>

            <td align="right">
                Rp {{ number_format($this->totalBeban,0,',','.') }}
            </td>
        </tr>

    </table>

</div>
<div style="
    border:1px solid {{ $this->surplusDefisit >= 0 ? '#22c55e' : '#ef4444' }};
    border-radius:12px;
    padding:20px;
">
    <div>
        {{ $this->surplusDefisit >= 0 ? 'Surplus' : 'Defisit' }}
    </div>

    <div style="
        font-size:28px;
        font-weight:bold;
        margin-top:10px;
        color:{{ $this->surplusDefisit >= 0 ? '#16a34a' : '#dc2626' }};
    ">
        Rp {{ number_format(abs($this->surplusDefisit),0,',','.') }}
    </div>
</div>
</x-filament-panels::page>