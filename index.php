<?php
include_once('config/conexao.php');

// Inicialize as variáveis
$email = "";
$senha = "";
$mensagemErro = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Verifica se o email e senha foram preenchidos
    if (empty($email)) {
        $mensagemErro = "Preencha seu e-mail";
    } elseif (empty($senha)) {
        $mensagemErro = "Preencha sua senha";
    } else {
        // Escapa os valores para evitar SQL Injection
        $email = $conn->real_escape_string($email);
        $senha = $conn->real_escape_string($senha);

        // Consulta SQL para verificar o login
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $result = $conn->query($sql) or die("Falha na execução: " . $conn->error);

        // Verifica se há resultados
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: cifras/consulta-musica.php");
            exit(); // Certifique-se de sair após redirecionar
        } else {
            $mensagemErro = "Falha ao logar! E-mail ou senha incorretos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/master.css">

    <title>Login</title>
</head>

<body class="body-login">
    <div class=" container-login">
        <form class="login-form" action="" method="POST">
            <div class="logo">
                <img src="image/logo-148x40.svg" alt="cifras e uma silhueta de um violão">
            </div>

            <h1>Acesso Administrativo</h1>
            <p>
                <label>E-mail</label>
                <input class="form-control" type="text" name="email">
            </p>

            <p>
                <label>Senha</label>
                <input class="form-control" type="password" name="senha">
            </p>

            <p>
                <button class="btn btn-success" type="submit">Entrar</button>
            </p>
        </form>
    </div>

</body>

</html>