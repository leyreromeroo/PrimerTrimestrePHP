<html>
<head>
    <title>Ejercicio 1</title>
</head>
<body>

    <h1>Ejercicio 1</h1>    

    <?php 
    $nombre = "Leyre Romero";
    $edad = 20;
    define("MAYORIA_EDAD", 18);
    
    echo "Hola, ". $nombre . " tienes " .  $edad . " años!";
    if ($edad < MAYORIA_EDAD){
        echo("<br>Todavía eres menor de edad");
    }else{
        echo("<br>Cuidado, puedes ir a la cárcel");
    }
    echo("<br>");
    for ( $i=1; $i<11; $i++){
        echo($i. " ");
    }
    ?>

    

</body>
</html>