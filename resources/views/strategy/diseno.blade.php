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
            diseño
        @endslot
    @endcomponent
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <button class="btn btn-info add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i
                                    class="ri-add-fill me-1 align-bottom"></i> Diseñar estrategia</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <div class="card" id="companyList">
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
                                    <option value="email">Email</option>
                                    <option value="name">Nombre</option>
                                    <option value="roles">Rol</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sort" data-sort="pos" scope="col">#</th>
                                        <th class="sort" data-sort="pos" scope="col">Canal</th>
                                        <th class="sort" data-sort="pos" scope="col">Cobertura</th>
                                        <th class="sort" data-sort="pos" scope="col">Registros</th>
                                        <th class="sort" data-sort="pos" scope="col">Repetidos</th>
                                        <th class="sort" data-sort="pos" scope="col">Criterio</th>
                                        <th scope="col">Acciones</th>
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
                                                <td class="name">
                                                    {{ $data['canal'] }}
                                                </td>
                                                <td class="email">{{ number_format($data['cobertura'], 2, ',', '.') }}%
                                                </td>
                                                <td class="email">
                                                    {{ number_format($data['registros_unicos'], 0, ',', '.') }}</td>
                                                <td class="email">
                                                    {{ number_format($data['registros_repetidos'], 0, ',', '.') }}</td>
                                                <td class="email">{{ $data['onlyWhere'] }}</td>

                                            </tr>
                                        @endif
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('strategy.modals.design_estrategia')
        </div>
    @endsection
    @section('script')
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/crm-companies.init.js') }}"></script>
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
