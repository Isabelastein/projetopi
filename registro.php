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
            position: relative; /* Adiciona posição relativa para permitir o posicionamento absoluto do ícone */
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
            width: calc(100% - 40px); /* Largura total menos a largura do ícone */
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ffd700; /* Borda reluzente */
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            position: relative; /* Adiciona posição relativa para permitir o posicionamento absoluto do ícone */
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
        /* Estilos para a mensagem de erro */
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        /* Estilos para o ícone de olho */
        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px; /* Ajusta a posição do ícone */
            transform: translateY(-50%);
            cursor: pointer;
            color: #ffd700;
            font-size: 20px;
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
            <div style="position: relative;">
                <input type="password" id="senha" name="senha" required>
                <span class="eye-icon">&#128274;</span>
            </div>

            <input type="submit" value="Registrar">
            <!-- Adicionando estilos ao link de entrada -->
            <p style="color: #fff; text-align: center;">Já tem uma conta? <a href="login.php" style="color: #ffd700; text-decoration: none; font-weight: bold;">Entrar</a></p>
            <!-- Exibição da mensagem de erro -->
            <?php if (isset($erroSenha)) { ?>
                <p class="error-message"><?php echo $erroSenha; ?></p>
            <?php } ?>
        </form>
    </div>

    <?php
    // Configuração do banco de dados
    $servername = "localhost:3307"; // Servidor MariaDB
    $username = "root"; // Nome de usuário do MySQL
    $password = "ProjetoPI2425"; // Senha do MySQL (vazia no seu caso)
    $dbname = "form"; // Nome do banco de dados

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

        // Verifica se a senha atende aos critérios de segurança
        function verificarSenha($senha) {
            // Verifica se a senha tem pelo menos 8 caracteres, uma letra maiúscula e um caractere especial
            if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/", $senha)) {
                return "A senha deve conter pelo menos 8 caracteres, incluindo pelo menos uma letra maiúscula, um número e um caractere especial.";
            }

            // Se a senha atender aos critérios, retorna true
            return true;
        }

        // Verifica se a senha atende aos critérios
        $erroSenha = verificarSenha($senha);

        // Se a senha não for válida, exibe a mensagem de erro
        if ($erroSenha !== true) {
            // Não é necessário exibir a mensagem aqui, pois já está sendo exibida no formulário
        } else {
            // Hash da senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Prepara e executa a consulta SQL para inserir os dados no banco de dados
            $sql = "INSERT INTO users (nome, email, senha_hash) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nome, $email, $senha_hash);

            if ($stmt->execute()) {
                // Registro bem-sucedido
                // Você pode adicionar uma mensagem de sucesso aqui, se desejar
            } else {
                // Erro ao registrar
                // Você pode adicionar uma mensagem de erro aqui, se desejar
            }
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
    ?>

    <!-- Script para mostrar/esconder a senha -->
    <script>
        function togglePasswordVisibility() {
            var senhaInput = document.getElementById("senha");
            var eyeIcon = document.querySelector(".eye-icon");
            if (senhaInput.type === "password") {
                senhaInput.type = "text";
                eyeIcon.innerHTML = "&#128065;"; // Olho aberto
            } else {
                senhaInput.type = "password";
                eyeIcon.innerHTML = "&#128274;"; // Olho fechado
            }
        }
    </script>
</body>
</html>
