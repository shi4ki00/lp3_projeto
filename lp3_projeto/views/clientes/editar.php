<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Editar Cliente</h3>
        </div>

        <form action="/lp3_projeto/clientes/editar?id=<?= $cliente['id'] ?>" method="POST" class="card-form">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome'] ?? '') ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente['email'] ?? '') ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" maxlength="11" value="<?= htmlspecialchars($cliente['cpf'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="salario">Salário:</label>
                <input type="number" id="salario" name="salario" step="0.01" min="0" value="<?= htmlspecialchars($cliente['salario'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" class="form-control">
                    <option value="">Selecione</option>
                    <option value="M" <?= ($cliente['sexo'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= ($cliente['sexo'] ?? '') === 'F' ? 'selected' : '' ?>>Feminino</option>
                </select>
            </div>

            <div class="form-group">
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" value="<?= htmlspecialchars($cliente['data'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="obs">Observações:</label>
                <textarea id="obs" name="obs" rows="4" class="form-control"><?= htmlspecialchars($cliente['obs'] ?? '') ?></textarea>
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-warning">Atualizar</button>
                <a href="/lp3_projeto/clientes" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
