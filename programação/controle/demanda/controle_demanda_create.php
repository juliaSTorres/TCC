<?php
require_once("modelo/Banco.php");
require_once("modelo/Demanda.php");

$obj = new stdClass();
$objDemanda = new Demanda();

$objDemanda->setId(1);

echo json_encode($objDemanda);
?>
