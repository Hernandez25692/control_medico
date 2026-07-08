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

<div class="table-responsive contenedor-tabla">
    <table class="table table-bordered table-sm tabla-consolidado">
        <thead>
            <tr>
                <th class="col-numero">Nº</th>
                <th class="col-concepto">Concepto</th>

                @foreach ($meses as $nombre)
                    <th>{{ $nombre }}</th>
                @endforeach

                <th>Total Anual</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($conceptos as $concepto)
                @php
                    $totalFila = 0;
                    $esAutomatico = in_array((int) $concepto->orden, [19, 44]);
                @endphp

                <tr class="{{ $esAutomatico ? 'fila-automatica' : '' }}">
                    <td class="text-center font-weight-bold col-numero">{{ $concepto->orden }}</td>
                    <td class="font-weight-bold col-concepto">{{ $concepto->nombre }}</td>

                    @foreach ($meses as $numero => $nombre)
                        @php
                            $key = $concepto->id . '_' . $numero;
                            $valor = $registrosDetalle[$key]->total ?? 0;
                            $totalFila += $valor;
                        @endphp

                        <td class="text-center {{ $valor > 0 ? 'celda-dato' : '' }}">
                            {{ $valor }}
                        </td>
                    @endforeach

                    <td class="text-center celda-total">{{ $totalFila }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
