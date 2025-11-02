<?php
session_start();

include_once("connection.php");
include_once("url.php");

//tabela pra preecher combo tipo
$tabelatipos = [];
$query = "SELECT * FROM tipo";
$stmt = $conn->prepare($query);
$stmt->execute();
$tabelatipos = $stmt->fetchAll();

$data = $_POST;


if (!empty($data)) {     

    if ($data["type"] === "create") { //CRIAR CONTATOS
        $name = $data["name"];
        $tipo = $data["tipo"];
        $phone = $data["phone"];
        $observations = $data["observations"];

        $query = "INSERT INTO contacts(name,tipo, phone,observations) VALUES (:name,:tipo, :phone, :observations) ";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);
        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato criado com sucesso.";
        } catch (PDOException $e) {
            $error = $e->getMessage();
            echo "Erro: .$error.";
        }
    } else if ($data["type"] === "edit") {
        $name = $data["name"];
        $tipo = $data["tipo"];
        $phone = $data["phone"];
        $observations = $data["observations"];
        $id = $data["id"];

        $query = "UPDATE contacts SET name = :name, tipo = :tipo, phone = :phone, observations = :observations 
                    WHERE id = :id";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato atualizado com sucesso.";
        } catch (PDOException $e) {
            $error = $e->getMessage();
            echo "Erro: .$error.";
        }
    } else if ($data["type"] === "delete") {

        $id = $data["id"];

        $query = "DELETE FROM contacts WHERE id=:id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $id);
        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato excluido com sucesso.";
        } catch (PDOException $e) {
            $error = $e->getMessage();
            echo "Erro: .$error.";
        }
    } 
    //direciona para o index
    header("location:" . $BASE_URL . "../index.php");
} else {

    $id;    

    if (!empty($_GET)) {
        $id = $_GET["id"];        
    }

    if (!empty($id)) { //REGISTRO INDIVIDUAL 
        $query = "call `find-contacts`(:id)";       
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $contact = $stmt->fetch();
    } else {  //TODOS OS REGISTROS
        $contacts = [];
        $query = "call `list-contacts`()";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $contacts = $stmt->fetchAll();
    }
}
//fecha a conexção
$conn = null;
    