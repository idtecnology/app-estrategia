<div class="modal fade" id="editModalMail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-info p-3">
                <h5 class="modal-title" id="exampleModalLabel">Crear una plantilla de email nueva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            {!! Form::open(['route' => 'emails.update-template', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <input type="hidden" name="prefix" value="{{ $client['prefix'] }}">
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div>
                            <label for="nombreTemplate" class="form-label">Nombre de la plantilla</label>
                            {!! Form::text('nombreTemplate', null, [
                                'placeholder' => 'Nombre de la plantilla',
                                'class' => 'form-control form-control-sm',
                                'autocomplete' => 'off',
                                'id' => 'nombreTemplateEdit',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <label for="nombreFrom" class="form-label">Nombre del remitente</label>
                            {!! Form::text('nombreFrom', null, [
                                'placeholder' => 'Nombre remitente',
                                'class' => 'form-control form-control-sm',
                                'autocomplete' => 'off',
                                'id' => 'nombreFromEdit',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <label for="emailFrom" class="form-label">Email del remitente</label>
                            {!! Form::text('emailFrom', null, [
                                'placeholder' => 'Email del remitente',
                                'class' => 'form-control form-control-sm',
                                'autocomplete' => 'off',
                                'id' => 'emailFromEdit',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <label for="asunto" class="form-label">Asunto</label>
                            {!! Form::text('asunto', null, [
                                'placeholder' => 'Asunto del email',
                                'class' => 'form-control form-control-sm',
                                'autocomplete' => 'off',
                                'id' => 'asuntoEdit',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="emailReply" class="form-label">Email de respuesta</label>
                            {!! Form::text('emailReply', null, [
                                'placeholder' => 'Email de respuesta',
                                'class' => 'form-control form-control-sm',
                                'autocomplete' => 'off',
                                'id' => 'emailReplyEdit',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="template" class="form-label">Plantilla</label>
                            {{ Form::file('templateEdit', ['class' => 'form-control form-control-sm', 'id' => 'template']) }}
                        </div>
                    </div>
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
