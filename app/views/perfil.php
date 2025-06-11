<!DOCTYPE html>
<html lang="pt-br">
<?php
require_once('template/head.php');
?>

<body class="page-perfil">
    <h1>MEU PERFIL</h1>
    <img src="<?php echo BASE_URL; ?>assets/img/profile.png" alt="Foto de Perfil" class="profile-pic">

    <form method="post" class="container">
        <label>NOME:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome_cliente']) ?>" required>

        <label>EMAIL:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email_cliente']) ?>" required>

        <label>TELEFONE:</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone_cliente']) ?>" required>

        <label>ENDEREÇO:</label>
        <input type="text" name="endereco" value="<?= htmlspecialchars($cliente['endereco_cliente']) ?>" required>

        <label>BAIRRO:</label>
        <input type="text" name="bairro" value="<?= htmlspecialchars($cliente['bairro_cliente']) ?>" required>

        <label>CIDADE:</label>
        <input type="text" name="cidade" value="<?= htmlspecialchars($cliente['cidade_cliente']) ?>" required>

        <label>ESTADO:</label>
        <select name="id_uf" required>
            <option value="">Selecione o estado</option>
            <?php foreach ($estados as $estado): ?>
                <option value="<?= $estado['id_uf'] ?>" <?= $cliente['id_uf'] == $estado['id_uf'] ? 'selected' : '' ?>>
                    <?= $estado['sigla_uf'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>ALTERAR SENHA (OPCIONAL):</label>
        <input type="password" name="senha" placeholder="Nova senha">
        <button class="btn">SALVAR ALTERAÇÕES</button>
        <a href="<?php echo BASE_URL; ?>index.php?url=menu" class="btn btn-secondary">VOLTAR</a>
    </form>


    <?php if (!empty($_SESSION['msg_sucesso'])): ?>
        <div class="alert sucesso"><?= $_SESSION['msg_sucesso'] ?></div>
        <?php unset($_SESSION['msg_sucesso']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['msg_erro'])): ?>
        <div class="alert erro"><?= $_SESSION['msg_erro'] ?></div>
        <?php unset($_SESSION['msg_erro']); ?>
    <?php endif; ?>

</body>

</html>