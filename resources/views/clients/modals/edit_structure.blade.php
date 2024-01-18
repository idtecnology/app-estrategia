<div class="modal fade" id="showModalEditStructure" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-info p-3">
                <h5 class="modal-title" id="exampleModalLabel">Crear una plantilla de email nueva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            {!! Form::open(['route' => 'clients.edit-structure', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <input type="hidden" name="client_id" value="{{ $client['id'] }}">
            <div class="modal-body">
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
                                            <input class="form-control form-control-sm" placeholder="Ingrese un nombre"
                                                type="text"
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
            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-soft-success" id="guardar">Guardar</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
