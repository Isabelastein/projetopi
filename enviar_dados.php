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
                $sql = "INSERT INTO depoimentos (texto, email, nome) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $depoimento, $email, $nome);
                if ($stmt->execute()) {
                    $message = "Depoimento inserido com sucesso";
                } else {
                    $error = "Erro ao inserir depoimento: " . $stmt->error;
                }
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
                $sql = "INSERT INTO duvidas (texto, email, nome) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $duvida, $email, $nome);
                if ($stmt->execute()) {
                    $message = "Dúvida inserida com sucesso";
                } else {
                    $error = "Erro ao inserir dúvida: " . $stmt->error;
                }
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
                $sql = "INSERT INTO sugestoesfeedback (texto, email, nome) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $sugestao, $email, $nome);
                if ($stmt->execute()) {
                    $message = "Sugestão ou feedback inserido com sucesso";
                } else {
                    $error = "Erro ao inserir sugestão ou feedback: " . $stmt->error;
                }
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
?>

<!-- Formulário de depoimentos -->
<?php if ($tipo_formulario === 'depoimentos') : ?>
    <?php if ($error) : ?>
        <p><?php echo $error; ?></p>
    <?php elseif ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="text" name="nome-depoimento" placeholder="Seu nome" required><br>
        <input type="email" name="email-depoimento" placeholder="Seu email" required><br>
        <textarea name="texto-depoimento" placeholder="Seu depoimento" required></textarea><br>
        <button type="submit">Enviar Depoimento</button>
    </form>
<?php endif; ?>

<!-- Formulário de dúvidas -->
<?php if ($tipo_formulario === 'duvidas') : ?>
    <?php if ($error) : ?>
        <p><?php echo $error; ?></p>
    <?php elseif ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="text" name="nome-duvida" placeholder="Seu nome" required><br>
        <input type="email" name="email-duvida" placeholder="Seu email" required><br>
        <textarea name="texto-duvida" placeholder="Sua dúvida" required></textarea><br>
        <button type="submit">Enviar Dúvida</button>
    </form>
<?php endif; ?>

<!-- Formulário de sugestões e feedback -->
<?php if ($tipo_formulario === 'sugestoesfeedback') : ?>
    <?php if ($error) : ?>
        <p><?php echo $error; ?></p>
    <?php elseif ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="text" name="nome-sugestao" placeholder="Seu nome" required><br>
        <input type="email" name="email-sugestao" placeholder="Seu email" required><br>
        <textarea name="texto-sugestao" placeholder="Sua sugestão ou feedback" required></textarea><br>
        <button type="submit">Enviar Sugestão ou Feedback</button>
    </form>
<?php endif; ?>
