// Função para alternar entre o formulário de registro e o formulário de login
function alternarFormularios() {
    var registroForm = document.getElementById('registro');
    var loginForm = document.getElementById('login');

    // Verifica se o formulário de registro está visível
    if (registroForm.style.display !== 'none') {
        // Oculta o formulário de registro e exibe o formulário de login
        registroForm.style.display = 'none';
        loginForm.style.display = 'block';
    } else {
        // Oculta o formulário de login e exibe o formulário de registro
        loginForm.style.display = 'none';
        registroForm.style.display = 'block';
    }
}

// Adiciona um ouvinte de evento para o link "Entrar"
document.getElementById('mostrarLogin').addEventListener('click', function(event) {
    event.preventDefault(); // Evita que o link recarregue a página
    alternarFormularios();
});

// Adiciona um ouvinte de evento para o link "Registrar"
document.getElementById('mostrarRegistro').addEventListener('click', function(event) {
    event.preventDefault(); // Evita que o link recarregue a página
    alternarFormularios();
});
