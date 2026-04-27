<x-filament-panels::page>
    <div style="display: flex; flex-direction: column; gap: 24px;">
        {{ $this->form }}

        <div style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        ">
            <div style="
                border: 1px solid rgba(59, 130, 246, .25);
                background: rgba(59, 130, 246, .08);
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            ">
                <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">
                    Total Tagihan
                </div>
                <div style="font-size: 26px; font-weight: 700;">
                    Rp {{ number_format($this->totalTagihan, 0, ',', '.') }}
                </div>
                <div style="font-size: 13px; color: #d97706; margin-top: 8px;">
                    Tagihan bulan ini
                </div>
            </div>

            <div style="
                border: 1px solid rgba(34, 197, 94, .25);
                background: rgba(34, 197, 94, .08);
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            ">
                <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">
                    Total Dibayar
                </div>
                <div style="font-size: 26px; font-weight: 700;">
                    Rp {{ number_format($this->totalDibayar, 0, ',', '.') }}
                </div>
                <div style="font-size: 13px; color: #16a34a; margin-top: 8px;">
                    Dibayar untuk tagihan periode ini
                </div>
            </div>

            <div style="
                border: 1px solid rgba(245, 158, 11, .25);
                background: rgba(245, 158, 11, .08);
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            ">
                <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">
                    Pembayaran Masuk
                </div>
                <div style="font-size: 26px; font-weight: 700;">
                    Rp {{ number_format($this->totalPembayaranMasuk, 0, ',', '.') }}
                </div>
                <div style="font-size: 13px; color: #d97706; margin-top: 8px;">
                    Pembayaran masuk bulan ini
                </div>
            </div>

            <div style="
                border: 1px solid rgba(239, 68, 68, .25);
                background: rgba(239, 68, 68, .08);
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            ">
                <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">
                    Total Tunggakan
                </div>
                <div style="font-size: 26px; font-weight: 700;">
                    Rp {{ number_format($this->totalTunggakan, 0, ',', '.') }}
                </div>
                <div style="font-size: 13px; color: #dc2626; margin-top: 8px;">
                    Belum lunas / sebagian
                </div>
            </div>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>