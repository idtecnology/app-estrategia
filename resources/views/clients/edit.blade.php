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
    {{-- {!! Form::model($client, ['method' => 'PATCH', 'route' => ['clients.update', $client['id']]]) !!} --}}

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
                            <button type="button" class="btn btn-soft-success" data-bs-toggle="modal"
                                data-bs-target="#showModalCreateMail"><i class="ri-mail-add-line me-1 align-bottom"></i>
                                Crear
                                plantilla email</button>
                        </div>
                        <div class="col-md-auto">
                            <button class="btn btn-soft-warning" data-bs-toggle="modal"
                                data-bs-target="#showModalEditChannels"><i
                                    class="ri-customer-service-2-line me-1 align-bottom"></i> Editar
                                canales</button>
                        </div>
                        <div class="col-md-auto">
                            <button class="btn btn-soft-warning" data-bs-toggle="modal"
                                data-bs-target="#showModalEditStructure"><i class="ri-table-line me-1 align-bottom"></i>
                                Editar
                                estructura</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" id="">
                <div class="card-header">
                    <h3>Canales</h3>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table table-sm table-bordered">
                                <thead class="table-dark text-uppercase align-middle">
                                    <tr>
                                        <th>Canales:</th>
                                        <th width="15%">tipo</th>
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
        <div class="col-md-6">
            <div class="card" id="">
                <div class="card-header">
                    <h3>Estructura</h3>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="table-dark text-uppercase text-center">
                                    <tr>
                                        <th>Campo BD</th>
                                        <th>Nombre</th>
                                        <th width='10%'>Seleccionar</th>
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
                @include('clients.modals.create_mail')
                @include('clients.modals.show_mail')
                @include('clients.modals.edit_mail')
                @include('clients.modals.edit_channels')
                @include('clients.modals.edit_structure')
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" id="">
                <div class="card-header">
                    <h3>Lista Agentes</h3>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0 table-sm" id="customerTable">
                                <thead class="table-dark text-uppercase text-center">
                                    <tr>

                                        <th scope="col">Nombre</th>
                                        <th width="30%" scope="col">Discador</th>
                                        <th width="10%" scope="col">tipo</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($listas as $key => $lista)
                                        <tr>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">{{ $lista['idlista'] }}</a>
                                            </td>
                                            <td>
                                                {{ $lista['descripcion'] }}
                                            </td>
                                            <td>
                                                {{ $lista['discador'] }}
                                            </td>
                                            <td>
                                                {{ $lista['tipo'] }}
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

        <div class="col-md-6">
            <div class="card" id="">
                <div class="card-header">
                    <h3>Plantillas de Email</h3>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0 table-sm" id="customerTable">
                                <thead class="table-dark text-uppercase text-center">
                                    <tr>

                                        <th scope="col">Nombre de la plantilla</th>
                                        <th width="10%" scope="col">Fecha</th>
                                        <th width="5%" class="text-center" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($emailsTemplates as $key => $template)
                                        <tr>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">{{ $template['id'] }}</a>
                                            </td>
                                            <td>
                                                {{ $template['nombreTemplate'] }}
                                            </td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($template['created_at'])) }}
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0 justify-content-center">

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Ver">
                                                        <a data-bs-toggle="modal" data-bs-target="#showTemplate"
                                                            onclick="showTemplate({{ $template['id'] }})"
                                                            class="view-item-btn"><i
                                                                class="ri-eye-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    {{-- <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                                                        <a data-bs-toggle="modal" data-bs-target="#editModalMail"
                                                            onclick="editTemplate({{ $template['id'] }})"><i
                                                                class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                    </li> --}}
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
        </div>
        {{-- {!! Form::close() !!} --}}
    @endsection
    @section('script')
        <script>
            const csrfToken = "{{ csrf_token() }}";

            function showTemplate(template_id) {

                document.getElementById('titleModal').innerHTML = 'Ver plantilla'
                document.getElementById('nombreTemplateShow').innerHTML = ''
                document.getElementById('nombreFromShow').innerHTML = ''
                document.getElementById('emailFromShow').innerHTML = ''
                document.getElementById('asuntoShow').innerHTML = ''
                document.getElementById('emailReplyShow').innerHTML = ''
                document.getElementById('templateShow').innerHTML = ''

                fetch('{{ route('emails.get-template-id') }}', {
                    method: 'POST',
                    body: JSON.stringify({
                        template_id: template_id,
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    return response.json();
                }).then(data => {
                    console.log(data)
                    //
                    document.getElementById('nombreTemplateShow').innerHTML = data.nombreTemplate
                    document.getElementById('nombreFromShow').innerHTML = data.nombreFrom
                    document.getElementById('emailFromShow').innerHTML = data.emailFrom
                    document.getElementById('asuntoShow').innerHTML = data.asunto
                    document.getElementById('emailReplyShow').innerHTML = data.emailReply
                    document.getElementById('templateShow').innerHTML = atob(data.body)

                });
            }


            function editTemplate(template_id) {

                console.log(template_id)

                document.getElementById('titleModal').innerHTML = 'Ver plantilla'


                fetch('{{ route('emails.get-template-id') }}', {
                    method: 'POST',
                    body: JSON.stringify({
                        template_id: template_id,
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    return response.json();
                }).then(data => {
                    console.log(data)
                    //
                    document.getElementById('nombreTemplateEdit').value = data.nombreTemplate
                    document.getElementById('nombreFromEdit').value = data.nombreFrom
                    document.getElementById('emailFromEdit').value = data.emailFrom
                    document.getElementById('asuntoEdit').value = data.asunto
                    document.getElementById('emailReplyEdit').value = data.emailReply
                    // document.getElementById('templateEdit').innerHTML = atob(data.body)

                });



            }


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
