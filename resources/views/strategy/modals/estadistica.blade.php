<div class="modal fade" id="showModalEstadisticas" tabindex="-1" aria-labelledby="exampleModalLabelEstadisticas"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-info p-3">
                <h5 class="modal-title" id="exampleModalLabel">Estadisticas <span id="title-estadisticas"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-center">
                    <div class="w-50">
                        <div id="simple_dount_chart"
                            data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                            class="apex-charts" dir="ltr">
                        </div>
                    </div>
                    <div class="w-50">
                        <table class="table table-sm table-bordered mt-3 align-middle">
                            <thead>
                                <tr class='text-center'>
                                    <th>Estatus</th>
                                    <th>Registros recorridos</th>
                                    <th>Avance recorrido</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-datos"></tbody>
                            <tfoot id='tabla-foot'></tfoot>
                        </table>


                        <div id="data-estrategia"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
