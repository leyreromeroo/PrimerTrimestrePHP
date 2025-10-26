<?php
$NOMBRE_ALUMNO = "Leyre";

$notas = array(
    "PSP" => array(
        "1EV" => array(6, 7, 8),   
        "2EV" => array(9, 8, 6),
        "3EV" => array(7, 8, 9),
    ),
    "DW" => array(
        "1EV" => array(1, 1, 1),
        "2EV" => array(2, 2, 2),
        "3EV" => array(2, 2, 2),
    )
);

function CrearTablaSimple() {
    global $notas;
    global $nota_final_curso;
    
    $nota_final_curso = 0;
    
    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse; text-align: center; font-family: Arial;'>";
    
    // Encabezado
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>Asignatura</th>";
    echo "<th colspan='3'>1EV</th>";
    echo "<th colspan='3'>2EV</th>";
    echo "<th colspan='3'>3EV</th>";
    echo "<th>EF</th>";
    echo "</tr>";
    
    // Subencabezado
    echo "<tr style='background-color: #f8f8f8;'>";
    echo "<th></th>";
    echo "<th>EJ1</th><th>EJ2</th><th>EJ3</th>";
    echo "<th>EJ1</th><th>EJ2</th><th>EJ3</th>";
    echo "<th>EJ1</th><th>EJ2</th><th>EJ3</th>";
    echo "<th></th>";
    echo "</tr>";

    // Datos de cada asignatura
    foreach ($notas as $asignatura => $evaluaciones) {
        $sumaTotal = 0;
        $totalNotas = 0;
        
        echo "<tr>";
        echo "<td style='text-align: left; font-weight: bold;'>$asignatura</td>";
        
        // 1EV - 3 notas
        foreach ($evaluaciones["1EV"] as $nota) {
            echo "<td>$nota</td>";
            $sumaTotal += $nota;
            $totalNotas++;
        }
        
        // 2EV - 3 notas
        foreach ($evaluaciones["2EV"] as $nota) {
            echo "<td>$nota</td>";
            $sumaTotal += $nota;
            $totalNotas++;
        }
        
        // 3EV - 3 notas
        foreach ($evaluaciones["3EV"] as $nota) {
            echo "<td>$nota</td>";
            $sumaTotal += $nota;
            $totalNotas++;
        }
        
        // Media final (EF)
        $media = $sumaTotal / $totalNotas;
        echo "<td style='font-weight: bold; background-color: #e6f3ff;'>" . number_format($media, 2) . "</td>";
        
        echo "</tr>";
        
        $nota_final_curso += $media;
    }
    
    echo "</table>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas Simplificado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border: 2px solid #333;
            margin: 20px 0;
        }
        th {
            background-color: #f0f0f0;
            padding: 10px;
            border: 1px solid #ccc;
        }
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .resultado {
            margin-top: 20px;
            padding: 15px;
            background-color: #e7f3ff;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Notas de 2DAM - <?= $NOMBRE_ALUMNO ?></h1>
    
    <?php CrearTablaSimple(); ?>
    
    <div class="resultado">
        <?php
            global $nota_final_curso;
            $media_final = $nota_final_curso / count($notas);
        ?>
        <h2>Nota Final del Curso: <?= number_format($media_final, 2) ?></h2>
        <h3>Estado: <?= ($media_final >= 5) ? "✅ Aprobado" : "❌ Suspendido" ?></h3>
    </div>
</body>
</html>