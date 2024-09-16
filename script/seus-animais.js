
function localizar() {
    alert("Animal foi localizado.");
}


function toggleEdit() {
    const editSection = document.querySelector('.edit-section');
    const infoSection = document.querySelector('.info-section');
    const isEditing = editSection.style.display === 'block';

    editSection.style.display = isEditing ? 'none' : 'block';
    infoSection.style.display = isEditing ? 'block' : 'none';

    if (!isEditing) {
        // document.getElementById('editId').value = document.getElementById('id').textContent;
        // document.getElementById('editLote').value = document.getElementById('lote').textContent;
        document.getElementById('editIdade').value = document.getElementById('idade').textContent;
        document.getElementById('editRaca').value = document.getElementById('raca').textContent;
        document.getElementById('editOrigem').value = document.getElementById('origem').textContent;
        document.getElementById('editUltimaPesagem').value = document.getElementById('ultimapesagem').textContent;
        document.getElementById('editEspecificacao').value = document.getElementById('especificacao').textContent;
    }
}

function saveChanges() {
    // const id = document.getElementById('editId').value;
    // const lote = document.getElementById('editLote').value;
    const idade = document.getElementById('editIdade').value;
    const raca = document.getElementById('editRaca').value;
    const origem = document.getElementById('editOrigem').value;
    const ultimapesagem = document.getElementById('editUltimaPesagem').value;
    const especificacao = document.getElementById('editEspecificacao').value;


    // document.getElementById('id').textContent = id;
    // document.getElementById('lote').textContent = lote;
    document.getElementById('idade').textContent = idade;
    document.getElementById('raca').textContent = raca;
    document.getElementById('origem').textContent = origem;
    document.getElementById('ultimapesagem').textContent = ultimapesagem;
    document.getElementById('especificacao').textContent = especificacao;

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