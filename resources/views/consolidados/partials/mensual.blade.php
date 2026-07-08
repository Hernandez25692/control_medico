@section('css')
    <style>
        .contenedor-tabla {
            max-height: 680px;
            overflow: auto;
            border: 1px solid #dee2e6;
        }

        .tabla-consolidado {
            font-size: 13px;
            margin-bottom: 0;
        }

        .tabla-consolidado th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #e9ecef;
            text-align: center;
            white-space: nowrap;
        }

        .tabla-consolidado td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .col-numero {
            min-width: 55px;
            position: sticky;
            left: 0;
            background: #fff;
            z-index: 8;
        }

        .col-concepto {
            min-width: 390px;
            position: sticky;
            left: 55px;
            background: #fff;
            z-index: 8;
        }

        thead .col-numero,
        thead .col-concepto {
            z-index: 20;
            background: #dfe4ea;
        }

        .celda-dato {
            background: #d4edda;
            font-weight: bold;
        }

        .celda-total {
            background: #d1ecf1;
        }

        .fila-automatica td,
        .fila-automatica .col-numero,
        .fila-automatica .col-concepto {
            background: #fff3cd !important;
            font-weight: bold;
        }
    </style>
@stop
