<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Clientes Cadastrados</h3>
            <a href="/lp3_projeto/clientes/adicionar" class="btn btn-success btn-sm">+ Novo Cliente</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>CPF</th>
                    <th>Salário</th>
                    <th>Sexo</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($clientes)): ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= $cliente['id'] ?></td>
                            <td><?= htmlspecialchars($cliente['nome'] ?? '') ?></td>
                            <td><?= htmlspecialchars($cliente['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($cliente['cpf'] ?? '') ?></td>
                            <td><?= $cliente['salario'] !== null ? 'R$ ' . number_format((float) $cliente['salario'], 2, ',', '.') : '' ?></td>
                            <td><?= htmlspecialchars($cliente['sexo'] ?? '') ?></td>
                            <td><?= !empty($cliente['data']) ? date('d/m/Y', strtotime($cliente['data'])) : '' ?></td>
                            <td class="text-center">
                                <a href="/lp3_projeto/clientes/editar?id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/lp3_projeto/clientes/excluir?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este cliente?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Nenhum cliente cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
