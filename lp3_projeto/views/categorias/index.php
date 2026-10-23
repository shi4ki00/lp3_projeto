<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Categorias Cadastrados</h3>
            <a href="/lp3_projeto/categorias/adicionar" class="btn btn-success btn-sm">+ Nova Categoria</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Categoria</th>
                    <th>Descrição</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $Car): ?>
                        <tr>
                            <td><?= $Car['id'] ?></td>
                            <td><?= htmlspecialchars($Car['categoria']) ?></td>
                            <td><?= htmlspecialchars($Car['descricao']) ?></td>
                            <td class="text-center">
                                <a href="/lp3_projeto/categorias/editar?id=<?= $Car['id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                                <a href="/lp3_projeto/categorias/excluir?id=<?= $Car['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Nenhum usuário cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>