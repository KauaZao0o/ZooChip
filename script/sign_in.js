document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita o envio padrão do formulário

    // Aqui você pode adicionar uma lógica de registro ou qualquer outro processamento

    // Redireciona para outra página após o registro
    window.location.href =   "../pages/sign_in.html"; // Substitua pelo link da página de destino
  });