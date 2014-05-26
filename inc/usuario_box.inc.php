<?php 
/**
*	Box de usuário
*/
?>
<?php if( isset($_SESSION['usuario_name']) && isset($_SESSION['usuario_surname']) ): ?>
<div id="usuario">
    Estou conectado como:
    <div id="login">
        <strong><?php echo $_SESSION['usuario_name'] . " " . $_SESSION['usuario_surname']; ?></strong><br> <small>(<?php echo $_SESSION['usuario_email']; ?>)</small>
    </div>
    <div role="form" id="form_logout" name="form_logout">
        <a href="inc/logout.php" class="btn btn-warning btn-logout" id="btn_logout">Logout</a>
    </div>
</div>
<?php else: ?>
<div id="usuario">
    <div role="form" id="form_logout" name="form_logout">
        <a href="index.php" class="btn btn-warning btn-logout" id="btn_logout">Login</a>
    </div>
</div>
<?php endif; ?>