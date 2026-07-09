@extends('adminlte::page')

@section('title', 'Centro de Reportes')

@section('content_header')
    <h1 class="mb-0">Centro de Reportes</h1>
    <small class="text-muted">Vista previa, impresión y exportación de reportes médicos</small>
@stop

@section('content')

    <div class="card shadow-sm border-0">
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
        <div class="card-header bg-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-search text-secondary"></i> Vista previa
            </h3>
        </div>

        <div class="card-body bg-light">
            <div id="previewContainer" class="report-preview">
                <div class="text-center text-muted p-5">
                    <i class="fas fa-file-medical fa-3x mb-3"></i>
                    <p>Presione <b>Vista previa</b> para generar el reporte.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPrint" tabindex="-1">
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
                    <select id="orientacion" class="form-control">
                        <option value="landscape">Horizontal</option>
                        <option value="portrait">Vertical</option>
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
        .report-preview {
            background: #fff;
            min-height: 520px;
            padding: 25px;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
            overflow-x: auto;
        }

        .report-title {
            text-align: center;
            margin-bottom: 18px;
        }

        .report-title h4 {
            font-weight: 700;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .report-title p {
            margin-bottom: 0;
            color: #555;
        }

        .table-report {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .table-report th,
        .table-report td {
            border: 1px solid #999;
            padding: 5px 7px;
            white-space: nowrap;
        }

        .table-report th {
            background: #eef1f5;
            text-align: center;
            font-weight: 700;
        }

        .table-report td:first-child {
            text-align: center;
            font-weight: 600;
        }

        @media print {
            body * {
                visibility: hidden !important;
            }

            #previewContainer,
            #previewContainer * {
                visibility: visible !important;
            }

            #previewContainer {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 0;
                border: none;
                box-shadow: none;
                overflow: visible;
            }

            .report-preview {
                border: none;
                box-shadow: none;
                padding: 0;
                overflow: visible;
            }

            .table-report {
                width: 100% !important;
                table-layout: auto;
                page-break-inside: auto;
            }

            .table-report th,
            .table-report td {
                font-size: 9px;
                padding: 3px;
                white-space: normal;
                word-break: break-word;
            }

            tr {
                page-break-inside: avoid;
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
                $('#previewContainer').html(`
                <div class="text-center text-muted p-5">
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
                        <div class="alert alert-danger mb-0">
                            <i class="fas fa-exclamation-triangle"></i> ${mensaje}
                        </div>
                    `);
                    }
                });
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
                    let papel = $('#papel').val();
                    let orientacion = $('#orientacion').val();

                    $('#printPageStyle').remove();

                    let style = document.createElement('style');
                    style.id = 'printPageStyle';
                    style.innerHTML = `
                    @page {
                        size: ${papel} ${orientacion};
                        margin: 8mm;
                    }
                `;

                    document.head.appendChild(style);

                    $('#modalPrint').modal('hide');

                    setTimeout(function() {
                        window.print();
                    }, 400);
                });
            });

        });
    </script>
@stop
