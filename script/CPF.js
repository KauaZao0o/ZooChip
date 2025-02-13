const cpfInput = document.getElementById('CPF');

cpfInput.addEventListener('input', function (e) {
    let value = cpfInput.value.replace(/\D/g, ''); // Remove tudo que não é dígito
    value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca o primeiro ponto
    value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca o segundo ponto
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Coloca o traço

    cpfInput.value = value; // Atualiza o valor do input
});

document.getElementById('cpfForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert(`CPF Enviado: ${cpfInput.value}`);
});