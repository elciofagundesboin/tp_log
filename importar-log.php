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
        // referencia o arquivo de funcoes
        require_once('funcoes.php');

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

        // AQUI VAI FAZER AS VERIFICAÇÕES E EXECUTAR OS REDOS NECESSÁRIOS
        // percorre o log do fim ao início procurando checkpoint
        $checkpoint_exists = FALSE;
        for($i = $rows - 1; $i >= 0; $i--){
            if(str_contains($log[$i], "CKPT")){
                // função que verifica e retorna as transações no Checkpoint
                $pendings = ckpt_pending_transactions($log[$i]);
                $checkpoint_line = $i;
                $checkpoint_exists = TRUE;
                break; // ao encontrar o primeiro CKPT, finaliza o laço
            }
        }
        
        // SE EXISTIR CHECKPOINT
        if($checkpoint_exists){ // se encontrou checkpoint
            echo "Chekpoint na linha: ".$checkpoint_line + 1 ."<br>";
            echo "<hr>";
            echo "Transações pendentes no checkpoint: ";
            foreach($pendings as $transaction){
                echo $transaction." ";
            }
            echo "<hr>";

            // VERIFICA AS TRANSAÇÕES ANTES DO CHEKPOINT
            // precisa verificar quais transações pendentes possuem commit
            foreach($pendings as $transaction){
                // $transaction é minha transação, exemplo 'T2'
                $needs_redo = FALSE;
                for($i = $rows - 1; $i >= 0; $i--){
                    if(str_contains($log[$i], "commit ".$transaction)){
                        // encontrou commit para a transacao
                        $needs_redo = TRUE;
                    }
                }
                if($needs_redo){
                    echo "<b>Transação ".$transaction." Precisa fazer REDO</b><br>";
                    // chama a função redo
                    redo($log, $transaction, $conn);
                    echo "<br>";
                }else{
                    echo "Transação ".$transaction." NÃO Precisa fazer REDO<br><br>";
                }
            }
            // VERIFICA AS TRANSAÇÕES APÓS O CHECKPOINT
            for($i = $checkpoint_line; $i < $rows; $i++){
                // verifica se é um início de transação
                if(str_contains($log[$i], "start")){
                    // verifica qual transação iniciou
                    $transaction = transaction_line_start($log[$i]);
                    $needs_redo = FALSE;
                    for($j = $i + 1; $j < $rows; $j++){
                        if(str_contains($log[$j], "commit ".$transaction)){
                            // se encontrou o commit
                            $needs_redo = TRUE;
                            break;
                        }
                    }
                    if($needs_redo){
                        echo "<b>Transação ".$transaction." Precisa fazer REDO</b><br>";
                        // chama a função redo
                        redo($log, $transaction, $conn);
                        echo "<br>";
                    }else{
                        echo "Transação ".$transaction." NÃO Precisa fazer REDO<br><br>";
                    }
                }
            }
        }else{
            // SE NÃO ENCONTROU CHECKPOINT, PRECISA PERCORRER O ARQUIVO TODO
            // percorre o arquivo todo verificando quais transações iniciaram e não finalizaram, e realiza o redo
            foreach($log as $line){
                // verifica se é um início de transação
                if(str_contains($line, "start")){
                    // verifica qual transação iniciou
                    $transaction = transaction_line_start($line);
                    $needs_redo = FALSE;
                    foreach($log as $line2){
                        if(str_contains($line2, "commit ".$transaction)){
                            // se encontrou o commit
                            $needs_redo = TRUE;
                            break;
                        }
                    }
                    if($needs_redo){
                        echo "<b>Transação ".$transaction." Precisa fazer REDO</b><br>";
                        // chama a função redo
                        redo($log, $transaction, $conn);
                        echo "<br>";
                    }else{
                        echo "Transação ".$transaction." NÃO Precisa fazer REDO<br><br>";
                    }
                }
            }
        }
        // FIM DO REDO
    ?>
    <hr>
    <a href="index.php">Voltar</a>
</body>
</html>
    