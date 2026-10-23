<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Editar Usuário</h3>
        </div>

        <form action="/lp3_projeto/categorias/editar?id=<?= $categorias['id'] ?>" method="POST" class="card-form">
            <div class="form-group">
                <label for="categoria">Nome da Categoria:</label>
                <input type="text" id="nome" name="categoria" value="<?= htmlspecialchars($categorias['categoria']) ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="nome" name="descricao" value="<?= htmlspecialchars($categorias['descricao']) ?>" required class="form-control">
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-warning">Atualizar</button>
                <a href="/lp3_projeto/categorias" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>