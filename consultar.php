<?php
session_start();

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

    // Calcular la edad promedio solo si hay hombres registrados
    $edadPromedioHombres = ($totalHombres > 0) ? ($totalEdad / $totalHombres) : 0;

    return $edadPromedioHombres;
}

if (isset($_SESSION['empleados'])) {
    $empleados = $_SESSION['empleados'];

    $totalMujeres = count(array_filter($empleados, 'filtrarMujeres'));
    $totalHombresCasadosAltoSueldo = count(array_filter($empleados, 'filtrarCasadosAltoSueldoHombres'));
    $totalMujeresViudasAltoSueldo = count(array_filter($empleados, 'filtrarViudasAltoSueldoMujeres'));
    $edadPromedioHombres = calcularEdadPromedioHombres($empleados);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Empleados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        p{
            font-size: 22px;
            font-style: italic;
            padding-top: 15px;
        }

        span{
            font-size: 22px;
            font-style: italic;
        }
   </style>
</head>
<body>
    <div class="container center">
        <h1 class="center-align">Consulta de Empleados</h1>
        <div class="row center">
            <div class="col s12 m6 l12">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <u><span class="card-title">Resultados</span></u>
                        <p>Total de empleados del sexo femenino: <?php echo $totalMujeres; ?></p>
                        <p>Total de hombres casados que ganan más de 2500 Bs: <?php echo $totalHombresCasadosAltoSueldo; ?></p>
                        <p>Total de mujeres viudas que ganan más de 1000 Bs: <?php echo $totalMujeresViudasAltoSueldo; ?></p>
                        <p>Edad promedio de los hombres: <?php echo $edadPromedioHombres; ?> años</p>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn waves-effect waves-light" href="index.php">Registrar Nuevo Empleado</a>
    </div>
    
    <br><br><br><br><br><br><br><br><br>
    <footer class="page-footer purple lighten-1">
        <div class="footer-copyright">
            <div class="container">
            <p>Copyright ©2023 rubilopez.site</p>
            </div>
        </div>
    </footer> 
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

<?php
} else {
    echo 'No hay empleados registrados.';
    
}
?>
<br>
<a class="btn waves-effect waves-light" href="index.php">Registrar Nuevo Empleado</a>
