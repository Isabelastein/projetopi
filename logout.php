<?php
// Inicia a sessão (se ainda não estiver iniciada)
if (!isset($_SESSION)) {
    session_start();
}

// Destroi a sessão
session_destroy();

// Redireciona para a página de login
header("Location: login.php");
exit; // Certifique-se de sair após o redirecionamento
?>
