<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Atenciones Médicas</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0f766e, #064e3b);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-container {
            width: 90%;
            max-width: 1050px;
            text-align: center;
        }

        .logo {
            font-size: 70px;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 42px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 18px;
            margin-bottom: 35px;
            color: #d1fae5;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 18px;
            margin-bottom: 35px;
        }

        .card {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 22px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .card i {
            font-size: 32px;
            margin-bottom: 12px;
            color: #a7f3d0;
        }

        .card h3 {
            margin: 8px 0;
            font-size: 18px;
        }

        .card p {
            font-size: 14px;
            color: #dcfce7;
        }

        .btn-login {
            display: inline-block;
            padding: 14px 34px;
            background: #ffffff;
            color: #065f46;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #d1fae5;
            transform: translateY(-2px);
        }

        .footer {
            margin-top: 35px;
            font-size: 13px;
            color: #d1fae5;
        }

        .developer {
            margin-top: 6px;
            font-weight: bold;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <div class="logo">
            <i class="fas fa-hospital-user"></i>
        </div>

        <h1>Sistema de Control de Atenciones Médicas</h1>

        <p class="subtitle">
            Registro, administración y generación de reportes de atenciones médicas diarias.
        </p>

        <div class="cards">
            <div class="card">
                <i class="fas fa-user-md"></i>
                <h3>Médicos</h3>
                <p>Administración del catálogo de médicos.</p>
            </div>

            <div class="card">
                <i class="fas fa-list-check"></i>
                <h3>Conceptos</h3>
                <p>Control de conceptos de atención médica.</p>
            </div>

            <div class="card">
                <i class="fas fa-calendar-days"></i>
                <h3>Atenciones Diarias</h3>
                <p>Registro mensual por médico.</p>
            </div>

            <div class="card">
                <i class="fas fa-file-excel"></i>
                <h3>Reportes</h3>
                <p>Consolidados mensuales, anuales y exportación a Excel.</p>
            </div>
        </div>

        <a href="{{ route('login') }}" class="btn-login">
            <i class="fas fa-right-to-bracket"></i> Iniciar Sesión
        </a>

        <div class="footer">
            Sistema de Control de Atenciones Médicas v1.0<br>
            © {{ date('Y') }} Todos los derechos reservados.
            <div class="developer">
                <i class="fas fa-code"></i> Desarrollado por José Hernández
            </div>
        </div>
    </div>
</body>

</html>
