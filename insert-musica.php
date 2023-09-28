<?php
include_once('config/conexao.php');

// $search_query = isset($_GET['q']) ? $_GET['q'] : '';
$search_query = isset($_GET['q']) ? $_GET['q'] : '';
$search_query = filter_var($search_query, FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeMusica = trim($_POST['nomeMusica']);
    $conteudoMusica = trim($_POST['conteudoMusica']);

    // Verifica se os campos estão vazios
    if (empty($nomeMusica) || empty($conteudoMusica)) {
        echo "O nome da música e o conteúdo não podem estar vazios!";
        exit;
    }

    // Verifica se a música já existe
    $checkStmt = $conn->prepare("SELECT * FROM Musicas WHERE nome_musica = ?");
    $checkStmt->bind_param("s", $nomeMusica);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    if ($checkResult->num_rows > 0) {
        echo "Uma música com esse nome já existe!";
        exit;
    }
    $checkStmt->close();

    // Insere a música
    $stmt = $conn->prepare("INSERT INTO Musicas (nome_musica, musica) VALUES (?, ?)");
    $stmt->bind_param("ss", $nomeMusica, $conteudoMusica);
    if ($stmt->execute()) {
        echo "Música inserida com sucesso!";
    } else {
        echo "Erro ao inserir música: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/master.css">
    <title>Inserir Música</title>
</head>

<body>

    <header id="component-layout-header" class="d-flex align-items-center justify-content-center p-2">
        <div class="d-flex align-items-center justify-content-center">
            <div class="">
                <a class="logo" href="https://rafaelberlato.site/cifras/consulta-musica.php"><img src="../image/logo-148x40.svg" alt="cifras e uma silhueta de um violão"></a>
            </div>
    </header>

    <section style="padding: 10px 10%;">
        <h2>Inserir novas Músicas</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="nomeMusica" class="form-label">Nome da Música:</label>
                <input type="text" class="form-control" name="nomeMusica" id="nomeMusica" required>
            </div>
            <div class="mb-3">
                <label for="conteudoMusica" class="form-label">Conteúdo da Música:</label><br>
                <textarea class="form-control" name="conteudoMusica" id="conteudoMusica" rows="15" required></textarea>
            </div>
            <input class="btn btn-success" type="submit" value="Inserir">
        </form>
    </section>


    <?php

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>