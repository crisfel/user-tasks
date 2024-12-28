@extends('layouts.dashboard')
@section('content')
    <div class="pt-4">
        <p style="font-size: 27px" class="text-center mt-5 mb-1"> Bienvenido/a! <br>{{Auth::user()->name}}</p>
        <p style="font-size: 15px" class="text-center mt-5"> Añade los datos personales de tus usuarios y después agrega sus tareas </p>
        <p style="font-size: 35px" class="mt-4 text-center">
            <a href="#" id="btn-add"><i class="bi bi-person-add"></i></a>
        </p>
        <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
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
                                    <select class="form-control" id="taskIDs" name="taskIDs" aria-label="select example" data-header="role" multiple>
                                        <option value="default" disabled>Seleccione</option>

                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="row d-flex justify-content-center">
                                        <div class="form-group col-md-6 mt-3">
                                            <label for="password">Contraseña</label>
                                            <input class="form-control" type="password" name="password" id="password" required>
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
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#btn-add').on('click', function() {
                $('#createUserModal').modal('show');
            });

            $('#btn-send').on('click', function(){

                if ($('#name').val() == '' || $('#email').val() == '' || $('#password').val() == '') {

                    Swal.fire({
                        title: 'Alerta',
                        text: 'Por favor llene los campos: nombres, apellidos y contraseña',
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
    </script>
    <script>
        $(document).ready(function () {
            // Endpoint que devuelve el JSON
            const endpoint = '{{getenv('APP_URL')}}/api/v1/tasks';

            // Realizar petición AJAX
            $.ajax({
                url: endpoint,
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
        });
    </script>
@endsection
