<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>BD2 - Log</title>
</head>
<body>
    <?php
        // referencia o arquivo de conexão com o banco
        require_once('conn.php');

        // pega os dados do arquivo json passado pelo formulário
        $json = file_get_contents($_FILES["file"]["tmp_name"]);
        // pega o nome do arquivo json passado pelo formulário
        $nome = $_FILES["file"]["name"];
        // decodifica o json
        $data = json_decode($json);
        
        // recupera/separa os arrays do json
        $id = $data->INITIAL->id;
        $A = $data->INITIAL->A;
        $B = $data->INITIAL->B;
        $i = 0;
        // exibe o nome do arquivo
        echo "Nome do Arquivo: ".$nome."<br>";
        // apaga os dados existentes no banco ("zera" os dados do banco)
        if($result = mysqli_query($conn, "DELETE FROM log WHERE 1;")){
            echo "Dados do Banco apagados!<br>";
        }else{
            echo "Falha ao apagar Dados do Banco:<br>".mysqli_error($conn);
        }
        // percorre os arrays inserindo os dados na tabela do banco
        $error = FALSE;
        foreach($id as $key){
            echo "ID = ".$id[$i]." | A=".$A[$i]." | B=".$B[$i]."<br>";
            $query = "INSERT INTO log (id, A, B) VALUES ($id[$i], $A[$i], $B[$i]);";
            if($result = mysqli_query($conn, $query)){
                echo "Tupla inserida<br>";
            }else{
                echo "Falha ao inserir Tupla:<br>".mysqli_error($conn);
                $error = TRUE;
            }
            $i++;
        }
        if(!$error){
            echo "Dados inseridos no banco!<br>";
        }else{
            echo "Falha<br>";
        }
    ?>
    <hr>
    <a href="index.php">Voltar</a>
</body>
</html>
    