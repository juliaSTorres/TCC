<?php
require_once("modelo/Banco.php");

$obj = new stdClass();

$obj ->teste = "";
$obj ->teste= "create rotulo";

echo json_encode($obj);
?>
