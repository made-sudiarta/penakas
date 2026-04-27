<x-filament-panels::page>
    <form wire:submit="save">
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{ $this->form }}

            <div style="
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                align-items: center;
            ">
                <button
                    type="submit"
                    style="
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 8px;
                        background: #f59e0b;
                        color: white;
                        font-weight: 600;
                        padding: 10px 18px;
                        border: none;
                        cursor: pointer;
                    "
                >
                    Simpan
                </button>

                <a
                    href="{{ url()->previous() }}"
                    style="
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 8px;
                        background: #f3f4f6;
                        color: #374151;
                        font-weight: 600;
                        padding: 10px 18px;
                        text-decoration: none;
                    "
                >
                    Batal
                </a>
            </div>
        </div>
    </form>
</x-filament-panels::page>