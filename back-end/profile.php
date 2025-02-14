<?php
    session_start();

    // verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        // redireciona para a página de login caso não esteja logado
        header("Location: sign_in.php");
        exit();
    }

    // conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "zoo_chip";

    // criando a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // verificando a conexão
    if ($conn->connect_error) {
        die("Erro: " . $conn->connect_error);
    }

    // pega o ID do usuário da sessão
    $cliente_id = $_SESSION['user_id'];

    // consulta para obter os dados do cliente
    $query = "SELECT nome, email, endereco, imagem FROM cliente WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // verifica se o cliente foi encontrado
    if ($result->num_rows > 0) {
        // obtém os dados do cliente
        $cliente_info = $result->fetch_assoc();
        $_SESSION['user_name'] = $cliente_info['nome']; // garante que o nome esteja na sessão
    } else {
        echo "Dados não encontrados.";
        exit();
    }

    $fotoPerfil = !empty($cliente_info['imagem']) ? $cliente_info['imagem'] : '../assets/img/Foto de perfil - icone.png'; // Caminho da imagem padrão

    // fecha a conexão
    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../assets/img/ZooChip - logo.png" type="image/x-icon">
    <title>Perfil da Empresa</title>
</head>
<body class="bodyEnterprise">

    <!-- Navbar -->
    <nav>
        <section class="nav-content">
            <figure class="nav-logo">
                <a href="inicio.html"><img src="../assets/img/ZooChip - logo.png" alt=""></a>
            </figure>
        </section>

        <aside class="aside-perfil">
            <ul>
                <li>
                    <a href="#">
                        <img src="../assets/img/Foto de perfil - icone.png" alt="Foto de Perfil da Empresa">
                        <h1><?php echo htmlspecialchars($_SESSION['user_name']); ?></h1> <!-- exibe o nome da empresa -->
                    </a>
                </li>
            </ul>
        </aside>
    </nav>

    <!-- Principal -->
    <div class="outer-containerEnterprise">
        <!-- Seção para ações -->
        <div class="left-sectionEnterprise">
            <div class="actionsEnterprise">
                <div class="profile-img-wrapper">
                    <div class="profile-img-circle no-click" id="profileImgMainCircle">
                        <img id="profileImg" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" class="profile-img">                        
                    </div>
                </div>
                <button class="buttonEnterprise" onclick="desconectar()">Desconectar</button>
                <button class="buttonEnterprise" onclick="excluir()">Excluir</button>
            </div>
        </div>

        <!-- Container verde para informações -->
        <div class="containerEnterprise">
            <!-- Seção de informações da conta -->
            <div class="info-section">
                <div class="account-details">
                    <p>Nome: <span id="empresa"><?php echo htmlspecialchars($cliente_info['nome']); ?></span></p>
                    <p>Email: <span id="email"><?php echo htmlspecialchars($cliente_info['email']); ?></span></p>                    
                    <p>Endereço: <span id="endereco"><?php echo htmlspecialchars($cliente_info['endereco']); ?></span></p>
                </div>
                <button class="buttonEnterprise" onclick="toggleEdit()">Editar</button>
            </div>

            <!-- Formulário de edição do perfil -->
            <div class="edit-section" style="display: none;">
                <form class="forms" id="editForm">
                <div class="profile-img-wrapper">
                        <div class="profile-img-circle clickable" onclick="document.getElementById('editImg').click();">
                            <img id="profileImg" src="" alt="Foto de Perfil" class="profile-img" style="display: none;">
                            <span id="editNoImageText">Clique para adicionar uma foto</span>
                        </div>
                    </div>
                    <input type="file" id="editImg" name="editImg" accept="image/*" style="display: none;" onchange="previewImage(event)">
                    <div class="form-groupEnterprise">
                        <label for="editEmpresa">Nome:</label>
                        <input type="text" id="editEmpresa" name="editEmpresa" value="<?php echo htmlspecialchars($cliente_info['nome']); ?>">
                    </div>
                    <div class="form-groupEnterprise">
                        <label for="editEmail">Email:</label>
                        <input type="email" id="editEmail" name="editEmail" value="<?php echo htmlspecialchars($cliente_info['email']); ?>">
                    </div>
                    <div class="form-groupEnterprise">
                        <label for="editEndereco">Endereço:</label>
                        <input type="text" id="editEndereco" name="editEndereco" value="<?php echo htmlspecialchars($cliente_info['endereco']); ?>">
                    </div>
                    <button class="buttonEnterprise" type="button" onclick="saveChanges()">Salvar</button>
                    <button class="buttonEnterprise" type="button" onclick="toggleEdit()">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function desconectar() {
            // excluir dados de sessão armazenados 
            sessionStorage.removeItem('user_id');              

            // redirecionar o usuário para a página de login ou home
            window.location.href = 'sign_in.php';
        }

        function excluir() {
            // confirmar se o usuário realmente deseja excluir a conta
            if (confirm("Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.")) {
                // chamar o script PHP de exclusão
                fetch('delete-profile.php', {
                    method: 'POST'
                })
                .then(response => response.json()) // pega a resposta JSON - do php
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message);
                        // redireciona o usuário para a página de cadastro
                        window.location.href = 'sign_up.php';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
            }
        }

        function toggleEdit() {
            const editSection = document.querySelector('.edit-section');
            const infoSection = document.querySelector('.info-section');
            if (editSection.style.display === 'none') {
                editSection.style.display = 'block';
                infoSection.style.display = 'none';
            } else {
                editSection.style.display = 'none';
                infoSection.style.display = 'block';
            }
        }

        function saveChanges() {
            const formData = new FormData(document.getElementById("editForm"));

            fetch('update-profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())  
            .then(data => {
                if (data.status === "success") {
                    // atualiza diretamente os campos da tela
                    document.getElementById("empresa").textContent = data.nome;
                    document.getElementById("email").textContent = data.email;
                    document.getElementById("endereco").textContent = data.endereco;

                    // atualiza a imagem de perfil
                    if (data.imagem) {
                        document.getElementById("profileImg").src = data.imagem;
                        document.getElementById("profileImg").style.display = "block";
                        document.getElementById("editNoImageText").style.display = "none";
                    }

                    // alterna para o modo de exibição (oculta o formulário de edição)
                    toggleEdit();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        }

    </script>

</body>
</html>
