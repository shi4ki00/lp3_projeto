<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Editar Fornecedor</h3>
        </div>

        <form action="/lp3_projeto/fornecedores/editar?id=<?= $fornecedor['id'] ?>" method="POST" class="card-form">
            <div class="form-group">
                <label for="razao_social">Razão Social:</label>
                <input type="text" id="razao_social" name="razao_social" value="<?= htmlspecialchars($fornecedor['razao_social'] ?? '') ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($fornecedor['email'] ?? '') ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="cnpj">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" value="<?= htmlspecialchars($fornecedor['cnpj'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($fornecedor['telefone'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($fornecedor['endereco'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="ativo">Ativo:</label>
                <select name="ativo" id="ativo" class="form-control">
                <option value="">Selecione</option>
                <option value="1" <?= ($fornecedor['ativo'] ?? '') === 1 ? 'selected' : '' ?>>Ativo</option>
                <option value="0" <?= ($fornecedor['ativo'] ?? '') === 0 ? 'selected' : '' ?>>Desativo</option>
                </select>
            </div>  

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-warning">Atualizar</button>
                <a href="/lp3_projeto/fornecedores" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
