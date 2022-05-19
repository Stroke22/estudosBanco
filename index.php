<?php
require('db/conexao.php');



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserindo dados</title>


    <style>
        table{
            border-collapse: collapse;
            width:100%;
        }

        th,td{
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

    </style>
</head>
<body>
    
<h1> Estudos de Banco de Dados</h1>
    <form method="post">
        <input type="text" name="nome" placeholder="Digite seu nome" required>
        <input type="email" name="email" placeholder="Digite seu email" required>
        <button type="submit" name="salvar">Salvar</button> 

    </form>
    <br>
    <?php

        if (isset($_POST['salvar'])&& isset($_POST['nome'])&& isset($_POST['email'])){

            $nome = limparPost( $_POST['nome']);
            $email = limparPost( $_POST['email']);
            $data = date('d-m-Y');

            // VALIDAÇÃO DE CAMPO VAZIO
            if ($nome =="" || $nome ==null){
                echo "<b style='color:red'> Nome não pode ser vazio</b>";
                exit();
            }

            if ($email =="" || $email==null){
                echo "<b style='color:red'>Email não pode ser vazio </b>";
                exit();
            }
            
            //VALIDAÇÃO DE NOME E EMAIL
            
            if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
                echo  "<b style='color:red'>Somente permitido letras e espaços em branco para o nome! </b>";
                exit();
            }

            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo  "<b style='color:red'>Formato de email inválido</b>";
                exit();
            }

            $sql = $pdo->prepare("INSERT INTO clientes VALUES (null,?,?,?)");
            $sql->execute(array($nome,$email,$data));
            
            echo "<b style='color:green'>Cliente inserido com sucesso </b>";

        }

    ?>
    
    <?php

        // //COMANDO PARA ATUALIZAR/EDITAR NO BANCO DE DADOS

        // $nome = "Pedro";
        // $email = "pedrinho123@gmail.com";
        // $id = 1;

        // $sql = $pdo->prepare("UPDATE clientes SET nome=?, email=? WHERE id=?");
        // $sql->execute(array($nome,$email,$id));

        //MOSTRAR DADO ESPECÍFICO
        // $sql = $pdo->prepare("SELECT * FROM clientes WHERE email = ?");
        // $email = 'pintanguinha@hormai.com';
        // $sql->execute(array($email));
        // $dados = $sql->fetchAll();

        //SELECIONAR DADOS DA TABELA
        $sql = $pdo->prepare("SELECT * FROM clientes");
        $sql->execute();
        $dados = $sql->fetchAll();

    ?>

    <?php
    //VERIFICA SE TEM DADOS (ARRAY DADOS MAIOR QUE ZERO)
    if(count($dados)>0){

        //CONSTRÓI PARTE DE CIMA DA TABELA
        echo "<br><br><table>
        <tr>
            <th>ID</th>
            <th>nome</th>
            <th>email</th>
            <th>ações</th>
        </tr>";
       
        //LAÇO DE REPETIÇÃO PARA ADICIONAR LINHA
       foreach($dados as $chave => $valor){
           echo "<tr>
           <td>".$valor['id']."</td>
           <td>".$valor['nome']."</td>
           <td>".$valor['email']."</td>
           <td><a href= '#'>Atualizar </a></td>
       </tr>";

       }
       
       
       
        echo "</table>";

      
    }else{
        echo "<p>Nenhum cliente cadastrado</p>";
        
    }


    ?>
    
        
    




</body>
</html>