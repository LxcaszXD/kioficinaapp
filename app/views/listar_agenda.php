<!DOCTYPE html>
<html lang="pt-BR">
<?php require_once('template/head.php'); ?>

<body>
    <div class="container my-5">
        <h1 class="mb-4">Lista de Agendamentos</h1>

        <?php if (!empty($agendamento) && is_array($agendamento)): ?>
            <?php foreach ($agendamento as $index => $item):
                $status = $item['status_agendamento'] ?? 'Indefinido';
                $statusClass = match ($status) {
                    'Em análise' => 'badge bg-warning text-dark',
                    'Confirmado' => 'badge bg-primary',
                    'Concluído' => 'badge bg-success',
                    'Cancelado' => 'badge bg-danger',
                    default => 'badge bg-secondary',
                };
            ?>


                <?php if (isset($_SESSION['msg_sucesso'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['msg_sucesso']; ?>
                        <?php unset($_SESSION['msg_sucesso']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['msg_erro'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['msg_erro']; ?>
                        <?php unset($_SESSION['msg_erro']); ?>
                    </div>
                <?php endif; ?>

                <div class="card mb-3 shadow-sm position-relative">
                    <form method="POST" action="<?= BASE_URL ?>index.php?url=listarAgenda/cancelarAgenda" onsubmit="return confirm('Cancelar este agendamento?')" class="position-absolute m-2;" style="margin-left: 89%;">
                        <input type="hidden" name="id_agendamento" value="<?= $item['id_agendamento'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Cancelar agendamento">
                            &times;
                        </button>
                    </form>

                    <div class="card-body">
                        <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($item['data_agendamento'])) ?></p>
                        <p><strong>Marca:</strong> <?= $item['nome_marca'] ?></p>
                        <p><strong>Modelo:</strong> <?= $item['nome_modelo'] ?></p>
                        <p><strong>Funcionário:</strong> <?= $item['nome_funcionario'] ?></p>
                        <p><strong>Veículo:</strong> <?= $item['nome_marca'] ?> - <?= $item['nome_modelo'] ?></p>
                        <p><strong>Ano:</strong> <?= $item['ano_veiculo'] ?></p>
                        <p><strong>Cor:</strong> <?= $item['cor_veiculo'] ?></p>
                        <p><strong>Status:</strong> <span class="<?= $statusClass ?>"><?= $status ?></span></p>
                    </div>
                </div>



            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Nenhum agendamento encontrado.</div>
        <?php endif; ?>

        <a href="<?= BASE_URL; ?>index.php?url=agendamento" class="btn btn-outline-primary mt-3">Voltar</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>