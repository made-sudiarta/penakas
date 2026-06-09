<x-filament-panels::page>
    <div style="display: flex; flex-direction: column; gap: 24px;">
        {{ $this->form }}

        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:16px;
        ">
        @if($this->jenis_laporan !== 'prajuru')

            <div style="
                border:1px solid #eab308;
                padding:16px;
                border-radius:12px;
            ">
                <div>Deposito LPD</div>
                <div style="font-size:24px;font-weight:bold;">
                    Rp {{ number_format($this->saldoDeposito,0,',','.') }}
                </div>
            </div>

            <div style="
                border:1px solid #06b6d4;
                padding:16px;
                border-radius:12px;
            ">
                <div>Tabungan LPD</div>
                <div style="font-size:24px;font-weight:bold;">
                    Rp {{ number_format($this->saldoTabungan,0,',','.') }}
                </div>
            </div>

            <div style="
                border:1px solid #a855f7;
                padding:16px;
                border-radius:12px;
            ">
                <div>Dana Cash</div>
                <div style="font-size:24px;font-weight:bold;">
                    Rp {{ number_format($this->saldoDanaCash,0,',','.') }}
                </div>
            </div>

        @endif

        @if($this->jenis_laporan !== 'banjar')

            <div style="
                border:2px solid #2563eb;
                padding:16px;
                border-radius:12px;
            ">
                <div>Kas Prajuru</div>
                <div style="font-size:24px;font-weight:bold;">
                    Rp {{ number_format($this->saldoKasPrajuru,0,',','.') }}
                </div>
            </div>

        @endif

            <div style="
                border:2px solid #2563eb;
                padding:16px;
                border-radius:12px;
                box-shadow:0 0 12px rgba(37,99,235,.3);
            ">
                <div>Total Saldo</div>
                <div style="font-size:24px;font-weight:bold;">
                    Rp {{ number_format($this->totalSaldoSemua,0,',','.') }}
                </div>
            </div>
        </div>


        {{ $this->table }}
    </div>
</x-filament-panels::page>