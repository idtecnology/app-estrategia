
<?php $__env->startSection('title'); ?>
    Editar <?php echo e($client['prefix']); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Editar cliente
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Editar <?php echo e($client['prefix']); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-dark">
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
        <div class="col-md-8">
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
                                    <?php $__currentLoopData = $channels_config['channels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <label for="checkbox_<?php echo e($k); ?>"
                                                    class="form-check-label"><?php echo e(strtoupper($channels[$k]['name'])); ?></label>
                                            </td>
                                            <td>
                                                <?php echo e(isset($value['tipo']) ? 'Masivo' : ''); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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

                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    <?php $__currentLoopData = $est2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($campo); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php echo $__env->make('clients.modals.create_mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('clients.modals.show_mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('clients.modals.edit_mail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('clients.modals.edit_channels', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('clients.modals.edit_structure', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                    <?php $__currentLoopData = $listas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary"><?php echo e($lista['idlista']); ?></a>
                                            </td>
                                            <td>
                                                <?php echo e($lista['descripcion']); ?>

                                            </td>
                                            <td>
                                                <?php echo e($lista['discador']); ?>

                                            </td>
                                            <td>
                                                <?php echo e($lista['tipo']); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php $__currentLoopData = $emailsTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary"><?php echo e($template['id']); ?></a>
                                            </td>
                                            <td>
                                                <?php echo e($template['nombreTemplate']); ?>

                                            </td>
                                            <td>
                                                <?php echo e(date('d-m-Y', strtotime($template['created_at']))); ?>

                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0 justify-content-center">

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Ver">
                                                        <a data-bs-toggle="modal" data-bs-target="#showTemplate"
                                                            onclick="showTemplate(<?php echo e($template['id']); ?>)"
                                                            class="view-item-btn"><i
                                                                class="ri-eye-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    
                                                    
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script>
            const csrfToken = "<?php echo e(csrf_token()); ?>";

            function showTemplate(template_id) {

                document.getElementById('titleModal').innerHTML = 'Ver plantilla'
                document.getElementById('nombreTemplateShow').innerHTML = ''
                document.getElementById('nombreFromShow').innerHTML = ''
                document.getElementById('emailFromShow').innerHTML = ''
                document.getElementById('asuntoShow').innerHTML = ''
                document.getElementById('emailReplyShow').innerHTML = ''
                document.getElementById('templateShow').innerHTML = ''

                fetch('<?php echo e(route('emails.get-template-id')); ?>', {
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


                fetch('<?php echo e(route('emails.get-template-id')); ?>', {
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
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PC\Desktop\CODIGO\GIT\app-estrategias\resources\views/clients/edit.blade.php ENDPATH**/ ?>