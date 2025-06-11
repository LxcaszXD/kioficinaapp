<!DOCTYPE html>
<html lang="pt-BR">
<?php
require_once('template/head.php');
?>

<body>
    <div class="container servicos-page">
        <div class="title">Lista de Serviços</div>

        <?php
        if (!empty($servicos) && is_array($servicos)) {
            foreach ($servicos as $servico) {
                $statusClass = '';
                switch ($servico['status_ordem']) {
                    case 'Em análise':
                        $statusClass = 'status-analise';
                        break;
                    case 'Em andamento':
                        $statusClass = 'status-andamento';
                        break;
                    case 'Concluído':
                        $statusClass = 'status-concluido';
                        break;
                }

        ?>

                <div class="info">
                    <p><strong>Data de Entrada:</strong> <?= date('d/m/Y H:i', strtotime($servico['data_abertura_ordem'])) ?></p>
                    <p><strong>Previsão de Saída:</strong> <?= date('d/m/Y H:i', strtotime($servico['data_fechamento_ordem'])) ?></p>
                    <p><strong>Marca:</strong> <?= $servico['nome_marca'] ?></p>
                    <p><strong>Modelo:</strong> <?= $servico['nome_modelo'] ?></p>
                    <p><strong>Chassi:</strong> <?= $servico['chassi_veiculo'] ?></p>
                    <p><strong>Observação:</strong> <?= $servico['obs_ordem'] ?></p>
                    <p><strong>Total:</strong><strong> R$ <?= $servico['valor_total_ordem'] ?></strong></p>
                    <p class="status <?= $statusClass ?>"><strong>Status:</strong> <?= $servico['status_ordem'] ?></p>
                </div>
        <?php
            }
        } else {
            echo "<p>Nenhuma ordem de serviço encontrada.</p>";
        }
        ?>
        <a href="<?php echo BASE_URL; ?>app/views/menu.php" class="button">Voltar</a>
    </div>
</body>

</html>