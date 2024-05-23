<?php
require_once("./databases/mariaDB.php");
require_once("./models/usuario.php");

$mariaDb = new MariaDb();
$conexao = $mariaDb->dbConnection();

$usuario = new Usuario($conexao);
// $usuario->nome = "gabriel";
// $usuario->login = "gabriel@teste.com.br";
// $usuario->senha = "123";
// $usuario->create();

// $usuario2 = new Usuario($conexao);
// $usuario2->nome = "maria";
// $usuario2->login = "maria@teste.com.br";
// $usuario2->senha = "12345678";
// $usuario2->create();

//remover um usuario
//$usuario = new Usuario($conexao);
//$usuario->id = 2;
//$usuario->remove();

$usuario = new Usuario($conexao);
$usuario->id = 2;
$usuario2->nome = "maria lkdjldk";
$usuario2->login = "maria@dfsfsd.com.br";
$usuario2->senha = "45678";
$usuario2->update();

$lista_de_usuario = $usuario->getALL();

foreach ($lista_de_usuario as $item) {
    echo "nome: {$item['nome']}";
    echo PHP_EOL;
}
$usuario = new usuario($conexao);
$usuario->getUserById(1);

if($usuario->id > 0){
    echo"usuario: {$usuario->nome} encontrado";
}
else{
    echo "usuario não encontrado";
}
echo PHP_EOL;