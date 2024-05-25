<?php
// Verificar se o formulário de registro foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuração do banco de dados
    $servername = "localhost:3307"; // Servidor MariaDB
    $username = "root";
    $password = "ProjetoPI2425";
    $dbname = "form"; // Nome do banco de dados

    // Conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se a conexão foi bem sucedida
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifica se os campos do formulário foram preenchidos
    if (isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"])) {
        // Obtém os dados do formulário
        $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $senha = mysqli_real_escape_string($conn, $_POST["senha"]);

        // Prepara e executa a consulta SQL para inserir os dados no banco de dados
        $sql = "INSERT INTO users (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if ($conn->query($sql) === TRUE) {
            // Redireciona para a página de login
            header('Location: login.php');
            exit; // Encerra o script após o redirecionamento
        } else {
            echo "Erro ao inserir os dados: " . $conn->error;
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>
