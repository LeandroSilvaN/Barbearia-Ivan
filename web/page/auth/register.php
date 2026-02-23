  <?php
  require_once "../../config/conection.php";

  if($_SERVER["REQUEST_METHOD"] === "POST"){
    $nome = $_POST["nome"];  
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $isEmail = $pdo->prepare("select email from users where email = ?");
    $isEmail->execute([$email]);

    if($isEmail->fetch()){
        header("Location: ?sucess=false");
        exit;
    }
    
    $insert = $pdo->prepare("insert into users (nome, email, telefone, senha) values(?, ?, ?, ?)");

    if($insert->execute([$nome, $email, $telefone, $senha])){
        header("Location: ?sucess=true");
        exit;
    }

    header("Location: ?sucess=false");
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
          <?php if(isset($_GET["sucess"])):?>
          <?php if($_GET["sucess"] == "true"):?>

          <script>
          alert("Cadastrado com sucesso")
          document.location.href = `${document.location.origin}/page/auth/login.php`;
          </script>

          <?php else:?>
          <script>
          alert("Erro no cadastro")
          </script>
          <?php endif; ?>
          <?php endif; ?>
          <h1>Cadastro</h1>
          <form method="POST" class="card">
              <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Nome</label>
                  <input name="nome" class="form-control" id="exampleInputPassword1">
              </div>

              <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                      aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Telefone</label>
                  <input type="text" name="telefone" class="form-control" id="exampleInputEmail1"
                      aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Senha</label>
                  <input type="password" name="senha" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3 form-check">
                  <span>Já tem conta? </span><a href="login.php">Entrar</a>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
      </main>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  </body>

  </html>