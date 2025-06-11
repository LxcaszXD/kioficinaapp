<!DOCTYPE html>
<html lang="pt-br">
<?php
    require_once('template/head.php');
    
?>


<body class="page-agendamento">
    <div class="container">
        <img src="<?php echo BASE_URL; ?>assets/img/logo-kioficina.png" class="logo" alt="Logo Ki Oficina">
        <h1 class="page-title">AGENDAMENTO</h1>
        
        <form method="POST" class="agendamento-form">
            <div class="form-group">
                <label class="form-label" for="id_veiculo">VEÍCULO</label>
                <select class="form-select" name="id_veiculo" id="id_veiculo" required>
                    <option value="">Selecione o veículo</option>
                    <?php foreach ($veiculos as $veiculo): ?>
                        <option value="<?= $veiculo['id_veiculo'] ?>"><?= $veiculo['nome_modelo'] ?> - <?=  $veiculo['cor_veiculo'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="data_agenda">DATA</label>
                    <input type="date" class="form-input" name="data_agenda" id="data_agenda" value="<?= date('Y-m-d') ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="hora">HORA</label>
                    <select class="form-select" name="hora_agenda" id="hora_agenda" required>
                        <option value="" disabled selected>Selecione a hora</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="tecnico">funcionário</label>
                <select class="form-select" name="id_funcionario" id="id_funcionario" required>
                    <option value="" disabled selected>Selecione o funcionário</option>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <option value="<?= $funcionario['id_funcionario'] ?>"><?= $funcionario['nome_funcionario'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-primary">CONFIRMAR AGENDAMENTO</button>
            </div>
        </form>
        
        <div class="secondary-actions">
            <a href="<?php echo BASE_URL; ?>index.php?url=Menu" class="btn-secondary">VOLTAR</a>
            <a href="<?php echo BASE_URL; ?>index.php?url=ListarAgenda" class="btn-secondary">VER AGENDAMENTOS</a>
        </div>
    </div>
</body>
</html>
