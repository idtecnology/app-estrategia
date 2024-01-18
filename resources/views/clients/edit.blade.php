@extends('layouts.master')
@section('title')
    Editar {{ $client['prefix'] }}
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Editar cliente
        @endslot
        @slot('title')
            Editar {{ $client['prefix'] }}
        @endslot
    @endcomponent
    {!! Form::model($client, ['method' => 'PATCH', 'route' => ['clients.update', $client['id']]]) !!}

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
                            <button type="submit" class="btn btn-success add-btn">
                                <i class="ri-save-2-line me-1 align-bottom"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="card" id="">
                <div class="card-header">
                    <h3>Canales</h3>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table table-sm table-bordered ">
                                <thead class="table-dark text-uppercase align-middle">
                                    <tr>
                                        <th width='50%'>Canales:</th>
                                        <th>tipo de canal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($channels as $k => $value)
                                        <tr>
                                            <td>
                                                {{ Form::checkbox('configuracion[channels][' . $k . '][seleccionado]', $k, isset($channels_config['channels'][$k]) ? true : false, ['id' => 'checkbox_' . $k, 'class' => 'name form-check-input', 'onchange' => 'enableRadio(this, ' . $k . ')']) }}
                                                <label for="checkbox_{{ $k }}"
                                                    class="form-check-label">{{ strtoupper($value['name']) }}</label>
                                            </td>
                                            <td>
                                                {{ Form::checkbox(
                                                    'configuracion[channels][' . $k . '][tipo]',
                                                    $k . '_1',
                                                    isset($channels_config['channels'][$k]['tipo']) ? true : false,
                                                    [
                                                        'class' => 'name form-check-input',
                                                        'id' => 'check_tipo_' . $k,
                                                        'disabled' => isset($channels_config['channels'][$k]['seleccionado']) ? false : true,
                                                    ],
                                                ) }}
                                                <label class="form-check-label">Masivo</label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="card" id="">
                <div class="card-header">
                    <h3>Estructura</h3>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">

                            <table class="table table-bordered table-sm mb-0">

                                <thead class="table-dark text-uppercase text-center">
                                    <tr>
                                        <th>Campo BD</th>
                                        <th>Nombre</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">

                                    @foreach ($estructura as $ke => $estruc)
                                        <tr>
                                            <td>
                                                {{ $estruc['COLUMN_NAME'] }}
                                            </td>
                                            <td>
                                                @if (isset($channels_config['estructura']))
                                                    @if (in_array($estruc['COLUMN_NAME'], array_keys($channels_config['estructura'])))
                                                        @if (isset($channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar']))
                                                            <input class="form-control form-control-sm"
                                                                placeholder="Ingrese un nombre" type="text"
                                                                name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][nombre]"
                                                                value="{{ $channels_config['estructura'][$estruc['COLUMN_NAME']]['nombre'] }}" />
                                                        @else
                                                            <input type="text" placeholder="Ingrese un nombre"
                                                                class="form-control form-control-sm"
                                                                name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][nombre]" />
                                                        @endif
                                                    @else
                                                        <input type="text" placeholder="Ingrese un nombre"
                                                            class="form-control form-control-sm"
                                                            name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][nombre]" />
                                                    @endif
                                                @else
                                                    <input class="form-control form-control-sm"
                                                        placeholder="Ingrese un nombre" type="text"
                                                        name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][nombre]" />
                                                @endif

                                            </td>

                                            <td class="text-center">

                                                @if (isset($channels_config['estructura']))
                                                    @if (in_array($estruc['COLUMN_NAME'], array_keys($channels_config['estructura'])))
                                                        @if (isset($channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar']))
                                                            <input type="checkbox"
                                                                name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][utilizar]"
                                                                checked
                                                                value="{{ $channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar'] }}" />
                                                        @else
                                                            <input type="checkbox"
                                                                name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][utilizar]" />
                                                        @endif
                                                    @else
                                                        <input type="checkbox"
                                                            name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][utilizar]" />
                                                    @endif
                                                @else
                                                    <input type="checkbox"
                                                        name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][utilizar]" />
                                                @endif
                                                {{-- <input type="checkbox"
                                    name="configuracion[estructura][{{ $estruc['COLUMN_NAME'] }}][utilizar]" /> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {!! Form::close() !!}
    @endsection
    @section('script')
        <script>
            function enableRadio(element, c) {
                var check_tipo = document.getElementById("check_tipo_" + c)
                if (check_tipo.hasAttribute("disabled")) {
                    check_tipo.removeAttribute("disabled")
                } else {
                    check_tipo.setAttribute("disabled", true);
                }
            }
        </script>
    @endsection
