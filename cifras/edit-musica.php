<?php
include_once('config/conexao.php');
include_once('protect.php');

$musicaId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$nomeMusica = '';
$conteudoMusica = '';

// Carregar música
if ($musicaId > 0) {
    $stmt = $conn->prepare("SELECT * FROM Musicas WHERE id = ?");
    $stmt->bind_param("i", $musicaId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $musica = $result->fetch_assoc();
        $nomeMusica = $musica['nome_musica'];
        $conteudoMusica = $musica['musica'];
    } else {
        echo "Música não encontrada!";
        exit;
    }
    $stmt->close();
}

// Atualizar música
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeMusica = trim($_POST['nomeMusica']);
    $conteudoMusica = trim($_POST['conteudoMusica']);
    if (empty($nomeMusica) || empty($conteudoMusica)) {
        echo "O nome e o conteúdo da música são obrigatórios!";
    } else {
        $stmt = $conn->prepare("UPDATE Musicas SET nome_musica = ?, musica = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nomeMusica, $conteudoMusica, $musicaId);
        if ($stmt->execute()) {
            echo "Música atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar música: " . $stmt->error;
        }
        $stmt->close();
    }
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
                <a class="logo" href="https://rafaelberlato.site/cifras"><img src="image/logo-148x40.svg" alt="cifras e uma silhueta de um violão"></a>
            </div>
    </header>

    <section style="padding: 10px 10%;">
        <h2>Editar Música</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="nomeMusica" class="form-label">Nome da Música:</label>
                <input type="text" class="form-control" name="nomeMusica" id="nomeMusica" value="<?php echo htmlspecialchars($nomeMusica); ?>" required>
            </div>
            <div class="mb-3">
                <label for="conteudoMusica" class="form-label">Conteúdo da Música:</label><br>
                <textarea class="form-control" name="conteudoMusica" id="conteudoMusica" rows="15" required><?php echo htmlspecialchars($conteudoMusica); ?></textarea>
            </div>
            <input class="btn btn-success" type="submit" value="Atualizar">
        </form>
    </section>



    <?php

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>