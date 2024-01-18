<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0">
            <div class="modal-header bg-soft-info p-3">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            {!! Form::open([
                'route' => 'strategy.save-strategy',
                'method' => 'POST',
                'id' => 'myForm',
                'autocomplete' => 'off',
            ]) !!}

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div>
                            <label for="companyname-field" class="form-label">Canal</label>
                            <select onchange='selectTemplate(this)' class="form-select form-select-sm" name="channels"
                                id="canalsito">
                                <option value="">Seleccione</option>
                                @for ($i = 0; $i < count($channels); $i++)
                                    @if (in_array($i, $ch_approve))
                                        <option value="{{ $i }}">
                                            {{ strtoupper($channels[$i]['name']) }}
                                        </option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <label for="owner-field" class="form-label" id="lblTemplate">Template</label>
                            <select disabled class="form-select form-select-sm" name="template" id="template">
                                <option value="">Seleccione</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="col-lg-21">
                            <div class="table-responsive my-2">
                                <table class="table table-sm align-middle table-nowrap mb-0">
                                    <thead class="table-light text-center text-uppercase">
                                        <tr>
                                            <th scope="col">
                                                <a type="button" class="btn btn-success btn-sm" id='btnNuevo'
                                                    onclick="addRow()">
                                                    <i class="ri-add-line"></i>
                                                </a>
                                            </th>
                                            <th scope="col">Campo</th>
                                            <th scope="col">Operador</th>
                                            <th scope="col">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTableDesign"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <textarea class="form-control" id="showQue" name="showQue" disabled></textarea>
                            <input type="hidden" name='prefix' id='prefix' value={{ $client['prefix'] }}>
                            <input type="hidden" name='onlyWhere' id='onlyWhere'>
                            <input type="hidden" name='table_name' id='table_name2'>
                            <input type="hidden" name='location' value='diseno'>
                            <input type="hidden" id="cober" name='cober'>
                            <input type="hidden" id="unic" name='unic'>
                            <input type="hidden" id="repe" name='repe'>
                            <input type="hidden" id="tota" name='total'>
                            <input type="hidden" id="registros" name='registros'>
                            <input type="hidden" id="id_cliente" name='id_cliente' value={{ $client['id'] }}>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="table-responsive my-2">
                            <table class="table table-sm align-middle table-nowrap mb-0">
                                <thead class="text-center text-uppercase">
                                    <tr>
                                        <th>cobertura</th>
                                        <th>unicos</th>
                                        <th>repetidos</th>
                                        <th>total</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td><span id='cobertura'></span></td>
                                        <td><span id='unicos'></span></td>
                                        <td><span id='repetidos'></span></td>
                                        <td><span id="total"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>


            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" disabled='true' class="btn btn-soft-success" id="guard">Guardar</button>
                    <button type="button" disabled='true' onclick="probarConsulta()" class="btn btn-soft-info"
                        id="probar"><i class="ri-play-fill me-1 align-bottom"></i> Probar</button>
                    {{-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> --}}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('script')
    <script>
        function acceptedStrategy(id, channels, prefix) {
            // spinner.removeAttribute('hidden');
            fetch('{{ route('strategy.accepted-strategy') }}', {
                method: 'POST',
                body: JSON.stringify({
                    id: id,
                    channels: channels,
                    prefix: prefix,
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
                } else {
                    // document.querySelector('.alert').classList.remove('d-none');
                    // document.querySelector('.alert').classList.remove('alert-success');
                    // document.querySelector('.alert').classList.add('alert-danger')
                    // document.querySelector('#messages').innerHTML = data.message
                }
            });

        }

        var i = 0;
        const csrfToken = "{{ csrf_token() }}";
        document.getElementById("myForm").addEventListener('submit', validar);


        function selectTemplate(select = '') {

            prefix = document.getElementById('prefix').value
            temp = document.getElementById('template')
            lblTemplate = document.getElementById('lblTemplate')
            temp.innerHTML = '<option value="">Seleccione</option>'
            if (select.selectedOptions[0].text === 'AGENTE') {
                objLista = @json($lista_discadores);
                for (var clave in objLista) {
                    var opcion = document.createElement("option");
                    opcion.value = objLista[clave].idlista;
                    opcion.text = objLista[clave].descripcion + ' ' + objLista[clave].discador;
                    lblTemplate.innerHTML = "Lista"
                    temp.appendChild(opcion);
                }
                temp.disabled = false;
            } else {
                temp.disabled = true;
                temp.value = '';
            }

            document.getElementById('guard').disabled = true;
            document.getElementById('cobertura').innerHTML = `0,00%`
            document.getElementById('unicos').innerHTML = `0`
            document.getElementById('repetidos').innerHTML = `0`
            document.getElementById('total').innerHTML = `0`
            document.getElementById('cober').value = 0
            document.getElementById('unic').value = 0
            document.getElementById('repe').value = 0
            document.getElementById('tota').value = 0
        }


        function addRow() {

            var estructura = @json($estrc);


            var table = document.getElementById("myTableDesign");
            document.getElementById('guard').disabled = true;
            document.getElementById('probar').disabled = false;
            var row = table.insertRow(-1);
            row.id = 'tr_' + i

            if (estructura.length > 0) {
                var cell2 = row.insertCell(-1);
                var cell3 = row.insertCell(-1);
                var cell4 = row.insertCell(-1);

                lines = `
                    <select id="my-select" class='form-select form-select-sm campo' onchange="selectInputType(this.value, ${i}, event, document.getElementById('operator_${i}'))">
                    <option>Seleccione</option>`
                for (let d in estructura) {
                    lines +=
                        `<option value='${estructura[d].COLUMN_TYPE}-${estructura[d].TABLE_NAME}-${estructura[d].COLUMN_NAME}'>${estructura[d].NAME}</option>`
                }
                lines += `</select>`

                cell2.innerHTML =
                    `<input type="hidden" id="name_table" />
                    <a onclick="borrarRow(this)" class="btn btn-sm btn-block mb-0 btn-danger"><i class="ri-close-line"></i></a>`;
                cell2.className = "text-center align-middle p-0"

                cell3.innerHTML = lines
                cell3.id = "td_" + i

                cell4.innerHTML = `
                    <select class='form-select form-select-sm operator' id='operator_${i}'>
                        <option>Seleccione</option>
                        <option value="=" > Igual </option>
                        <option value=">=" > Mayor ó igual </option>
                        <option value="<=" > Menor ó igual </option>
                        <option value=">" > Mayor qué </option>
                        <option value="<" > Menor qué </option>
                        </select>`
            }
            i++
        }

        function borrarRow(x) {
            var i = x.parentNode.parentNode.rowIndex;
            document.getElementById("myTableDesign").deleteRow(i);
        }




        function probarConsulta() {


            document.getElementById('guard').disabled = true;
            var query = document.getElementById('showQue').value;
            var prefix = document.getElementById('prefix').value;
            var table_name = document.getElementById('table_name2').value;
            var id_cliente = document.getElementById('id_cliente').value;
            var template = document.getElementById('template').value;
            var canal = document.querySelector('#canalsito').value





            if (canal == '') {
                Swal.fire({
                    title: 'Probando estrategia',
                    icon: 'error',
                    text: 'Debe seleccionar un Canal',
                    showCloseButton: true
                });
                return;
            }

            if (template == '') {
                Swal.fire({
                    title: 'Probando estrategia',
                    icon: 'error',
                    text: 'Debe seleccionar una Lista',
                    showCloseButton: true
                });
                return;
            }

            if (query == '') {
                Swal.fire({
                    title: 'Probando estrategia',
                    icon: 'error',
                    text: 'Debe seleccionar una Lista',
                    showCloseButton: true
                });
                return;
            }

            Swal.fire({
                title: 'Probando estrategia',
                html: 'Por favor espera a que se valide la estrategia para continuar',
                allowOutsideClick: false,
                showLoaderOnConfirm: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            let opciones = {
                style: "decimal",
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            };

            fetch('{{ route('strategy.test-strategy') }}', {
                method: 'POST',
                body: JSON.stringify({
                    query: query,
                    prefix: prefix,
                    table_name: table_name,
                    check: 1,
                    id_cliente: id_cliente,
                    template: template,
                    channel: canal
                }),
                headers: {
                    'content-type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            }).then(response => {
                return response.json();
            }).then(data => {
                console.log(data)
                if (!data.error) {
                    Swal.fire({
                        title: 'Comprobando estrategia',
                        icon: 'success',
                        text: 'Tu estrategia retorno algo',
                        showCloseButton: true
                    })
                    document.getElementById('cobertura').innerHTML =
                        `${data.percent_cober.toLocaleString("de-DE", opciones)}%`
                    document.getElementById('unicos').innerHTML = data.total_unicos.toLocaleString("de-DE")
                    document.getElementById('repetidos').innerHTML = data.total_repetidos.toLocaleString(
                        "de-DE")
                    document.getElementById('total').innerHTML = data.total_r.toLocaleString("de-DE")
                    document.getElementById('cober').value = data.percent_cober.toFixed(2)
                    document.getElementById('unic').value = data.total_unicos
                    document.getElementById('repe').value = data.total_repetidos
                    document.getElementById('tota').value = data.total_r
                    document.getElementById('registros').value = JSON.stringify(data.unicos)
                    document.getElementById('guard').disabled = false;
                } else {
                    document.getElementById('cobertura').innerHTML = `0,00%`
                    document.getElementById('unicos').innerHTML = `0`
                    document.getElementById('repetidos').innerHTML = `0`
                    document.getElementById('total').innerHTML = `0`
                    document.getElementById('cober').value = 0
                    document.getElementById('unic').value = 0
                    document.getElementById('repe').value = 0
                    document.getElementById('tota').value = 0
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: data.error,
                        showCloseButton: true
                    })
                }
            });
        }

        function validar(e) {
            console.log(e)
            const valoresElements = document.querySelectorAll('.valores');
            if (document.getElementById("canalsito").value === '') {
                alert('Debe selccionar el canal para la estrategia.');
                document.getElementById("canalsito").focus()
                e.preventDefault();
                return false

            } else if (valoresElements.length === 0) {
                alert('debe haber al menos una consultar para generar la estrategia.');
                document.getElementById("btnNuevo").focus()
                e.preventDefault();
                return false;
            } else {
                return true
            }
        }

        function selectInputType(value, i, e, op = '') {

            document.getElementById('guard').disabled = true;

            const pattern = /\((\d+)\)/;
            const matches = value.match(pattern);
            var text = ''

            if (matches) {
                const openingParenIndex = value.indexOf("(");
                text = value.substring(0, openingParenIndex);
            } else {
                text = value
            }
            var openingParenIndex2 = value.split("-");
            document.getElementById("name_table").value = openingParenIndex2[1];
            var table = document.getElementById("myTableDesign");
            nuevoTd = document.createElement("td");
            var nuevoDiv = document.createElement("div");
            nuevoDiv.className = 'input-group'
            nuevoTd.id = 'td2_' + i

            const ultimaFila = table.rows[table.rows.length - 1];
            const nuevoInput = document.createElement("input");

            switch (text) {
                case 'varchar':
                    nuevoInput.type = "text";
                    break;
                case 'int':
                    nuevoInput.type = "number";
                    break;
                case 'date':
                    nuevoInput.type = "date";
                    break;
            }

            if (e.target.selectedOptions[0].text === 'monto') {
                if (op.value === 'dh') {
                    nuevoInput.name = e.target.selectedOptions[0].text + '_min'
                    nuevoInput.className = 'form-control form-control-sm valores limite-input'
                    nuevoInput.setAttribute("data-limite", matches[1]);
                    nuevoInput.setAttribute("onkeyup", 'showQuery()');

                    const nuevoInput2 = document.createElement("input");
                    nuevoInput2.type = "number";
                    nuevoInput2.name = e.target.selectedOptions[0].text + '_max'
                    nuevoInput2.className = 'form-control form-control-sm valores limite-input'
                    nuevoInput2.setAttribute("data-limite", matches[1]);
                    nuevoInput.setAttribute("placeholder", 'minimo');
                    nuevoInput2.setAttribute("placeholder", 'maximo');
                    nuevoInput2.setAttribute("onkeyup", 'showQuery()');
                    if (document.getElementById('td2_' + i)) {
                        document.getElementById('td2_' + i).innerHTML = ''
                        nuevoDiv.appendChild(nuevoInput)
                        nuevoDiv.appendChild(nuevoInput2)
                        document.getElementById('td2_' + i).appendChild(nuevoDiv)
                    } else {
                        nuevoDiv.appendChild(nuevoInput)
                        nuevoDiv.appendChild(nuevoInput2)
                        ultimaFila.appendChild(nuevoDiv);
                    }

                    const campos = document.querySelectorAll(".limite-input");
                    campos.forEach(function(campo) {
                        const limite = campo.dataset.limite;
                        campo.addEventListener("input", function() {
                            if (this.value.length > limite) {
                                this.value = this.value.slice(0, limite);
                            }
                        });
                    });
                } else {
                    nuevoInput.name = e.target.selectedOptions[0].text
                    nuevoInput.className = 'form-control form-control-sm valores limite-input'
                    nuevoInput.setAttribute("data-limite", matches[1]);
                    nuevoInput.setAttribute("onkeyup", 'showQuery()');

                    if (document.getElementById('td2_' + i)) {
                        document.getElementById('td2_' + i).innerHTML = ''
                        nuevoDiv.appendChild(nuevoInput)
                        document.getElementById('td2_' + i).appendChild(nuevoDiv)
                    } else {
                        nuevoDiv.appendChild(nuevoInput)
                        ultimaFila.appendChild(nuevoDiv);
                    }

                }

            } else if (e.target.selectedOptions[0].text === 'comuna') {
                var selectComuna =
                    `<select class="form-select valores" onchange="showQuery()" name="${e.target.selectedOptions[0].text}" ><option>Seleccione la comuna</option>`
                for (let i in objComunas) {
                    selectComuna += `<option value="${objComunas[i]}">${objComunas[i]}</option>`
                }
                selectComuna += `</select>`

                if (document.getElementById('td2_' + i)) {
                    document.getElementById('td2_' + i).innerHTML = ''
                    document.getElementById('td2_' + i).innerHTML = selectComuna;
                } else {
                    ultimaFila.appendChild(nuevoTd);
                    document.getElementById('td2_' + i).innerHTML = selectComuna;
                }
            } else {
                nuevoInput.name = e.target.selectedOptions[0].text
                nuevoInput.className = 'form-control form-control-sm valores limite-input'
                nuevoInput.setAttribute("data-limite", matches[1]);
                nuevoInput.setAttribute("onkeyup", 'showQuery()');
                if (document.getElementById('td2_' + i)) {
                    document.getElementById('td2_' + i).innerHTML = ''
                    document.getElementById('td2_' + i).appendChild(nuevoInput)
                } else {
                    nuevoTd.appendChild(nuevoInput);
                    ultimaFila.appendChild(nuevoTd);
                }

                const campos = document.querySelectorAll(".limite-input");
                campos.forEach(function(campo) {
                    const limite = campo.dataset.limite;

                    campo.addEventListener("input", function() {
                        if (this.value.length > limite) {
                            this.value = this.value.slice(0, limite);
                        }
                    });
                });
            }
        }

        function showQuery() {
            document.getElementById('guard').disabled = true;
            document.getElementById('probar').disabled = false;

            var query = "";
            var queryParts = [];
            const valoresElements = document.querySelectorAll('.valores');
            const name_table = document.querySelector('#name_table');
            const op = document.querySelectorAll('.operator');
            const valoresObj = {};


            const campo = document.querySelectorAll('.campo');

            valoresElements.forEach((element, i) => {

                var dato = campo[i].value
                var openingParenIndex3 = dato.split("-");

                if (element.name === 'monto_min' && element.value !== '') { //Verificamos el campo monto
                    const montoMin = parseFloat(element.value);
                    const montoMax = parseFloat(document.querySelector('[name="monto_max"]').value);
                    if (!isNaN(montoMin) && !isNaN(montoMax)) {
                        const betweenClause =
                            `monto BETWEEN ${montoMin} AND ${montoMax}`; //crearmos la linea del between
                        if (!queryParts.includes(betweenClause)) {
                            queryParts.push(betweenClause); // lo metemos en el objeto
                        }
                    }
                } else if (element.name === 'monto_max' && element.value !== '') {
                    const montoMin = parseFloat(document.querySelector('[name="monto_min"]').value);
                    const montoMax = parseFloat(element.value);
                    if (!isNaN(montoMin) && !isNaN(montoMax)) {
                        const betweenClause = `monto BETWEEN ${montoMin} AND ${montoMax}`;
                        if (!queryParts.includes(betweenClause)) {
                            queryParts.push(betweenClause);
                        }
                    }
                } else {
                    if (op[i].value === 'like') {
                        queryParts.push(`${openingParenIndex3[2]} like '%${element.value}%'`); // 
                    } else if (element.type === 'date' || element.type === 'text') {
                        queryParts.push(`${openingParenIndex3[2]} ${op[i].value} '${element.value}'`); // 
                    } else {
                        queryParts.push(`${openingParenIndex3[2]} ${op[i].value} ${element.value}`); // 
                    }

                }
            });

            query = queryParts.join(' and '); //añadimos los and a la consulta
            document.getElementById('showQue').value = query; // muestro en el textarea el codigo
            document.getElementById('onlyWhere').value = query; // muestro en el textarea el codigo
            document.getElementById('table_name2').value = name_table.value; // muestro en el textarea el codigo
        }
    </script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
