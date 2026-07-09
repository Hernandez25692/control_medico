@php
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];
@endphp

<div class="print-sheet">

    <div class="report-title">
        <h4>Consolidado de Atenciones Médicas</h4>

        <p>
            {{ ucfirst($reporte) }}

            @if ($reporte === 'mensual')
                - {{ $meses[(int) $mes] ?? '' }}
            @endif

            - {{ $anio }}
        </p>
    </div>

    <table class="table-report">
        <thead>
            <tr>
                @foreach ($encabezados as $encabezado)
                    <th>{{ $encabezado }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @forelse ($filas as $fila)
                <tr>
                    @foreach ($fila as $celda)
                        <td>{{ $celda }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($encabezados) }}" class="text-center">
                        No hay datos disponibles.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
