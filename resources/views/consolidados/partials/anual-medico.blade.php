<div class="table-responsive contenedor-tabla">
    <table class="table table-bordered table-sm tabla-consolidado">
        <thead>
            <tr>
                <th class="col-numero">Nº</th>
                <th class="col-concepto">Concepto</th>

                @foreach ($medicos as $medico)
                    <th>{{ $medico->nombre }}</th>
                @endforeach

                <th>Total General</th>
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

                    @foreach ($medicos as $medico)
                        @php
                            $key = $medico->id . '_' . $concepto->id;
                            $valor = $registrosPorMedico[$key]->total ?? 0;
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
