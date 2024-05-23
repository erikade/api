<?php //index.php

require_once("./models/Tarefas.php");
require_once("./models/usuario.php");
require_once("./databases/mariaDB.php");

function dd($valor)
{
    echo "<pre>";
    print_r($valor);
    echo "</pre>";
    die();
}

$metodo = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];
$rota = explode('/', $path);

$status_code = 200;
$resposta = [
    "status" => true,
    "mensagem" => "",
];





if ($rota[1] == "usuario") {
    $database = new MariaDb();
    $usuario = new Usuario($database->dbConnection());
    switch ($metodo) {
        case "GET":
            if (isset($rota[2]) && is_numeric($rota[2])) {
                $result = $usuario->getUserById($rota[2]);
                if (count($result) == 0) {
                    $status_code = 404;
                    $resposta['status'] = false;
                    $resposta['mensagem'] = "Usuário não encontrado";
                    break;
                }
                $resposta['dados'] = $result;
            } else {
                $resposta['dados'] = $usuario->getAll();
            }
            break;
        case "DELETE": //  /usuarios/2
            if (isset($rota[2]) && is_numeric($rota[2])) {
                $usuario->id = $rota[2];
                $result =  $usuario->remove();
                if ($result === false) {
                    $status_code = 403;
                    $resposta['status'] = false;
                    $resposta['mensagem'] = "Erro ao tentar remover o usuário";
                    break;
                }
            } else {
                $status_code = 403;
                $resposta['status'] = false;
                $resposta['mensagem'] = "Usuário não foi informado";
            }
            break;
        case "POST":
            $parametros = file_get_contents('php://input');
            $parametros = (array) json_decode($parametros, true);
            $usuario->nome = $parametros['nome'];
            $usuario->login = $parametros['login'];
            $usuario->senha = $parametros['senha'];

            if (!$usuario->create()) {
                $status_code = 403;
                $resposta['status'] = false;
                $resposta['mensagem'] = "Erro ao tentar cadastrar o usuário";
                break;
            }
            $resposta['mensagem'] = "Usuário cadastrado com sucesso!";
            break;

        case "PUT":
            $parametros = file_get_contents('php://input');
            $parametros = (array) json_decode($parametros, true);
            $usuario->id = $rota[2];
            $usuario->nome = $parametros['nome'];
            $usuario->login = $parametros['login'];
            $usuario->senha = $parametros['senha'];

            if (!$usuario->update()) {
                $status_code = 403;
                $resposta['status'] = false;
                $resposta['mensagem'] = "Erro ao tentar atualizar o usuário";
                break;
            }
            $resposta['mensagem'] = "Usuário atualizado com sucesso!";
            break;
        default:
            $status_code = 403;
            $resposta['status'] = false;
            $resposta['mensagem'] = "Método não permitido";
    }
}
else if ($rota[1] == "tarefas") {
    $database = new MariaDb();
    $tarefas = new Tarefas($database->dbConnection());
    switch ($metodo) {
        case "GET":
            if (isset($rota[2]) && is_numeric($rota[2])) {
                $result = $tarefas->getTarefasById($rota[2]);
                if (count($result) == 0) {
                    $status_code = 404;
                    $resposta['status'] = false;
                    $resposta['mensagem'] = "Usuário não encontrado";
                    break;
                }
                $resposta['dados'] = $result;
            } else {
                $resposta['dados'] = $tarefas->getAll();
            }
            break;
        case "DELETE": //  /usuarios/2
            if (isset($rota[2]) && is_numeric($rota[2])) {
                $tarefas->id_tarefas = $rota[2];
                $result =  $tarefas->remove();
                if ($result === false) {
                    $status_code = 403;
                    $resposta['status'] = false;
                    $resposta['mensagem'] = "Erro ao tentar remover o usuário";
                    break;
                }
            } else {
                $status_code = 403;
                $resposta['status'] = false;
                $resposta['mensagem'] = "Usuário não foi informado";
            }
            break;
        case "POST":
            $parametros = file_get_contents('php://input');
            $parametros = (array) json_decode($parametros, true);
            $tarefas->id_tarefas = $parametros['id_tarefas'];
            $tarefas->nome = $parametros['nome'];
            $tarefas->descricao = $parametros['descricao'];
            $tarefas->id_usuario = $parametros['id_usuario'];

            if (!$tarefas->create()) {
                $status_code = 403;
                $resposta['status'] = false;
                $resposta['mensagem'] = "Erro ao tentar cadastrar o usuário";
                break;
            }
            $resposta['mensagem'] = "Usuário cadastrado com sucesso!";
            break;

        case "PUT":
            $parametros = file_get_contents('php://input');
            $parametros = (array) json_decode($parametros, true);
            $tarefas->id_tarefas = $rota[2];
            $tarefas->nome = $parametros['nome'];
            $tarefas->descricao = $parametros['descricao'];
            $tarefas->id_usuario = $parametros['id_usuario'];

            if (!$tarefas->update()) {
                $status_code = 403;
                $resposta['status'] = false;
                $resposta['mensagem'] = "Erro ao tentar atualizar o usuário";
                break;
            }
            $resposta['mensagem'] = "Usuário atualizado com sucesso!";
            break;
        default:
            $status_code = 403;
            $resposta['status'] = false;
            $resposta['mensagem'] = "Método não permitido";
    }
}


else {
    $status_code = 403;
    $resposta['status'] = false;
    $resposta['mensagem'] = "Não foi possível atender a sua requisição!";
}


http_response_code($status_code);
header("Content-Type: application/json");
echo json_encode($resposta);
