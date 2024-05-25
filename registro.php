<?php
ob_start(); // Inicia o buffer de saída

// Inicialize a variável $erroRegistro
$erroRegistro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $servername = "localhost:3307"; // Servidor MySQL (ou MariaDB)
    $username = "root";
    $password = "ProjetoPI2425";
    $dbname = "form";

    // Criando a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificando a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Preparando os dados para inserção no banco de dados
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);

    // Verifica se a senha tem pelo menos 8 caracteres
    if (strlen($senha) < 8) {
        // Senha não atende aos requisitos
        $erroRegistro = "A senha deve ter pelo menos 8 caracteres.";
    } else {
        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Preparando a consulta SQL
        $sql = "INSERT INTO users (nome, email, senha_hash) VALUES ('$nome', '$email', '$senha_hash')";

        if ($conn->query($sql) === TRUE) {
            // Redireciona para a página de login
            header('Location: login.php');
            exit; // Encerra o script após o redirecionamento
        } else {
            $erroRegistro = "Erro: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fechar a conexão
    $conn->close();
}
ob_end_flush(); // Envia o buffer de saída para o navegador
?>
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
        input[type="text"],
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
        input[type="text"]:focus,
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
            display: <?php echo isset($erroRegistro) && $erroRegistro != "" ? 'block' : 'none'; ?>; /* Mostrar mensagem se houver erro */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Formulário de registro -->
        <div id="registro">
            <h2>Registrar Novo Usuário</h2>
            <form id="registro-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>

                <span id="erro-senha" class="error-message">A senha deve ter pelo menos 8 caracteres.</span>
                <input type="submit" value="Registrar">
            </form>
            <!-- Mensagem de erro -->
            <p class="error-message" id="erro-registro"><?php echo isset($erroRegistro) ? $erroRegistro : ''; ?></p>
        </div>
        
        <!-- Link para a página de login -->
        <div class="form-wrapper">
            <p style="margin-top: -20px;">Já tem uma conta? <a href="login.php">Entrar</a></p>
        </div>
    </div>
    <script>
        document.getElementById('registro-form').addEventListener('submit', function(event) {
            var senha = document.getElementById('senha').value;
            var erroSenha = document.getElementById('erro-senha');
            
            if (senha.length < 8) {
                erroSenha.style.display = 'block';
                event.preventDefault(); // Impede o envio do formulário
            } else {
                erroSenha.style.display = 'none';
            }
        });
    </script>
</body>
</html>
