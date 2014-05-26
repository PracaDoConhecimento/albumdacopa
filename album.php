<?php 
/**
 *  Album usuário (view)
 *
 *  @todo Listar albuns por time
 *
 */
require_once('inc/header.inc.php');
require_once('inc/usuario.php');
require_once('inc/album.php');

if($usuario->usuarioLogado()):
?>

        <div id="cabecalho" class="container">
            <a id="logo" href="index.html"><img src="img/logocopaxbox.png"></a>
            <?php require_once('inc/usuario_box.inc.php'); ?>
        </div>


        <div class="miolo box-secundario">
            
            <div class="container">

                <div class="content">

                    <img class="icone" src="img/icone1.png">
                    <button class="btn btn-default btn-lg btn-pergunta">Responda sua pergunta</button>

                </div>

                <div class="times">
                    <h1 class="nome-time">Atlético de Madrid</h1>
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">

                </div>

                <div class="times">
                    <h1 class="nome-time">Bostafogo</h1>
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                </div>

                <div class="times">
                    <h1 class="nome-time">Tabajara</h1>
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                </div>

                <div class="times">
                    <h1 class="nome-time">Biro-Biro F.C</h1>
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                </div>

                <div class="times">
                    <h1 class="nome-time">Unidos do Complexo</h1>
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                </div>

                <div class="times">
                    <h1 class="nome-time">Quarteto Fantástico</h1>
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                </div>

                <div class="times">
                    <h1 class="nome-time">Flamerda</h1>
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                    <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
                </div>

            </div><!--container -->
        
        </div><!--miolo / box-secundario-->

<?php 
else: 
    require_once('inc/login_fail.php');
endif; //login check 

require_once('inc/footer.inc.php'); 
?>