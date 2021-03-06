<?php 
/**
 *  Album usuário (view)
 *
 *  @todo Listar albuns por time
 *
 */

require_once('inc/header.inc.php');
require_once('inc/area_restrita.inc.php');
require_once('inc/usuario.php');
require_once('inc/album.php');
require_once('inc/pergunta.php');

if($usuario->usuarioLogado()):
?>
<div id="cabecalho" class="container">
    <a id="logo" href="index"><img src="img/logocopaxbox.png"></a>
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
                    if ( $figurinha['tipo'] == 1 ): 
                ?>
                    <div id="figurinha<?php echo $indice; ?>" class="pull-left fundo-figurinha1" style="margin-right:10px">
                        <img src="<?php echo 'img/figurinhas/' . $figurinha['img_url']; ?>" class="img-thumbnail"/>
                        <div class="titulo-figurinha"><?php echo $figurinha['label']; ?></div>
                    </div><!-- .figurinha -->                       
                <?php 
                    endif; 
                    $indice++;
                endforeach;                                         
                ?>                  
                <div class="clearfix"></div>

                <div class="desejos">
                <?php 
                foreach ($figurinhas as $figurinha): 
                    if ( $figurinha['tipo'] == 2 ): 
                ?>
                    <div id="figurinha-x2-<?php echo $indice; ?>" class="figurinha-x2">
                        <img src="<?php echo 'img/figurinhas/' . $figurinha['img_url']; ?>" class="img-thumbnail"/>
                        <div class="titulo-figurinha"><?php echo $figurinha['label']; ?></div>
                    </div>
                <?php 
                    endif; 
                endforeach; 
                ?>                
                <div class="clearfix"></div>
                </div><!-- .desejos -->
            </div><!-- .times -->
            <?php 
                    endforeach;
                else:
            ?>
            <div id="album-vazio" >
                <h3>
                    Poxa, seu álbum ainda está vazio!<br>
                    E você ainda não tem nenhuma figurinha no seu Álbum.<br>

                    <small>Mas que tal começar respondendo uma <a href="#form_pergunta">pergunta</a>?</small>
                </h3>
            </div>

            <?php endif; ?>

            
        </div><!-- .album -->
        

    </div><!--container -->

</div><!--miolo / box-secundario-->

<?php 
else: 
    require_once('inc/login_fail.php');
endif; //login check 

require_once('inc/footer.inc.php'); 
?>