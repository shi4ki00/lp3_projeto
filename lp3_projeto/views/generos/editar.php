<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="page-layout"><?php include __DIR__ . '/../layout/nav.php'; ?><div class="content-panel">
<h3>Editar gênero</h3><?php if (!empty($erro)): ?><div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<form method="post" action="/lp3_projeto/generos/editar?id=<?= (int)$genero['id'] ?>">
<div class="mb-3"><label for="nome" class="form-label">Nome *</label><input class="form-control" id="nome" name="nome" maxlength="100" required value="<?= htmlspecialchars($genero['nome'] ?? '') ?>"></div>
<div class="mb-3"><label for="descricao" class="form-label">Descrição</label><input class="form-control" id="descricao" name="descricao" maxlength="255" value="<?= htmlspecialchars($genero['descricao'] ?? '') ?>"></div>
<button type="submit" class="btn btn-success">Salvar</button> <a href="/lp3_projeto/generos" class="btn btn-secondary">Cancelar</a>
</form></div></div><?php include __DIR__ . '/../layout/footer.php'; ?>