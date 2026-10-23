<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>
    <div class="content-panel">
        <div class="header-action"><h3>Gêneros cadastrados</h3><a href="/lp3_projeto/generos/adicionar" class="btn btn-success btn-sm">+ Novo gênero</a></div>
        <table class="table table-striped"><thead><tr><th>ID</th><th>Nome</th><th>Descrição</th><th class="text-center">Ações</th></tr></thead><tbody>
        <?php if (!empty($generos)): foreach ($generos as $genero): ?><tr>
            <td><?= (int)$genero['id'] ?></td><td><?= htmlspecialchars($genero['nome'] ?? '') ?></td><td><?= htmlspecialchars($genero['descricao'] ?? '') ?></td>
            <td class="text-center"><a class="btn btn-warning btn-sm" href="/lp3_projeto/generos/editar?id=<?= (int)$genero['id'] ?>">Editar</a> <a class="btn btn-danger btn-sm" href="/lp3_projeto/generos/excluir?id=<?= (int)$genero['id'] ?>" onclick="return confirm('Deseja excluir este gênero? Os livros vinculados ficarão sem gênero.');">Excluir</a></td>
        </tr><?php endforeach; else: ?><tr><td colspan="4" class="text-center">Nenhum gênero cadastrado.</td></tr><?php endif; ?>
        </tbody></table>
    </div>
</div><?php include __DIR__ . '/../layout/footer.php'; ?>