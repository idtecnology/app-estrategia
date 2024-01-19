@extends('layouts.master')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@section('title')
    Estrategias Diseño
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Estrategias
        @endslot
        @slot('title')
            Diseñar {{ $client['prefix'] }}
        @endslot
    @endcomponent
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('strategy.show', $client['prefix']) }}" class="btn btn-dark">
                                <i class="ri-arrow-left-line me-1 align-bottom"></i>
                                Regresar
                            </a>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div class="ms-auto">
                                    <button class="btn btn-info add-btn" data-bs-toggle="modal" onclick="resetModal()"
                                        data-bs-target="#showModal"><i class="ri-add-fill me-1 align-bottom"></i> Crear
                                        estrategia</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    {{-- <div class="row g-2">
                                <div class="col-md-4 ms-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted">Ordenar por: </span>
                                        <select class="form-control mb-0" data-choices data-choices-search-false
                                            id="choices-single-default">
                                            <option value="pos">Posicion</option>
                                            <option value="canal">Canal</option>
                                            <option value="registros">Registros</option>
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
                                        <th width="4%" class="sort" data-sort="pos" scope="col">#</th>
                                        <th width="9%" class="sort" data-sort="canal" scope="col">Canal
                                        </th>
                                        <th width="9%" class="sort" data-sort="lista" scope="col">Lista
                                        </th>
                                        <th width="9%" class="sort" scope="col">Cobertura</th>
                                        <th width="9%" class="sort" data-sort="registros" scope="col">
                                            Registros
                                        </th>
                                        <th width="9%" class="sort" scope="col">Repetidos</th>
                                        <th class="sort" scope="col">Criterio</th>
                                        <th width="9%" class="text-center" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($datas as $k => $data)
                                        @if ($data['type'] === 1)
                                            <tr>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">{{ $client['id'] }}</a>
                                                </td>
                                                <td class="pos">{{ ++$k }}</td>
                                                <td class="canal">{{ $data['canal'] }}</td>
                                                <td class="canal">{{ $data['listaTemplate'] ?? '' }}</td>
                                                <td>{{ number_format($data['cobertura'], 2, ',', '.') }}%</td>
                                                <td class="registros">
                                                    {{ number_format($data['registros_unicos'], 0, ',', '.') }}</td>
                                                <td>{{ number_format($data['registros_repetidos'], 0, ',', '.') }}
                                                </td>
                                                <td>{{ $data['onlyWhere'] }}</td>
                                                <td class="text-center">
                                                    <a type="button" class="btn btn-success btn-sm" id='btnActivate'
                                                        onclick="acceptedStrategy({{ $data['id'] }}, {{ $data['channels'] }}, '{{ $client['prefix'] }}')" />
                                                    <i class="ri-check-line"></i>
                                                    </a>
                                                    <a type="button" class="btn btn-danger btn-sm" id='btnDelete'>
                                                        <i class="ri-close-line"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
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
            @include('strategy.modals.design_estrategia')
        </div>
    @endsection
