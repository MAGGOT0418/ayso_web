<?php
session_start(); 


if (isset($_SESSION['id_usuario'])) {
    $rol = $_SESSION['id_rol']; 
    $nombre = $_SESSION['nombre'];
    $correo = $_SESSION['correo'];
    if ($rol == 3) {
        header("location: index.php");
    }
} else {
    $rol = null; 
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo - DentalCare</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="sidebar">
        <h2 class="text-center mb-4">AYSO Admin</h2>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendario.php"><i class="fas fa-calendar-alt"></i> Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="resumen_financiero.php"><i class="fas fa-user-md"></i> Finanzas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registro_pacientes.php"><i class="fas fa-users"></i> Pacientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="inventario.php"><i class="fas fa-clipboard-list"></i> Inventario /
                        Servicios</a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="../php/logout.php" class="nav-link text-danger logout">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>
    <div class="main-content">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-xs-8">
                            <h5 class="card-title mb-0">Inventario</h5>
                        </div>
                        <div class="col-xs-4 text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modalInsertarProducto">
                                Agregar Producto
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="inventariototal" class="table table-light">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-xs-8">
                            <h5 class="card-title mb-0">Servicios</h5>
                        </div>
                        <div class="col-xs-4 text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modalInsertarServicio">
                                Agregar Servicio
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="serviciosTable" class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>Servicio</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se agregarán las filas dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalInsertarServicio" tabindex="-1" role="dialog"
        aria-labelledby="modalInsertarServicioLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalInsertarServicioLabel">Insertar Servicio</h4>
                </div>
                <div class="modal-body">
                    <form id="formInsertarServicio">
                        <div class="form-group">
                            <label for="nombre_servicio">Nombre del Servicio</label>
                            <input type="text" class="form-control" id="nombre_servicio" name="nombre_servicio"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_servicio">Descripción</label>
                            <textarea class="form-control" id="descripcion_servicio" name="descripcion_servicio"
                                rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="precio_servicio">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precio_servicio"
                                name="precio_servicio" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="insertarServicio()">Guardar Servicio</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalActualizarServicio" tabindex="-1" role="dialog"
        aria-labelledby="modalActualizarServicioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalActualizarServicioLabel">Actualizar Servicio</h4>
                </div>
                <div class="modal-body">
                    <form id="formActualizarServicio">
                        <input type="hidden" id="id_servicio" name="id_servicio">
                        <div class="form-group">
                            <label for="nombre_servicio" class="control-label">Nombre del Servicio</label>
                            <input type="text" class="form-control" id="nombre_servicio" name="nombre_servicio"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="precio" class="control-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="actualizarServicio()">Guardar
                        Cambios</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalInsertarProducto" tabindex="-1" role="dialog"
        aria-labelledby="modalInsertarProductoLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalInsertarProductoLabel">Insertar Producto</h4>
                </div>
                <div class="modal-body">
                    <form id="formInsertarProducto">
                        <div class="form-group">
                            <label for="nombre_producto">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="insertarProducto()">Guardar Producto</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function insertarServicio() {
            const servicioData = {
                nombre_servicio: $('#nombre_servicio').val(),
                descripcion: $('#descripcion_servicio').val(),
                precio: $('#precio_servicio').val()
            };
            $.ajax({
                url: '../ajax/servicio.php?op=agregarServicio',
                type: 'POST',
                data: servicioData,
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(res.message);
                        $('#modalInsertarServicio').modal('hide');
                        cargarServicios();
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert('Error al insertar el servicio.');
                }
            });
        }

        function cargarServicios() {
            $.ajax({
                url: '../ajax/servicio.php?op=listarServicios',
                type: 'GET',
                success: function(response) {
                    $('#serviciosTable tbody').html(response);
                },
                error: function() {
                    alert('Error al cargar los servicios.');
                }
            });
        }

        $(document).ready(function() {
            cargarServicios();
        });

        function insertarProducto() {
            const productoData = {
                nombre_producto: $('#nombre_producto').val(),
                stock: $('#stock').val(),
                precio: $('#precio').val()
            };
            $.ajax({
                url: '../ajax/inventario.php?op=insertarProducto',
                type: 'POST',
                data: productoData,
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(res.message);
                        $('#modalInsertarProducto').modal('hide');
                        cargarProductos();
                    } else {
                        alert(res.message);
                    }
                },
                error: function() {
                    alert('Error al insertar el producto.');
                }
            });
        }

        function cargarProductos() {
            $.ajax({
                url: '../ajax/inventario.php?op=listar',
                type: 'GET',
                success: function(response) {
                    $('#inventariototal tbody').html(response);
                },
                error: function() {
                    alert('Error al cargar los productos.');
                }
            });
        }

        function mostrarActualizarServicios(id_servicio) {
            $.ajax({
                url: '../ajax/servicio.php?op=obtenerServicio',
                type: 'POST',
                data: {
                    id_servicio: id_servicio
                },
                success: function(response) {
                    const servicio = JSON.parse(response);
                    if (servicio) {
                        $('#id_servicio').val(servicio.id_servicio);
                        $('#nombre_servicio').val(servicio.nombre_servicio);
                        $('#descripcion').val(servicio.descripcion);
                        $('#precio').val(servicio.precio);
                        $('#modalActualizarServicio').modal('show');
                    } else {
                        alert('No se pudieron obtener los datos del servicio.');
                    }
                },
                error: function() {
                    alert('Error al obtener los datos del servicio.');
                }
            });
        }

        function actualizarServicio() {
            const datos = $('#formActualizarServicio').serialize();
            $.ajax({
                url: '../ajax/servicio.php?op=actualizarServicio',
                type: 'POST',
                data: datos,
                success: function(response) {
                    alert(response);
                    $('#modalActualizarServicio').modal('hide');
                    $.ajax({
                        url: '../ajax/servicio.php?op=listarServicios',
                        type: 'GET',
                        success: function(response) {
                            $('#serviciosTable tbody').html(response);
                        }
                    });
                },
                error: function() {
                    alert('Error al actualizar el servicio.');
                }
            });
        }
        $(document).ready(function() {
            $.ajax({
                url: '../ajax/servicio.php?op=listarServicios',
                type: 'GET',
                success: function(response) {
                    $('#serviciosTable tbody').empty();
                    if (response.trim().length > 0) {
                        $('#serviciosTable tbody').html(response);
                    } else {
                        $('#serviciosTable tbody').html('<tr><td colspan="4">No se encontraron servicios</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar los servicios:', error);
                    $('#serviciosTable tbody').html('<tr><td colspan="4">Error al cargar los datos</td></tr>');
                }
            });
        });
        $(document).ready(function() {
            $.ajax({
                url: '../ajax/inventario.php?op=listar',
                type: 'GET',
                success: function(response) {
                    $('#inventariototal tbody').html(response);
                }
            });
        });

        function eliminarServicio(id_servicio) {
            if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                $.ajax({
                    url: '../ajax/inventario.php?op=eliminarServicio',
                    type: 'POST',
                    data: {
                        id_servicio: id_servicio
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert(res.message);
                            $.ajax({
                                url: '../ajax/servicio.php?op=listarServicios',
                                type: 'GET',
                                success: function(response) {
                                    $('#inventariototal tbody').html(response);
                                }
                            });
                        } else {
                            alert(res.message);
                        }
                    },
                    error: function() {
                        alert('Error en la solicitud.');
                    }
                });
            }
        }

        function eliminarProducto(id_producto) {
            if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                $.ajax({
                    url: '../ajax/inventario.php?op=eliminar',
                    type: 'POST',
                    data: {
                        id_producto: id_producto
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert(res.message);
                            $.ajax({
                                url: '../ajax/inventario.php?op=listar',
                                type: 'GET',
                                success: function(response) {
                                    $('#inventariototal tbody').html(response);
                                }
                            });
                        } else {
                            alert(res.message);
                        }
                    },
                    error: function() {
                        alert('Error en la solicitud.');
                    }
                });
            }
        }

        function actualizarStock(id_producto, cantidad) {
            if (cantidad > 0) {
                $.ajax({
                    url: '../ajax/inventario.php?op=actualizarstock',
                    type: 'POST',
                    data: {
                        id_producto: id_producto,
                        cantidad: cantidad
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert(res.message);
                            $.ajax({
                                url: '../ajax/inventario.php?op=listar',
                                type: 'GET',
                                success: function(response) {
                                    $('#inventariototal tbody').html(response);
                                }
                            });
                        } else {
                            alert(res.message);
                        }
                    },
                    error: function() {
                        alert('Error al realizar la solicitud.');
                    }
                });
            } else {
                alert("Por favor ingresa una cantidad válida.");
            }
        }

        function mostrarActualizarStock(id_producto) {
            const cantidad = prompt("Ingresa la cantidad que deseas añadir al stock:");
            if (cantidad) {
                actualizarStock(id_producto, parseInt(cantidad, 10));
            }
        }
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>