<?php
// função que 'limpa' a linha de checkpoint e retorna um array com as transaçoes contidas nele
function ckpt_pending_transactions($line){
    $remove = array("<", ">", "ckpt", "CKPT", " ", "(", ")");
    $new_line = str_replace($remove, "", $line);
    $new_line = preg_replace('/[^a-z0-9,]/i', '', $new_line);
    $transactions = explode(",", $new_line);
    return $transactions;
}

// função que 'limpa' a linha de alterações e retorna um array com os valores da linha, sendo
// [0] = Transação
// [1] = ID
// [2] = Coluna
// [3] = Valor Antigo
// [4] = Valor novo
function transaction_line_update($line){
    $remove = array("<", ">", " ");
    $new_line = str_replace($remove, "", $line);
    $values = explode(",", $new_line);
    return $values;
}

// função que executa o REDO em uma transação
// recebe como parâmetros o log, a transação que precisa fazer o REDO, e a variável para conexão com o banco
function redo($log, $transaction, $conn){
    $rows = count($log);
    // percorre do fim do arquivo para o início procurando o início da transação
    for($i = $rows - 1; $i >= 0; $i--){
        // se encontrou o 'start'
        if(str_contains($log[$i], "<start ".$transaction.">")){
            // passa a percorrer o log deste ponto para o final do arquivo
            for($j = $i; $j < $rows; $j++){
                $line_array = transaction_line_update($log[$j]);
                // se tiver alguma alteração (linha começa com o nome da transação)
                if($line_array[0] == $transaction){
                    // precisa verificar o valor
                    $query = "SELECT ".$line_array[2]." FROM log WHERE id = ".$line_array[1].";";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    // se o valor do Banco for diferente do Novo Valor da transação, altera
                    if($row['A'] != $line_array[4]){
                        $query = "UPDATE log SET ".$line_array[2]." = ".$line_array[4]." WHERE id = ".$line_array[1].";";
                        $result = mysqli_query($conn, $query);
                        // precisa retornar o valor que foi alterado
                        echo "ID <b>".$line_array[1]."</b>, valor da coluna <b>".$line_array[2]."</b> alterado de <b>".$row['A']."</b> para <b>".$line_array[4]."</b><br>";
                    }
                }
                // se encontrou o commit
                if(str_contains($log[$j], "<commit ".$transaction.">")){
                    // encerra
                    break;
                }
            }
            break; // encerra
        }
    }
}


?>