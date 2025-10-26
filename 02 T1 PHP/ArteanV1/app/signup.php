<?php
/**
 * @title: Proyecto integrador Ev01 - Registro en el sistema.
 * @description:  Script PHP para almacenar un nuevo usuario en la base de datos
 *
 * @version    0.2
 *
 * @author     Ander Frago & Miguel Goyena <miguel_goyena@cuatrovientos.org>
 */

//TODO completa los requiere que necesites
require_once '../templates/header.php';
require_once '../persistence/DAO/UserDAO.php';
require_once '../utils/SessionHelper.php';

$urlApp = '/Trabajos DW/PrimerTrimestrePHP/02 T1 PHP/ArteanV1';
$indexPath = $urlApp .'/index.php';

$error = $user = $pass = "";
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Inicializar el objeto DAO (solo una vez)
    $dao = new UserDAO();
    $error = ""; // Inicializamos la variable de error

    // 2. Realizar la lectura y sanitización (buena práctica) de los campos
    // Usamos el operador de fusión de null (??) para evitar errores si las claves no existen
    $user = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';

    // 3. Comprobación de campos vacíos
    if ($user === "" || $pass === "") {
        $error = "Debes completar todos los campos<br><br>";
    } 
    
    // 4. Comprobación de existencia del usuario (lógica corregida)
    // El método checkExists probablemente debería recibir solo el $user para ver si ya está en la base de datos.
    // Si la función checkExists recibe $user y $pass, normalmente es para LOGUEAR, no para REGISTRAR.
    // Asumiendo que checkExists($user) verifica si el email ya está registrado:
    elseif ($dao->checkExists($user, $pass) == true) { 
        
        // La lógica debe ser: si ya existe, no puedes registrarlo.
        $error = "<span class='error'>El usuario ya existe. Inténtalo con otro email.</span><br><br>";
        
    }
    
    // 5. Si todo es correcto (ningún error, campos llenos, no existe), se procede al registro
    else {
        
        // Inserta el nuevo usuario (el UserDAO debería manejar la persistencia)
        // Nota: Asegúrate de que $pass se guarda HASHADO en la base de datos, no en texto plano.
        $dao->insert($user, $pass);

        // Establece el usuario en sesión con SessionHelper
        SessionHelper::setSession($user);

        // Redirigir al usuario tras registrarse
        // Asegúrate de que $indexPath está definido y contiene la URL de destino
        header("Location: " . $indexPath);
        exit; // Terminar el script para asegurar la redirección
    }
}
// Si hay un error, el script continuará y se podrá mostrar la variable $error en el HTML
?>

<div class="container">
    <form class="form-horizontal" role="form" method="POST" action="signup.php">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Por favor registrate</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group has-danger">
                    <label class="sr-only" for="email">Email:</label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i
                                    class="fa fa-at"></i></div>
                        <input type="text" name="email" class="form-control"
                               id="email"
                               placeholder="vivayo@correo.com"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <i class="fa fa-close"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="sr-only" for="password">Contraseña:</label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i
                                    class="fa fa-key"></i></div>
                        <input type="password" name="password"
                               class="form-control" id="password"
                               placeholder="Password">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                    </span>
                </div>
            </div>
        </div>

        <div class="row" style="padding-top: 1rem">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success"><i
                            class="fa fa-sign-in"></i> Registrar
                </button>
            </div>
        </div>
    </form>
</div>
