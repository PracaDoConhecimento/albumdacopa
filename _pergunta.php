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

<?php 
    $user_id = $usuario->getID();
    $pergunta = new Pergunta();

    //verificar se a pergunta pode ser feita o número passado é o id do usuário
    if($pergunta->possoPergunta($user_id)):

        //Trazer as perguntas que vão ser colocadas no formulário
        $vetorPergunta=$pergunta->obterPergunta();
?>
<img class="icone" src="img/icone1.png">

<form action="" method="" id="form_pergunta" role="form"> 	
    <div class="box">
        <div class="pergunta"><?php echo($vetorPergunta[1]) ?></div>
        <div class="radio">
            <label><input type ="radio" name="resposta" id="resposta1" value="0"/> <?php echo($vetorPergunta[2][0]); ?></label>
        </div>
        <div class="radio">
            <label><input type ="radio" name="resposta" id="resposta2" value="1"/> <?php echo($vetorPergunta[2][1]); ?></label>
        </div>
        <div class="radio">
            <label><input type ="radio" name="resposta" id="resposta3" value="2"/> <?php echo($vetorPergunta[2][2]); ?></label>
        </div>
    </div><!-- .box -->
    <input type="hidden" name="id_pergunta" id="id_pergunta" value="<?php echo($vetorPergunta[0]); ?>"/>
    
    <input type="submit" name="btnSubmit" value="Responder pergunta" id="form_pergunta_submit" class="btn btn-warning" />
</form> 

<?php 
    else:
        echo("Você não pode fazer mais perguntas , aguarde até seu prazo passar :)");			
    endif;
?>

<script type="text/javascript">
$(document).ready(function() {

    $('#form_pergunta_submit').click(function() {        

        var opcao = $('input[name=resposta]:checked', '#form_pergunta').val();
        var id = $('#id_pergunta').val();

        $.ajax({
            url: 'inc/perguntar.php',
            type: 'POST',                        
            data: "id_pergunta="+id+"&resposta="+opcao+"&id_usuario="+<?php echo $user_id ?>,
            success: function(html) {
        
                var estadoResposta = html.killWhiteSpace();

                if (estadoResposta == "certa") {
                    alert('Parabéns resposta certa!');

                } else if ( estadoResposta == "errada" ) {
                    alert('Ops! Resposta errada!');

                } else if ( estadoResposta == "10" ) {
                    alert('Seu album está completo.');
                }
                
            }
        });

        return false;
    
    }); // click bind
    
});

String.prototype.killWhiteSpace = function() {
    return this.replace(/\s/g, '');
};
</script>
<?php 
else: 
    require_once('inc/login_fail.php');
endif; //login check 

require_once('inc/footer.inc.php'); 
?>