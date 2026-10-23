<?php

class FilmeController
{
    private $model;

    public function __construct()
    {
        $this->model = new Filme();
    }

    public function index()
    {
        $filmes = $this->model->listar();
        require_once __DIR__ . '/../views/filmes/index.php';
    }

    public function adicionar()
    {
        $erro = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filme = trim($_POST['filme'] ?? '');
            $diretor = trim($_POST['diretor'] ?? '');
            $duracaoTexto = trim($_POST['duracao'] ?? '');
            $duracao = $duracaoTexto === '' ? null : filter_var($duracaoTexto, FILTER_VALIDATE_INT);

            if ($filme === '' || $diretor === '') {
                $erro = 'Preencha o nome do filme e o diretor.';
            } elseif ($duracaoTexto !== '' && ($duracao === false || $duracao < 0)) {
                $erro = 'Informe uma duração válida em minutos.';
            } else {
                $imagem = $this->processarImagem($_FILES['imagem'] ?? null);
                if (!empty($_FILES['imagem']['name']) && $imagem === null) {
                    $erro = 'A imagem não é válida. Envie JPG, PNG, GIF ou WebP de até 5 MB.';
                } else {
                    $this->model->salvar($filme, $diretor, $duracao, $imagem);
                    header('Location: /lp3_projeto/filmes');
                    exit;
                }
            }
        }
        require_once __DIR__ . '/../views/filmes/criar.php';
    }

    public function editar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id || !($filmeAtual = $this->model->buscarPorId($id))) {
            header('Location: /lp3_projeto/filmes');
            exit;
        }

        $erro = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['filme'] ?? '');
            $diretor = trim($_POST['diretor'] ?? '');
            $duracaoTexto = trim($_POST['duracao'] ?? '');
            $duracao = $duracaoTexto === '' ? null : filter_var($duracaoTexto, FILTER_VALIDATE_INT);

            if ($titulo === '' || $diretor === '') {
                $erro = 'Preencha o nome do filme e o diretor.';
            } elseif ($duracaoTexto !== '' && ($duracao === false || $duracao < 0)) {
                $erro = 'Informe uma duração válida em minutos.';
            } else {
                $imagemNova = $this->processarImagem($_FILES['imagem'] ?? null, $filmeAtual['imagem']);
                if (!empty($_FILES['imagem']['name']) && $imagemNova === $filmeAtual['imagem']) {
                    $erro = 'Não foi possível processar a imagem. Envie JPG, PNG, GIF ou WebP de até 5 MB.';
                } else {
                    $this->model->atualizar($titulo, $diretor, $duracao, $imagemNova, $id);
                    if ($imagemNova !== $filmeAtual['imagem']) {
                        $this->removerImagem($filmeAtual['imagem']);
                    }
                    header('Location: /lp3_projeto/filmes');
                    exit;
                }
            }
        }
        require_once __DIR__ . '/../views/filmes/editar.php';
    }

    public function excluir()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $filme = $this->model->buscarPorId($id);
            if ($filme && $this->model->excluir($id)) {
                $this->removerImagem($filme['imagem'] ?? null);
            }
        }
        header('Location: /lp3_projeto/filmes');
        exit;
    }

    private function processarImagem(?array $arquivo, ?string $imagemAtual = null): ?string
    {
        if (!$arquivo || empty($arquivo['name'])) {
            return $imagemAtual;
        }
        if (($arquivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || ($arquivo['size'] ?? 0) > 5 * 1024 * 1024) {
            return $imagemAtual;
        }

        $info = @getimagesize($arquivo['tmp_name']);
        if ($info === false) {
            return $imagemAtual;
        }

        $extensoes = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_GIF => 'gif',
            IMAGETYPE_WEBP => 'webp'
        ];
        $tipo = $info[2] ?? null;
        if (!isset($extensoes[$tipo])) {
            return $imagemAtual;
        }

        $diretorio = __DIR__ . '/../uploads/filmes';
        if (!is_dir($diretorio) && !mkdir($diretorio, 0755, true) && !is_dir($diretorio)) {
            return $imagemAtual;
        }

        $nomeArquivo = bin2hex(random_bytes(12)) . '.' . $extensoes[$tipo];
        $destino = $diretorio . '/' . $nomeArquivo;
        if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
            return $imagemAtual;
        }
        return $nomeArquivo;
    }

    private function removerImagem(?string $nomeArquivo): void
    {
        if (!$nomeArquivo || basename($nomeArquivo) !== $nomeArquivo) {
            return;
        }
        $caminho = __DIR__ . '/../uploads/filmes/' . $nomeArquivo;
        if (is_file($caminho)) {
            unlink($caminho);
        }
    }
}
