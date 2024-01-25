
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->startSection('title'); ?>
    Estrategias Diseño
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Estrategias
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Diseñar <?php echo e($client['prefix']); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo e(route('strategy.show', $client['prefix'])); ?>" class="btn btn-dark">
                                <i class="ri-arrow-left-line me-1 align-bottom"></i>
                                Regresar
                            </a>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div class="ms-auto">
                                    <button class="btn btn-info add-btn" data-bs-toggle="modal" onclick="resetModal()"
                                        data-bs-target="#showModal"><i class="ri-add-fill me-1 align-bottom"></i> Crear
                                        estrategia</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="4%" class="sort" data-sort="pos" scope="col">#</th>
                                        <th width="9%" class="sort" data-sort="canal" scope="col">Canal
                                        </th>
                                        <th width="9%" class="sort" data-sort="lista" scope="col">Lista
                                        </th>
                                        <th width="9%" class="sort" scope="col">Cobertura</th>
                                        <th width="9%" class="sort" data-sort="registros" scope="col">
                                            Registros
                                        </th>
                                        <th width="9%" class="sort" scope="col">Repetidos</th>
                                        <th class="sort" scope="col">Criterio</th>
                                        <th width="9%" class="text-center" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($data['type'] === 1): ?>
                                            <tr>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary"><?php echo e($client['id']); ?></a>
                                                </td>
                                                <td class="pos"><?php echo e(++$k); ?></td>
                                                <td class="canal"><?php echo e($data['canal']); ?></td>
                                                <td class="canal"><?php echo e($data['listaTemplate'] ?? ''); ?></td>
                                                <td><?php echo e(number_format($data['cobertura'], 2, ',', '.')); ?>%</td>
                                                <td class="registros">
                                                    <?php echo e(number_format($data['registros_unicos'], 0, ',', '.')); ?></td>
                                                <td><?php echo e(number_format($data['registros_repetidos'], 0, ',', '.')); ?>

                                                </td>
                                                <td><?php echo e($data['onlyWhere']); ?></td>
                                                <td class="text-center">
                                                    <a type="button" class="btn btn-success btn-sm" id='btnActivate'
                                                        onclick="acceptedStrategy(<?php echo e($data['id']); ?>, <?php echo e($data['channels']); ?>, '<?php echo e($client['prefix']); ?>')">
                                                        <i class="ri-check-line"></i>
                                                    </a>
                                                    <a type="button" class="btn btn-danger btn-sm eliminar-estrategia"
                                                        onclick="deleteStrategy(<?php echo e($data['id']); ?>)" id='btnDelete'>
                                                        <i class="ri-close-line"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                        <td scope="col">
                                            <strong><?php echo e(number_format($porcentaje_total, 2, ',', '.')); ?></strong>
                                        </td>
                                        <td scope="col">
                                            <strong><?php echo e(number_format($suma_total, 0, ',', '.')); ?></strong>
                                        </td>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('strategy.modals.design_estrategia', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PC\Desktop\CODIGO\GIT\app-estrategias\resources\views/strategy/diseno.blade.php ENDPATH**/ ?>