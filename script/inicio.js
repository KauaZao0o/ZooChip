document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita o envio padrão do formulário

    // Aqui você pode adicionar uma lógica de autenticação ou qualquer outro processamento

    // Redireciona para outra página
    window.location.href = "../home-menu/inicio.html"; // Substitua pelo link da página de destino
  });