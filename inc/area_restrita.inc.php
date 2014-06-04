<?php
	$registro = $_SESSION['registro'];
	$limite = $_SESSION['limite'];

	// verifica se a session  registro esta ativa
	if($registro) {
	 $segundos = time()- $registro;
	}
	// fim da verificação da session registro

	/* verifica o tempo de inatividade 
	se ele tiver ficado mais de 900 segundos sem atividade ele destroi a session
	se não ele renova o tempo e ai é contado mais 900 segundos*/
	if($segundos>$limite) {
	 session_destroy();
	?>
	<div id="cabecalho" class="container">
	    <a id="logo" href="index.php"><img src="img/logocopaxbox.png"></a>
	    <h1 id="titulo">Álbum de figurinhas virtual</h1>
	</div>

	<div class="container">    
	    <div class="col-sm-12 login-fail">        
	        <div class="row">            

			<div class="container">
				<h1>Ops!</h1>
				<p>Sua sessão expirou faça o <strong>login</strong> novamente.<br>
				Se você ainda não tem, faça o <a href="index.php?form=cadastro">cadastro</a>. É rápido!</p>	
			</div><!-- /.container -->

			</div>
		</div><!-- .box-principal -->
	</div><!-- .miolo -->
	<?php	 
		die();
	}
	else{
	 $_SESSION['registro'] = time();
	}
	// fim da verificação de inatividade
?>