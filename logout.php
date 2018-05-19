<?php

session_start();

$_SESSION['online'] = false;

session_destroy();

header('Location: ../login/login.php');