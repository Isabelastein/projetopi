<?php
// Mensagens de erro/sucesso
$message = '';
$error = '';

// Verifica se o tipo de formulário foi enviado
if (isset($_GET['type'])) {
    $tipo_formulario = $_GET['type'];

    // Conexão com o banco de dados
    $servername = "localhost:3307"; // Servidor MariaDB
    $username = "root"; // Altere para o seu nome de usuário do MySQL
    $password = "ProjetoPI2425"; // Altere para a sua senha do MySQL
    $dbname = "form"; // Altere para o nome do seu banco de dados

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Checa a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Insere dados na tabela correspondente
    switch ($tipo_formulario) {
        case 'depoimentos':
            // Processamento do formulário de depoimentos
            if (isset($_POST['texto-depoimento']) && isset($_POST['email-depoimento']) && isset($_POST['nome-depoimento'])) {
                $depoimento = $_POST['texto-depoimento'];
                $email = $_POST['email-depoimento'];
                $nome = $_POST['nome-depoimento'];
                if (empty($depoimento) || empty($email) || empty($nome)) {
                    die("Campos não podem estar vazios");
                }
                $sql = "INSERT INTO depoimentos (texto, email, nome) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("Erro ao preparar statement: " . $conn->error);
                }
                $stmt->bind_param("sss", $depoimento, $email, $nome);
                if ($stmt->execute()) {
                    $message = "Depoimento inserido com sucesso";
                } else {
                    $error = "Erro ao inserir depoimento: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = "Todos os campos são obrigatórios";
            }
            break;
        case 'duvidas':
            // Processamento do formulário de dúvidas
            if (isset($_POST['texto-duvida']) && isset($_POST['email-duvida']) && isset($_POST['nome-duvida'])) {
                $duvida = $_POST['texto-duvida'];
                $email = $_POST['email-duvida'];
                $nome = $_POST['nome-duvida'];
                if (empty($duvida) || empty($email) || empty($nome)) {
                    die("Campos não podem estar vazios");
                }
                $sql = "INSERT INTO duvidas (texto, email, nome) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("Erro ao preparar statement: " . $conn->error);
                }
                $stmt->bind_param("sss", $duvida, $email, $nome);
                if ($stmt->execute()) {
                    $message = "Dúvida inserida com sucesso";
                } else {
                    $error = "Erro ao inserir dúvida: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = "Todos os campos são obrigatórios";
            }
            break;
        case 'sugestoesfeedback':
            // Processamento do formulário de sugestões e feedback
            if (isset($_POST['texto-sugestao']) && isset($_POST['email-sugestao']) && isset($_POST['nome-sugestao'])) {
                $sugestao = $_POST['texto-sugestao'];
                $email = $_POST['email-sugestao'];
                $nome = $_POST['nome-sugestao'];
                if (empty($sugestao) || empty($email) || empty($nome)) {
                    die("Campos não podem estar vazios");
                }
                $sql = "INSERT INTO sugestoesfeedback (texto, email, nome) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("Erro ao preparar statement: " . $conn->error);
                }
                $stmt->bind_param("sss", $sugestao, $email, $nome);
                if ($stmt->execute()) {
                    $message = "Sugestão ou feedback inserido com sucesso";
                } else {
                    $error = "Erro ao inserir sugestão ou feedback: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = "Todos os campos são obrigatórios";
            }
            break;
        default:
            $error = "Tipo de formulário desconhecido";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    $error = "Tipo de formulário não especificado";
}

// Resposta em formato JSON
$response = array(
    'message' => $message,
    'error' => $error
);

// Retorna a resposta em JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
