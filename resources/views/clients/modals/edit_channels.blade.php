<div class="modal fade" id="showModalEditChannels" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-info p-3">
                <h5 class="modal-title" id="exampleModalLabel">Canales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            {!! Form::open(['route' => 'clients.edit-channels', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <input type="hidden" name="client_id" value="{{ $client['id'] }}">
            <div class="modal-body">
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
