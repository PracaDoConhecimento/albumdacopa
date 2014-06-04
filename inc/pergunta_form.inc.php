
<?php 
$user_id = $usuario->getID();
$pergunta = new Pergunta();

//verificar se a pergunta pode ser feita o número passado é o id do usuário
if($pergunta->possoPergunta($user_id)):

    //Trazer as perguntas que vão ser colocadas no formulário
    $vetorPergunta = $pergunta->obterPergunta($user_id);
?>

    <div id="box_pergunta">
        <img class="icone" src="img/icone1.png">

        <form action="" method="" id="form_pergunta" role="form">	
            <div class="box">
                <div class="pergunta"><?php echo($vetorPergunta[1]) ?></div>                                
                <div class="radio">
                    <label><input type ="radio"  name="resposta" id="resposta1" value="0"/> <?php echo($vetorPergunta[2][0]); ?></label>
                </div>
                <div class="radio">
                    <label><input type ="radio"  name="resposta" id="resposta1" value="1"/> <?php echo($vetorPergunta[2][1]); ?></label>
                </div>
                <div class="radio">
                    <label><input type ="radio"  name="resposta" id="resposta1" value="2"/> <?php echo($vetorPergunta[2][2]); ?></label>
                </div>
            </div><!-- .box -->
            <input type="hidden" name="id" id="id_pergunta" value="<?php echo($vetorPergunta[0]); ?>"/>
            
            <input type="submit" name="btnSubmit" value="Responder pergunta" id="form_pergunta_submit" class="btn btn-warning" />
        </form> 

    </div><!-- .box pergunta -->

    <?php 
        // CONTAGEM DE CHANCES
        $chance = $pergunta->qde_perguntas_dia - $pergunta->obterParticipacao($user_id);

        /*echo 'chances: ' . $chance . '<br>';
        echo 'tentativas: ' . $pergunta->obterParticipacao($user_id) . '<br>';
        echo 'total por dia: ' . $pergunta->qde_perguntas_dia . '<br>';*/

        if (( $pergunta->obterParticipacao($user_id) < $pergunta->qde_perguntas_dia ) && ($chance - 1) != 0): 
    ?>

    <div id="box_pergunta_chance" class="hide">
        <div class="ja-respondi">
            <h3>Você ainda tem <?php echo ($chance - 1) ?> pergunta<?php echo (($chance - 1) > 1)? 's' : ''; ?></h3>
            <a href="#" class="btn btn-warning" id="nova-pergunta">Carregar nova pergunta</a>
        </div>
    </div><!-- .box pergunta -->

    <?php endif; ?>

<?php else: ?>

    <div id="box_pergunta">
        <div class="ja-respondi">
            <h3>Você não pode fazer mais perguntas hoje, <br>
            volte amanhã para conquiste novas figurinhas!</h3>
        </div>
    </div><!-- .box pergunta -->

<?php endif; ?>
    

<!-- BOX de FEEDBACK -->
<div id="box_feedback_errada" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">                      
          <div class="modal-body">            
            <div class="ico"><div class="glyphicon glyphicon-remove"></div> </div>
            <span><h3>Ops! Sua resposta está errada</h3>Tente da próxima vez.</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>
    </div>
</div>

<!-- BOX de FEEDBACK -->
<div id="box_feedback_certo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">                      
          <div class="modal-body">            
            <div class="ico"><div class="glyphicon glyphicon-ok"></div> </div>
            <span><h3>Parabéns!</h3>Resposta correta.</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>
    </div>
</div>

<!-- BOX de FEEDBACK -->
<div id="box_feedback_completo" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">                      
          <div class="modal-body">            
            <div class="ico"><div class="glyphicon glyphicon-check"></div> </div>
            <span><h3>Parabéns!</h3>Seu álbum já está completo, mas você pode continuar responder as perguntas e testar o seus conhecimentos.</span>            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>
    </div>
</div>



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

            /*console.log(estadoResposta);*/

            if (estadoResposta == "certa") {
                $('#box_feedback_certo').modal('show');

            } else if ( estadoResposta == "errada" ) {
                $('#box_feedback_errada').modal('show');

            } else {                            
                $('#box_feedback_completo').modal('show');
            }

            $('#box_pergunta').fadeOut('slow');
            $('#box_pergunta_chance').fadeIn('slow').addClass('show');
        }

    });

    return false;

}); // click bind

$('#nova-pergunta').click(function(event) {
   window.setTimeout('location.reload()', 100);
});


});

String.prototype.killWhiteSpace = function() {
return this.replace(/\s/g, '');
};
</script>