let imageFile;

function loadFile(event) {
    imageFile = URL.createObjectURL(event.target.files[0]);
    document.getElementById('image').src = imageFile;
}

function updateColorDisplay() {
    const color = document.getElementById('colorInput').value;
    document.querySelector('.color-input').style.backgroundColor = color;
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        addResult();
    }
});

function addResult() {
    const text = document.getElementById('textInput').value;
    const color = document.getElementById('colorInput').value;

    if (!imageFile || !text || !color) return;

    const truncatedText = text.length > 15 ? text.slice(0, 15) + '...' : text;

    const resultContainer = document.getElementById('result');
    const resultItem = document.createElement('div');
    resultItem.className = 'result-item';
    resultItem.innerHTML = `
        <a href="animais.html">
            <img src="${imageFile}" alt="Imagem">
        </a>
        <div class="info">
            <p class="message">${truncatedText}</p>
            <div class="color-circle" style="background-color: ${color};"></div>
        </div>
        <hr class="divider"> <!-- Linha divisória adicionada aqui -->
    `;

    resultContainer.appendChild(resultItem);

    // Clear inputs after adding
    document.getElementById('textInput').value = '';
    document.getElementById('colorInput').value = '#000000';
    document.getElementById('image').src = '';
    imageFile = null;
}