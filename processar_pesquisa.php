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
include_once("config/connection.php");


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

    // Arquivo: processar_pesquisa.php
    
    // 2. Obter o termo de pesquisa do formulário
    if (isset($_POST['pesquisar'])) { // Verifica se o botão "Pesquisar" foi clicado
        $termo = mysqli_real_escape_string($conexao, $_POST['termo']); // Pega o valor do input 'termo' e sanitiza

        // 3. Consulta SQL para buscar os dados
        $sql = "SELECT * FROM contacts WHERE name LIKE '" . $termo . "%'"; // Altere 'nome' e 'sua_tabela' para seus campos e tabela
        $resultado = mysqli_query($conexao, $sql);

        //novo
        if ($resultado && mysqli_num_rows($resultado) > 0) { ?>
            <table class="table" id="contacts-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">tipo</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php }

            // 4. Exibir os resultados
            if ($resultado && mysqli_num_rows($resultado) > 0) {
                echo "<h1 id='main-title'>Resultados da Pesquisa</h1>";
                echo "<h6 id='main-title'> Contatos iniciados com  '$termo' </h6>";

                while ($linha = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td scope="row" class="col-id"><?= $linha["id"] ?></td>
                        <td scope="row"><?= $linha["name"] ?></td>
                        <td scope="row"><?= $linha["phone"] ?></td>
                        <td scope="row"><?= $linha["tipo"] ?></td>
                        <td class="actions">
                            <a href="<?= $BASE_URL ?>show.php?id=<?= $linha["id"] ?>"><i class="fas fa-eye check-icon"></i></a>
                            <a href="<?= $BASE_URL ?>edit.php?id=<?= $linha["id"] ?>"><i class="far fa-edit edit-icon"></i></a>
                            <form class="delete-form" action="<?= $BASE_URL ?>/config/process.php" method="POST">
                                <input type="hidden" name="type" value="delete">
                                <input type="hidden" name="id" value="<?= $linha["id"] ?>">
                                <button type="submit" class="delete-btn" onclick="return confirmarAcao()"><i class="fas fa-times delete-icon"></i></button>
                            </form>
                            <?php $nome = $linha["name"]; ?>
                            <script>
                                function confirmarAcao() {
                                    let nome = "<?= $linha["name"]; ?>";
                                    console.log(nome);
                                    // A função confirm() exibe a caixa de diálogo de confirmação.
                                    // Se o usuário clicar em "OK", retorna true, e o formulário é enviado.
                                    // Se o usuário clicar em "Cancelar", retorna false, e o formulário não é enviado.                  
                                    return confirm("Tem certeza que deseja deletar eeste contato?");
                                }
                            </script>
                        </td>
                    </tr>
        <?php }
                echo "</table>";
            } else {
                echo "Nenhum resultado encontrado para o termo: " . htmlspecialchars($termo); // Use htmlspecialchars para exibir o termo buscado sem problemas de segurança
            }
        } else {
            echo "Acesso inválido.";
        }

        // Fechar a conexão com o banco de dados
        mysqli_close($conexao);

        include_once("templates/footer.php");

        ?>