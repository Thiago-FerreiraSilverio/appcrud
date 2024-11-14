<?php
$servername = "localhost"; // ou o endereço do seu servidor
$username = "root"; // padrão do XAMPP
$password = "Root123"; // senha em branco
$dbname = "sistema"; // substitua pelo nome do seu banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>