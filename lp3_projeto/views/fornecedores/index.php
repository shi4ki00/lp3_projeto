<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Fornecedores Cadastrados</h3>
            <a href="/lp3_projeto/fornecedores/adicionar" class="btn btn-success btn-sm">+ Adicionar</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Razão Social</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>CNPJ</th>
                    <th>Endereço</th>
                    <th>Ativo</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($fornecedores)): ?>
                    <?php foreach ($fornecedores as $fornecedor): ?>
                        <tr>
                            <td><?= $fornecedor['id'] ?></td>
                            <td><?= htmlspecialchars($fornecedor['razao_social']) ?></td>
                            <td><?= htmlspecialchars($fornecedor['email']) ?></td>
                            <td><?= htmlspecialchars($fornecedor['telefone']) ?></td>
                            <td><?= htmlspecialchars($fornecedor['cnpj']) ?></td>
                            <td><?= htmlspecialchars($fornecedor['endereco']) ?></td>
                            <td><?= htmlspecialchars($fornecedor['ativo']) ?></td>
                            <td class="text-center">
                                <a href="/lp3_projeto/fornecedores/editar?id=<?= $fornecedor['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/lp3_projeto/fornecedores/excluir?id=<?= $fornecedor['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este registro?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Nenhum registro encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>