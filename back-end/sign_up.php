<?php
  // conexão com o banco de dados
  $servername = "localhost"; // servidor
  $username = "root"; // usuário do MySQL
  $password = ""; // senha do MySQL
  $dbname = "zoo_chip"; // nome do banco de dados

  // criando a conexão
  $conn = new mysqli($servername, $username, $password, $dbname);

  // verificando a conexão - se não conectar mostrar:
  if ($conn->connect_error) {
      die("Erro: " . $conn->connect_error);
  }

  // verificando se o formulário foi enviado
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // obtendo os dados do formulário
      $nome = htmlspecialchars($_POST['nome']);
      $registro = htmlspecialchars($_POST['registro']);
      $endereco = htmlspecialchars($_POST['endereco']);
      $email = htmlspecialchars($_POST['email']);
      $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // criptografando a senha

      // inserindo os dados no banco de dados
      $sql = "INSERT INTO cliente (nome, registro, endereco, email, senha) VALUES ('$nome', '$registro', '$endereco', '$email', '$senha')";

      if ($conn->query($sql) == TRUE) {        
          echo "Cadastro realizado com sucesso!";
      } else {
          // exibir o erro SQL - se não foi possível fazer o insert:
          echo "Erro: " . $sql . "<br>" . $conn->error;
      }
  }

  // Fechando a conexão
  $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/ZooChip - logo.png" type="image/x-icon">
    <title>Cadastrar</title>
</head>
<body>
  <script>
    // função para enviar o formulário via AJAX
    function enviarFormulario(event) {
      event.preventDefault();  // impede o envio padrão do formulário

      // pega os dados do formulário
      var formData = new FormData(document.getElementById("registerForm"));

      // envia os dados via AJAX
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "", true);  // envia para a mesma página
      xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);  // para depuração
            
            // verifica a resposta do servidor e redireciona se o cadastro for bem-sucedido
            if (xhr.responseText.includes("Cadastro realizado com sucesso!")) {
              window.location.href = "sign_in.php";  // redireciona para a página de login
            } else {
              // Exibe a resposta do PHP caso tenha ocorrido um erro
              document.getElementById("resultado").innerHTML = xhr.responseText;
            }
        } else {
          document.getElementById("resultado").innerHTML = "Erro ao enviar o formulário.";
        }
      };
      xhr.onerror = function () {
        console.log("Erro na requisição AJAX.");  // depuração de erro
      };
      xhr.send(formData);  // envia o formulário
    }
  </script>

    <!-- Navbar -->
    <nav>
      <section class="nav-content">
        <figure class="nav-logo">
          <a href="../index.html"><img src="../img/ZooChip - logo.png" alt=""></a>
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
          <script src="../script/script.js"></script>
      </section>

      <aside class="aside-links">
        <ul>
          <li><a href="sign_in.php" id="sign_in">Sign in</a></li>
          <li><a href="sign_up.php" id="sign_up">Sign up</a></li>
        </ul>
      </aside>
    </nav>

    <main class="container">
      <div class="register-container">
        <h2>Cadastrar</h2>
        <form id="registerForm" onsubmit="enviarFormulario(event)">
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome" required>
            </div>
            <div class="input-group">
                <label for="registro">CPF/CNPJ:</label>
                <input type="text" id="registro" name="registro" maxlength="14" placeholder="CPF/CNPJ" required>
            </div>
            <div class="input-group">
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" placeholder="Endereço" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
            </div>
            <input type="submit" value="Crie sua conta" class="button">
        </form>        
        
        <div class="links-register">
            <a href="sign_in.php" id="registerLink">Já tem uma conta? Entrar</a>
        </div>
      </div>
    </main>

</body>
</html>