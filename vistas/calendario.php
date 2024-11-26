<?php

date_default_timezone_set("America/Mexico_City");

// incluimos el archivo de funciones
include 'funciones.php';

// incluimos el archivo de configuracion
include '../config/conexion.php';

// Verificamos si se ha enviado el campo con name from
if (isset($_POST['from'])) {

    // Si se ha enviado verificamos que no vengan vacios
    if ($_POST['from'] != "" and $_POST['to'] != "") {

        // Recibimos el fecha de inicio y la fecha final desde el form
        $Datein                    = date('d/m/Y H:i:s', strtotime($_POST['from']));
        $Datefi                    = date('d/m/Y H:i:s', strtotime($_POST['to']));
        $inicio = _formatear($Datein);
        // y la formateamos con la funcion _formatear

        $final  = _formatear($Datefi);

        // Recibimos el fecha de inicio y la fecha final desde el form
        $orderDate                      = date('d/m/Y H:i:s', strtotime($_POST['from']));
        $inicio_normal = $orderDate;

        // y la formateamos con la funcion _formatear
        $orderDate2                      = date('d/m/Y H:i:s', strtotime($_POST['to']));
        $final_normal  = $orderDate2;

        // Recibimos los demas datos desde el form
        $titulo = evaluar($_POST['title']);

        // y con la funcion evaluar
        $body   = evaluar($_POST['event']);

        // reemplazamos los caracteres no permitidos
        $clase  = evaluar($_POST['class']);

        // insertamos el evento
        $query = "INSERT INTO agenda VALUES(null,'$titulo','$body','','$clase','$inicio','$final','$inicio_normal','$final_normal')";

        // Ejecutamos nuestra sentencia sql
        $conexion->query($query) or die('<script type="text/javascript">alert("Horario No Disponible ")</script>');

        header("Location:$base_url");


        // Obtenemos el ultimo id insetado
        $im = $conexion->query("SELECT MAX(id) AS id FROM agenda");
        $row = $im->fetch_row();
        $id = trim($row[0]);

        // para generar el link del evento
        $link = "$base_url" . "descripcion_evento.php?id=$id";

        // y actualizamos su link
        $query = "UPDATE agenda SET url = '$link' WHERE id = $id";

        // Ejecutamos nuestra sentencia sql
        $conexion->query($query);

        // redireccionamos a nuestro calendario
        //header("Location:$base_url"); 
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Calendario</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/calendar.css">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="../assets/js/es-ES.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/moment.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css" />

</head>
</head>

<body>
    <div class="d-flex">
        <div class="sidebar">
            <h2 class="text-center mb-4">ASYO Admin</h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link " href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="index.php"><i class="fas fa-calendar-alt"></i> Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-user-md"></i> Doctores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registro_pacientes.html"><i class="fas fa-users"></i> Pacientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inventario.html"><i class="fas fa-clipboard-list"></i> Inventario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-cog"></i> Configuración</a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="btn-group">
                            <button class="btn btn-primary" data-calendar-nav="prev"><i class="fa fa-arrow-left"></i></button>
                            <button class="btn" data-calendar-nav="today">Hoy</button>
                            <button class="btn btn-primary" data-calendar-nav="next"><i class="fa fa-arrow-right"></i></button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-warning" data-calendar-view="year">Año</button>
                            <button class="btn btn-warning active" data-calendar-view="month">Mes</button>
                            <button class="btn btn-warning" data-calendar-view="week">Semana</button>
                            <button class="btn btn-warning" data-calendar-view="day">Día</button>
                        </div>
                    </div>
                    <div class="col-sm-4 text-right">
                        <button class="btn btn-info" data-toggle='modal' data-target='#add_evento'>Añadir Evento</button>
                    </div>
                </div>

                <br><br><br>
                <div class="row">
                    <div id="calendar"></div> <!-- Aqui se mostrara nuestro calendario -->

                </div>
                <!--ventana modal para el calendario-->
                <div class="modal fade" id="events-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a href="#" data-dismiss="modal" style="float: right;"> <i class="glyphicon glyphicon-remove "></i> </a>
                                <br>
                            </div>
                            <div class="modal-body" style="height: 400px">
                                <p>One fine body&hellip;</p>
                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        </div>
    </div>

    <script src="js/underscore-min.js"></script>
    <script src="js/calendar.js"></script>
    <script type="text/javascript">
        (function($) {
            //creamos la fecha actual
            var date = new Date();
            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
            var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

            //establecemos los valores del calendario
            var options = {

                // definimos que los agenda se mostraran en ventana modal
                modal: '#events-modal',

                // dentro de un iframe
                modal_type: 'iframe',

                //obtenemos los agenda de la base de datos
                events_source: 'obtener_eventos.php',

                // mostramos el calendario en el mes
                view: 'month',

                // y dia actual
                day: yyyy + "-" + mm + "-" + dd,


                // definimos el idioma por defecto
                language: 'es-ES',

                //Template de nuestro calendario
                tmpl_path: 'tmpls/',
                tmpl_cache: false,


                // Hora de inicio
                time_start: '08:00',

                // y Hora final de cada dia
                time_end: '22:00',

                // intervalo de tiempo entre las hora, en este caso son 30 minutos
                time_split: '30',

                // Definimos un ancho del 100% a nuestro calendario
                width: '100%',

                onAfterEventsLoad: function(events) {
                    if (!events) {
                        return;
                    }
                    var list = $('#eventlist');
                    list.html('');

                    $.each(events, function(key, val) {
                        $(document.createElement('li'))
                            .html('<a href="' + val.url + '">' + val.title + '</a>')
                            .appendTo(list);
                    });
                },
                onAfterViewLoad: function(view) {
                    $('#page-header').text(this.getTitle());
                    $('.btn-group button').removeClass('active');
                    $('button[data-calendar-view="' + view + '"]').addClass('active');
                },
                classes: {
                    months: {
                        general: 'label'
                    }
                }
            };

            // id del div donde se mostrara el calendario
            var calendar = $('#calendar').calendar(options);

            $('.btn-group button[data-calendar-nav]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.navigate($this.data('calendar-nav'));
                });
            });

            $('.btn-group button[data-calendar-view]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.view($this.data('calendar-view'));
                });
            });

            $('#first_day').change(function() {
                var value = $(this).val();
                value = value.length ? parseInt(value) : null;
                calendar.setOptions({
                    first_day: value
                });
                calendar.view();
            });
        }(jQuery));
    </script>

    <div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Agregar nuevo evento</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <label for="from">Inicio</label>
                        <div class='input-group date' id='from'>
                            <input type='text' id="from" name="from" class="form-control" readonly />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </div>

                        <br>

                        <label for="to">Final</label>
                        <div class='input-group date' id='to'>
                            <input type='text' name="to" id="to" class="form-control" readonly />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </div>

                        <br>

                        <label for="tipo">Tipo de evento</label>
                        <select class="form-control" name="class" id="tipo">
                            <option value="Limpieza">Limpieza</option>
                            <option value="Extracciones">Extracciones</option>
                            <option value="Implantes dentales">Implantes dentales</option>
                            <option value="Endodoncias">Endodoncias</option>
                            <option value="Protesis dental">Protesis dental</option>
                        </select>

                        <br>


                        <label for="title">Título</label>
                        <input type="text" required autocomplete="off" name="title" class="form-control" id="title" placeholder="Introduce un título">

                        <br>


                        <label for="body">Evento</label>
                        <textarea id="body" name="event" required class="form-control" rows="3"></textarea>

                        <script type="text/javascript">
                            $(function() {
                                $('#from').datetimepicker({
                                    language: 'us',
                                    minDate: new Date()
                                });
                                $('#to').datetimepicker({
                                    language: 'us',
                                    minDate: new Date()
                                });

                            });
                        </script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>