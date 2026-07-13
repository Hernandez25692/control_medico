<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Atenciones Médicas</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy: #0B3B5C;
            --navy-dark: #082A44;
            --navy-deeper: #051D30;
            --teal: #1E8A75;
            --teal-light: #2FB39A;
            --ink: #16232E;
            --muted-on-dark: rgba(255, 255, 255, 0.68);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            height: 100%;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: radial-gradient(circle at 20% 10%, rgba(47, 179, 154, 0.10), transparent 45%),
                linear-gradient(160deg, var(--navy) 0%, var(--navy-dark) 55%, var(--navy-deeper) 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        /* ---------- Banda de monitor cardíaco (firma visual) ---------- */

        .ekg-band {
            width: 100%;
            height: 88px;
            overflow: hidden;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.12);
        }

        .ekg-band::before,
        .ekg-band::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 60px;
            z-index: 2;
            pointer-events: none;
        }

        .ekg-band::before {
            left: 0;
            background: linear-gradient(90deg, var(--navy-deeper), transparent);
        }

        .ekg-band::after {
            right: 0;
            background: linear-gradient(270deg, var(--navy-deeper), transparent);
        }

        .ekg-track {
            display: flex;
            width: 200%;
            height: 100%;
            animation: scroll-ekg 9s linear infinite;
        }

        .ekg-track svg {
            width: 50%;
            height: 100%;
            flex-shrink: 0;
        }

        .ekg-pulse {
            fill: none;
            stroke: var(--teal-light);
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            filter: drop-shadow(0 0 5px rgba(47, 179, 154, 0.6));
        }

        .ekg-baseline {
            stroke: rgba(255, 255, 255, 0.08);
            stroke-width: 1;
        }

        @keyframes scroll-ekg {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* ---------- Contenido principal ---------- */

        .welcome-container {
            width: 90%;
            max-width: 1050px;
            text-align: center;
            padding: 48px 0 40px;
        }

        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--teal-light);
            margin: 0 0 18px;
        }

        .logo {
            width: 76px;
            height: 76px;
            margin: 0 auto 22px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo i {
            font-size: 32px;
            color: var(--teal-light);
        }

        h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 40px;
            line-height: 1.15;
            margin: 0 0 14px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .subtitle {
            font-size: 16px;
            margin: 0 auto 40px;
            max-width: 56ch;
            color: var(--muted-on-dark);
            line-height: 1.6;
        }

        /* ---------- Tarjetas ---------- */

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 16px;
            margin-bottom: 40px;
            text-align: left;
        }

        .card {
            background: rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 22px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(47, 179, 154, 0.4);
        }

        .card-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(47, 179, 154, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .card i {
            font-size: 18px;
            color: var(--teal-light);
        }

        .card h3 {
            font-family: 'Space Grotesk', sans-serif;
            margin: 0 0 6px;
            font-size: 16.5px;
            font-weight: 600;
        }

        .card p {
            font-size: 13.5px;
            color: var(--muted-on-dark);
            margin: 0;
            line-height: 1.5;
        }

        /* ---------- CTA ---------- */

        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 36px;
            background: linear-gradient(135deg, var(--teal) 0%, #17705F 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.01em;
            box-shadow: 0 14px 28px -10px rgba(30, 138, 117, 0.55);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 32px -8px rgba(30, 138, 117, 0.65);
        }

        .btn-login:focus-visible {
            outline: 2px solid var(--teal-light);
            outline-offset: 3px;
        }

        /* ---------- Readouts de estado ---------- */

        .status-readouts {
            display: flex;
            justify-content: center;
            gap: 28px;
            flex-wrap: wrap;
            margin-top: 34px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: var(--muted-on-dark);
        }

        .status-readouts span.readout-label {
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 0.05em;
            margin-right: 6px;
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
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0% {
                box-shadow: 0 0 0 0 rgba(47, 179, 154, 0.55);
            }

            70% {
                box-shadow: 0 0 0 7px rgba(47, 179, 154, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(47, 179, 154, 0);
            }
        }

        /* ---------- Footer ---------- */

        .footer {
            margin-top: 38px;
            font-size: 12.5px;
            color: var(--muted-on-dark);
            font-family: 'IBM Plex Mono', monospace;
            line-height: 1.8;
        }

        .developer {
            margin-top: 4px;
            font-weight: 600;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        /* ---------- Responsive ---------- */

        @media (max-width: 640px) {
            h1 {
                font-size: 28px;
            }

            .subtitle {
                font-size: 14.5px;
            }

            .ekg-band {
                height: 64px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .ekg-track {
                animation: none;
            }

            .status-dot {
                animation: none;
            }
        }
    </style>
</head>

<body>

    <!-- Banda de monitor cardíaco -->
    <div class="ekg-band" aria-hidden="true">
        <div class="ekg-track">
            <svg viewBox="0 0 400 88" preserveAspectRatio="none">
                <line class="ekg-baseline" x1="0" y1="44" x2="400" y2="44" />
                <path class="ekg-pulse"
                    d="M0,44 L60,44 L74,44 L84,14 L96,74 L108,28 L120,44 L200,44 L214,44 L224,14 L236,74 L248,28 L260,44 L400,44" />
            </svg>
            <svg viewBox="0 0 400 88" preserveAspectRatio="none">
                <line class="ekg-baseline" x1="0" y1="44" x2="400" y2="44" />
                <path class="ekg-pulse"
                    d="M0,44 L60,44 L74,44 L84,14 L96,74 L108,28 L120,44 L200,44 L214,44 L224,14 L236,74 L248,28 L260,44 L400,44" />
            </svg>
        </div>
    </div>

    <div class="welcome-container">
        <p class="eyebrow">Panel clínico administrativo</p>

        <div class="logo">
            <i class="fas fa-hospital-user"></i>
        </div>

        <h1>Sistema de Control de Atenciones Médicas Prueba</h1>

        <p class="subtitle">
            Registro, administración y generación de reportes de atenciones médicas diarias.
        </p>

        <div class="cards">
            <div class="card">
                <div class="card-icon"><i class="fas fa-user-md"></i></div>
                <h3>Médicos</h3>
                <p>Administración del catálogo de médicos.</p>
            </div>

            <div class="card">
                <div class="card-icon"><i class="fas fa-list-check"></i></div>
                <h3>Conceptos</h3>
                <p>Control de conceptos de atención médica.</p>
            </div>

            <div class="card">
                <div class="card-icon"><i class="fas fa-calendar-days"></i></div>
                <h3>Atenciones Diarias</h3>
                <p>Registro mensual por médico.</p>
            </div>

            <div class="card">
                <div class="card-icon"><i class="fas fa-file-excel"></i></div>
                <h3>Reportes</h3>
                <p>Consolidados mensuales, anuales y exportación a Excel.</p>
            </div>
        </div>

        <a href="{{ route('login') }}" class="btn-login">
            <i class="fas fa-right-to-bracket"></i> Iniciar Sesión
        </a>

        <div class="status-readouts">

            <span><span class="readout-label">Fecha</span>{{ now()->format('d/m/Y') }}</span>
            <span><span class="readout-label">Versión</span>SCAM v1.0</span>
        </div>

        <div class="footer">
            © {{ date('Y') }} Todos los derechos reservados.
            <div class="developer">
                <i class="fas fa-code"></i> Desarrollado por José Hernández
            </div>
        </div>
    </div>

</body>

</html>
