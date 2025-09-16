<?php
    include "conexao.php"; // inclui o arquivo de conexão
    $result = mysqli_query($conexao, "SELECT * FROM user"); // exemplo de consulta
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
   <title>Login</title>
</head>
<body>
    <section id="form-container">
        <form id="form-login">
            <h2>Login</h2>
            <input type="text" id="email"  class="data-input" placeholder="Email">
            <input type="password" id="password" class="data-input" placeholder="Senha">
            <input type="text" id="submit" class="data-input">
        </form>
    </section>
</body>
</html>

