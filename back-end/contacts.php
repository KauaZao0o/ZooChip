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
      $email = htmlspecialchars($_POST['email']);
      $telefone = htmlspecialchars($_POST['telefone']);
      $mensagem = htmlspecialchars($_POST['mensagem']);      

      // inserindo os dados no banco de dados
      $sql = "INSERT INTO mensagem (nome, email, telefone, mensagem) VALUES ('$nome', '$email', '$telefone', '$mensagem')";

      if ($conn->query($sql) == TRUE) {        
          echo "Mensagem enviada com sucesso!";
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/ZooChip - logo.png" type="image/x-icon">
    <title>Contatos</title>
</head>
<body>
  <script>
    // função para enviar o formulário via AJAX
    function enviarFormulario(event) {
      event.preventDefault();  // impede o envio padrão do formulário

      // pega os dados do formulário
      var formData = new FormData(document.getElementById("registerMensage"));

      // envia os dados via AJAX
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "", true);  // envia para a mesma página
      xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);  // para depuração
            
            // verifica a resposta do servidor e redireciona se o cadastro for bem-sucedido
            if (xhr.responseText.includes("Mensagem enviada com sucesso!")) {
              window.location.href = "contacts.php";  // refresh
            } else {
              // Exibe a resposta do PHP caso tenha ocorrido um erro
              document.getElementById("resultado").innerHTML = xhr.responseText;
            }
        } else {
          document.getElementById("resultado").innerHTML = "Erro ao enviar a mensagem.";
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

    <main class="container3">
        <section class="content3">
          <article class="content3-text">

            <form id="registerMensage" onsubmit="enviarFormulario(event)" action="../back-end/form-contacts.php" method="post">
                <label for="nome">Nome:</label><br>
                <input type="text" id="nome" name="nome" required><br><br>
        
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email" required><br><br>
        
                <label for="telefone">Telefone:</label><br>
                <input type="tel" id="telefone" name="telefone"><br><br>
        
                <label for="mensagem">Mensagem:</label><br>
                <textarea id="mensagem" name="mensagem" rows="5" cols="30" required></textarea><br><br>
        
                <input type="submit" class="button3" value="Enviar">
            </form>

          </article>
        </section>

      <section class="img-content3">
        <figure>
          <img class="img-size3" src="../assets/img/zoochip2024_qr.png" alt="Imagem">         
        </figure>
      </section>

    </main>

      <!-- Final do Centro do Index (Cor Verde)-->
  <footer class="rodape">

    <div class="rodape-div">
      <div class="rodape-div-1">
          <div class="rodape-div-1-coluna">
              <!-- elemento -->
              <span>Links</span>
              <p><a href="../index.html">Início</a></p>
              <p><a href="../pages/chips.html">Chips</a></p>
              <p><a href="../pages/about.html">Sobre Nós</a></p>
              <p><a href="contacts.php">Contatos</a></p>
          </div>
      </div>

      <div class="rodape-div-2">
          <div class="rodape-div-2-coluna">
              <!-- elemento -->
              <span>Contate-nos</span>
                <article class="icon-rodape">
                  <p><img src="../assets/img/Instagram - icon.png" alt="icon de instagram"><a href="https://www.instagram.com/zoochip2024/" target="_blank"> zoochip2024</a></p>
                  <p><img src="../assets/img/Email - icon.png" alt="icon de email"> ZooChip2024@gmail.com</p>
              </article>
          </div>
      </div>
      
      <div class="rodape-div-3">
        <div class="rodape-div-3-coluna">            
            <!-- elemento -->
              <figure>
                <img class="img-size" src="../assets/img/Footer - logo.png" alt="Imagem">         
              </figure>
        </div>
    </div>
</div>

<!-- Rodapé do Index (Cor Preta)-->

  <p class="rodape-direitos">Copyright &copy; 2024 ZooChip All right reserved</p>
</footer>


</body>
</html>