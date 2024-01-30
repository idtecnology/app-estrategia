
<?php $__env->startSection('title'); ?>
    Estrategias <?php echo e($data_client['prefix_client']); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Estrategias historicas
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Listado historico <?php echo e($data_client['prefix_client']); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?php echo e(route('strategy.show', $data_client['prefix_client'])); ?>" class="btn btn-dark">
                                <i class="ri-arrow-left-line me-1 align-bottom"></i>
                                Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="card">

                <div class="card-body">
                    <div class="listjs-table">
                        <div class="table-responsive table-card mb-3">
                            <table class="table align-middle table-nowrap mb-0" id="companyList">
                                <thead class="table-light">
                                    <tr>

                                        <th class="sort" data-sort="pos" scope="col">#</th>
                                        <th class="sort" data-sort="channel" scope="col">Canal</th>
                                        <th scope="col">Registros</th>
                                        <th scope="col">Repetidos</th>
                                        <th scope="col">Criterio</th>
                                        <th class="sort" data-sort="activation" scope="col">Activaci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <?php $__currentLoopData = $historical; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($strategy['type'] == 3): ?>
                                            <tr>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary"><?php echo e($strategy['id']); ?></a>
                                                </td>
                                                <td class="pos"><a class="text-primary" aria-label="Estadisticas"
                                                        title="Estadisticas" style="cursor: pointer" data-bs-toggle="modal"
                                                        data-bs-target="#showModalEstadisticas"
                                                        onclick="verEstadisticas(<?php echo e($strategy['id']); ?>, '<?php echo e($data_client['prefix_client']); ?>')"><?php echo e($strategy['id']); ?></a>
                                                <td class="channel">
                                                    <?php echo e($strategy['canal']); ?>

                                                </td>
                                                <td>
                                                    <?php echo e(number_format($strategy['registros_unicos'], 0, ',', '.')); ?></td>
                                                <td>
                                                    <?php echo e(number_format($strategy['registros_repetidos'], 0, ',', '.')); ?></td>
                                                <td><?php echo e($strategy['onlyWhere']); ?></td>
                                                <td class="activation">
                                                    <?php echo e($strategy['activation_date'] === null ? 'Sin Activar' : date('d-m-Y', strtotime($strategy['activation_date']))); ?>

                                                    <?php echo e($strategy['activation_time'] === null ? 'Sin Activar' : date('G:i:m', strtotime($strategy['activation_time']))); ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
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
                <?php echo $__env->make('strategy.modals.estadistica', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('build/libs/apexcharts/apexcharts.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/apexcharts-pie.init.js')); ?>"></script>
        <script>
            var chartDonutBasicColors = getChartColorsArray("simple_dount_chart");

            function formatearNumeroCustom(numero) {
                if (typeof numero === 'number' && !isNaN(numero)) {
                    const partes = numero.toFixed(2).split('.');
                    const parteEntera = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    const resultado = parteEntera + '.' + partes[1];
                    return resultado;
                } else {
                    // Manejar el caso en el que 'numero' no es un número válido
                    console.error("El valor proporcionado no es un número válido.");
                    return null; // O puedes devolver una cadena vacía u otro valor según tu lógica
                }
            }


            function verEstadisticas(id, prefix) {
                if (chart) {
                    chart.destroy();
                }
                let opciones = {
                    style: "decimal",
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                };
                let linea = '';
                var tablaDatos = document.querySelector("#tabla-datos")

                var title = document.querySelector("#title-estadisticas")
                var dataEstrategia = document.querySelector("#data-estrategia")
                var tablaFoot = document.querySelector("#tabla-foot")


                title.innerHTML = ''
                dataEstrategia.innerHTML = ''
                tablaDatos.innerHTML = ''
                tablaFoot.innerHTML = ''

                fetch('<?php echo e(route('strategy.estadisticas')); ?>', {
                    method: 'POST',
                    body: JSON.stringify({
                        id: id,
                        prefix: prefix,
                        historico: true,
                        type: 3
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    return response.json();
                }).then(data => {
                    let regsArray = Object.values(data.estadisticas).map(item => item.regs);
                    let statusArray = Object.values(data.estadisticas).map(item => item.status);

                    title.innerHTML = data.estrategia.prefix_client + ' ' + data.estrategia.id
                    dataEstrategia.innerHTML = `
                        <table class='table table-sm table-bordered align-middle'>
                            <tr>
                                <th>Criterio</th>
                                <td>${data.estrategia.onlyWhere}</td>
                            </tr>
                            <tr>
                                <th>Total de registros del criterio</th>
                                
                                <td>${data.estrategia.total_registros.toLocaleString(
                            "de-DE")}</td>
                            </tr>
                            <tr>
                                <th>Cobertura de la cartera</th>
                                <td>${data.estrategia.cobertura.toFixed(2)}%</td>
                            </tr>
                        </table>`


                    let tr = 0
                    let av = 0

                    for (let line of data.estadisticas) {
                        linea += '<tr class="text-center" >'
                        linea += '<td>' + line.status + '</td>';
                        linea += '<td>' + line.regs.toLocaleString(
                            "de-DE") + '</td>';
                        linea += '<td>' + ((line.regs / data.estrategia.total_registros) * 100).toFixed(2) +
                            '%</td>';
                        linea += '</tr>';

                        tr += line.regs
                        av += ((line.regs / data.estrategia.total_registros) * 100)
                    }


                    tablaFoot.innerHTML = `
                            <tr>
                                <th>Total recorrido</th>
                                <th>${tr.toLocaleString(
                            "de-DE")}</th>
                                <th>${av.toFixed(2)}%</th>
                            </tr>
                        `
                    // let linea = '<tr><td>lorem</td></tr>'
                    tablaDatos.innerHTML = linea;





                    console.log(data)
                    if (chartDonutBasicColors) {
                        var options = {
                            series: regsArray,
                            labels: statusArray,
                            chart: {
                                height: 400,
                                type: 'pie',
                            },
                            legend: {
                                position: 'bottom'
                            },
                            dataLabels: {
                                enabled: true,
                                dropShadow: {
                                    enabled: false,
                                }

                            },
                            colors: chartDonutBasicColors
                        };
                        chart = new ApexCharts(document.querySelector("#simple_dount_chart"), options);
                        chart.render();
                    }
                });
            }






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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PC\Desktop\CODIGO\GIT\app-estrategias\resources\views/strategy/history.blade.php ENDPATH**/ ?>