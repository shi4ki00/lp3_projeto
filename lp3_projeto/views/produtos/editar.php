<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Editar Produto</h3>
        </div>

        <form action="/lp3_projeto/produtos/editar?id=<?= $produto['id'] ?>" method="POST" class="card-form">
            <div class="form-group">
                <label for="produto">Nome do Produto:</label>
                <input type="text" id="produto" name="produto" value="<?= htmlspecialchars($produto['produto']) ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="valor">Valor (R$):</label>
                <input type="number" step="0.01" id="valor" name="valor" value="<?= $produto['valor'] ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoria:</label>
                <select id="categoria_id" name="categoria_id" class="form-control">
                    <option value="">Sem categoria</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>" <?= (isset($produto['categoria_id']) && $produto['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>><?= htmlspecialchars($categoria['categoria']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" value="<?= htmlspecialchars($produto['descricao']) ?>" required class="form-control">
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-warning">Atualizar</button>
                <a href="/lp3_projeto/produtos" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
