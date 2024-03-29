
<?php $__env->startSection('title'); ?>
    Estrategias <?php echo e($data_client['prefix_client']); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Estrategias Activas
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Listado <?php echo e($data_client['prefix_client']); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <a href="<?php echo e(route('strategy.desing', $data_client['prefix_client'])); ?>" class="btn btn-info add-btn">
                                <i class="ri-pencil-ruler-2-line me-1 align-bottom"></i>
                                Diseñar
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="card" id="companyList">
                <div class="card-header">
                    <div class="row g-2">
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
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead class="table-light">
                                    <tr>

                                        <th class="sort" data-sort="pos" scope="col">#</th>
                                        <th class="sort" data-sort="name" scope="col">Canal</th>
                                        <th class="sort" data-sort="email" scope="col">Registros</th>
                                        <th class="sort" data-sort="email" scope="col">Repetidos</th>
                                        <th class="sort" data-sort="email" scope="col">Criterio</th>
                                        <th class="sort" data-sort="email" scope="col">Activacion</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <?php $__currentLoopData = $strategies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($strategy['type'] == 2 && $strategy['inProcess'] == 1): ?>
                                            <tr>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary"><?php echo e($strategy['id']); ?></a>
                                                </td>
                                                <td class="pos">#</td>
                                                <td class="name">
                                                    <?php echo e($strategy['canal']); ?>

                                                </td>
                                                <td class="email">
                                                    <?php echo e(number_format($strategy['registros_unicos'], 0, ',', '.')); ?></td>
                                                <td class="email">
                                                    <?php echo e(number_format($strategy['registros_repetidos'], 0, ',', '.')); ?></td>
                                                <td class="email"><?php echo e($strategy['onlyWhere']); ?></td>
                                                <td class="email">
                                                    <?php echo e($strategy['activation_date'] === null ? 'Sin Activar' : date('d-m-Y', strtotime($strategy['activation_date']))); ?>

                                                    <?php echo e($strategy['activation_time'] === null ? 'Sin Activar' : date('G:i:m', strtotime($strategy['activation_time']))); ?>

                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Stop">
                                                            <a class="remove-item-btn" data-bs-toggle="modal"
                                                                href="#">
                                                                <i class="ri-stop-circle-line align-bottom text-muted"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('build/libs/list.js/list.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/crm-companies.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PC\Desktop\CODIGO\GIT\app-estrategias\resources\views/strategy/index.blade.php ENDPATH**/ ?>