<?php

spl_autoload_register(function ($class_name) {
    if (file_exists(__DIR__ . '/controllers/' . $class_name . '.php')) {
        require_once __DIR__ . '/controllers/' . $class_name . '.php';
    } elseif (file_exists(__DIR__ . '/models/' . $class_name . '.php')) {
        require_once __DIR__ . '/models/' . $class_name . '.php';
    }
});

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/lp3_projeto';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
if (empty($uri)) {
    $uri = '/';
}

$rotas = [
    '/'               => ['controller' => 'HomeController',    'metodo' => 'index'],
    '/empresa'         => ['controller' => 'HomeController',    'metodo' => 'sobre'],
    '/usuarios'         => ['controller' => 'UsuarioController',    'metodo' => 'index'],
    '/usuarios/adicionar'         => ['controller' => 'UsuarioController',    'metodo' => 'adicionar'],
    '/usuarios/editar'         => ['controller' => 'UsuarioController',    'metodo' => 'editar'],
    '/usuarios/excluir'         => ['controller' => 'UsuarioController',    'metodo' => 'excluir'],
    '/categorias'         => ['controller' => 'CategoriaController',    'metodo' => 'index'],
    '/categorias/adicionar'         => ['controller' => 'CategoriaController',    'metodo' => 'adicionar'],
    '/categorias/editar'         => ['controller' => 'CategoriaController',    'metodo' => 'editar'],
    '/categorias/excluir'         => ['controller' => 'CategoriaController',    'metodo' => 'excluir'],
    '/produtos'             => ['controller' => 'ProdutoController',  'metodo' => 'index'],
    '/produtos/adicionar'   => ['controller' => 'ProdutoController',  'metodo' => 'adicionar'],
    '/produtos/editar'      => ['controller' => 'ProdutoController',  'metodo' => 'editar'],
    '/produtos/excluir'     => ['controller' => 'ProdutoController',  'metodo' => 'excluir'],
    '/clientes'             => ['controller' => 'ClienteController',  'metodo' => 'index'],
    '/clientes/adicionar'   => ['controller' => 'ClienteController',  'metodo' => 'adicionar'],
    '/clientes/editar'      => ['controller' => 'ClienteController',  'metodo' => 'editar'],
    '/clientes/excluir'     => ['controller' => 'ClienteController',  'metodo' => 'excluir'],
    '/generos'              => ['controller' => 'GeneroController', 'metodo' => 'index'],
    '/generos/adicionar'    => ['controller' => 'GeneroController', 'metodo' => 'adicionar'],
    '/generos/editar'       => ['controller' => 'GeneroController', 'metodo' => 'editar'],
    '/generos/excluir'      => ['controller' => 'GeneroController', 'metodo' => 'excluir'],
    '/livros'               => ['controller' => 'LivroController', 'metodo' => 'index'],
    '/livros/adicionar'     => ['controller' => 'LivroController', 'metodo' => 'adicionar'],
    '/livros/editar'        => ['controller' => 'LivroController', 'metodo' => 'editar'],
    '/livros/excluir'       => ['controller' => 'LivroController', 'metodo' => 'excluir'],
];

if (array_key_exists($uri, $rotas)) {
    $controllerName = $rotas[$uri]['controller'];
    $metodo = $rotas[$uri]['metodo'];

    $controller = new $controllerName();
    $controller->$metodo();
} else {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
