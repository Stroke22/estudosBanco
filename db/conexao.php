<?php
$servidor="localhost";
$usuario="root";
$senha="";
$banco="primeiro_banco";

$pdo = new PDO("mysql:host=$servidor; dbname=$banco",$usuario,$senha); 


//FUNÇAO PARA SANITIZAR(LIMPAR ENTRADAS)
function limparPost($dado){
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}


?>