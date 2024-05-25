<?php
ob_start(); // Inicia o buffer de saída

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $servername = "localhost:3307"; // Servidor MariaDB
    $username = "root"; // substitua pelo nome de usuário do seu banco de dados
    $password = "ProjetoPI2425"; // substitua pela senha do seu banco de dados
    $dbname = "form"; // substitua pelo nome do seu banco de dados

    // Criando a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificando a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verificando as credenciais do usuário
    $email = mysqli_real_escape_string($conn, $_POST["login_email"]);
    $senha = mysqli_real_escape_string($conn, $_POST["login_senha"]);

    // Consulta SQL para verificar as credenciais do usuário
    $sql = "SELECT senha_hash FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar a senha hash
        if (password_verify($senha, $row["senha_hash"])) {
            // Credenciais corretas, o usuário está autenticado
            echo "<script>window.location.href = 'dashboard.html';</script>";
            exit; // Certifique-se de sair após o redirecionamento
        } else {
            // Senha incorreta
            echo "<script>document.getElementById('error-msg').style.display = 'block';</script>";
        }
    } else {
        // Email não encontrado
        echo "<script>document.getElementById('error-msg').style.display = 'block';</script>";
    }

    // Fechar conexão com o banco de dados
    $stmt->close();
    $conn->close();
}

ob_end_flush(); // Envia o buffer de saída para o navegador
?>

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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url("https://i.ibb.co/zhc6vhZ/Site-Empresarial-Aplicativo-de-Tecnologia-Ousado-Roxo-e-Azul-escuro-5.png");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: flex-end; /* Centralizar horizontalmente */
            align-items: center; /* Centralizar verticalmente */
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
            margin-right: 240px; /* Aumentando a margem direita */
            margin-left: 40px; /* Reduzindo a margem esquerda */
        }
        /* Estilos para o formulário */
        form {
            padding: 20px; /* Reduzindo o padding interno */
        }
        /* Estilos para as etiquetas de rótulo */
        label {
            display: block;
            margin-bottom: 5px; /* Reduzindo a margem inferior */
            font-size: 16px;
            color: #fff;
        }
        /* Estilos para os campos de entrada */
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: calc(100% - 40px); /* Reduzindo a largura para compensar o padding do formulário */
            padding: 12px;
            margin-bottom: 10px; /* Reduzindo a margem inferior */
            border-radius: 25px; /* Borda mais arredondada */
            border: 1px solid #ffd700; /* Borda com 1px de espessura */
            font-size: 16px;
            box-sizing: border-box;
            transition: background-color 0.3s;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            outline: none; /* Remove a borda de foco */
        }
        /* Estilos para os campos de entrada quando focados ou hover */
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="submit"]:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        /* Estilos para o botão de envio */
        input[type="submit"] {
            cursor: pointer;
            background-color: #ffd700;
            color: #000;
            font-weight: bold; /* Texto em negrito */
            transition: background-color 0.3s;
            border-radius: 25px; /* Borda mais arredondada */
        }
        input[type="submit"]:hover {
            background-color: #ffcc00;
        }
        /* Estilos para o link de entrada */
        .form-wrapper p {
            text-align: center; /* Alinha o texto ao centro */
            margin-top: 10px;
            font-size: 14px;
            color: #fff;
        }
        .form-wrapper p a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
            margin-left: 5px;
            margin-right: 5px;
        }
        .form-wrapper p a:hover {
            text-decoration: underline;
        }
        /* Estilos para o título */
        h2 {
            text-align: center;
            margin-bottom: 10px; /* Reduzindo a margem inferior */
            color: #fff;
            font-size: 20px; /* Tamanho maior para o título */
            margin-top: 10px; /* Reduzindo a margem superior */
        }
        /* Estilos para a mensagem de erro */
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
            display: none; /* Inicialmente oculta */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Formulário de login -->
        <div id="login">
            <h2>Entrar</h2>
            <form id="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="login_email">E-mail:</label>
                <input type="email" id="login_email" name="login_email" required>

                <label for="login_senha">Senha:</label>
                <input type="password" id="login_senha" name="login_senha" required>

                <input type="submit" value="Entrar">
            </form>
            <p class="error-message" id="error-msg">Credenciais inválidas. Tente novamente ou <a href="registro.php">registre-se</a>.</p>
        </div>
        
        <!-- Link para a página de registro -->
        <div class="form-wrapper">
            <p>Não tem uma conta? <a href="registro.php">Registrar</a></p>
        </div>
        
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
            $email = mysqli_real_escape_string($conn, $_POST["login_email"]);
            $senha = mysqli_real_escape_string($conn, $_POST["login_senha"]);

            // Consulta SQL para verificar as credenciais do usuário
            $sql = "SELECT senha_hash FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Verificar a senha hash
                if (password_verify($senha, $row["senha_hash"])) {
                    // Credenciais corretas, o usuário está autenticado
                    echo "<script>window.location.href = 'dashboard.html';</script>";
                    exit; // Certifique-se de sair após o redirecionamento
                } else {
                    // Senha incorreta
                    echo "<script>document.getElementById('error-msg').style.display = 'block';</script>";
                }
            } else {
                // Email não encontrado
                echo "<script>document.getElementById('error-msg').style.display = 'block';</script>";
            }

            // Fechar conexão com o banco de dados
            $stmt->close();
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
                errorMsg.style.display = 'none';
            }
        }, 5000); // 5000 milissegundos = 5 segundos
    </script>
</body>
</html>
