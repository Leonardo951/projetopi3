<?php

session_start();

    if (isset($_SESSION["sessiontime"])) {
        if ($_SESSION["sessiontime"] < time()) {
            $_SESSION['expirado'] = 'Sua sessão expirou!';
            header('Location: login.php');
        } else {
            $_SESSION["sessiontime"] = time() + 1200;
        }
    } else {
        if (!isset($_SESSION['online']) || $_SESSION['online'] != true) {
            header('Location: login.php');
        }
    }
