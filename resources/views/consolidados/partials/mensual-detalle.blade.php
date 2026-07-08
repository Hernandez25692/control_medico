@foreach ($medicos as $medico)
    <div class="mb-4">
        <h5 class="font-weight-bold">
            <i class="fas fa-user-md"></i> {{ $medico->nombre }}
        </h5>

        <div class="table-responsive contenedor-tabla">
            <table class="table table-bordered table-sm tabla-consolidado">
                <thead>
                    <tr>
                        <th class="col-numero">Nº</th>
                        <th class="col-concepto">Concepto</th>

                        @for ($dia = 1; $dia <= $diasMes; $dia++)
                            <th>{{ $dia }}</th>
                        @endfor

                        <th>Total</th>
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

                            @for ($dia = 1; $dia <= $diasMes; $dia++)
                                @php
                                    $key = $medico->id . '_' . $concepto->id . '_' . $dia;
                                    $valor = $registrosDetalle[$key]->cantidad ?? 0;
                                    $totalFila += $valor;
                                @endphp

                                <td class="text-center {{ $valor > 0 ? 'celda-dato' : '' }}">
                                    {{ $valor }}
                                </td>
                            @endfor

                            <td class="text-center font-weight-bold celda-total">
                                {{ $totalFila }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach
