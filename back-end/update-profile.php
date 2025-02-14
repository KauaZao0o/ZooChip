<?php
session_start();

// conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zoo_chip";

$conn = new mysqli($servername, $username, $password, $dbname);

// verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// pega o ID do usuário da sessão
$cliente_id = $_SESSION['user_id'];

// verifica se os dados foram enviados corretamente
if (isset($_POST['editEmpresa'], $_POST['editEmail'], $_POST['editEndereco'])) {
    $nome = $_POST['editEmpresa'];
    $email = $_POST['editEmail'];
    $endereco = $_POST['editEndereco'];    

    // processa a imagem
    if (isset($_FILES['editImg']) && $_FILES['editImg']['error'] == 0) {
        $imagem_nome = $_FILES['editImg']['name'];
        $imagem_tmp = $_FILES['editImg']['tmp_name'];
        $imagem_destino = "../assets/img/" . basename($imagem_nome);

        // move a imagem para o diretório de uploads
        if (move_uploaded_file($imagem_tmp, $imagem_destino)) {

        } else {
            $imagem_destino = ""; // caso não tenha imagem
        }
    } else {
        $imagem_destino = ""; // caso não tenha imagem
    }

    // prepara a consulta SQL para atualizar o perfil
    $query = "UPDATE cliente SET nome = ?, email = ?, endereco = ?, imagem = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $nome, $email, $endereco, $imagem_destino, $cliente_id);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Perfil atualizado com sucesso.",
            "nome" => $nome,
            "email" => $email,
            "endereco" => $endereco,
            "imagem" => $imagem_destino
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Erro ao atualizar o perfil."
        ]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Dados incompletos."]);
}

$conn->close();
?>
