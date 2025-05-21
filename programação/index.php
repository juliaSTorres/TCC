<?php
require_once("modelo/Router.php");
$roteador = new Router();

//////////////////////////
// ROTAS PARA DEMANDAS
//////////////////////////

$roteador->get('/demandas', function() {
    require_once("controle/demanda/controle_demanda_read_all.php");
});

$roteador->get('/demandas/(\d+)', function($idDemanda) {
    require_once("controle/demanda/controle_demanda_read_by_id.php");
});

$roteador->post('/demandas', function() {
    require_once("controle/demanda/controle_demanda_create.php");
});

$roteador->put('/demandas/(\d+)', function($idDemanda) {
    require_once("controle/demanda/controle_demanda_update.php");
});

$roteador->delete('/demandas/(\d+)', function($idDemanda) {
    require_once("controle/demanda/controle_demanda_delete.php");
});

//////////////////////////
// ROTAS PARA ROTULOS
//////////////////////////

$roteador->get('/rotulos', function() {
    require_once("controle/rotulo/controle_rotulo_read_all.php");
});

$roteador->get('/rotulos/(\d+)', function($idRotulo) {
    require_once("controle/rotulo/controle_rotulo_read_by_id.php");
});

$roteador->post('/rotulos', function() {
    require_once("controle/rotulo/controle_rotulo_create.php");
});

$roteador->put('/rotulos/(\d+)', function($idRotulo) {
    require_once("controle/rotulo/controle_rotulo_update.php");
});

$roteador->delete('/rotulos/(\d+)', function($idRotulo) {
    require_once("controle/rotulo/controle_rotulo_delete.php");
});

//////////////////////////
// ROTAS PARA MEMBROS
//////////////////////////

$roteador->get('/membros', function() {
    require_once("controle/membro/controle_membro_read_all.php");
});

$roteador->get('/membros/(\d+)', function($idMembro) {
    require_once("controle/membro/controle_membro_read_by_id.php");
});

$roteador->post('/membros', function() {
    require_once("controle/membro/controle_membro_create.php");
});

$roteador->put('/membros/(\d+)', function($idMembro) {
    require_once("controle/membro/controle_membro_update.php");
});

$roteador->delete('/membros/(\d+)', function($idMembro) {
    require_once("controle/membro/controle_membro_delete.php");
});

$roteador->run();
?>
