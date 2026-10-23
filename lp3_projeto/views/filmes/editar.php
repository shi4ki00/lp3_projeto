<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>
    <div class="content-panel">
        <div class="header-action"><h3>Editar Filme</h3></div>
        <?php if (!empty($erro)): ?><div class="alert alert-danger"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
        <form action="/lp3_projeto/filmes/editar?id=<?= (int) $filmeAtual['id'] ?>" method="POST" enctype="multipart/form-data" class="card-form">
            <div class="form-group"><label for="filme">Nome do filme:</label><input type="text" id="filme" name="filme" maxlength="200" required class="form-control" value="<?= htmlspecialchars($_POST['filme'] ?? $filmeAtual['filme'], ENT_QUOTES, 'UTF-8') ?>"></div>
            <div class="form-group"><label for="diretor">Diretor:</label><input type="text" id="diretor" name="diretor" maxlength="200" required class="form-control" value="<?= htmlspecialchars($_POST['diretor'] ?? $filmeAtual['diretor'], ENT_QUOTES, 'UTF-8') ?>"></div>
            <div class="form-group"><label for="duracao">Duração (minutos):</label><input type="number" id="duracao" name="duracao" min="0" class="form-control" value="<?= htmlspecialchars($_POST['duracao'] ?? (string) ($filmeAtual['duracao'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></div>
            <?php if (!empty($filmeAtual['imagem'])): ?><div class="form-group"><label>Imagem atual:</label><div><img src="/lp3_projeto/uploads/filmes/<?= rawurlencode($filmeAtual['imagem']) ?>" alt="Capa atual" style="width:90px;height:120px;object-fit:cover"></div></div><?php endif; ?>
            <div class="form-group"><label for="imagem">Substituir imagem (opcional):</label><input type="file" id="imagem" name="imagem" accept="image/jpeg,image/png,image/gif,image/webp" class="form-control"><small class="form-text text-muted">JPG, PNG, GIF ou WebP; máximo de 5 MB. Deixe vazio para manter a imagem atual.</small></div>
            <div class="mt-3 d-flex gap-2"><button type="submit" class="btn btn-warning">Atualizar</button><a href="/lp3_projeto/filmes" class="btn btn-secondary">Voltar</a></div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
