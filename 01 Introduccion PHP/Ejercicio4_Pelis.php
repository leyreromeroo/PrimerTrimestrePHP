<?php
$peliculas = [
    "El Padrino" => 2004,
    "La lista de Schindler" => 2006,
    "Forrest Gump" => 2006,
    "Inception" => 1994,
    "The Dark Knight" => 2001,
    "Pulp Fiction" => 2004,
    "The Shawshank Redemption" => 2002,
    "Fight Club" => 2003,
    "Interstellar" => 2001,
    "The Matrix" => 1998
];

function filasPeliculas($peliculas)
{
    foreach ($peliculas as $pelicula => $anyo) {
        echo "<tr>";
        echo "<td>" . $pelicula . "</td>";
        echo "<td>" . $anyo . "</td>";
        echo "</tr>";
    }
}

function peliculasMasActuales($peliculas)
{
    if (empty($peliculas)) {
        return "No hay películas disponibles.";
    } else {
        $anyoMasReciente = max($peliculas);
        $peliculasMasActuales = array_keys($peliculas, $anyoMasReciente);
        return implode(", ", $peliculasMasActuales) . " (" . $anyoMasReciente . ")";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
</head>

<body>
    <h1>Listado de Películas</h1>
    <p>Película/s más actuales: <?= peliculasMasActuales($peliculas) ?></p>
    <table border='1' cellpadding='5' cellspacing='0'>
        <th>Película</th>

        <th>Año</th>

        <?php $peliculas = array_merge(["Avatar" => 2004], $peliculas) ?>
        <?php $ultimaClave = array_key_last($peliculas);
        unset($peliculas[$ultimaClave]);
        // Elimina la última película añadida, en este caso "The Matrix"
        //1º Cojo el índice de la última película
        //2º La elimino con unset
        ?>
        <?php filasPeliculas($peliculas) ?>
    </table>
    <!--<h3>Añadir película nueva:</h3>
    <form action="Ejercicio4.php" method="post">
        <label for="pelicula">Película:</label>
        <input type="text" id="pelicula" name="pelicula" required>
        <br><br>
        <label for="anyo">Año:</label>
        <input type="number" id="anyo" name="anyo" required>
        <br><br>
        <button  onclick=anyadirPelicula() value="btnAñadir"> Añadir</button>
    </form>-->
</body>

</html>