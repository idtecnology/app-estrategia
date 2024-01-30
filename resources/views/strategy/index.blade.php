@extends('layouts.master')
@section('title')
    Estrategias {{ $data_client['prefix_client'] }}
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Estrategias Activas
        @endslot
        @slot('title')
            Listado {{ $data_client['prefix_client'] }}
        @endslot
    @endcomponent
    @php
        date_default_timezone_set('UTC');
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('clients.index') }}" class="btn btn-dark">
                                <i class="ri-arrow-left-line me-1 align-bottom"></i>
                                Regresar
                            </a>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <a href="{{ route('strategy.history', [$data_client['prefix_client'], 3]) }}"
                                class="btn btn-outline-danger">
                                <i class="ri-history-line me-1 align-bottom"></i>
                                Histórico
                            </a>
                        </div>
                        <div class="col-md-auto">
                            <a href="{{ route('strategy.desing', $data_client['prefix_client']) }}" class="btn btn-info">
                                <i class="ri-pencil-ruler-2-line me-1 align-bottom"></i>
                                Diseñar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    {{-- <div class="row g-2">
                        <div class="col-md-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Buscar usuario...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted">Ordenar por: </span>
                                <select class="form-control mb-0" data-choices data-choices-search-false
                                    id="choices-single-default">
                                    <option value="pos">Posicion</option>
                                    <option value="email">Email</option>
                                    <option value="name">Nombre</option>
                                    <option value="roles">Rol</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>

                                        <th class="sort" data-sort="pos" scope="col">#</th>
                                        <th class="sort" data-sort="name" scope="col">Canal</th>
                                        <th class="sort text-center" data-sort="email" scope="col">Registros</th>
                                        <th class="sort" data-sort="email" scope="col">Repetidos</th>
                                        <th class="sort" data-sort="email" scope="col">Criterio</th>
                                        <th class="sort" data-sort="email" scope="col">Activacion</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($strategies as $key => $strategy)
                                        @if ($strategy['type'] == 2 && $strategy['inProcess'] == 1)
                                            <tr>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">{{ $strategy['id'] }}</a>
                                                </td>
                                                <td class="pos"><a class="text-primary" aria-label="Estadisticas"
                                                        title="Estadisticas" style="cursor: pointer" data-bs-toggle="modal"
                                                        data-bs-target="#showModalEstadisticas"
                                                        onclick="verEstadisticas({{ $strategy['id'] }}, '{{ $data_client['prefix_client'] }}')">{{ $strategy['id'] }}</a>
                                                </td>
                                                <td class="name">
                                                    {{ $strategy['canal'] }}
                                                </td>
                                                <td class="email text-center">
                                                    {{ number_format($strategy['registros_unicos'], 0, ',', '.') }}</td>
                                                <td class="email">
                                                    {{ number_format($strategy['registros_repetidos'], 0, ',', '.') }}</td>
                                                <td class="email">{{ $strategy['onlyWhere'] }}</td>
                                                <td class="email">
                                                    {{ $strategy['activation_date'] === null ? 'Sin Activar' : date('d-m-Y', strtotime($strategy['activation_date'])) }}
                                                    {{ $strategy['activation_time'] === null ? 'Sin Activar' : date('G:i:m', strtotime($strategy['activation_time'])) }}
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Stop">
                                                            <a onclick="stopedStrategy({{ $strategy['id'] }})"
                                                                class="remove-item-btn fs-4">
                                                                <i class="ri-stop-circle-line align-bottom text-muted"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                <tfoot>
                                    <tr class="text-center">
                                        <td colspan="2">&nbsp;</td>
                                        <td scope="col">
                                            <strong>{{ number_format($suma_total, 0, ',', '.') }}</strong>
                                        </td>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @include('strategy.modals.estadistica')
            </div>
        </div>
    @endsection
    @section('script')
        <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/apexcharts-pie.init.js') }}"></script>
        <script>
            var chartDonutBasicColors = getChartColorsArray("simple_dount_chart");


            function verEstadisticas(id, prefix) {
                if (chart) {
                    chart.destroy();
                }
                let opciones = {
                    style: "decimal",
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                };
                let linea = '';
                var tablaDatos = document.querySelector("#tabla-datos")

                var title = document.querySelector("#title-estadisticas")
                var dataEstrategia = document.querySelector("#data-estrategia")
                var tablaFoot = document.querySelector("#tabla-foot")


                title.innerHTML = ''
                dataEstrategia.innerHTML = ''
                tablaDatos.innerHTML = ''
                tablaFoot.innerHTML = ''

                fetch('{{ route('strategy.estadisticas') }}', {
                    method: 'POST',
                    body: JSON.stringify({
                        id: id,
                        prefix: prefix,
                        historico: false,
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    return response.json();
                }).then(data => {
                    let regsArray = Object.values(data.estadisticas).map(item => item.regs);
                    let statusArray = Object.values(data.estadisticas).map(item => item.status);

                    title.innerHTML = data.estrategia.prefix_client + ' ' + data.estrategia.id

                    dataEstrategia.innerHTML = `
                        <table class='table table-sm table-bordered align-middle'>
                            <tr>
                                <th>Criterio</th>
                                <td>${data.estrategia.onlyWhere}</td>
                            </tr>
                            <tr>
                                <th>Total de registros del criterio</th>
                                <td>${data.estrategia.total_registros.toLocaleString("de-DE")}</td>
                            </tr>
                            <tr>
                                <th>Cobertura de la cartera</th>
                                <td>${data.estrategia.cobertura.toLocaleString("de-DE")}%</td>
                            </tr>
                        </table>`


                    let tr = 0
                    let av = 0

                    for (let line of data.estadisticas) {
                        linea += '<tr class="text-center" >'
                        linea += '<td>' + line.status + '</td>';
                        linea += '<td>' + line.regs.toLocaleString("de-DE") + '</td>';
                        linea += '<td>' + ((line.regs / data.estrategia.total_registros) * 100).toFixed(2)
                            .toLocaleString("de-DE") + '%</td>';
                        linea += '</tr>';

                        tr += line.regs
                        av += ((line.regs / data.estrategia.total_registros) * 100)
                    }


                    tablaFoot.innerHTML = `
                            <tr>
                                <th>Total recorrido</th>
                                <th>${tr.toLocaleString("de-DE")}</th>
                                <th>${av.toFixed(2).toLocaleString("de-DE")}%</th>
                            </tr>
                            `
                    tablaDatos.innerHTML = linea;

                    if (chartDonutBasicColors) {
                        var options = {
                            series: regsArray,
                            labels: statusArray,
                            chart: {
                                height: 400,
                                type: 'pie',
                            },
                            legend: {
                                position: 'bottom'
                            },
                            dataLabels: {
                                enabled: true,
                                dropShadow: {
                                    enabled: false,
                                }

                            },
                            colors: chartDonutBasicColors
                        };
                        chart = new ApexCharts(document.querySelector("#simple_dount_chart"), options);
                        chart.render();
                    }
                });
            }






            function stopedStrategy(id) {
                fetch('{{ route('strategy.stopped-strategy') }}', {
                    method: 'POST',
                    body: JSON.stringify({
                        id: id,
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    return response.json();
                }).then(data => {
                    // Recargar la página actual
                    if (data.result === '201') {
                        alert(data.message)
                        // spinner.setAttribute('hidden', '');
                        location.reload()
                    } else {}
                });

            }
            const enlacesElement = document.querySelectorAll('.detener-estrategia');
            const csrfToken = "{{ csrf_token() }}";

            if (enlacesElement !== null) {
                enlacesElement.forEach((enlaceElement) => {
                    enlaceElement.addEventListener('click', (event) => {
                        console.log(enlaceElement.dataset.identificador)
                        const confirmacion = confirm('¿Desea detener la estrategia?');
                        if (!confirmacion) {
                            event.preventDefault();
                        } else {
                            fetch(`http://api.iawave:3000/api/v1/estrategia/detener/${enlaceElement.dataset.identificador}`, {
                                    method: 'PUT',
                                    headers: {
                                        'content-type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                })
                                .then(response => {
                                    if (response.ok) {
                                        // La respuesta fue exitosa (código de estado HTTP 200-299)
                                        return response
                                            .json(); // Devuelve una promesa que resuelve a un objeto JSON
                                    } else {
                                        // La respuesta no fue exitosa
                                        throw new Error('Error de respuesta');
                                    }
                                })
                                .then(data => {
                                    // Haz algo con los datos recibidos
                                    if (data.status === "201") {
                                        alert('Detenido con exito')
                                        location.reload()
                                    }
                                })
                                .catch(error => {
                                    // Manejar errores de red u otros errores
                                    console.error(error);
                                });
                        }
                    });
                });
            }
        </script>
    @endsection
