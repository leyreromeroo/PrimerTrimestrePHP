<?php
    $fecha = date("d/m/Y");
    $hora = date("h:i:s");
    $number1 = 31; // integer
    $number2 = 5.12; // float
?>
<html>
<head>
<title>Fecha y hora</title>
</head>
<body>
<p><?php echo "Hola Mundo. Hoy es ".$fecha.". "; ?></p>
<p><?php echo "Hora: ".$hora; ?></p>
<p><?php echo "<p>La suma de $number1 y $number2 es
".($number1+$number2)."</p>"
?></p>
<?php
// Asignar el valor TRUE a una variable
$show_error = true;
var_dump($show_error);//Sirve para mostrar el tipo de dato y su valor
?>
<?php
// Array indexado
$clase_2dam = array(
"clase" => "2DAM",
"alumnos" => array("Ana","Luis","Pedro","Marta"),
);
var_dump($clase_2dam);
?>

<?php
// Operadores de comparación
echo "<br>";
$a = 10; $b = 5;
function comparar($a, $b) {
if ($a > $b) {
echo "a es mayor que b";
} elseif ($a == $b) {
echo "a es igual que b";
} else {
echo "a es menor que b";
}
}
echo comparar($a, $b);
//(expr) ? ValorSiTrue : ValorSiFalse;
echo "<br>";
$boolean = TRUE; $result = ($boolean) ? 'Es True' : 'Es False';
echo $result;
?>
</body>
</html>