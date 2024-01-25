
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
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-dark">
                                <i class="ri-arrow-left-line me-1 align-bottom"></i>
                                Regresar
                            </a>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <a href="<?php echo e(route('strategy.history', [$data_client['prefix_client'], 3])); ?>"
                                class="btn btn-outline-danger">
                                <i class="ri-history-line me-1 align-bottom"></i>
                                Histórico
                            </a>
                        </div>
                        <div class="col-md-auto">
                            <a href="<?php echo e(route('strategy.desing', $data_client['prefix_client'])); ?>" class="btn btn-info">
                                <i class="ri-pencil-ruler-2-line me-1 align-bottom"></i>
                                Diseñar
                            </a>
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

                                        <th class="sort" data-sort="pos" scope="col">#</th>
                                        <th class="sort" data-sort="name" scope="col">Canal</th>
                                        <th class="sort text-center" data-sort="email" scope="col">Registros</th>
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
                                                <td class="email text-center">
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
                                                            <a onclick="stopedStrategy(<?php echo e($strategy['id']); ?>)"
                                                                class="remove-item-btn fs-4">
                                                                <i class="ri-stop-circle-line align-bottom text-muted"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tfoot>
                                    <tr class="text-center">
                                        <td colspan="2">&nbsp;</td>
                                        <td scope="col">
                                            <strong><?php echo e(number_format($suma_total, 0, ',', '.')); ?></strong>
                                        </td>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script>
            function stopedStrategy(id) {
                fetch('<?php echo e(route('strategy.stopped-strategy')); ?>', {
                    method: 'POST',
                    body: JSON.stringify({
                        id: id,
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    return response.json();
                }).then(data => {
                    // Recargar la página actual
                    if (data.result === '201') {
                        alert(data.message)
                        // spinner.setAttribute('hidden', '');
                        location.reload()
                    } else {}
                });

            }
            const enlacesElement = document.querySelectorAll('.detener-estrategia');
            const csrfToken = "<?php echo e(csrf_token()); ?>";

            if (enlacesElement !== null) {
                enlacesElement.forEach((enlaceElement) => {
                    enlaceElement.addEventListener('click', (event) => {
                        console.log(enlaceElement.dataset.identificador)
                        const confirmacion = confirm('¿Desea detener la estrategia?');
                        if (!confirmacion) {
                            event.preventDefault();
                        } else {
                            fetch(`http://api.iawave:3000/api/v1/estrategia/detener/${enlaceElement.dataset.identificador}`, {
                                    method: 'PUT',
                                    headers: {
                                        'content-type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                })
                                .then(response => {
                                    if (response.ok) {
                                        // La respuesta fue exitosa (código de estado HTTP 200-299)
                                        return response
                                            .json(); // Devuelve una promesa que resuelve a un objeto JSON
                                    } else {
                                        // La respuesta no fue exitosa
                                        throw new Error('Error de respuesta');
                                    }
                                })
                                .then(data => {
                                    // Haz algo con los datos recibidos
                                    if (data.status === "201") {
                                        alert('Detenido con exito')
                                        location.reload()
                                    }
                                })
                                .catch(error => {
                                    // Manejar errores de red u otros errores
                                    console.error(error);
                                });
                        }
                    });
                });
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PC\Desktop\CODIGO\GIT\app-estrategias\resources\views/strategy/index.blade.php ENDPATH**/ ?>