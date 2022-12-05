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
        print_r($data);
        echo "<hr>";
        var_dump($data);
        echo "<hr>";
        echo $data->INITIAL->id[0];
        echo "<br>";
        echo $data->INITIAL->A[0];
        echo "<br>";
        echo $data->INITIAL->B[0];
        echo "<br><br>";
        echo $data->INITIAL->id[1];
        echo "<br>";
        echo $data->INITIAL->A[1];
        echo "<br>";
        echo $data->INITIAL->B[1];
        echo "<hr>";
        foreach ($data->INITIAL as $key){
            echo $key[0];
            echo "<br>";
        }
        echo "<hr>";
        foreach ($data->INITIAL as $key){
            foreach($key as $n){
                echo $n."<br>";
            }
        }
    ?>
</body>
</html>