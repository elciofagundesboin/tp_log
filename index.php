<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>BD2 - Log</title>
</head>
<body>
    <div>
        <h3>Importar metadata (json)</h3>
        <form action="importar-metadata.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="file" name="file" accept=".json">
            <button class="btn btn-success" type="submit" id="file">Enviar</button>
            <a href="index.php">Cancelar</a>
        </form>
    </div>
    <hr>
</body>
</html>