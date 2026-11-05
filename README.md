# lp3_projeto

Roteiro para criação de um novo módulo
Objetivo

Este documento explica, passo a passo, como criar um novo módulo no projeto seguindo o padrão já utilizado por Categorias, Produtos, Usuários e Filmes.

Estrutura base da aplicação
index.php: centraliza as rotas e dispara os controllers
controllers/: arquivos de controle da lógica do módulo
models/: classes de acesso ao banco e operações CRUD
views/: arquivos de interface (lista, cadastro e edição)
schema.sql: estrutura do banco de dados
Padrão atual do projeto
A rota é definida em index.php
O controller é instanciado com base no nome da rota
O model acessa o banco e implementa operações de listagem, cadastro, edição e exclusão
As telas ficam em views/<modulo>/...
Passo 1Definir o nome do módulo
Escolha um nome em minúsculas, no plural, seguindo o padrão do projeto.

Exemplos:

categorias
produtos
usuarios
filmes
Se o módulo for "clientes", então a convenção será:

Item	Convenção
Controller	ClienteController
Model	Cliente
Pasta de views	views/clientes/
Rota principal	/clientes
Passo 2Planejar a tabela no banco
Antes de criar o código, defina a estrutura da tabela. Exemplo:

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Importante

O nome da tabela deve ficar no mesmo padrão do módulo
Os campos devem ser consistentes com o formulário da tela
Atualize o arquivo schema.sql
Se necessário, rode o SQL no banco para criar a tabela
Passo 3Criar o model
Crie um arquivo em models/<Nome>.php. Estrutura mínima:

<?php
require_once __DIR__ . '/../config/Database.php';

class Cliente {
    private $db;
    private $tabela = "clientes";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {
        $stmt = $this->db->query("select * from $this->tabela order by id asc");
        return $stmt->fetchAll();
    }

    public function salvar(string $nome, string $email, string $telefone) {
        $sql = "insert into $this->tabela (nome, email, telefone) values (:nome, :email, :telefone)";
        $stmt = $this->db->prepare($sql);
        $values = [
            ':nome' => $nome,
            ':email' => $email,
            ':telefone' => $telefone
        ];
        return $stmt->execute($values);
    }

    public function buscarPorId(int $id) {
        $sql = "select * from $this->tabela where id = :id";
        $stmt = $this->db->prepare($sql);
        $values = [':id' => $id];
        $stmt->execute($values);
        return $stmt->fetch();
    }

    public function atualizar(int $id, string $nome, string $email, string $telefone) {
        $sql = "update $this->tabela set nome=:nome, email=:email, telefone=:telefone where id=:id";
        $stmt = $this->db->prepare($sql);
        $values = [
            ':nome' => $nome,
            ':email' => $email,
            ':telefone' => $telefone,
            ':id' => $id
        ];
        return $stmt->execute($values);
    }

    public function excluir(int $id) {
        $sql = "delete from $this->tabela where id = :id";
        $stmt = $this->db->prepare($sql);
        $values = [':id' => $id];
        return $stmt->execute($values);
    }
}
Regras

Sempre use require_once para Database.php
Use a propriedade $tabela com o nome da tabela do banco
Implemente os métodos básicos: listar, salvar, buscarPorId, atualizar, excluir
Passo 4Criar o controller
Crie um arquivo em controllers/<NomeController>.php. Estrutura mínima:

<?php
class ClienteController {
    private $model;

    public function __construct()
    {
        $this->model = new Cliente();
    }

    public function index() {
        $dados = $this->model->listar();
        require __DIR__ . '/../views/clientes/index.php';
    }

    public function adicionar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);

            if($nome && $email) {
                $this->model->salvar($nome, $email, $telefone);
                header('Location: /lp3_projeto/clientes');
                exit;
            }
        }
        require __DIR__ . '/../views/clientes/criar.php';
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /lp3_projeto/clientes');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);

            if($nome && $email) {
                $this->model->atualizar($id, $nome, $email, $telefone);
                header('Location: /lp3_projeto/clientes');
                exit;
            }
        }

        $dado = $this->model->buscarPorId($id);

        if(!$dado) {
            header('Location: /lp3_projeto/clientes');
            exit;
        }

        require __DIR__ . '/../views/clientes/editar.php';
    }

    public function excluir() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if($id) {
            $this->model->excluir($id);
        }

        header('Location: /lp3_projeto/clientes');
        exit;
    }
}
Neste padrão:

index(): carrega a listagem do módulo
adicionar(): recebe POST e salva
editar(): busca registro por id e atualiza
excluir(): remove registro pelo id
Passo 5Registrar as rotas no index.php
Edite o arquivo index.php e adicione as rotas do novo módulo. Exemplo:

$rotas = [
    '/clientes' => ['controller' => 'ClienteController', 'metodo' => 'index'],
    '/clientes/adicionar' => ['controller' => 'ClienteController', 'metodo' => 'adicionar'],
    '/clientes/editar' => ['controller' => 'ClienteController', 'metodo' => 'editar'],
    '/clientes/excluir' => ['controller' => 'ClienteController', 'metodo' => 'excluir'],
];
Importante

O nome do controller deve bater com a classe
O nome do método deve existir no controller
A URL do módulo precisa seguir o padrão do projeto
Passo 6Criar a pasta de views
Crie a pasta views/clientes/ e os arquivos:

index.php
criar.php
editar.php
A pasta deve seguir o mesmo padrão dos módulos existentes.

Exemplo de estrutura da listagem (index.php):

<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Clientes Cadastrados</h3>
            <a href="/lp3_projeto/clientes/adicionar" class="btn btn-success btn-sm">+ Adicionar</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dados)): ?>
                    <?php foreach ($dados as $linha): ?>
                        <tr>
                            <td><?= $linha['id'] ?></td>
                            <td><?= htmlspecialchars($linha['nome']) ?></td>
                            <td><?= htmlspecialchars($linha['email']) ?></td>
                            <td><?= htmlspecialchars($linha['telefone']) ?></td>
                            <td class="text-center">
                                <a href="/lp3_projeto/clientes/editar?id=<?= $linha['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/lp3_projeto/clientes/excluir?id=<?= $linha['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este registro?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Nenhum registro encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
Passo 7Criar os formulários de cadastro e edição
O formulário de criação deve postar para:

/lp3_projeto/clientes/adicionar
O formulário de edição deve postar para:

/lp3_projeto/clientes/editar?id=ID
Exemplo de formulário de criação:

<form method="POST" action="/lp3_projeto/clientes/adicionar">
    <label>Nome</label>
    <input type="text" name="nome" required>

    <label>E-mail</label>
    <input type="email" name="email" required>

    <label>Telefone</label>
    <input type="text" name="telefone">

    <button type="submit">Salvar</button>
</form>
Exemplo de formulário de edição:

<form method="POST" action="/lp3_projeto/clientes/editar?id=<?= $dado['id'] ?>">
    <label>Nome</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($dado['nome']) ?>" required>

    <label>E-mail</label>
    <input type="email" name="email" value="<?= htmlspecialchars($dado['email']) ?>" required>

    <label>Telefone</label>
    <input type="text" name="telefone" value="<?= htmlspecialchars($dado['telefone']) ?>">

    <button type="submit">Atualizar</button>
</form>
Passo 8Adicionar o módulo ao menu de navegação
Se a aplicação tiver um menu principal, adicione o novo item no arquivo views/layout/nav.php. Exemplo:

<li><a href="/lp3_projeto/clientes">Clientes</a></li>
Isso permite que o usuário acesse o módulo pela interface.

Passo 9Validar o funcionamento
Após criar o módulo, faça os testes:

Acesse /lp3_projeto/clientes
Verifique se a listagem abre corretamente
Clique em Adicionar
Crie um registro
Verifique se foi salvo no banco
Clique em Editar
Atualize os dados
Clique em Excluir
Confirme que o registro foi removido
Passo 10Checklist final
Antes de concluir, confirme:

☐ tabela criada no banco
☐ model criado corretamente
☐ controller criado corretamente
☐ rota adicionada em index.php
☐ pasta views/<modulo>/ criada
☐ página de listagem funcionando
☐ formulário de cadastro funcionando
☐ formulário de edição funcionando
☐ botão de exclusão funcionando
☐ menu atualizado
☐ sem erros visíveis no navegador
Padrão de nomenclatura recomendado
Nome do módulo em singular para classes: Cliente
Nome do módulo em plural para pastas e rotas: clientes
Arquivo do controller: ClienteController.php
Arquivo do model: Cliente.php
Padrão de nomes para métodos: index, adicionar, editar, excluir
Exemplo de fluxo completo
Cria a tabela clientes no schema.sql
Cria models/Cliente.php
Cria controllers/ClienteController.php
Registra /clientes, /clientes/adicionar, /clientes/editar, /clientes/excluir em index.php
Cria views/clientes/index.php
Cria views/clientes/criar.php
Cria views/clientes/editar.php
Adiciona link no menu
Testa o fluxo completo
Conclusão

Seguindo este padrão, qualquer novo módulo da aplicação pode ser criado de forma organizada, consistente e fácil de manter.
