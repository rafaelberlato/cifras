<?php
include_once('config/conexao.php');
include_once('protect.php');

// Inicialize as variáveis
$search_query = "";
$music_name = "";
$music_content = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $search_query = isset($_POST['search_query']) ? $_POST['search_query'] : '';

    // Consulta SQL para buscar todas as músicas que correspondem à pesquisa
    $sql = "SELECT id, nome_musica, musica FROM Musicas WHERE nome_musica LIKE '%$search_query%'";

    $result = $conn->query($sql);

    // Verifica se há resultados
    if ($result->num_rows > 0) {
        // Obtém o primeiro resultado (você pode ajustar para mostrar todos os resultados)
        $row = $result->fetch_assoc();
        $music_name = $row['nome_musica'];
        $music_content = $row['musica'];
    } else {
        // Se nenhuma música for encontrada, configure o nome da música para "Música não encontrada"
        $music_name = "Música não encontrada";
        // Aqui você pode definir uma mensagem padrão para exibir no modal
        $music_content = "Desculpe, a música que você está <br>procurando não foi encontrada.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/master.css">
    <title> <?php echo $music_name; ?> </title>
</head>


<body>

    <!-- <header id="component-layout-header" class="d-flex align-items-center justify-content-center p-1">

        <form method="post" action="" class="">
            <div class="row mx-auto">

                <div class="logo col-auto">
                    <a href="https://rafaelberlato.site/cifras/musicas"><img src="../image/logo-148x40.svg" alt="cifras e uma silhueta de um violão"></a>
                </div>

                <?php if (!$result || $result->num_rows == 0) { ?>
                    <div class="col-auto mt-1 mb-1">
                        <input class="form-control form-control-sm" type="text" name="search_query" id="search_query" placeholder="Pesquisar uma música...">
                    </div>

                    <div class="col-auto col-2 col-sm-2 col-md-2 col-xxl-2 mt-1 mb-1">
                        <button id="busca" class="btn btn-success btn-sm"><i class="fa-solid fa-magnifying-glass" style="color: #0c214c;"></i>Busca</button>
                    </div>
                <?php } ?>
            </div>
        </form>

        <div class="col-auto mt-1 mb-1">
            <button id="scrollToBottomButton" class="btn btn-primary btn-sm">Rolar</button>
        </div>

        <div class="d-flex align-items-center justify-content-center mx-3">
            <input type="range" class="form-range " id="customRange1" min="1" max="50" value="1">
        </div>

    </header> -->


    <header id="component-layout-header" class="p-1">

        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">

                <div class="col-12 col-md-auto text-center mb-2 mb-md-0">
                    <a href="https://rafaelberlato.site/cifras/musicas">
                        <img src="../image/logo-148x40.svg" alt="cifras e uma silhueta de um violão" class="img-fluid">
                    </a>
                </div>

                <form method="post" action="" class="col-12 col-md-auto">
                    <div class="row align-items-center justify-content-center gx-2">
                        <?php if (!$result || $result->num_rows == 0) { ?>
                            <div class="col-12 col-sm-6 mt-1 mb-1">
                                <input class="form-control form-control-sm" type="text" name="search_query" id="search_query" placeholder="Pesquisar uma música...">
                            </div>

                            <div class="col-auto mt-1 mb-1">
                                <button id="busca" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-magnifying-glass" style="color: #0c214c;"></i>Busca
                                </button>
                            </div>
                        <?php } ?>

                        <div class="col-auto mt-1 mb-1">
                            <button id="scrollToBottomButton" class="btn btn-primary btn-sm">Rolar</button>
                        </div>
                    </div>
                </form>

                <div class="col-12 col-md-auto mt-2 mt-md-0">
                    <input type="range" class="form-range" id="customRange1" min="1" max="100" value="1">
                </div>

                <div class="col-12 col-md-auto mt-2 mt-md-0">
                    <a class="btn btn-sm btn-danger" href="logout.php">Sair</a>
                </div>
            </div>
        </div>

    </header>

    <main class="" id="app" data-v-app>
        <div class="d-flex align-items-center">
            <div class="d-flex flex-column p-3 mt-5" rounded style=" width: 100vw;">
                <div class="container ">
                    <section>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <span>🎵🎶</span>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar, Editar ou Excluir Musicas</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <a type="button" class="btn btn-primary" href="insert-musica.php" target="_blank" rel="noopener noreferrer">Cadastrar</a>

                                        <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) : ?>
                                            <a class="btn btn-warning" href="edit-musica.php?id=<?php echo $row['id']; ?>" target="_blank" rel="noopener noreferrer">Editar</a>
                                            <a class="btn btn-danger" href="delete-musica.php" target="_blank" rel="noopener noreferrer">Excluir</a>
                                        <?php else : ?>
                                            <button class="btn btn-sm btn-warning" disabled>Editar</button>
                                            <button class="btn btn-sm btn-danger" disabled>Excluir</button>
                                            <a class="btn btn-sm btn-danger" href="../logout.php">Sair</a>
                                        <?php endif; ?>
                                    </div>
                                    <a class="btn btn-sm btn-danger" href="logout.php">Sair</a>
                                </div>
                            </div>

                        </div>
                    </section>
                    <div class="fixed-chord-container">
                        <h3 class="d-flex align-items-center justify-content-center"><?php echo $music_name; ?></h3>
                        <pre class="corpo-musica"><?php echo $music_content; ?></pre>

                    </div>
                </div>

            </div>
        </div>

    </main>

    <!-- Scripts do Bootstrap (JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scrollToBottomButton = document.getElementById("scrollToBottomButton");
            const customRange1 = document.getElementById("customRange1");

            let isScrolling = false;
            let scrollInterval;

            scrollToBottomButton.addEventListener("click", function() {
                if (!isScrolling) {
                    const scrollHeight = document.documentElement.scrollHeight;
                    const windowHeight = window.innerHeight;

                    scrollInterval = setInterval(function() {
                        let scrollSpeed = parseFloat(customRange1.value);
                        const scrollStep = scrollSpeed * 0.2;

                        if (window.scrollY < scrollHeight - windowHeight) {
                            window.scrollTo(0, window.scrollY + scrollStep);
                        } else {
                            clearInterval(scrollInterval);
                            isScrolling = false;
                        }
                    }, 0.2);

                    isScrolling = true;
                    scrollToBottomButton.textContent = "Pausar";
                } else {
                    clearInterval(scrollInterval);
                    isScrolling = false;
                    scrollToBottomButton.textContent = "Rolar";
                }
            });
        });
    </script>

</body>

</html>