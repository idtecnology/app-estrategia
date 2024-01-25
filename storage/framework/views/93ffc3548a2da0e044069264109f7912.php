<div class="modal fade" id="showModalEditStructure" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-info p-3">
                <h5 class="modal-title" id="exampleModalLabel">Cartera/Mejor Gesti&oacute;n</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <?php echo Form::open([
                'route' => 'clients.edit-structure',
                'method' => 'POST',
                'enctype' => 'multipart/form-data',
                'id' => 'editStructure',
            ]); ?>

            <input type="hidden" name="client_id" value="<?php echo e($client['id']); ?>">
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#structure">Cartera</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#better">Mejor Gesti&oacute;n</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane container active p-3" id="structure">
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

                                    <?php $__currentLoopData = $estructura; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ke => $estruc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e($estruc['COLUMN_NAME']); ?>

                                            </td>
                                            <td>
                                                <?php if(isset($channels_config['estructura'])): ?>
                                                    <?php if(in_array($estruc['COLUMN_NAME'], array_keys($channels_config['estructura']))): ?>
                                                        <?php if(isset($channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar'])): ?>
                                                            <input class="form-control form-control-sm input-text"
                                                                placeholder="Ingrese un nombre" type="text"
                                                                name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][nombre]"
                                                                value="<?php echo e($channels_config['estructura'][$estruc['COLUMN_NAME']]['nombre']); ?>" />
                                                        <?php else: ?>
                                                            <input type="text" placeholder="Ingrese un nombre"
                                                                class="form-control form-control-sm input-text"
                                                                name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][nombre]" />
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <input type="text" placeholder="Ingrese un nombre"
                                                            class="form-control form-control-sm input-text"
                                                            name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][nombre]" />
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <input class="form-control form-control-sm input-text"
                                                        placeholder="Ingrese un nombre" type="text"
                                                        name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][nombre]" />
                                                <?php endif; ?>

                                            </td>

                                            <td class="text-center">

                                                <?php if(isset($channels_config['estructura'])): ?>
                                                    <?php if(in_array($estruc['COLUMN_NAME'], array_keys($channels_config['estructura']))): ?>
                                                        <?php if(isset($channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar'])): ?>
                                                            <input class="checks" type="checkbox"
                                                                name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][utilizar]"
                                                                checked
                                                                value="<?php echo e($channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar']); ?>" />
                                                        <?php else: ?>
                                                            <input class="checks" type="checkbox"
                                                                name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][utilizar]" />
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <input class="checks" type="checkbox"
                                                            name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][utilizar]" />
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <input class="checks" type="checkbox"
                                                        name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][utilizar]" />
                                                <?php endif; ?>
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="tab-pane container fade p-3" id="better">
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

                                    <?php $__currentLoopData = $better_structure; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ke => $better): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e($better['COLUMN_NAME']); ?>

                                            </td>
                                            <td>
                                                <?php if(isset($channels_config['mejor'])): ?>
                                                    <?php if(in_array($better['COLUMN_NAME'], array_keys($channels_config['mejor']))): ?>
                                                        <?php if(isset($channels_config['mejor'][$better['COLUMN_NAME']]['utilizar'])): ?>
                                                            <input class="form-control form-control-sm input-text"
                                                                placeholder="Ingrese un nombre" type="text"
                                                                name="configuracion[mejor][<?php echo e($better['COLUMN_NAME']); ?>][nombre]"
                                                                value="<?php echo e($channels_config['mejor'][$better['COLUMN_NAME']]['nombre']); ?>" />
                                                        <?php else: ?>
                                                            <input type="text" placeholder="Ingrese un nombre"
                                                                class="form-control form-control-sm input-text"
                                                                name="configuracion[mejor][<?php echo e($better['COLUMN_NAME']); ?>][nombre]" />
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <input type="text" placeholder="Ingrese un nombre"
                                                            class="form-control form-control-sm input-text"
                                                            name="configuracion[mejor][<?php echo e($better['COLUMN_NAME']); ?>][nombre]" />
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <input class="form-control form-control-sm input-text"
                                                        placeholder="Ingrese un nombre" type="text"
                                                        name="configuracion[mejor][<?php echo e($better['COLUMN_NAME']); ?>][nombre]" />
                                                <?php endif; ?>

                                            </td>

                                            <td class="text-center">

                                                <?php if(isset($channels_config['mejor'])): ?>
                                                    <?php if(in_array($better['COLUMN_NAME'], array_keys($channels_config['mejor']))): ?>
                                                        <?php if(isset($channels_config['mejor'][$better['COLUMN_NAME']]['utilizar'])): ?>
                                                            <input type="checkbox"
                                                                name="configuracion[mejor][<?php echo e($better['COLUMN_NAME']); ?>][utilizar]"
                                                                checked
                                                                value="<?php echo e($channels_config['mejor'][$better['COLUMN_NAME']]['utilizar']); ?>" />
                                                        <?php else: ?>
                                                            <input class="checks" type="checkbox"
                                                                name="configuracion[mejor][<?php echo e($better['COLUMN_NAME']); ?>][utilizar]" />
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <input class="checks" type="checkbox"
                                                            name="configuracion[mejor][<?php echo e($better['COLUMN_NAME']); ?>][utilizar]" />
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <input class="checks" type="checkbox"
                                                        name="configuracion[mejor][<?php echo e($better['COLUMN_NAME']); ?>][utilizar]" />
                                                <?php endif; ?>
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

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
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
<?php $__env->startSection('script'); ?>
    <script>
        // const checks = document.querySelectorAll('checks')

        // console.log(checks)

        document.getElementById("editStructure").addEventListener("submit", function(event) {
            // Evitar que el formulario se envíe por defecto
            event.preventDefault();

            // Obtener todos los checkboxes y campos de texto
            var checkboxes = document.getElementsByClassName("checks");
            var textInputs = document.getElementsByClassName("input-text");

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    console.log('si: ' + i)
                    // Obtener el índice del checkbox seleccionado
                    var index = checkboxes[i].getAttribute("data-related-checkbox");

                    // Obtener el campo de texto correspondiente al checkbox seleccionado
                    var relatedTextInput = textInputs[i];

                    // Validar si el campo de texto está vacío
                    if (relatedTextInput.value.trim() === "") {
                        // Si está vacío, mostrar un mensaje de error o realizar la acción que desees
                        alert("El campo de texto relacionado al checkbox seleccionado es requerido.");
                        relatedTextInput.focus()
                        return; // Detener el envío del formulario
                    }
                }
            }

            // Si todos los checkboxes seleccionados tienen campos de texto no vacíos, enviar el formulario
            this.submit();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\PC\Desktop\CODIGO\GIT\app-estrategias\resources\views/clients/modals/edit_structure.blade.php ENDPATH**/ ?>