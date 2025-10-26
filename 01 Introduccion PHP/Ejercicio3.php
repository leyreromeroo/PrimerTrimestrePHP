<?php

$EQUIPO = "Atlético de Madrid";
$jugadores = array("Oblak", "Lodi", "Giménez", "Savic", "Hermoso", "Koke", "De Paul", "Llorente", "Griezmann", "Suárez", "João Félix");
$proximosRivales = array("Real Madrid", "Barcelona", "Sevilla", "Villarreal", "Betis");
$rndRival = array_rand($proximosRivales);
$proximoRival = $proximosRivales[$rndRival];
$fechas = [
    new DateTime("2025-10-05 18:30:00"),
    new DateTime("2025-10-12 20:00:00"),
    new DateTime("2025-10-19 16:15:00"),
    new DateTime("2025-10-26 21:00:00")
];
$rndFecha = array_rand($fechas);
$fechaPartido = $fechas[$rndFecha]->format("d/m/Y H:i");
$totalJugadores = count($jugadores);

function mostrarJugadores($jugadores)
{
    foreach ($jugadores as $jugador) {
        echo "<li>$jugador</li>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipo</title>
</head>

<body>
    <h1><?= $EQUIPO ?></h1>
    <h2>Próximo rival: <?=$proximoRival?></h2>
    <h3>Fecha: <?=$fechaPartido?></h3>
    <br>
    <h3>Jugadores disponibles del <?= $EQUIPO ?>: </h3>
    <ul>
        <?= mostrarJugadores($jugadores) ?>
    </ul>
    <h3>Jugadores disponibles del <?= $EQUIPO ?>:</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Jugador</th>
        </tr>
        <?php foreach ($jugadores as $jugador): ?>
            <tr>
                <td><?php echo $jugador; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <button onclick=mostrarJugadores() style="margin-top:10px">Listo</button>
    <script>
        function mostrarJugadores() {
            const $TOTAL_JUGADORES = <?php echo $totalJugadores ?>;
            if ($TOTAL_JUGADORES < 18) {
                alert("El equipo debe de tener un mínimo de 18 jugadores, y ahora mismo tiene " + $TOTAL_JUGADORES + ".");
            }else{
                alert("Ya estamos listos");
            }
        }
    </script>
</body>

</html>