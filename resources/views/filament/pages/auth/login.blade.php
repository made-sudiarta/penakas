<div
    class="penakas-login-page"
    style="
        width: 100vw;
        min-height: 100vh;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        margin-top: -180px;
        margin-bottom: -180px;
        position: relative;
        z-index: 50;
        color-scheme: light;
        font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif;
    "
>
    @php
        $setting = \App\Models\AppSetting::getSetting();

        $appName = $setting->app_name ?? 'PenaKas';

        $description = $setting->description ?? 'Kelola keuangan kos dan banjar dalam satu aplikasi.'; // 👈 tambahkan ini

        $loginImage = asset('images/login-penakas.jpg');
    @endphp

    <div
        style="
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 32px;
            background:
                radial-gradient(circle at top left, rgba(168, 85, 247, .16), transparent 32%),
                radial-gradient(circle at bottom right, rgba(126, 34, 206, .10), transparent 30%),
                #f8fafc;
        "
    >
        <div
            class="penakas-login-card"
            style="
                width: 100%;
                max-width: 980px;
                min-height: 600px;
                display: grid;
                grid-template-columns: 45% 55%;
                background: #ffffff;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 24px 70px rgba(15, 23, 42, .14);
                border: 1px solid rgba(148, 163, 184, .22);
            "
        >
            <div
                class="penakas-login-image"
                style="
                    background-image:
                        linear-gradient(to bottom, rgba(15, 23, 42, .06), rgba(15, 23, 42, .28)),
                        url('{{ $loginImage }}');
                    background-size: cover;
                    background-position: center;
                    position: relative;
                "
            >
                <div
                    style="
                        position: absolute;
                        left: 28px;
                        right: 28px;
                        bottom: 28px;
                        padding: 20px;
                        border-radius: 18px;
                        background: rgba(15, 23, 42, .55);
                        backdrop-filter: blur(10px);
                        color: #ffffff;
                    "
                >
                    <div
                        style="
                            font-size: 22px;
                            font-weight: 900;
                            margin-bottom: 6px;
                            color: #ffffff;
                        "
                    >
                        {{ $appName }}
                    </div>

                    <div style="font-size: 14px; line-height: 1.6; color: rgba(255,255,255,.86);">
                        Catat Pemasukan, Pengeluaran, Pembayaran Kos, dan Dana Banjar dalam satu aplikasi.
                    </div>
                </div>
            </div>

            <div
                class="penakas-login-form-wrapper"
                style="
                    padding: 56px 52px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    background: #ffffff;
                    color: #0f172a;
                "
            >
                <div style="margin-bottom: 0px;">
                    <div style="margin-bottom: 26px;">
                        <div
                            style="
                                font-size: 36px;
                                font-weight: 900;
                                line-height: 1;
                                color: #7e22ce;
                                letter-spacing: -0.045em;
                            "
                        >
                            {{ $appName }}
                        </div>

                        <div style="font-size: 14px; color: #64748b; line-height: 1.5;">
                            {{ $description }}
                        </div>
                    </div>

                    <!-- <h1 style="font-size: 34px; font-weight: 900; margin: 0 0 10px; line-height: 1.15; color: #0f172a;">
                        Selamat Datang
                    </h1>

                    <p style="font-size: 15px; color: #64748b; margin: 0; line-height: 1.6;">
                        Masuk untuk melanjutkan ke dashboard {{ $appName }}.
                    </p> -->
                </div>

                <form wire:submit="authenticate">
                    <div style="display: flex; flex-direction: column; gap: 18px;">
                        {{ $this->form }}

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="authenticate"
                            style="
                                width: 100%;
                                height: 48px;
                                border-radius: 12px;
                                border: none;
                                background: linear-gradient(135deg, #a855f7, #7e22ce);
                                color: #ffffff;
                                font-weight: 800;
                                cursor: pointer;
                                box-shadow: 0 10px 24px rgba(126, 34, 206, .28);
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                gap: 10px;
                            "
                        >
                            <span wire:loading.remove wire:target="authenticate">
                                Masuk
                            </span>

                            <span
                                wire:loading
                                wire:target="authenticate"
                                style="
                                    width: 18px;
                                    height: 18px;
                                    border: 2px solid rgba(255,255,255,.45);
                                    border-top-color: #ffffff;
                                    border-radius: 9999px;
                                    animation: penakas-spin .8s linear infinite;
                                "
                            ></span>

                            <span wire:loading wire:target="authenticate">
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>

                <div style="margin-top: 28px; font-size: 13px; color: #94a3b8; line-height: 1.7;">
                    © {{ date('Y') }} {{ $appName }}.
                    <br>
                    Kelola keuangan lebih rapi dan mudah dipantau.
                </div>
            </div>
        </div>
    </div>

    <style>
        .penakas-login-page,
        .penakas-login-page * {
            color-scheme: light !important;
        }

        .penakas-login-page label,
        .penakas-login-page .fi-fo-field-wrp-label span,
        .penakas-login-page .fi-fo-field-wrp-label {
            color: #0f172a !important;
        }

        .penakas-login-page input {
            background: #ffffff !important;
            color: #0f172a !important;
            border-color: #d1d5db !important;
        }

        .penakas-login-page input:focus {
            border-color: #a855f7 !important;
            box-shadow: 0 0 0 1px #a855f7 !important;
        }

        .penakas-login-page .fi-checkbox-input {
            background-color: #ffffff !important;
            border-color: #d1d5db !important;
        }

        .penakas-login-page .fi-input-wrp {
            background: #ffffff !important;
        }

        .penakas-login-page .fi-input-wrp,
        .penakas-login-page .fi-input-wrp * {
            color: #0f172a !important;
        }

        .penakas-login-page .fi-input-wrp-suffix {
            background: #f8fafc !important;
        }

        @keyframes penakas-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        button[disabled] {
            opacity: .85;
            cursor: not-allowed !important;
        }

        @media (max-width: 900px) {
            .penakas-login-card {
                grid-template-columns: 1fr !important;
                max-width: 460px !important;
                min-height: auto !important;
            }

            .penakas-login-image {
                display: none !important;
            }

            .penakas-login-form-wrapper {
                padding: 36px 24px !important;
            }
        }
    </style>
</div>