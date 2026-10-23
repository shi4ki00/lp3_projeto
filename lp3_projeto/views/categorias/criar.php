<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Cadastrar Nova Categoria</h3>
        </div>

        <form action="/lp3_projeto/categorias/adicionar" method="POST" class="card-form">
            <div class="form-group">
                <label for="categoria">Nome da Categoria:</label>
                <input type="text" id="nome" name="categoria" required class="form-control" placeholder="Ex: Teste">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="nome" name="descricao" required class="form-control" placeholder="Ex: Bla bla bla...">
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="/lp3_projeto/categorias" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
