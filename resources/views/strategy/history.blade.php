@extends('layouts.master')
@section('title')
    Estrategias {{ $data_client['prefix_client'] }}
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Estrategias historicas
        @endslot
        @slot('title')
            Listado historico {{ $data_client['prefix_client'] }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('strategy.show', $data_client['prefix_client']) }}" class="btn btn-dark">
                                <i class="ri-arrow-left-line me-1 align-bottom"></i>
                                Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row g-2">
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
                                    <option value="channel">Canal</option>
                                    <option value="activation">Activaci&oacute;n</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="listjs-table">
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="companyList">
                                <thead class="table-light">
                                    <tr>

                                        <th class="sort" data-sort="pos" scope="col">#</th>
                                        <th class="sort" data-sort="channel" scope="col">Canal</th>
                                        <th scope="col">Registros</th>
                                        <th scope="col">Repetidos</th>
                                        <th scope="col">Criterio</th>
                                        <th class="sort" data-sort="activation" scope="col">Activaci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($historical as $key => $strategy)
                                        @if ($strategy['type'] == 3)
                                            <tr>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">{{ $strategy['id'] }}</a>
                                                </td>
                                                <td class="pos">#</td>
                                                <td class="channel">
                                                    {{ $strategy['canal'] }}
                                                </td>
                                                <td>
                                                    {{ number_format($strategy['registros_unicos'], 0, ',', '.') }}</td>
                                                <td>
                                                    {{ number_format($strategy['registros_repetidos'], 0, ',', '.') }}</td>
                                                <td>{{ $strategy['onlyWhere'] }}</td>
                                                <td class="activation">
                                                    {{ $strategy['activation_date'] === null ? 'Sin Activar' : date('d-m-Y', strtotime($strategy['activation_date'])) }}
                                                    {{ $strategy['activation_time'] === null ? 'Sin Activar' : date('G:i:m', strtotime($strategy['activation_time'])) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                <tfoot>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                        <td scope="col">
                                            <strong>{{ number_format($porcentaje_total, 2, ',', '.') }}</strong>
                                        </td>
                                        <td scope="col">
                                            <strong>{{ number_format($suma_total, 0, ',', '.') }}</strong>
                                        </td>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
