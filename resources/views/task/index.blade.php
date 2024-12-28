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
                            <h6 class="text-white text-center text-capitalize ps-2 mx-6 p-3">Empleados</h6>
                        </div>
                    </div>
                    <div class="card-body pb-2 ">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center pb-4">
                                <a href="#" id="btn-add" class="btn btn-primary">Crear tarea</a>
                            </div>
                        </div>
                        <div class="table-responsive mt-3 p-0">
                            <table id="my_table" class="table table-striped table-align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Título
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
    <div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Crear Tarea</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="form-group col-md-6 mt-2">
                                <label for="titulo">Título</label>
                                <input class="form-control" type="text" name="title" id="title" required>
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
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{getenv('APP_URL')}}/api/v1/tasks',
                method: 'GET',
                success: function (response) {
                    let table = $('#my_table').DataTable();

                    // Limpiar la tabla antes de agregar nuevas filas
                    table.clear();

                    // Construir dinámicamente cada fila
                    response.forEach(function (item) {

                        let rowHTML = `
                        <tr class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <td>${item.title}</td>
                            <td>
                                <div class="d-flex justify-content-center">

                                    <div class="d-inline">
                                        <a style="color: darkred;" href="#" title="Editar" class="btn btn-link px-1 mb-0" onclick="showEditModal('${item.id}')"><i style="color: darkslategrey; font-size: 25px !important;" class="material-icons opacity-10">edit</i></a>
                                    </div>
                                    <div class="d-inline">
                                        <a style="color: darkgreen;" href="#" title="Eliminar" id="btn-delete" class="btn btn-link px-1 mb-0" onclick="deleteTask('${item.id}')"><i style="color: darkred; font-size: 25px !important;" class="material-icons opacity-10">delete</i></a>
                                    </div>
                                </div>
                            </td>
                        </tr>`;

                        let updateModalHTML = `
                        <div class="modal fade" id="editTaskModal${item.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Editar Tarea</h6>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row d-flex justify-content-center">
                                                <div class="form-group col-md-12 mt-2 d-flex justify-content-center">
                                                    <label for="title">Título</label>
                                                    <input class="form-control" type="text" name="title" id="title${item.id}" value="${item.title}" required>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-center mt-4">
                                                    <input type="submit" class="btn btn-success" id="btn-upload" onclick="updateTask('${item.id}')" value="Modificar">
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
                    });

                    // Dibujar la tabla para reflejar los cambios
                    table.draw();
                }
            });

            $('#btn-add').on('click', function() {
                $('#createTaskModal').modal('show');
            });

            $('#btn-send').on('click', function(){
                console.log($('#title').val());
                if ($('#title').val() == '') {

                    Swal.fire({
                        title: 'Alerta',
                        text: 'Por favor llene los campos: título',
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    return false;
                }

                $.ajax({
                    url: '{{getenv('APP_URL')}}/api/v1/task/store',
                    method: 'POST',
                    data: {
                        'title': $('#title').val()
                    },
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
                            window.location="{{getenv('APP_URL')}}/tasks";
                        });
                    }
                });
            });
        });
    </script>
    <script>
        function showEditModal(id)
        {
            $(`#editTaskModal${id}`).modal('show');
        }

        function updateTask(id)
        {
            if ($('#title'+id).val() == '') {

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
                'title': $('#title'+ id).val()
            }

            console.log(data);

            $.ajax({
                url: '{{getenv('APP_URL')}}/api/v1/task/update',
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
                        window.location="{{getenv('APP_URL')}}/tasks";
                    });
                },
                error: function(r) {
                    console.log(r);
                }
            });
        }

        function deleteTask(id)
        {
            Swal.fire({
                title: 'Alerta',
                text: '¿Está seguro que quiere borrar esta tarea?',
                icon: 'question',
                showCancelButton: false,
                confirmButtonText: 'Aceptar',
                allowOutsideClick: true,
                allowEscapeKey: false
            }).then(function(result){
                if(result.isConfirmed) {
                    $.ajax({
                        url: '{{getenv('APP_URL')}}/api/v1/task/' + id,
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
                                window.location = "{{getenv('APP_URL')}}/tasks";
                            });
                        }
                    });
                }
            });
        }

    </script>


@endsection
