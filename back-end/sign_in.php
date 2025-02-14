<?php
  session_start();

  // conexão com o banco de dados
  $servername = "localhost"; // servidor
  $username = "root"; // usuário
  $password = ""; // senha
  $dbname = "zoo_chip"; // banco de dados

  // criando a conexão
  $conn = new mysqli($servername, $username, $password, $dbname);

  // verificando a conexão -- se erro na conexão, exibir
  if ($conn->connect_error) {
      die("Erro: " . $conn->connect_error);
  }

  // verificando se o formulário foi enviado
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $registro = $_POST['registro'];
      $senha = $_POST['senha'];

      // preparando a consulta para evitar SQLi
      $sql = "SELECT * FROM cliente WHERE registro = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $registro);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          // se usuário encontrado, verificar a senha
          $row = $result->fetch_assoc();
          if (password_verify($senha, $row['senha'])) {
              // armazenando o ID e o nome do usuário na sessão
              $_SESSION['user_id'] = $row['id'];
              $_SESSION['user_name'] = $row['nome'];

              // direcionando para a página inicial
              header("Location: ../home-menu/inicio.html");
              exit();  
          } else {
              echo "Senha incorreta. Tente novamente.";
          }
      } else {
          echo "Nenhuma conta encontrada com este registro.";
      }

      $stmt->close();
  }

  // fechando a conexão
  $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/ZooChip - logo.png" type="image/x-icon">
    <title>Entrar</title>
</head>
<body>

  <script>
    // função para enviar o formulário via AJAX
    document.getElementById("loginForm").addEventListener("submit", function(event) {
      event.preventDefault(); // evita o envio tradicional do formulário
      const formData = new FormData(this);

      fetch('../back-end/sign_in.php', {
          method: 'POST',
          body: formData
      })
      .then(response => response.text()) // recebe a resposta como txt
      .then(data => {
        alert(data.message); // exibe a resposta num alerta
      })
      .catch(error => console.error('Erro:', error));
    });
  </script>

    <!-- Navbar -->
    <nav>
      <section class="nav-content">
        <figure class="nav-logo">
          <a href="../index.html"><img src="../assets/img/ZooChip - logo.png" alt=""></a>
        </figure>
        <div class="mobile-menu">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
        <section>
          <ul class="links">
            <li class="link"><a href="../pages/chips.html">Chips</a></li>
            <li class="link"><a href="../pages/about.html">Sobre nós</a></li>
            <li class="link"><a href="contacts.php">Contatos</a></li>
          </ul>
        </section>
        <!-- barra hamburguer -->
        <script src="../assets/script/script.js"></script>
      </section>

      <aside class="aside-links">
        <ul>
          <li><a href="sign_in.php" id="sign_in">Sign in</a></li>
          <li><a href="sign_up.php" id="sign_up">Sign up</a></li>
        </ul>
      </aside>
    </nav>

    <main class="container">
      <div class="login-container">
        <h2>Entrar</h2>
          <form id="loginForm" method="POST">
              <div class="input-group">
                  <label for="registro"></label>
                  <input type="text" id="registro" name="registro" maxlength="14" placeholder="CPF/CNPJ" required>                  
              </div>
              <div class="input-group">
                <label for="senha"></label>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
              </div>  
              <input type="submit" value="Entre na sua conta" class="button">
          </form>
        <div class="links-login">
          <a href="#" id="forgotPasswordLink">Esqueci minha senha</a>
          <a href="sign_up.php" id="registerLink">Não tem uma conta? Registre-se</a>
        </div>
      </div>

    </main>
</body>
</html>
