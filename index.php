<?php
session_start();

$mensajeRegistro = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['empleados'])) {
        $_SESSION['empleados'] = [];
    }

    // Verificar si ya hay 5 empleados registrados
    if (count($_SESSION['empleados']) >= 5) {
        echo "<script>alert('No se pueden registrar más de 5 empleados.');</script>";
    } else {
        $empleado = [
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'edad' => (int)$_POST['edad'],
            'estado_civil' => $_POST['estado_civil'],
            'sexo' => $_POST['sexo'],
            'sueldo' => $_POST['sueldo'],
        ];

        
        $_SESSION['empleados'][] = $empleado;

        $mensajeRegistro = 'Empleado registrado exitosamente.';
    }
}

function filtrarMujeres($empleado) {
    return $empleado['sexo'] === 'Femenino';
}

function filtrarCasadosAltoSueldoHombres($empleado) {
    return $empleado['sexo'] === 'Masculino' && $empleado['estado_civil'] === 'Casado(a)' && $empleado['sueldo'] === 'Más de 2500 Bs.';
}

function filtrarViudasAltoSueldoMujeres($empleado) {
    return $empleado['sexo'] === 'Femenino' && $empleado['estado_civil'] === 'Viudo(a)' && ($empleado['sueldo'] === 'Entre 1000 y 2500 Bs.' || $empleado['sueldo'] === 'Más de 2500 Bs.');
}

function calcularEdadPromedioHombres($empleados) {
    $totalEdad = 0;
    $totalHombres = 0;

    foreach ($empleados as $empleado) {
        if ($empleado['sexo'] === 'Masculino') {
            $totalEdad += $empleado['edad'];
            $totalHombres++;
        }
    }

   
    $edadPromedioHombres = ($totalHombres > 0) ? ($totalEdad / $totalHombres) : 0;

    return $edadPromedioHombres;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empleados</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        label, p {
            font-size: 18px;
            font-style: bold;
            margin-top: 20px;
        }

        button {
            align-items: center;
            align-content: center;
        }

        .parallax-container {
            min-height: 200px;
            line-height: 0;
            height: auto;
            color: rgba(255, 255, 255, .9);
        }

        .success-message {
            color: green;
        }
    </style>
</head>
<body>
<div class="parallax-container">
    <div class="container">
        <br><br>
        <h1 class="header center black-text">Registro de Empleados</h1>
    </div>
    <div class="parallax"><img
        src="https://img.freepik.com/fotos-premium/foto-suave-degradado-fondo-encabezado-degradado-medio-inferior-superior-degradado-colorido_873925-63657.jpg?w=2000"
        alt="Unsplashed background img 2"></div>
    </div>
</div>
<?php if (!empty($mensajeRegistro)) : ?>
    <p class="success-message"><?php echo $mensajeRegistro; ?></p>
    <hr>
<?php endif; ?>
<br>

<div class="container">
    <div class="card">
        <div class="card-content">
            <span class="card-title center-align">Formulario:</span>
            <form action="" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$"><br>

                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" required pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$"><br>

                <label for="edad">Edad:</label>
                <input type="number" name="edad" required min="18" max="90"><br>

                <label for="estado_civil">Estado Civil:</label>
                <select class="browser-default" name="estado_civil">
                    <option value="Soltero(a)">Soltero(a)</option>
                    <option value="Casado(a)">Casado(a)</option>
                    <option value="Viudo(a)">Viudo(a)</option>
                </select><br>

                <div class="input-field container center">
                    <p>Sexo:</p>
                    <p>
                        <label>
                            <input name="sexo" type="radio" value="Femenino" required />
                            <span>Femenino</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="sexo" type="radio" value="Masculino" required />
                            <span>Masculino</span>
                        </label>
                    </p>
                </div>

                <label for="sueldo">Sueldo:</label>
                <select class="browser-default" name="sueldo">
                    <option value="Menos de 1000 Bs.">Menos de 1000 Bs.</option>
                    <option value="Entre 1000 y 2500 Bs.">Entre 1000 y 2500 Bs.</option>
                    <option value="Más de 2500 Bs.">Más de 2500 Bs.</option>
                </select><br>
<br><br>
                <div class="center-align">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Registrar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <a href="consultar.php" class="waves-effect waves-light btn">Consultar Empleados</a>
    <br><br>
    
    <form action="destruir_sesion.php" method="post">
    <button class="btn waves-effect waves-light" type="submit">Borrar
                <i class="material-icons right">delete</i>
    </form>
</div>
<br>

<footer class="page-footer purple lighten-1">
    <div class="footer-copyright">
        <div class="container">
            <p>Copyright ©2023 rubilopez.site</p>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.parallax');
        var instances = M.Parallax.init(elems);
    });
</script>
</body>
</html>
