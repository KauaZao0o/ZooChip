<?php
session_start();

// verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não está logado.']);
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
    echo json_encode(['status' => 'error', 'message' => 'Erro na conexão com o banco de dados.']);
    exit();
}

// pega o ID do usuário da sessão
$cliente_id = $_SESSION['user_id'];

// consulta para excluir o usuário
$query = "DELETE FROM cliente WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cliente_id);

// executa a exclusão
if ($stmt->execute()) {
    // encerra a sessão
    session_destroy();

    echo json_encode(['status' => 'success', 'message' => 'Conta excluída com sucesso.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir a conta.']);
}

// fecha a conexão
$stmt->close();
$conn->close();
?>