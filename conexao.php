<?php

$usuario = 'root';
$senha = 'ProjetoPI2425';
$database = 'form';
$host = 'localhost:3307'; // Servidor MariaDB

$mysqli = new mysqli($host, $usuario, $senha, $database);

if($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
}

// Verifique os dados recebidos do formulário
var_dump($_POST);

// Verifique a consulta SQL
echo $sql;

?>
