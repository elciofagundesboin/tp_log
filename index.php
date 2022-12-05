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
        echo $data->INITIAL->id[0]."<br>";
        echo $data->INITIAL->id[1]."<br>";
        echo $data->INITIAL->A[0]."<br>";
        echo $data->INITIAL->A[1]."<br>";
        echo $data->INITIAL->B[0]."<br>";
        echo $data->INITIAL->B[1]."<br>";
        echo "<br><br>";
        print_r($data);
    ?>
</body>
</html>