<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Atenciones Médicas — Ingreso</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #0B3B5C;
            --navy-dark: #082A44;
            --navy-deeper: #051D30;
            --teal: #1E8A75;
            --teal-light: #2FB39A;
            --bg: #F5F8FA;
            --card: #FFFFFF;
            --ink: #16232E;
            --muted: #6B7A88;
            --border: #E2E8ED;
            --danger: #C7373F;
            --danger-bg: #FDEEEF;
        }

        * { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            background: var(--bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(30, 138, 117, 0.05), transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(11, 59, 92, 0.05), transparent 45%);
        }

        .clinic-shell {
            width: 100%;
            max-width: 940px;
        }

        .clinic-card {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            background: var(--card);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px -25px rgba(5, 29, 48, 0.35), 0 2px 8px rgba(5, 29, 48, 0.06);
        }

        /* ---------- Panel izquierdo: monitor ---------- */

        .monitor-panel {
            background: linear-gradient(160deg, var(--navy) 0%, var(--navy-dark) 65%, var(--navy-deeper) 100%);
            color: #fff;
            padding: 44px 38px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .monitor-top {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .monitor-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .monitor-icon svg {
            width: 24px;
            height: 24px;
        }

        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--teal-light);
            margin: 0;
        }

        .monitor-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 26px;
            font-weight: 600;
            line-height: 1.25;
            margin: 0;
            letter-spacing: -0.01em;
        }

        .monitor-subtitle {
            font-size: 13.5px;
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.68);
            margin: 0;
            max-width: 30ch;
        }

        /* ECG waveform */
        .ekg-wrap {
            margin: 30px 0 6px;
        }

        .ekg-wrap svg {
            width: 100%;
            height: 46px;
            display: block;
            overflow: visible;
        }

        .ekg-line {
            fill: none;
            stroke: var(--teal-light);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 340;
            stroke-dashoffset: 340;
            animation: draw-ekg 2.4s ease-out 0.3s forwards;
            filter: drop-shadow(0 0 4px rgba(47, 179, 154, 0.55));
        }

        @keyframes draw-ekg {
            to { stroke-dashoffset: 0; }
        }

        .monitor-readouts {
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.75);
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .readout-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .readout-label {
            letter-spacing: 0.06em;
            color: rgba(255, 255, 255, 0.5);
        }

        .status-live {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--teal-light);
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--teal-light);
            box-shadow: 0 0 0 0 rgba(47, 179, 154, 0.6);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%   { box-shadow: 0 0 0 0 rgba(47, 179, 154, 0.55); }
            70%  { box-shadow: 0 0 0 7px rgba(47, 179, 154, 0); }
            100% { box-shadow: 0 0 0 0 rgba(47, 179, 154, 0); }
        }

        /* ---------- Panel derecho: formulario ---------- */

        .form-panel {
            padding: 44px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-heading {
            margin: 0 0 28px;
        }

        .form-heading h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 19px;
            font-weight: 600;
            margin: 0 0 4px;
            color: var(--ink);
        }

        .form-heading p {
            margin: 0;
            font-size: 13px;
            color: var(--muted);
        }

        .status-banner {
            background: #EAF6F2;
            border: 1px solid #CDEBE2;
            color: #146455;
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .field-group {
            margin-bottom: 20px;
        }

        .field-group label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 7px;
            letter-spacing: 0.01em;
        }

        .field-box {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1.5px solid var(--border);
            border-radius: 11px;
            padding: 0 14px;
            background: #FBFCFD;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .field-box:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(30, 138, 117, 0.12);
            background: #fff;
        }

        .field-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: var(--muted);
        }

        .field-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            padding: 12px 0;
            font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            color: var(--ink);
        }

        .field-box input::placeholder {
            color: #A6B2BD;
        }

        .field-error {
            margin-top: 7px;
            font-size: 12.5px;
            color: var(--danger);
        }

        .medical-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4px 0 26px;
            font-size: 13px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            cursor: pointer;
        }

        .remember-label input {
            width: 16px;
            height: 16px;
            accent-color: var(--teal);
        }

        .medical-options a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 500;
        }

        .medical-options a:hover { text-decoration: underline; }

        .medical-btn {
            width: 100%;
            padding: 13px 0;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--teal) 0%, #17705F 100%);
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 14.5px;
            font-weight: 600;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: transform 0.12s ease, box-shadow 0.15s ease;
            box-shadow: 0 10px 20px -8px rgba(30, 138, 117, 0.55);
        }

        .medical-btn:hover {
            box-shadow: 0 12px 24px -6px rgba(30, 138, 117, 0.6);
        }

        .medical-btn:active {
            transform: translateY(1px);
        }

        .medical-btn:focus-visible,
        .field-box input:focus-visible,
        .medical-options a:focus-visible {
            outline: 2px solid var(--teal);
            outline-offset: 2px;
        }

        .medical-footer {
            margin-top: 26px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10.5px;
            letter-spacing: 0.03em;
            color: var(--muted);
            line-height: 1.7;
            text-align: center;
        }

        .medical-footer strong {
            color: var(--ink);
        }

        /* ---------- Responsive ---------- */

        @media (max-width: 760px) {
            .clinic-card {
                grid-template-columns: 1fr;
            }

            .monitor-panel {
                padding: 32px 28px;
            }

            .monitor-readouts {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 16px 24px;
                padding-top: 18px;
            }

            .form-panel {
                padding: 32px 28px 30px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .ekg-line {
                animation: none;
                stroke-dashoffset: 0;
            }

            .status-dot {
                animation: none;
            }
        }
    </style>
</head>
<body>

    <div class="clinic-shell">
        <div class="clinic-card">

            <!-- Panel izquierdo: monitor clínico -->
            <div class="monitor-panel">
                <div class="monitor-top">
                    <div class="monitor-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>

                    <div>
                        <p class="eyebrow">Panel clínico administrativo</p>
                        <h1 class="monitor-title">Sistema de Atenciones Médicas</h1>
                    </div>

                    <p class="monitor-subtitle">Control diario, reportes y gestión clínica administrativa.</p>
                </div>

                <div>
                    <div class="ekg-wrap" aria-hidden="true">
                        <svg viewBox="0 0 300 46" preserveAspectRatio="none">
                            <path class="ekg-line" d="M0,23 L60,23 L74,23 L82,6 L92,40 L102,15 L112,23 L130,23 L300,23" />
                        </svg>
                    </div>

                    <div class="monitor-readouts">
                        <div class="readout-row">
                            <span class="readout-label">Estado</span>
                            <span class="status-live"><span class="status-dot"></span>En línea</span>
                        </div>
                        <div class="readout-row">
                            <span class="readout-label">Fecha</span>
                            <span>{{ now()->format('d/m/Y') }}</span>
                        </div>
                        <div class="readout-row">
                            <span class="readout-label">Versión</span>
                            <span>SCAM v1.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel derecho: formulario -->
            <div class="form-panel">
                <div class="form-heading">
                    <h2>Ingreso al sistema</h2>
                    <p>Ingrese sus credenciales para continuar</p>
                </div>

                @if (session('status'))
                    <div class="status-banner">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <div class="field-group">
                        <label for="email">Correo electrónico</label>
                        <div class="field-box">
                            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Z"></path>
                                <path d="m22 6-10 7L2 6"></path>
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username" placeholder="usuario@correo.com">
                        </div>
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="password">Contraseña</label>
                        <div class="field-box">
                            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="Ingrese su contraseña">
                        </div>
                        @error('password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="medical-options">
                        <label class="remember-label">
                            <input type="checkbox" name="remember">
                            Recordarme
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">¿Olvidó su contraseña?</a>
                        @endif
                    </div>

                    <button type="submit" class="medical-btn">Ingresar al sistema</button>
                </form>

                <div class="medical-footer">
                    Sistema de Control de Atenciones Médicas v1.0<br>
                    © {{ date('Y') }}<br>
                    <strong>Desarrollado por José Hernández</strong>
                </div>
            </div>

        </div>
    </div>

</body>
</html>