<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua Página de Registro</title>
    <!-- Estilo CSS -->
    <style>
        /* Reset de estilos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Estilos para o corpo da página */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Nova fonte */
            background-image: url("https://i.ibb.co/GJsV3Zn/Site-Empresarial-Aplicativo-de-Tecnologia-Ousado-Roxo-e-Azul-escuro-1.png");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: flex-end; /* Alinha o conteúdo à direita */
            align-items: center; /* Centraliza o conteúdo verticalmente */
            height: 100vh;
            margin: 0;
        }
        /* Estilos para o container do formulário */
        .container {
            width: 400px; /* Largura do formulário */
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 30px 5px rgba(255, 215, 0, 0.5); /* Borda reluzente dourada */
            margin-right: 200px; /* Deslocamento para o lado direito */
            margin-left: 80px; /* Deslocamento para o lado esquerdo */
        }
        /* Estilos para o cabeçalho */
        h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }
        /* Estilos para as etiquetas de rótulo */
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #fff;
        }
        /* Estilos para os campos de entrada */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%; /* Largura total */
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ffd700; /* Borda reluzente */
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        /* Estilos para os campos de entrada quando focados ou hover */
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="submit"]:hover {
            border-color: #ffcc00;
        }
        /* Estilos para o botão de envio */
        input[type="submit"] {
            cursor: pointer;
            background-color: #ffd700;
            color: #000;
            border: none;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #ffcc00;
        }
        /* Estilos para o link de entrada */
        .form-wrapper p {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Altera a fonte */
        }
        .form-wrapper p a {
            color: #ffd700; /* Cor amarela para o link */
            text-decoration: none;
            font-weight: bold;
        }
        .form-wrapper p a:hover {
            text-decoration: underline;
        }
        /* Centralizar e deixar em branco o texto "Já tem uma conta? Entrar" */
        .form-wrapper p {
            text-align: center;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Formulário de registro -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Registrar Novo Usuário</h2>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <input type="submit" value="Registrar">
            <!-- Adicionando estilos ao link de entrada -->
            <p style="color: #fff; text-align: center;">Já tem uma conta? <a href="login.php" style="color: #ffd700; text-decoration: none; font-weight: bold;">Entrar</a></p>
        </form>
    </div>

    <?php
    // Configuração do banco de dados
    $servername = "localhost:3307"; // Servidor MySQL (ou MariaDB)
    $username = "root";
    $password = "ProjetoPI2425";
    $dbname = "form";

    // Conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se a conexão foi bem sucedida
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtém os dados do formulário
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        // Verifica se o e-mail já está cadastrado
        $sql_check_email = "SELECT * FROM users WHERE email = ?";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();

        if ($result_check_email->num_rows > 0) {
            // E-mail já está cadastrado, exiba uma mensagem de erro ou redirecione para uma página de erro
            echo "Este e-mail já está cadastrado. Por favor, faça login ou use outro e-mail.";
        } else {
            // E-mail não está cadastrado, proceda com o registro normalmente
            // Prepara a consulta SQL usando declarações preparadas
            $sql = "INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Vincula os parâmetros e executa a consulta
            $stmt->bind_param("sss", $nome, $email, $senha);
            if ($stmt->execute()) {
                // Redireciona para a página de login
                echo '<script>window.location.href = "login.php";</script>';
                exit; // Encerra o script após o redirecionamento
            } else {
                echo "Erro ao inserir os dados: " . $stmt->error;
            }
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
    ?>
</body>
</html>
