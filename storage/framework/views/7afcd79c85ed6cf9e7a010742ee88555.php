
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
    <?php echo Form::model($client, ['method' => 'PATCH', 'route' => ['clients.update', $client['id']]]); ?>


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
                                    <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e(Form::checkbox('configuracion[channels][' . $k . '][seleccionado]', $k, isset($channels_config['channels'][$k]) ? true : false, ['id' => 'checkbox_' . $k, 'class' => 'name form-check-input', 'onchange' => 'enableRadio(this, ' . $k . ')'])); ?>

                                                <label for="checkbox_<?php echo e($k); ?>"
                                                    class="form-check-label"><?php echo e(strtoupper($value['name'])); ?></label>
                                            </td>
                                            <td>
                                                <?php echo e(Form::checkbox(
                                                    'configuracion[channels][' . $k . '][tipo]',
                                                    $k . '_1',
                                                    isset($channels_config['channels'][$k]['tipo']) ? true : false,
                                                    [
                                                        'class' => 'name form-check-input',
                                                        'id' => 'check_tipo_' . $k,
                                                        'disabled' => isset($channels_config['channels'][$k]['seleccionado']) ? false : true,
                                                    ],
                                                )); ?>

                                                <label class="form-check-label">Masivo</label>
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

                                    <?php $__currentLoopData = $estructura; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ke => $estruc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e($estruc['COLUMN_NAME']); ?>

                                            </td>
                                            <td>
                                                <?php if(isset($channels_config['estructura'])): ?>
                                                    <?php if(in_array($estruc['COLUMN_NAME'], array_keys($channels_config['estructura']))): ?>
                                                        <?php if(isset($channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar'])): ?>
                                                            <input class="form-control form-control-sm"
                                                                placeholder="Ingrese un nombre" type="text"
                                                                name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][nombre]"
                                                                value="<?php echo e($channels_config['estructura'][$estruc['COLUMN_NAME']]['nombre']); ?>" />
                                                        <?php else: ?>
                                                            <input type="text" placeholder="Ingrese un nombre"
                                                                class="form-control form-control-sm"
                                                                name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][nombre]" />
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <input type="text" placeholder="Ingrese un nombre"
                                                            class="form-control form-control-sm"
                                                            name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][nombre]" />
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <input class="form-control form-control-sm"
                                                        placeholder="Ingrese un nombre" type="text"
                                                        name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][nombre]" />
                                                <?php endif; ?>

                                            </td>

                                            <td class="text-center">

                                                <?php if(isset($channels_config['estructura'])): ?>
                                                    <?php if(in_array($estruc['COLUMN_NAME'], array_keys($channels_config['estructura']))): ?>
                                                        <?php if(isset($channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar'])): ?>
                                                            <input type="checkbox"
                                                                name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][utilizar]"
                                                                checked
                                                                value="<?php echo e($channels_config['estructura'][$estruc['COLUMN_NAME']]['utilizar']); ?>" />
                                                        <?php else: ?>
                                                            <input type="checkbox"
                                                                name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][utilizar]" />
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <input type="checkbox"
                                                            name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][utilizar]" />
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <input type="checkbox"
                                                        name="configuracion[estructura][<?php echo e($estruc['COLUMN_NAME']); ?>][utilizar]" />
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

        </div>
        <?php echo Form::close(); ?>

    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('build/libs/list.js/list.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/crm-companies.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

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
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PC\Desktop\CODIGO\GIT\app-estrategias\resources\views/clients/edit.blade.php ENDPATH**/ ?>