<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>
    <div class="content-panel">
        <div class="header-action">
            <h3>Filmes Cadastrados</h3>
            <a href="/lp3_projeto/filmes/adicionar" class="btn btn-success btn-sm">+ Novo Filme</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>ID</th><th>Imagem</th><th>Filme</th><th>Diretor</th><th>Duração</th><th class="text-center">Ações</th></tr></thead>
                <tbody>
                <?php if (!empty($filmes)): ?>
                    <?php foreach ($filmes as $item): ?>
                    <tr>
                        <td><?= (int) $item['id'] ?></td>
                        <td><?php if (!empty($item['imagem'])): ?><img src="/lp3_projeto/uploads/filmes/<?= rawurlencode($item['imagem']) ?>" alt="Capa de <?= htmlspecialchars($item['filme'], ENT_QUOTES, 'UTF-8') ?>" style="width:70px;height:90px;object-fit:cover"><?php else: ?>Sem imagem<?php endif; ?></td>
                        <td><?= htmlspecialchars($item['filme'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($item['diretor'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= $item['duracao'] !== null ? (int) $item['duracao'] . ' min' : '—' ?></td>
                        <td class="text-center text-nowrap">
                            <a href="/lp3_projeto/filmes/editar?id=<?= (int) $item['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/lp3_projeto/filmes/excluir?id=<?= (int) $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este filme?');">Excluir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">Nenhum filme cadastrado.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
