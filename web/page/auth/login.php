<?php

require_once "../../config/conection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $result = $pdo->prepare("select email from users where email = ?");
    $result->execute([$email]);
    
    $userEmail = $result->fetch();

    if(!$userEmail){

        header("Location: /page/auth/login.php?err=1");
        exit;
    }
 
    $resultSenha = $pdo->prepare("select senha from users where email = ?");
    $resultSenha->execute([$userEmail[0]]);

    $userSenha = $resultSenha->fetch(); 
    
    if(!$userSenha){
        header("Location: /page/auth/login.php?err=1");
        exit;
    }

    header("Location: /?logado=true");
    exit;  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../styles/auth.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <main>
        <?php if(isset($_GET["err"])):?>
        <script>
        alert("Email ou senha errado")
        </script>
        <?php endif; ?>
        <h1>Login</h1>
        <form class="card" method="POST">
            <div class=" mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" id="exampleInputPassword1" </div>
                <div class="mb-3 form-check">
                    <span>Não tem conta? </span><a href="register.php">Cadastra-se</a>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>