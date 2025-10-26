<?php 
$resultado = ""; // Inicializamos la variable

// Procesar cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];

    $resultado = validarNumeros($num1, $num2);
}

function validarNumeros($num1, $num2) {
    if ($num1 === '' || $num2 === '') {
        return "Error: Ambos campos deben estar completos.";
    } elseif (!is_numeric($num1) || !is_numeric($num2)) {
        return "Error: Ambos valores deben ser numéricos.";
    } else {
        return sumar($num1, $num2);
    }
}

function sumar($num1, $num2) {
    $suma = $num1 + $num2;
    return "El resultado de la suma es: $suma";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
</head>
<body>
    <h1>Calculadora de Suma en PHP</h1>
    <form method="POST" action="Calculadora.php">
        <label for="num1">Número 1:</label>
        <input type="text" name="num1"><br><br>

        <label for="num2">Número 2:</label>
        <input type="text" name="num2"><br><br>

        <button type="submit">SUMA</button>

        <p><?php echo $resultado; ?></p>
    </form>
</body>
</html>


