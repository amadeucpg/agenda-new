
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agenda de Contatos</title>
  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css"
    integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g=="
    crossorigin="anonymous" />
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
    crossorigin="anonymous" />
  <!-- CSS -->
  <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
</head>
<?php
include_once("config/url.php");
//include_once("config/process.php");

// limpa a mensagem
if (isset($_SESSION['msg'])) {
  $printMsg = $_SESSION['msg'];
  $_SESSION['msg'] = '';
}
?>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="index.php">
        <img src="<?= $BASE_URL ?>img/logo.svg" alt="Agenda">
      </a>
      <div>
        <div class="navbar-nav">
          <a class="nav-link active" href="<?= $BASE_URL ?>create.php">Adicionar Contato</a>
          <form name="busca" action="processar_pesquisa.php" method="POST" id="search-form" class="form-inline my-2 my-lg-0">            
            <input type="text" id="termo" name="termo" class="form-control mr-sm-2" placeholder="Pesquisar Contatos" aria-label="Search">
            <button class="btn my-2 my-sm-0" type="submit" name="pesquisar" value="Pesquisar">
              <i class="fas fa-search"></i>
            </button>
          </form>
          
        </div>
      </div>
    </nav>
  </header>

<?php
include_once("templates/back.html");
// Arquivo: processar_pesquisa.php

// 1. Conexão com o banco de dados (use PDO ou MySQLi para melhor segurança)
// Exemplo com MySQLi:
$hostname = "localhost"; // Host do banco de dados
$username = "amadeu"; // Usuário do banco de dados
$password = "96812569"; // Senha do banco de dados
$database = "agenda"; // Nome do banco de dados

$conexao = mysqli_connect($hostname, $username, $password, $database) or die ("Erro ao conectar ao banco de dados");
// Fim da conexão com o banco de dados
// 2. Obter o termo de pesquisa do formulário
if (isset($_POST['pesquisar'])) { // Verifica se o botão "Pesquisar" foi clicado
    $termo = mysqli_real_escape_string($conexao, $_POST['termo']); // Pega o valor do input 'termo' e sanitiza

    // 3. Consulta SQL para buscar os dados
    $sql = "SELECT id, name, phone FROM contacts WHERE name LIKE '" . $termo . "%'"; // Altere 'nome' e 'sua_tabela' para seus campos e tabela
    $resultado = mysqli_query($conexao, $sql);

    // 4. Exibir os resultados
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo "<h1 id='main-title'>Resultados da Pesquisa</h1>";
        echo "<table class='table' id='contacts-table'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Phone</th></tr>";
        while ($linha = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $linha['id'] . "</td>";
            echo "<td>" . $linha['name'] . "</td>";
            echo "<td>" . $linha['phone'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum resultado encontrado para o termo: " . htmlspecialchars($termo); // Use htmlspecialchars para exibir o termo buscado sem problemas de segurança
    }
} else {
    echo "Acesso inválido.";
}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);

?>