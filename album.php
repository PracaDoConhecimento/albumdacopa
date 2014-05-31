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
require_once('inc/pergunta.php');

if($usuario->usuarioLogado()):
?>
<div id="cabecalho" class="container">
    <a id="logo" href="index.php"><img src="img/logocopaxbox.png"></a>
    <h1 id="titulo">Álbum de figurinhas virtual</h1>
    <?php require_once('inc/usuario_box.inc.php'); ?>
</div>


<div class="miolo box-secundario">
    
    <div class="container">        

        <?php require_once('inc/pergunta_form.inc.php'); ?>

        <!-- ALBUM -->
        <div id="album_usuario">
            <?php                 
                $album = new Album();
                $colecao = $album->obterColecaoTime( $usuario->getID(), 1 );

                if ($colecao):
                    foreach ($colecao as $item):
            ?>
            <div id="<?php echo $item['time_nome'] ?>" class="times"> 
                <?php 
                echo "<h3 class='nome-time'>" . $item['time_nome'] . "</h3>"; 
                
                $indice = 0;
                $figurinhas=$item['figurinhas'];
                     
                foreach ($figurinhas as $figurinha):
                 ?>
                    <div id="figurinha<?php echo $indice; ?>" class="pull-left fundo-figurinha1" style="margin-right:10px">
                        <img src="<?php echo 'img/figurinhas/' . $figurinha['img_url']; ?>" class="img-thumbnail"/>
                        <div class="titulo-figurinha"><?php echo $figurinha['label']; ?></div>
                    </div><!-- .figurinha -->                
                <?php
                    $indice++;
                endforeach;                                         
                ?>                  
                <div class="clearfix"></div>
            <?php 
                    endforeach;
                else:
            ?>
            <div id="album-vazio" >
                <h3>
                    Você ainda não tem nenhuma figurinha no seu Álbum.<br>
                    <small>Que tal começar respondendo uma <a href="#form_pergunta">pergunta</a>?</small>
                </h3>
            </div>

            <?php endif; ?>

            </div><!-- .time -->
        </div><!-- .album -->
<!--
         <div class="times">
            <h1 class="nome-time">Atlético de Madrid</h1>
            <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
            <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
            <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
            <img class="fundo-figurinha1" src="img/fundofigurinha.jpg">
            <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
            <img class="fundo-figurinha2" src="img/fundofigurinha2.jpg">
        </div>  
 -->  
        </div><!-- content -->

    </div><!--container -->

</div><!--miolo / box-secundario-->

<?php 
else: 
    require_once('inc/login_fail.php');
endif; //login check 

require_once('inc/footer.inc.php'); 
?>