<!DOCTYPE html>
<html lang="pt-br">
<?php
    require_once('template/head.php');
?>
<body>
    <div class="container">
        <img src="<?php echo BASE_URL; ?>assets/img/logo-kioficina.png" alt="Logo" class="logo">

        <h2 class="welcome-title">BEM VINDO À KI-OFICINA</h2>
        <p class="username">OLÁ, <?php echo $nome_cliente ?>!</p>

        <div class="menu-buttons">
            <a href="<?php echo BASE_URL; ?>index.php?url=agendamento" class="menu-button">AGENDAMENTO</a>
            <a href="<?php echo BASE_URL; ?>index.php?url=listarServico" class="menu-button">LISTAR SERVIÇO</a>
            <a href="<?php echo BASE_URL; ?>index.php?url=depoimento" class="menu-button">DEPOIMENTOS</a>
            <a href="<?php echo BASE_URL; ?>index.php?url=perfil" class="menu-button">PERFIL</a>
            <a href="<?php echo BASE_URL; ?>index.php?url=login" class="menu-button exit">SAIR</a>
        </div>
    </div>
</body>
</html>
