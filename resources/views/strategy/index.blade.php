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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <a href="{{ route('strategy.desing', $data_client['prefix_client']) }}" class="btn btn-info add-btn">
                                <i class="ri-pencil-ruler-2-line me-1 align-bottom"></i>
                                Diseñar
                            </a>
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
                                        <th class="sort" data-sort="name" scope="col">Canal</th>
                                        <th class="sort" data-sort="email" scope="col">Registros</th>
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
                                                <td class="pos">#</td>
                                                <td class="name">
                                                    {{ $strategy['canal'] }}
                                                </td>
                                                <td class="email">
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
                                                            <a class="remove-item-btn" data-bs-toggle="modal"
                                                                href="#">
                                                                <i class="ri-stop-circle-line align-bottom text-muted"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/crm-companies.init.js') }}"></script>
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
