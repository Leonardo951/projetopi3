<?php
session_start();

unset($_SESSION['itens']);
unset($_SESSION['quantidades']);

echo json_encode(array(
    "result" => true
));
