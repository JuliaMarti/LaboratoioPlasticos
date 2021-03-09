<?php
session_start();



$user = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';




if (!empty($user) && !empty($password)) {

    require_once 'clases/DB.php';
    require_once 'clases/User.php';
    require_once 'php/funciones.php';


    $sql = "SELECT * FROM users WHERE user = '$user'";

    $stmt = DB::getStatement($sql);
    $stmt->execute();


    if ($stmt->rowCount() === 1) {
        $oneUser = $stmt->fetchObject('User');

        $id_user= ($oneUser -> id_user);

        $correct= ($password == $oneUser->password);

        $ip= getIp();

        $sqlInsert = "
            INSERT INTO logs
            (   id_user,
                password,
                ip
            )
            VALUES
            (
                $id_user,
                '$password',
                '$ip'
            )
        ";

        $stmtInsert = DB::getStatement($sqlInsert);
        $stmtInsert->execute();

        if ($correct) {
            $_SESSION['usuario_logueado'] = $user;

            header('Location: correct_log.php');
            die;

        } else{
            $alertParaUsuario = getHtmlAlert('Contraseña incorrecta, por favor vuelva a intentarlo.', 'alert-danger');
        }

    } else {
        $alertParaUsuario = getHtmlAlert('Usuario inexistente, por favor vuelva a intentarlo.', 'alert-danger');
    }

}

$titulo = 'Laboratorio Plásticos';

include_once('includes/header.html');

echo $alertParaUsuario ?? '';
include 'includes/login_form.html';



include_once('includes/footer.html');









function initVariables () {
    global $user, $correct, $ip, $password, $timestamp;
    $user = '';
    $correct= '';
    $ip='';
    $password = '';
    $timestamp='';
}


// Se inicializan las variables que se utilizarán en el formulario de login
initVariables();

$errores = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'php/validar.php';

    // Si hubo errores de validación
    if ($errores !== '') {
        $alertParaUsuario = getHtmlAlert('Contraseña incorrecta', 'alert-danger');
    } else {

        require_once 'clases/DB.php';


        $sql = "
            INSERT INTO logs
            (
                id_user,
                correct,
                ip,
                password,
                timestamp,
            )
            VALUES
            (
                '$nombre',
                $precio,
                $stock,
                $categoria,
                '$descripcion',
                '$observaciones',
                '$imagen'
            )
        ";


        $stmt = DB::getStatement($sql);
        $stmt->execute();


        // Si no hubo errores de validación
        $alertParaUsuario = getHtmlAlert('El producto fue dado de alta con éxito.', 'alert-success');

        // Se resetean las variables para que el formulario aparezca vacío para seguir cargando otros productos
        initVariables();
    }
}

include 'includes/header_backend.php';

include 'includes/productos_alta_form.php';

include 'includes/footer_backend.php';

?>

