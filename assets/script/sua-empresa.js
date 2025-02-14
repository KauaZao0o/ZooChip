
function desconectar() {
    alert("Você foi desconectado.");
}

function excluir() {
    alert("Sua conta será excluída.");
}


function toggleEdit() {
    const editSection = document.querySelector('.edit-section');
    const infoSection = document.querySelector('.info-section');
    const isEditing = editSection.style.display === 'block';

    editSection.style.display = isEditing ? 'none' : 'block';
    infoSection.style.display = isEditing ? 'block' : 'none';

    if (!isEditing) {
        document.getElementById('editEmpresa').value = document.getElementById('empresa').textContent;
        document.getElementById('editEmail').value = document.getElementById('email').textContent;
        document.getElementById('editTelefone').value = document.getElementById('telefone').textContent;
        document.getElementById('editEndereco').value = document.getElementById('endereco').textContent;
    }
}

function saveChanges() {
    const empresa = document.getElementById('editEmpresa').value;
    const email = document.getElementById('editEmail').value;
    const telefone = document.getElementById('editTelefone').value;
    const endereco = document.getElementById('editEndereco').value;

    // Atualiza as informações exibidas
    document.getElementById('empresa').textContent = empresa;
    document.getElementById('email').textContent = email;
    document.getElementById('telefone').textContent = telefone;
    document.getElementById('endereco').textContent = endereco;

    const newImageSrc = document.getElementById('profileImg').src;
    if (newImageSrc) {
        document.getElementById('profileImgMainCircle').innerHTML = `<img src="${newImageSrc}" class="profile-img">`;
    }

    toggleEdit(); // Esconde a seção de edição e mostra a seção de informações
}

function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    
    reader.onload = function() {
        document.getElementById('profileImg').src = reader.result;
        document.getElementById('profileImg').style.display = 'block';
        document.getElementById('editNoImageText').style.display = 'none';
    }
    
    if (file) {
        reader.readAsDataURL(file);
    }
}

// Função para aplicar a máscara de telefone
function applyPhoneMask(input) {
    let value = input.value.replace(/\D/g, ""); // Remove qualquer coisa que não seja dígito
    if (value.length <= 10) {
        value = value.replace(/(\d{2})(\d{4})(\d+)/, "($1) $2-$3"); // Formato para 8 dígitos no número
    } else {
        value = value.replace(/(\d{2})(\d{5})(\d+)/, "($1) $2-$3"); // Formato para 9 dígitos no número
    }
    input.value = value;
}