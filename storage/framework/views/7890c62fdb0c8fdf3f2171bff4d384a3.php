
<?php $__env->startSection('title'); ?>
    Clientes
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Clientes
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Listado
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">

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

                                        <th class="sort" data-sort="pos" scope="col">#</th>
                                        <th class="sort" data-sort="name" scope="col">Nombre</th>
                                        <th class="sort" data-sort="email" scope="col">Prefijo</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary"><?php echo e($client['id']); ?></a>
                                            </td>
                                            <td class="pos">#</td>
                                            <td class="name">
                                                <?php echo e($client['name']); ?>

                                            </td>
                                            <td class="email"><?php echo e($client['prefix']); ?></td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="<?php echo e(route('strategy.show', $client['prefix'])); ?>"
                                                            class="view-item-btn"><i
                                                                class="ri-eye-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="<?php echo e(route('clients.edit', $client['id'])); ?>"><i
                                                                class="ri-pencil-fill align-bottom text-muted"></i></a>
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
            <?php echo $__env->make('configuration.users.modals.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PC\Desktop\CODIGO\GIT\app-estrategias\resources\views/clients/index.blade.php ENDPATH**/ ?>