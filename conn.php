<?php
    define('HOST','localhost');
    define('USER','root');
    define('PASSWORD','');
    define('DB','bd2');

    $conexao = mysqli_connect(HOST,USER,PASSWORD,DB) or die(mysqli_error());
?>