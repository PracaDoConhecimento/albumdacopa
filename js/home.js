$(document).ready(function() {

	$('#login_btn_enviar').click(function(event) {

		var email = $('#login_email').val();
		var password = $('#login_senha').val();
		var formOK = false;

		if (email != "") { formOK = true; } else { formOK = false; } //validação email
		if (password != "") { formOK = true; } else { formOK  = false; } // validacao senha

		if (formOK) {
			$.ajax({
			   type: "POST",
			   url: "inc/login.php",
			   data: "email="+email+"&pwd="+password,
			   success: function(html){
			    if(html=='true') {
			    	window.location="album.php";
			    }
			    else {
			    	$('.resposta_login').html('<em>Ops! E-MAIL ou SENHA errados.<em>').removeClass('hide');
			    }
			   }
			});
		} else {
			$('.resposta_login').html('<em>Ops! Você precisa preencher TODOS os campos para prosseguir.</em>').removeClass('hide').addClass('error');
		}

		return false;
	});

	

	$('#cadastro_form input').focus(function(event) {
		$(".help-block").html('');
	});


	$('.form-group').each(function(index, el) {

		$('input').blur(function(event) {

			$formGroup = $(this).parent();	

			// limpando..
			$formGroup.removeClass('has-success').removeClass('has-error');		
			$(this).siblings('.form-control-feedback').removeClass('glyphicon-remove glyphicon-ok');

			// atribuindo..
			if ($(this).val() != "") {			
				$formGroup.addClass('has-success');		
				$(this).siblings('.form-control-feedback').addClass('glyphicon glyphicon-ok');		    		
			} else {
				$formGroup.removeClass('has-error');		
				$(this).siblings('.form-control-feedback').addClass('glyphicon glyphicon-remove');				
			}
		});

	});


	$('#cadastro_email').blur(function(event) {

		var email = $('#cadastro_email').val();

		if (email != "") {

			// qdo não for um email válido...
			if (!isEmail(email)) {
				$('#form-group-email').addClass('has-error');		
				$('#form-group-email').find('.form-control-feedback').addClass('glyphicon glyphicon-remove');
				$('.resposta_login').html('<em>Ops! Parece que não digitou um E-MAIL válido</em>').removeClass('hide').addClass('error');				

			} else {

				// é valido, agora checa se já existe no banco de dados
				$.ajax({
					url: 'inc/usuario_mail_check.php',
					type: 'POST',
					data: 'user_email='+email,
					success: function(formOk){
					    if(formOk=='false') {
					    	if( $('#form-group-email').hasClass('has-success') ) { //limpando...
					    		$('#form-group-email').removeClass('has-success');		
					    		$('#form-group-email .form-control-feedback').removeClass('glyphicon glyphicon-ok');		    		
					    	}
					    	$('#form-group-email').addClass('has-error');
					    	$('#form-group-email .form-control-feedback').addClass('glyphicon glyphicon-remove');
					    }
					    else {
					    	if( $('#form-group-email').hasClass('has-error') ) { //limpando...
					    		$('#form-group-email').removeClass('has-error');		
					    		$('#form-group-email .form-control-feedback').removeClass('glyphicon glyphicon-remove');		    		
					    	}
					    	$('#form-group-email').addClass('has-success');
					    	$('#form-group-email .form-control-feedback').addClass('glyphicon glyphicon-ok');
					    }
					}
				});						
			}

		} 

	});


	$('#form-group-idade input').blur(function(event) {
		
		$formGroup = $('#form-group-idade');		

		if (isNaN($(this).val()))  {
			$formGroup.addClass('has-error');		
			$formGroup.find('.form-control-feedback').addClass('glyphicon glyphicon-remove');
			$('.resposta_login').html('<em>Ops! Parece que não digitou uma IDADE válida.</em>').removeClass('hide').addClass('error');
		} else {
			$formGroup.addClass('has-success');		
			$formGroup.find('.form-control-feedback').addClass('glyphicon glyphicon-ok');		    		
		}

	});


	$('#cadastro_senha').blur(function(event) {

		$formGroup = $(this).parent();
		senha = $(this).val();

		if (senha.length < 5)  {
			$formGroup.addClass('has-error');		
			$(this).siblings('.form-control-feedback').addClass('glyphicon glyphicon-remove');
			$('.resposta_login').html('<em>Tente escrever uma SENHA maior que 5 caracteres.</em>').removeClass('hide').addClass('error');
		} else {
			$formGroup.addClass('has-success');		
			$(this).siblings('.form-control-feedback').addClass('glyphicon glyphicon-ok');		    		
		}

	});


	$('#cadastro_confirma_senha').blur(function(event) {
		
		$senha = $('#cadastro_senha').val();
		$contrasenha = $(this).val();
		$formGroup = $('#cadastro_confirma_senha').parent();		

		if ($contrasenha != $senha)  {
			$formGroup.addClass('has-error');		
			$formGroup.find('.form-control-feedback').addClass('glyphicon glyphicon-remove');
			$('.resposta_login').html('<em>Ops! Os campos SENHA e CONFIRMAÇÃO precisam ser iguais.</em>').removeClass('hide').addClass('error');
		} else {
			$formGroup.addClass('has-success');		
			$formGroup.find('.form-control-feedback').addClass('glyphicon glyphicon-ok');		    		
		}

	});



	/*  ENVIANDO O FORMULARIO... */

	$('#cadastro_btn_enviar').click(function(event) {
		
		var nome 		= $('#cadastro_nome').val();
		var sobrenome 	= $('#cadastro_sobrenome').val();
		var email 		= $('#cadastro_email').val();
		var idade 		= $('#cadastro_idade').val();
		var sexo 		= $('#cadastro_sexo').val();		
		var senha 		= $('#cadastro_senha').val();
		var confirmar	= $('#cadastro_confirma_senha').val();

		if ( senha != confirmar ) {
			$('.resposta_login').html('<em>Ops! Os campos SENHA e CONFIRMAR SENHA precisam ser iguais.</em>').removeClass('hide').addClass('error');
		} else {
			if (nome != "" && sobrenome != "" && email != "" && senha != "") { //validacao simples
				$.ajax({
				   type: "POST",
				   url: "inc/cadastro_usuario.php",
				   data: "user_nome="+nome+"&user_sobrenome="+sobrenome+"&user_email="+email+"&user_idade="+idade+"&user_sexo="+sexo+"&user_senha="+senha,
				   success: function(formOk){
				    if(formOk=='true') {
				    	window.location="album.php";
				    }
				    else {
				    	$('.resposta_login').html('<em>Ops! Infelizmente ocorreu um erro inesperado.</em>').removeClass('hide').addClass('error');			    	
				    }
				   }
				});
		 	} else {
		 		$('.resposta_login').html('<em>Ops! Está faltando preencher alguma coisa...</em>').removeClass('hide').addClass('error');			    	
		 	}
	 	}

		return false;
	});


});

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}