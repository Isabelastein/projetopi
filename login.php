<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua Página de Login</title>
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
            font-family: Arial, sans-serif;
            background-image: url("https://i.ibb.co/GJsV3Zn/Site-Empresarial-Aplicativo-de-Tecnologia-Ousado-Roxo-e-Azul-escuro.png");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        /* Estilos para o container do formulário */
        .container {
            width: 400px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
            margin-right: 200px;
            margin-left: 80px;
        }
        /* Estilos para o formulário */
        form {
            padding: 30px;
        }
        /* Estilos para as etiquetas de rótulo */
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #fff;
        }
        /* Estilos para os campos de entrada */
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 2px solid #ffd700;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s, background-color 0.3s;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        /* Estilos para os campos de entrada quando focados ou hover */
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="submit"]:hover {
            background-color: rgba(255, 255, 255, 0.2);
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
        }
        .form-wrapper p a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
        }
        .form-wrapper p a:hover {
            text-decoration: underline;
        }
        /* Estilos para o título */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Formulário de login -->
        <div id="login" class="form-wrapper">
            <h2>Entrar</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="login_email">E-mail:</label>
                <input type="email" id="login_email" name="login_email" required>

                <label for="login_senha">Senha:</label>
                <input type="password" id="login_senha" name="login_senha" required>

                <input type="submit" value="Entrar">
            </form>
            <p>Não tem uma conta? <a href="registro.php">Registrar</a></p>
        </div>
        <!-- Mensagem de erro -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Conexão com o banco de dados
            $servername = "localhost:3307"; // Servidor MariaDB
            $username = "root"; // substitua pelo nome de usuário do seu banco de dados
            $password = "ProjetoPI2425"; // substitua pela senha do seu banco de dados
            $dbname = "form"; // substitua pelo nome do seu banco de dados
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verifica se a conexão foi bem sucedida
            if ($conn->connect_error) {
                die("Erro na conexão com o banco de dados: " . $conn->connect_error);
            }

            // Verificar as credenciais do usuário
            $email = $_POST["login_email"];
            $senha = $_POST["login_senha"];

            // Consulta SQL para verificar as credenciais do usuário
            $sql = "SELECT * FROM users WHERE email = '$email' AND senha = '$senha'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Credenciais corretas, o usuário está autenticado
                // Você pode redirecionar o usuário para a página principal ou realizar outras ações aqui
                echo "<script>window.location.href = 'dashboard.html';</script>";
                exit; // Certifique-se de sair após o redirecionamento
            } else {
                // Credenciais incorretas, exiba uma mensagem de erro
                echo "<p id='error-msg' style='color: red; text-align: center;'>Credenciais inválidas. Tente novamente ou <a href='registro.php'>registre-se</a>.</p>";
            }

            // Fechar conexão com o banco de dados
            $conn->close();
        }
        ?>
    </div>

    <!-- Script para remover a mensagem de erro após alguns segundos -->
    <script>
        // Seleciona a mensagem de erro
        var errorMsg = document.getElementById('error-msg');
        // Remove a mensagem de erro após 5 segundos
        setTimeout(function() {
            if (errorMsg) {
                errorMsg.remove();
            }
        }, 5000); // 5000 milissegundos = 5 segundos
    </script>
</body>
</html>
