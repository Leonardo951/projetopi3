<?php

session_start();

if(basename( __FILE__ ) != 'menuprincipal.php') {
    if( base64_decode($_SESSION['user']) == 'Vendedor' && basename( __FILE__ ) == 'usuarios.php' ||
        base64_decode($_SESSION['user']) == 'Vendedor' && basename( __FILE__ ) == 'fornecedores.php' ||
        base64_decode($_SESSION['user']) == 'Gerente' && basename( __FILE__ ) == 'usuarios.php' )
    {
        header('location: ../menuprincipal.php');
    } else {
        if (isset($_SESSION["sessiontime"])) {
            if ($_SESSION["sessiontime"] < time()) {
                $_SESSION['expirado'] = 'Sua sessão expirou!';
                header('Location: ../login/login.php');
            } else {
                $_SESSION["sessiontime"] = time() + 1200;
            }
        } else {
            if (!isset($_SESSION['online']) || $_SESSION['online'] != true) {
                header('Location: ../login/login.php');
            }
        }
    }
} else {
    if (isset($_SESSION["sessiontime"])) {
        if ($_SESSION["sessiontime"] < time()) {
            $_SESSION['expirado'] = 'Sua sessão expirou!';
            header('Location: login/login.php');
        } else {
            $_SESSION["sessiontime"] = time() + 1200;
        }
    } else {
        if (!isset($_SESSION['online']) || $_SESSION['online'] != true) {
            header('Location: login/login.php');
        }
    }
}