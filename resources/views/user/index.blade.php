@extends('layouts.dashboard')
@section('content')
    <div class="row mt-4">
    </div>

    <div class="container-fluid py-4" id="containerUsers">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-1 pb-0">
                            <h6 class="text-white text-center text-capitalize ps-2 mx-6 p-3">Usuarios</h6>
                        </div>
                    </div>
                    <div class="card-body pb-2 ">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center pb-4">
                                <a href="#" id="btn-add" class="btn btn-primary">Crear usuario</a>
                            </div>
                        </div>
                        <div class="table-responsive mt-3 p-0">
                            <table id="my_table" class="table table-striped table-align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nombre
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Correo
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Acción
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                            </table>
                            <style>
                                .form-control {
                                    background-color: #f2f2f2 !important;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Crear Usuario</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="form-group col-md-6 mt-2">
                                <label for="name">Nombre</label>
                                <input class="form-control" type="text" name="name" id="name" required>
                            </div>

                            <div class="form-group col-md-6 mt-2">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email" required>
                            </div>
                            <div class="col-md-6 mt-2 mx-auto">
                                <label class="form-label" for="taskIDs">Asigna tarea</label>
                                <select class="form-control" id="taskIDs" name="taskIDs" aria-label="select example"
                                        data-header="role" multiple>
                                    <option value="default" disabled>Seleccione</option>

                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="row d-flex justify-content-center">
                                    <div class="form-group col-md-6 mt-3">
                                        <label for="password">Contraseña</label>
                                        <input class="form-control" type="password" name="password" id="password"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 d-flex justify-content-center mt-4">
                                <input type="submit" class="btn btn-success" id="btn-send" value="Guardar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                url: '{{getenv('APP_URL')}}/api/v1/users',
                method: 'GET',
                success: function (response) {
                    let table = $('#my_table').DataTable();

                    // Limpiar la tabla antes de agregar nuevas filas
                    table.clear();

                    // Construir dinámicamente cada fila
                    response.forEach(function (item) {

                        $(`#my_modal_table${item.id}`).DataTable({
                            paging: true,
                            searching: true,
                            responsive: true,
                            autoWidth: false,
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                            }
                        });

                        let rowHTML = `
                        <tr class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <td>${item.name}</td>
                            <td>${item.email}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div class="d-inline">
                                        <a style="color: darkgreen;" href="#" title="Detalle" id="btn-delete" class="btn btn-link px-1 mb-0" onclick="userDetail('${item.id}')"><i style="color: darkblue; font-size: 25px !important;" class="material-icons opacity-10">add</i></a>
                                    </div>
                                    <div class="d-inline">
                                        <a style="color: darkred;" href="#" title="Editar" class="btn btn-link px-1 mb-0" onclick="showEditModal('${item.id}')"><i style="color: darkslategrey; font-size: 25px !important;" class="material-icons opacity-10">edit</i></a>
                                    </div>
                                    <div class="d-inline">
                                        <a style="color: darkgreen;" href="#" title="Eliminar" id="btn-delete" class="btn btn-link px-1 mb-0" onclick="deleteUser('${item.id}')"><i style="color: darkred; font-size: 25px !important;" class="material-icons opacity-10">delete</i></a>
                                    </div>

                                </div>
                            </td>
                        </tr>`;

                        let updateModalHTML = `
                        <div class="modal fade" id="editUserModal${item.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Editar Usuario</h6>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="form-group col-md-6 mt-2">
                                                    <label for="name">Nombre</label>
                                                    <input class="form-control" type="text" name="name" id="name${item.id}" value="${item.name}" required>
                                                </div>
                                                <div class="form-group col-md-6 mt-2">
                                                    <label for="email">Email</label>
                                                    <input class="form-control" type="email" name="email" id="email${item.id}" value="${item.email}" required>
                                                </div>
                                                <div class="col-md-6 mt-2 mx-auto">
                                                    <label class="form-label" for="taskIDs">Asigna tarea</label>
                                                    <select class="form-control" id="taskIDs${item.id}" name="taskIDs${item.id}" aria-label="select example"
                                                            data-header="role" multiple>
                                                        <option value="default" disabled>Seleccione</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="form-group col-md-6 mt-3">
                                                            <label for="password">Contraseña</label>
                                                            <input class="form-control" type="password" name="password" id="password${item.id}"
                                                            required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-center mt-4">
                                                    <input type="submit" class="btn btn-success" id="btn-upload" onclick="updateUser('${item.id}')" value="Modificar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        let tasksByUserModalHTML = `
                        <div class="modal fade" id="userTasksModal${item.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Editar Cargo</h6>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="table-responsive mt-3 p-0">
                                                    <table id="my_table${item.id}" class="my_modal_table table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Título Tarea
                                                                </th>
                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Estado
                                                                </th>
                                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    Acción
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        // Convertir HTML en un elemento jQuery y agregarlo a la tabla
                        table.row.add($(rowHTML));
                        $('#containerUsers').append(updateModalHTML);
                        $('#containerUsers').append(tasksByUserModalHTML);
                    });

                    // Dibujar la tabla para reflejar los cambios
                    table.draw();
                }
            });

            $.ajax({
                url: '{{getenv('APP_URL')}}/api/v1/tasks',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    // Seleccionar el elemento del select
                    const $select = $('#taskIDs');

                    // Limpiar opciones previas (si es necesario)
                    $select.empty();

                    // Agregar una opción por defecto
                    $select.append('<option value="default" disabled>Seleccione</option>');

                    // Iterar sobre el JSON para crear las opciones
                    response.forEach(function (item) {
                        const option = `<option value="${item.id}">${item.title}</option>`;
                        $select.append(option);
                    });

                    // Si necesitas que la opción por defecto esté seleccionada
                    //$select.val('default');
                },
                error: function (error) {
                    console.error('Error al cargar las tareas:', error);
                }
            });

            $('#btn-add').on('click', function() {
                $('#createUserModal').modal('show');
            });

            $('#btn-send').on('click', function(){

                if ($('#name').val() == '' || $('#email').val() == '' || $('#password').val() == '') {

                    Swal.fire({
                        title: 'Alerta',
                        text: 'Por favor llene los campos: nombre, correo y contraseña',
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    return false;
                }

                let data = {
                    'name': $('#name').val(),
                    'email': $('#email').val(),
                    'taskIDs': $('#taskIDs').val(),
                    'password': $('#password').val(),
                }

                if ($('#taskIDs').val().length == 0) {
                    data = {
                        'name': $('#name').val(),
                        'email': $('#email').val(),
                        'password': $('#password').val(),
                    }
                }

                $.ajax({
                    url: '{{getenv('APP_URL')}}/api/v1/user/store',
                    method: 'POST',
                    data: data,
                    success: function() {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Registro Satisfactorio',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(function(){
                            window.location="{{getenv('APP_URL')}}/users";
                        });
                    }
                });
            });
        });

        $(document).on('shown.bs.modal', '.modal', function () {
            $(this).find('.my_modal_table').each(function () {
                if (!$.fn.DataTable.isDataTable(this)) { // Verifica si ya está inicializado
                    $(this).DataTable({
                        paging: true,
                        searching: true,
                        responsive: true,
                        autoWidth: false,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                        }
                    });
                }
            });
        });

    </script>
    <script>
        function showEditModal(id)
        {
            $.ajax({
                url: '{{getenv('APP_URL')}}/api/v1/tasks',
                method: 'GET',
                success: function(allTasks) {
                    // Solicitar las tareas asignadas al usuario
                    $.ajax({
                        url: `{{getenv('APP_URL')}}/api/v1/user-task/${id}`,
                        method: 'GET',
                        success: function(userTasks) {
                            // Crear un conjunto con los IDs de las tareas asignadas
                            const assignedTaskIds = new Set(userTasks.map(task => task.task_id));

                            // Seleccionar el <select> correspondiente al modal del usuario
                            const $select = $(`#taskIDs${id}`);

                            // Limpiar el contenido previo
                            $select.empty();

                            // Generar opciones
                            allTasks.forEach(task => {
                                const isSelected = assignedTaskIds.has(task.id) ? 'selected' : '';
                                const option = `<option value="${task.id}" ${isSelected}>${task.title}</option>`;
                                $select.append(option);
                            });

                            // Mostrar el modal
                            $(`#editUserModal${id}`).modal('show');
                        },
                        error: function(err) {
                            console.error('Error al obtener tareas asignadas:', err);
                        }
                    });
                },
                error: function(err) {
                    console.error('Error al obtener todas las tareas:', err);
                }
            });
        }

        function updateUser(id)
        {
            if ($('#name'+id).val() == '' || $('#email'+id).val() == '') {

                Swal.fire({
                    title: 'Alerta',
                    text: 'Por favor llene los campos: nombre y correo ',
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });

                return false;
            }

            let data = {
                'id': id,
                'name': $('#name'+ id).val(),
                'email': $('#email'+ id).val(),
                'taskIDs': $('#taskIDs'+ id).val(),
                'password': $('#password'+ id).val(),
            }

            $.ajax({
                url: '{{getenv('APP_URL')}}/api/v1/user/update',
                method: 'PUT',
                data: data,
                success: function() {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Registro Modificado',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(function(){
                        window.location="{{getenv('APP_URL')}}/users";
                    });
                },
                error: function(r) {
                    console.log(r);
                }
            });
        }

        function userDetail(id)
        {
            // Realizar la solicitud AJAX para obtener las tareas del usuario
            $.ajax({
                url: `{{getenv('APP_URL')}}/api/v1/user-task/${id}`, // Endpoint para obtener tareas del usuario
                method: 'GET',
                success: function (userTasks) {
                    // Obtener el contenedor de la tabla del modal
                    const tableBody = $(`#userTasksModal${id} table tbody`);
                    tableBody.empty(); // Limpiar filas previas

                    userTasks.forEach(userTask => {

                        const switchId = `taskSwitch${userTask.id}`;
                        const taskRow = `
                    <tr>
                        <td class="text-center text-uppercase">${userTask.task.title}</td>
                        <td class="text-center text-uppercase"><p id="statusText${userTask.id}">${userTask.status}</p></td>
                        <td class="text-center">
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input class="form-check-input" type="checkbox" id="${switchId}" onchange="changeTaskStatus('${userTask.id}', this.checked)">
                                <label class="form-check-label" for="${switchId}"></label>
                            </div>
                        </td>
                    </tr>
                `;
                        tableBody.append(taskRow);
                        $(`#userTasksModal${id}`).modal('show');

                    });
                },
                error: function () {
                    alert('Error al cargar las tareas del usuario.');
                }
            });

        }

        function changeTaskStatus(id, isChecked)
        {
            const newStatus = isChecked ? 'completado' : 'pendiente';

            $.ajax({
                url: `{{getenv('APP_URL')}}/api/v1/user-task/change-status`,
                method: 'POST',
                data: {
                    'id': id,
                    'status': newStatus
                },
                success: function(r) {
                    console.log(r.user_task_status);

                    $('#statusText' + id).text(r.user_task_status);
                },
                error: function(r) {
                    console.log(r);
                }
            });
        }

        function deleteUser(id)
        {
            Swal.fire({
                title: 'Alerta',
                text: '¿Está seguro que quiere borrar este usuario?',
                icon: 'question',
                showCancelButton: false,
                confirmButtonText: 'Aceptar',
                allowOutsideClick: true,
                allowEscapeKey: false
            }).then(function(result){
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{getenv('APP_URL')}}/api/v1/user/' + id,
                        method: 'DELETE',
                        success: function () {
                            Swal.fire({
                                title: 'Éxito',
                                text: 'Registro Eliminado',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'Aceptar',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(function () {
                                window.location = "{{getenv('APP_URL')}}/users";
                            });
                        }
                    });
                }
            });
        }
    </script>


@endsection
