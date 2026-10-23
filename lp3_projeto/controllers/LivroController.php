<?php
class LivroController
{
    private $model;

    public function __construct() { $this->model = new Livro(); }

    public function index()
    {
        $livros = $this->model->listar();
        require __DIR__ . '/../views/livros/index.php';
    }

    private function processarImagem($arquivo, ?string $imagemAtual = null): ?string
    {
        if (!isset($arquivo) || !is_array($arquivo) || empty($arquivo['name'])) return $imagemAtual;
        if (!isset($arquivo['error']) || $arquivo['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($arquivo['tmp_name'])) return $imagemAtual;

        // Confere o conteúdo real do arquivo, sem confiar apenas no tipo enviado pelo navegador.
        $permitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
        $info = @getimagesize($arquivo['tmp_name']);
        $mime = $info['mime'] ?? '';
        if (!$info || !isset($permitidos[$mime])) return $imagemAtual;

        $diretorio = __DIR__ . '/../uploads/livros';
        if (!is_dir($diretorio) && !mkdir($diretorio, 0755, true) && !is_dir($diretorio)) return $imagemAtual;

        $nomeArquivo = bin2hex(random_bytes(16)) . '.' . $permitidos[$mime];
        $destino = $diretorio . '/' . $nomeArquivo;
        if (!move_uploaded_file($arquivo['tmp_name'], $destino)) return $imagemAtual;

        if ($imagemAtual && basename($imagemAtual) === $imagemAtual && is_file($diretorio . '/' . $imagemAtual)) {
            unlink($diretorio . '/' . $imagemAtual);
        }
        return $nomeArquivo;
    }

    private function dadosPost(): array
    {
        $titulo = trim($_POST['titulo'] ?? '');
        $autor = trim($_POST['autor'] ?? '');
        $isbn = trim($_POST['isbn'] ?? '');
        $anoTexto = trim($_POST['ano_publicacao'] ?? '');
        $sinopse = trim($_POST['sinopse'] ?? '');
        $generoTexto = trim($_POST['id_genero'] ?? '');
        $ano = $anoTexto === '' ? null : filter_var($anoTexto, FILTER_VALIDATE_INT);
        $genero = $generoTexto === '' ? null : filter_var($generoTexto, FILTER_VALIDATE_INT);
        $erro = '';
        if ($titulo === '' || $autor === '') $erro = 'Título e autor são obrigatórios.';
        elseif ($anoTexto !== '' && ($ano === false || $ano < 0 || $ano > 65535)) $erro = 'Informe um ano de publicação válido.';
        elseif ($generoTexto !== '' && ($genero === false || $genero < 1)) $erro = 'Selecione um gênero válido.';
        return [
            'dados' => ['titulo'=>$titulo, 'autor'=>$autor, 'isbn'=>$isbn !== '' ? $isbn : null, 'ano'=>$ano === false ? null : $ano, 'sinopse'=>$sinopse !== '' ? $sinopse : null, 'genero'=>$genero === false ? null : $genero],
            'erro' => $erro
        ];
    }

    public function adicionar()
    {
        $generos = $this->model->listarGeneros();
        $erro = '';
        $livro = ['titulo'=>'', 'autor'=>'', 'isbn'=>'', 'ano_publicacao'=>'', 'sinopse'=>'', 'id_genero'=>'', 'capa'=>null];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->dadosPost(); $erro = $resultado['erro']; $d = $resultado['dados']; $livro = array_merge($livro, $_POST);
            if ($erro === '') {
                $capa = $this->processarImagem($_FILES['capa'] ?? null);
                try {
                    $this->model->salvar($d['titulo'], $d['autor'], $d['isbn'], $d['ano'], $d['sinopse'], $capa, $d['genero']);
                    header('Location: /lp3_projeto/livros'); exit;
                } catch (PDOException $e) { $erro = $e->getCode() === '23000' ? 'Esse ISBN já está cadastrado.' : 'Não foi possível salvar o livro. Confira os dados e o banco.'; }
            }
        }
        require __DIR__ . '/../views/livros/criar.php';
    }

    public function editar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $livro = $id ? $this->model->buscarPorId((int)$id) : false;
        if (!$livro) { header('Location: /lp3_projeto/livros'); exit; }
        $generos = $this->model->listarGeneros(); $erro = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->dadosPost(); $erro = $resultado['erro']; $d = $resultado['dados'];
            if ($erro === '') {
                $capa = $this->processarImagem($_FILES['capa'] ?? null, $livro['capa']);
                try {
                    $this->model->atualizar($d['titulo'], $d['autor'], $d['isbn'], $d['ano'], $d['sinopse'], $capa, $d['genero'], (int)$id);
                    header('Location: /lp3_projeto/livros'); exit;
                } catch (PDOException $e) { $erro = $e->getCode() === '23000' ? 'Esse ISBN já está cadastrado.' : 'Não foi possível atualizar o livro. Confira os dados e o banco.'; }
            }
            $livro = array_merge($livro, $_POST);
            $livro['capa'] = $livro['capa'] ?? null;
        }
        require __DIR__ . '/../views/livros/editar.php';
    }

    public function excluir()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $livro = $this->model->buscarPorId((int)$id);
            if ($livro && !empty($livro['capa'])) {
                $arquivo = __DIR__ . '/../uploads/livros/' . basename($livro['capa']);
                if (is_file($arquivo)) unlink($arquivo);
            }
            $this->model->excluir((int)$id);
        }
        header('Location: /lp3_projeto/livros'); exit;
    }
}
