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

        .oculto{
            display:none;
        }

    </style>
</head>
<body>
    

<h1> Estudos de Banco de Dados</h1>
    <form id="form_salva" method="post">
        <input type="text" name="nome" placeholder="Digite seu nome" required>
        <input type="email" name="email" placeholder="Digite seu email" required>
        <button type="submit" name="salvar">Salvar</button> 

    </form>
    
    <form class="oculto" id="form_atualiza" method="post">
        <input type="hidden" id="id_editado" name="id_editado" placeholder="ID" required>
        <input type="text" id="nome_editado" name="nome_editado" placeholder="Editar nome" required>
        <input type="email" id="email_editado" name="email_editado" placeholder="Editar email" required>
        <button type="submit" name="atualizar">Atualizar</button> 
        <button type="submit" id="cancelar" name="cancelar">Cancelar</button> 
        

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
    // PROCESSO DE ATUALIZAÇÃO 
        if(isset($_POST['atualizar']) && isset($_POST['id_editado']) && isset($_POST['nome_editado']) && isset($_POST['email_editado'])){
            
            $id=limparPost( $_POST['id_editado']);
            $nome=limparPost( $_POST['nome_editado']);
            $email=limparPost( $_POST['email_editado']);

            
            // VALIDAÇÃO DE CAMPO VAZIO ATT
            if ($nome =="" || $nome ==null){
                echo "<b style='color:red'> Nome não pode ser vazio</b>";
                exit();
            }

            if ($email =="" || $email==null){
                echo "<b style='color:red'>Email não pode ser vazio </b>";
                exit();
            }
            
            //VALIDAÇÃO DE NOME E EMAIL ATT
            
            if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
                echo  "<b style='color:red'>Somente permitido letras e espaços em branco para o nome! </b>";
                exit();
            }

            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo  "<b style='color:red'>Formato de email inválido</b>";
                exit();
            }

            // COMANDO ATUALIZAR ATT
            $sql = $pdo->prepare("UPDATE clientes SET nome=?, email=? WHERE id=?");
            $sql->execute(array($nome,$email,$id));

            echo "Atualizado ".$sql->rowCount(). " registros!";

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
    //VERIFICA SE TEM DADOS (ARRAY DADOS MAIOR QUE ZERO) obs: não podem ser altarados

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
           <td><a href= '#' class='btn-atualizar' data-id='".$valor['id']."' data-nome='".$valor['nome']."' data-email='".$valor['email']."'>Atualizar </a></td>
       </tr>"; // cria um "botão" que puxa essas informações a cima para que possam ser alteradas futuramente 
               // CLASE PARA ESTILIZAÇÃO
       }
       
       
       
        echo "</table>";

      
    }else{
        echo "<p>Nenhum cliente cadastrado</p>";
        
    }


    ?>
    

     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
     <script>
         $(".btn-atualizar"). click(function(){
             var id = $(this).attr('data-id');
             var nome = $(this).attr('data-nome');
             var email = $(this).attr('data-email');

             $('#form_salva').addClass('oculto');
             $('#form_atualiza').removeClass('oculto');

             $("#id_editado").val(id);
             $("#nome_editado").val(nome);
             $("#email_editado").val(email);


          //   alert('O ID é: '+id+" | nome é: " +nome+ " | email é: "+email );
         });

             $('#cancelar').click(function(){
             $('#form_salva').removeClass('oculto');
             $('#form_atualiza').addClass('oculto');

         });
        
         
         /* LINK PARA PUXAR JQUERY
         THIS =  DO BOTÃO QUE FOR CLICADO
         DATA-ID É UM ATRIBUTO
         ALERT PARA TESTAR SE OS DADOS ESTÃO SENDO PUXADOS CORRETAMENTE
          
         */

    </script>
    




</body>
</html>