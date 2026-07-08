<div class="table-responsive contenedor-tabla">
    <table class="table table-bordered table-sm tabla-consolidado">
        <thead>
            <tr>
                <th class="col-numero">Nº</th>
                <th class="col-concepto">Concepto</th>
                <th>Total Anual</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($conceptos as $concepto)
                @php
                    $valor = $registrosResumen[$concepto->id]->total ?? 0;
                    $esAutomatico = in_array((int) $concepto->orden, [19, 44]);
                @endphp

                <tr class="{{ $esAutomatico ? 'fila-automatica' : '' }}">
                    <td class="text-center font-weight-bold col-numero">{{ $concepto->orden }}</td>
                    <td class="font-weight-bold col-concepto">{{ $concepto->nombre }}</td>
                    <td class="text-center font-weight-bold {{ $valor > 0 ? 'celda-dato' : '' }}">
                        {{ $valor }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
