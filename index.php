<?php require_once('inc/header.inc.php') ?>

<div id="cabecalho" class="container">    
    <a id="logo" href="index"><img src="img/logocopaxbox.png"></a>
    <h1 id="titulo">Álbum de figurinhas virtual</h1>
</div>

<div class="miolo">    
    <div id="box-principal" class="container">        
        <div class="row">            
            <div class="texto bemvindo col-xs-12 col-md-6">
                <h2 class="titulo">Olá, seja bem-vindo!</h2>
                <p>Quer colecionar as figurinhas do jogadores participantes da Copa Xbox, 
                na Praça do Conhecimento? Realize seu <strong>cadastro</strong> e responda novas perguntas 
                a cada dia para ganhar novas figurinhas.</p>
                <p>Para acessar o álbum e conferir sua coleção, faça o seu <strong>login</strong>. 
                Simples e rápido, como abrir um pacote de figurinhas. Aproveite!</p>

                <?php if (isset($_GET['form']) != 'cadastro'): ?>
                <a href="?form=cadastro" class="link-cadastro"><button class="btn btn-warning btn-submit btn-cadastro btn-lg">Cadastre-se</button></a>
                <?php endif; ?>            

            </div>

            <?php if (isset($_GET['form']) != 'cadastro'): ?>
            <div class="texto login col-xs-12 col-md-6">
                <h1 class="titulo login">Login</h1>
                <form id="login_form" name="login_form" role="form" method="post">
                    <div class="form-group">
                        <input id="login_email" name="login_email" class="form-control" type="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="form-group">
                        <input id="login_senha" name="login_senha" class="form-control" type="password" placeholder="Digite sua senha" required>
                    </div>
                    <p class="resposta_login help-block hide">Todos os campos são obrigatórios.</p>
                    <input id="login_btn_enviar" name="login_btn_enviar" class="btn btn-warning btn-submit" type="submit" value="Entrar" />
                </form>
            </div>
            <?php else: ?>
            <div class="texto cadastro col-xs-12 col-md-6">
                <h1 class="titulo cadastro">Cadastro</h1>
                <span class="subtitulo">Preencha o formulário abaixo para criar o seu Álbum.<br> Lembre-se que todos os campos são obrigatórios. ;)</span>
                <form id="cadastro_form" name="cadastro_form" role="form" method="post">
                    <div class="form-group has-feedback">
                        <input id="cadastro_nome" name="cadastro_nome" class="form-control" type="text" placeholder="Digite seu nome" required>
                        <span class="form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="cadastro_sobrenome" name="cadastro_sobrenome" class="form-control" type="text" placeholder="Digite seu sobrenome" required>
                        <span class="form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" id="form-group-email">                        
                        <input id="cadastro_email" name="cadastro_email" class="form-control" type="email" placeholder="Digite seu e-mail" required>
                        <span class="form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" id="form-group-idade">
                        <input id="cadastro_idade" name="cadastro_idade" class="form-control" type="text" placeholder="Digite sua idade" required>
                        <span class="form-control-feedback"></span>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="cadastro_sexo" name="cadastro_sexo">
                            <option value="">Selecione o sexo:</option>
                            <option value="0">Masculino</option>
                            <option value="1">Feminino</option>
                        </select>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="cadastro_senha" name="cadastro_senha" class="form-control" type="password" placeholder="Digite uma senha" required>
                        <span class="form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input id="cadastro_confirma_senha" name="cadastro_confirma_senha" class="form-control" type="password" placeholder="Confirme sua senha" required>
                        <span class="form-control-feedback"></span>
                    </div>
                    <p class="resposta_login help-block hide">Todos os campos são obrigatórios.</p>
                    <input id="cadastro_btn_enviar" name="cadastro_btn_enviar" class="btn btn-warning btn-submit" type="submit" value="Finalizar o cadastro">
                </form>
                <div class="clearfix"></div>
            </div>
            <?php endif; ?>        
        </div>
    </div><!-- box-principal/container -->

</div><!--miolo-->

<script type="text/javascript" src="js/home.js"></script>

<?php require_once('inc/footer.inc.php'); ?>