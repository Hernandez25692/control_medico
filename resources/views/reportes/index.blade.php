@extends('adminlte::page')

@section('title', 'Centro de Reportes')

@section('content_header')
    <h1 class="mb-0">Centro de Reportes</h1>
    <small class="text-muted">Vista previa, impresión y exportación de reportes médicos</small>
@stop

@section('content')

    <div class="card shadow-sm border-0 no-print">
        <div class="card-header bg-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-file-medical-alt text-primary"></i> Generador de reportes
            </h3>
        </div>

        <div class="card-body">
            <form id="formReporte" class="row">

                <div class="col-md-3 mb-3">
                    <label>Reporte</label>
                    <select name="reporte" id="reporte" class="form-control">
                        <option value="mensual">Consolidado Mensual</option>
                        <option value="anual">Consolidado Anual</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3" id="grupoMes">
                    <label>Mes</label>
                    <select name="mes" class="form-control">
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

                        @foreach ($meses as $numero => $nombre)
                            <option value="{{ $numero }}" {{ date('n') == $numero ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ date('Y') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Tipo de vista</label>
                    <select name="tipo" class="form-control">
                        <option value="resumen">Resumen general</option>
                        <option value="medico">Resumen por médico</option>
                        <option value="detalle">Detalle</option>
                    </select>
                </div>

                <div class="col-md-12 text-right">
                    <button type="button" id="btnPreview" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Vista previa
                    </button>

                    <button type="button" id="btnPrintConfig" class="btn btn-dark">
                        <i class="fas fa-print"></i> Imprimir
                    </button>

                    <button type="button" id="btnExcel" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Descargar Excel
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white no-print">
            <h3 class="card-title mb-0">
                <i class="fas fa-search text-secondary"></i> Vista previa
                <span id="contadorRegistros" class="badge badge-success ml-2 d-none"></span>
            </h3>
        </div>

        <div class="card-body bg-light preview-body">
            <div id="previewContainer" class="report-preview">
                <div class="text-center text-muted p-5 no-print">
                    <i class="fas fa-file-medical fa-3x mb-3"></i>
                    <p>Presione <b>Vista previa</b> para generar el reporte.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade no-print" id="modalPrint" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Configurar impresión</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <label>Tamaño de papel</label>
                    <select id="papel" class="form-control mb-3">
                        <option value="Letter">Carta</option>
                        <option value="Legal">Legal</option>
                        <option value="A4">A4</option>
                    </select>

                    <label>Orientación</label>
                    <select id="orientacion" class="form-control mb-3">
                        <option value="landscape">Horizontal</option>
                        <option value="portrait">Vertical</option>
                    </select>

                    <label>Márgenes</label>
                    <select id="margen" class="form-control">
                        <option value="5mm">Estrecho</option>
                        <option value="8mm">Normal</option>
                        <option value="12mm">Amplio</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" id="btnPrint" class="btn btn-dark">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <style>
        .preview-body {
            padding: 15px;
        }

        .report-preview {
            background: #fff;
            min-height: 520px;
            padding: 15px;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
            overflow: auto;
        }

        .print-sheet {
            width: 100%;
            background: #fff;
            margin: 0 auto;
        }

        .report-title {
            text-align: center;
            margin: 0 0 8px 0;
            padding: 0;
        }

        .report-title h4 {
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            font-size: 20px;
            line-height: 1.1;
        }

        .report-title p {
            margin: 2px 0 0 0;
            color: #555;
            font-size: 13px;
            line-height: 1.1;
        }

        .table-report {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .table-report th,
        .table-report td {
            border: 1px solid #777;
            padding: 3px 5px;
            white-space: nowrap;
            vertical-align: middle;
        }

        .table-report th {
            background: #eef1f5;
            text-align: center;
            font-weight: 700;
        }

        .table-report td {
            text-align: center;
        }

        .table-report td:nth-child(2) {
            text-align: left;
        }

        @media print {
            @page {
                margin: 5mm;
            }

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: auto !important;
                background: #fff !important;
            }

            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body * {
                visibility: hidden !important;
            }

            #previewContainer,
            #previewContainer * {
                visibility: visible !important;
            }

            #previewContainer {
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                right: 0 !important;
                bottom: auto !important;
                width: 100% !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
                overflow: visible !important;
                background: #fff !important;
            }

            .content-wrapper,
            .content,
            .container-fluid,
            .card,
            .card-body,
            .preview-body,
            .report-preview {
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
                background: #fff !important;
                min-height: 0 !important;
                overflow: visible !important;
            }

            .no-print {
                display: none !important;
            }

            .print-sheet {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            .report-title {
                margin: 0 0 3mm 0 !important;
                padding: 0 !important;
                page-break-after: avoid !important;
            }

            .report-title h4 {
                font-size: 13pt !important;
                line-height: 1 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .report-title p {
                font-size: 9pt !important;
                line-height: 1 !important;
                margin: 1mm 0 0 0 !important;
                padding: 0 !important;
            }

            .table-report {
                width: 100% !important;
                border-collapse: collapse !important;
                table-layout: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                page-break-inside: auto !important;
            }

            .table-report thead {
                display: table-header-group !important;
            }

            .table-report tr {
                page-break-inside: avoid !important;
                page-break-after: auto !important;
            }

            .table-report th,
            .table-report td {
                font-size: 6.5pt !important;
                line-height: 1 !important;
                padding: 1.5px 2px !important;
                border: 1px solid #555 !important;
                white-space: nowrap !important;
                word-break: normal !important;
            }

            .table-report th {
                background: #e9ecef !important;
                font-weight: bold !important;
            }
        }
    </style>
@stop

@section('js')
    <script>
        $(function() {

            function toggleMes() {
                $('#grupoMes').toggle($('#reporte').val() === 'mensual');
            }

            function queryString() {
                return $('#formReporte').serialize();
            }

            function cargarPreview(callback = null) {
                $('#contadorRegistros').addClass('d-none').text('');

                $('#previewContainer').html(`
                    <div class="text-center text-muted p-5 no-print">
                        <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                        <p>Generando vista previa...</p>
                    </div>
                `);

                $.ajax({
                    url: "{{ route('reportes.preview') }}",
                    type: "GET",
                    data: queryString(),
                    success: function(html) {
                        $('#previewContainer').html(html);

                        let total = $('#previewContainer table tbody tr').length;
                        $('#contadorRegistros').removeClass('d-none').text(total + ' registros');

                        if (callback) {
                            callback();
                        }
                    },
                    error: function(xhr) {
                        let mensaje = 'No se pudo generar la vista previa del reporte.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            mensaje = xhr.responseJSON.message;
                        }

                        $('#previewContainer').html(`
                            <div class="alert alert-danger mb-0 no-print">
                                <i class="fas fa-exclamation-triangle"></i> ${mensaje}
                            </div>
                        `);
                    }
                });
            }

            function aplicarConfiguracionImpresion() {
                let papel = $('#papel').val();
                let orientacion = $('#orientacion').val();
                let margen = $('#margen').val();

                $('#printPageStyle').remove();

                let style = document.createElement('style');
                style.id = 'printPageStyle';

                style.innerHTML = `
                    @page {
                        size: ${papel} ${orientacion};
                        margin: ${margen};
                    }
                `;

                document.head.appendChild(style);
            }

            $('#reporte').on('change', toggleMes);
            toggleMes();

            $('#btnPreview').on('click', function() {
                cargarPreview();
            });

            $('#btnExcel').on('click', function() {
                window.location.href = "{{ route('reportes.exportar') }}?" + queryString();
            });

            $('#btnPrintConfig').on('click', function() {
                $('#modalPrint').modal('show');
            });

            $('#btnPrint').on('click', function() {
                cargarPreview(function() {
                    aplicarConfiguracionImpresion();

                    $('#modalPrint').modal('hide');

                    setTimeout(function() {
                        window.print();
                    }, 350);
                });
            });

        });
    </script>
@stop
