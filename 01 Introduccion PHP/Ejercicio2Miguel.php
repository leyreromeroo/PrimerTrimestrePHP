<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $nombres = array("Leyre", "Pablo", "Maite", "Irina", "Iker");
    //Añado el nombre al último elemento del array
    $nombres[] = "Javier"; //Con array_push($nombres, "Javier") para meter +1 nombre
    
    function pintarNombres($nombres) {
            echo "<ul>\n";
        foreach ($nombres as $nombre){
            echo "<li>$nombre</li>\n";
        }
        echo "</ul>\n";
    }
    
    ?>
    <h1>Lista de Nombres en PHP</h1>
    <?= pintarNombres($nombres); ?>

</body>
</html>