<?php
/**
 *	Definições gerais
 */

$sid = session_id();

if(isset($sid) ) { //checa se a sessão foi criada.
 session_start();
} 

?>