<?php
include_once("templates/header.php");
?>
<a href="search.php">search</a>
<div class="container">
  <?php if (isset($printMsg) && $printMsg != ''): ?>
    <p id="msg"><?= $printMsg ?></p>
  <?php endif; ?>
  <h1 id="main-title">Minha Nova Agenda</h1>
  <?php if (count($contacts) > 0): ?>
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
      <tbody>
        <?php foreach ($contacts as $contact): ?>
          <tr>
            <td scope="row" class="col-id"><?= $contact["id"] ?></td>
            <td scope="row"><?= $contact["name"] ?></td>
            <td scope="row"><?= $contact["phone"] ?></td>
            <td scope="row"><?= $contact["tipo"] ?></td>
            <td class="actions">
              <a href="<?= $BASE_URL ?>show.php?id=<?= $contact["id"] ?>"><i class="fas fa-eye check-icon"></i></a>
              <a href="<?= $BASE_URL ?>edit.php?id=<?= $contact["id"] ?>"><i class="far fa-edit edit-icon"></i></a>
              <form class="delete-form" action="<?= $BASE_URL ?>/config/process.php" method="POST">
                <input type="hidden" name="type" value="delete">
                <input type="hidden" name="id" value="<?= $contact["id"] ?>">
                <button type="submit" class="delete-btn" onclick="return confirmarAcao()"><i class="fas fa-times delete-icon"></i></button>
              </form>
              <?php $nome = $contact["name"];?>
              <script>
                function confirmarAcao() {
                  let nome= "<?=$contact["name"]; ?>";
                  console.log(nome);
                  // A função confirm() exibe a caixa de diálogo de confirmação.
                  // Se o usuário clicar em "OK", retorna true, e o formulário é enviado.
                  // Se o usuário clicar em "Cancelar", retorna false, e o formulário não é enviado.                  
                  return confirm("Tem certeza que deseja deletar eeste contato?");
                }
              </script>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p id="empty-list-text">Ainda não há contatos na sua agenda, <a href="<?= $BASE_URL ?>create.php">clique aqui para
        adicionar</a>.</p>
  <?php endif; ?>
</div>
<?php
include_once("templates/footer.php");
?>