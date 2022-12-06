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

        // pega os dados do arquivo de log passado pelo formulário
        $log = file($_FILES["file"]["tmp_name"]);
        // pega o nome do arquivo de log passado pelo formulário
        $nome = $_FILES["file"]["name"];
        $rows = count($log);
        
        // exibe o nome do arquivo
        echo "Nome do Arquivo: ".$nome."<br>";
        echo "Quantidade de linhas: ".$rows."<br>";
        $i = 1;
        // abre uma textarea para exibir as linhas (necessário devido a '<' e '>' serem tags html)
        echo "<textarea disabled rows='".$rows + 1 ."' cols='50'>";
        foreach($log as $line){
            echo "Linha[".$i."]: ".$line;
            $i ++;
        }
        echo "</textarea><hr>";

        // AQUI VAI FAZER O REDO
        // percorre o log do fim ao início procurando checkpoint
        for($i = $rows - 1; $i >= 0; $i--){
            if(str_contains($log[$i], "CKPT")){
                echo "Chekpoint na linha: ".$i+1;
                // função que verifica e retorna as transações no Checkpoint
                // ckpt_pending_transactions();
            }
        }
        // FIM DO REDO
    ?>
    <hr>
    <a href="index.php">Voltar</a>
</body>
</html>
    