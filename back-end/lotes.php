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

    // verifica se o formulário foi submetido para adicionar um novo lote
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lote_nome'])) {
        $lote_nome = $_POST['lote_nome'];

        // lógica para fazer o upload da imagem (se estiver presente)
        if (isset($_FILES['lote_imagem']) && $_FILES['lote_imagem']['error'] == 0) {
            $imagem_nome = $_FILES['lote_imagem']['name'];
            $imagem_tmp = $_FILES['lote_imagem']['tmp_name'];
            $imagem_destino = "../assets/img/" . $imagem_nome;

            // move a imagem para o diretório de uploads
            move_uploaded_file($imagem_tmp, $imagem_destino);
        } else {
            $imagem_destino = ""; // caso não tenha imagem
        }

        // insere o novo lote no banco de dados
        $query = "INSERT INTO lotes (client_id, lote, imagem) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $cliente_id, $lote_nome, $imagem_destino);
        $stmt->execute();
    }

    // consulta para obter os lotes do cliente
    $query = "SELECT id, lote, imagem FROM lotes WHERE client_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // lotes cadastrados
    $lotes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $lotes[] = $row;
        }
    }

    // fecha a conexão
    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/ZooChip - logo.png" type="image/x-icon">
    <title>Lotes</title>
</head>
<body>
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
                    <a href="profile.php">
                        <img src="../assets/img/Foto de perfil - icone.png" alt="Foto de Perfil da Empresa">
                        <h1>Perfil</h1>
                    </a>
                </li>
            </ul>
        </aside>
    </nav>

    <!-- Principal -->
    <main>
        <section class="mapaLote">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.820044712544!2d-43.2093855!3d-19.934786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9ddf727838a4aeb%3C%2Fspan%20!2sBelo+Horizonte%2C+MG!5e0!3m2!1spt-BR!2sbr!6m0!8u2" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </section>
    </main>

    <!-- Aba verde -->
    <div class="right-sidebarLote">
        <div class="content">
            <div class="content-textLote">Lotes</div>

            <!-- Formulário para adicionar novo lote -->
            <div class="containerLote">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="circle" onclick="document.getElementById('upload').click();">
                        <input type="file" id="upload" name="lote_imagem" accept="image/*" onchange="loadFile(event)">
                        <img id="image" src="" alt="Imagem">
                    </div>
                    <input type="text" class="text-input" id="textInput" name="lote_nome" placeholder="Adicionar lote" required>
                    <button type="submit" class="submit-button">Adicionar Lote</button>
                </form>
            </div>

            <!-- Exibe os lotes cadastrados -->
            <div class="lotes-cadastrados">
                <h3>Seus Lotes</h3>
                <?php if (!empty($lotes)) : ?>
                    <ul>
                        <?php foreach ($lotes as $lote) : ?>
                            <li>
                                <a href="animais_lote.php?lote_id=<?php echo htmlspecialchars($lote['id']); ?>">
                                    <p><?php echo htmlspecialchars($lote['lote']); ?></p>
                                    <?php if (!empty($lote['imagem'])) : ?>
                                        <img src="<?php echo htmlspecialchars($lote['imagem']); ?>" alt="Imagem do lote" width="100">
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>Nenhum lote cadastrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

<script src="../assets/script/adicionar_lote.js"></script>

</body>
</html>
