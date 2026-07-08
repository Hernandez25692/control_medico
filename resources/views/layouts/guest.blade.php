<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema de Control de Atenciones Médicas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="medical-page">
        <div class="medical-bg-shape shape-one"></div>
        <div class="medical-bg-shape shape-two"></div>

        <div class="medical-left">
            <div class="medical-brand">
                <div class="brand-icon">✚</div>
                <h2>Control Médico Diario</h2>
                <p>
                    Plataforma para consolidar atenciones médicas.
                </p>

                <div class="medical-list">
                    <div>✓ Registro de atenciones diarias</div>
                    <div>✓ Catálogo de médicos y conceptos</div>
                    <div>✓ Reportes mensuales y anuales</div>
                    <div>✓ Exportación a Excel</div>
                </div>
            </div>
        </div>

        <div class="medical-right">
            {{ $slot }}
        </div>
    </div>

</body>

</html>
