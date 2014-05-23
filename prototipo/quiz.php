<?php 

require_once('inc/quiz.php');

$quiz = new Quiz();

$pergunta = $quiz->atualizaAcesso(9);

var_dump($pergunta);

?>