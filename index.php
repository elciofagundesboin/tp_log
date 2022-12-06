<?php
    require_once('conn.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>BD2 - Log</title>
</head>
<body>
    <?php
        $json = file_get_contents("metadado.json");
        $data = json_decode($json);

        $id = $data->INITIAL->id;
        $A = $data->INITIAL->A;
        $B = $data->INITIAL->B;
        $i = 0;
        foreach($id as $key){
            echo "ID = ".$id[$i]." | A=".$A[$i]." | B=".$B[$i]."<br>";
            $i++;
        }
    ?>
</body>
</html>