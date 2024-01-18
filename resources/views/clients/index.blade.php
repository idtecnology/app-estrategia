@extends('layouts.master')
@section('title')
    Clientes
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Clientes
        @endslot
        @slot('title')
            Listado
        @endslot
    @endcomponent
    <div class="row">

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
                                        <th class="sort" data-sort="name" scope="col">Nombre</th>
                                        <th class="sort" data-sort="email" scope="col">Prefijo</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($clients as $key => $client)
                                        <tr>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">{{ $client['id'] }}</a>
                                            </td>
                                            <td class="pos">#</td>
                                            <td class="name">
                                                {{ $client['name'] }}
                                            </td>
                                            <td class="email">{{ $client['prefix'] }}</td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('strategy.show', $client['prefix']) }}"
                                                            class="view-item-btn"><i
                                                                class="ri-eye-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="{{ route('clients.edit', $client['id']) }}"><i
                                                                class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    {{-- <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteRecordModal">
                                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li> --}}
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('configuration.users.modals.create')
        </div>
    @endsection
