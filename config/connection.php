<?php

$host="localhost";
$dbname= "agenda";
$user= "amadeu";
$pass= "96812569";

//conexao PDO
try{
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);


$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    $error=$e->getMessage();
    echo"Erro: .$error.";
}

//conexao msqli
$conexao = mysqli_connect($host, $user, $pass, $dbname) or die("Erro ao conectar ao banco de dados");

//conexao com sqlite
$db_file = 'sqlite/agenda.db';

try {
    // Tenta criar uma conexão PDO com o banco de dados SQLite
    $pdo = new PDO("sqlite:" . $db_file);

    // Define para que erros do PDO sejam lançados como exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "Conexão com SQLite estabelecida com sucesso!<br>";

    // Você pode executar suas consultas aqui, por exemplo:
    // $stmt = $pdo->query("SELECT 'Olá, mundo!'");
    // $row = $stmt->fetch();
    // echo $row[0];

} catch (PDOException $e) {
    // Captura qualquer erro de conexão e o exibe
    echo "Erro na conexão com o SQLite: " . $e->getMessage();
}