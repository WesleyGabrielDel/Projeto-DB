<?php include "conexao.php"; 
if (isset($_POST['cadastra'])) {
    $nome  = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $msg   = mysqli_real_escape_string($conexao, $_POST['msg']);

    $sql = "INSERT INTO user (nome, email, mensagem) VALUES ('$nome', '$email', '$msg')";
    mysqli_query($conexao, $sql) or die("Erro ao inserir dados: " . mysqli_error($conexao));
    header("Location: mural.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Mural de pedidos</title>
    <script src="scripts/jquery.js"></script>
    <script src="scripts/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            $("#mural").validate({
                rules: {
                    nome: {
                        required: true,
                        minlength: 4
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    msg: {
                        required: true,
                        minlength: 10
                    }
                },
                messages: {
                    nome: {
                        required: "Digite o seu nome",
                        minlength: "O nome deve ter no mínimo 4 caracteres"
                    },
                    email: {
                        required: "Digite o seu e-mail",
                        email: "Digite um e-mail válido"
                    },
                    msg: {
                        required: "Digite sua mensagem",
                        minlength: "A mensagem deve ter no mínimo 10 caracteres"
                    }
                }
            });
        });
    </script>
</head>
<body>
    <div id="main">
        <div id="geral">
            <div id="header">
                <h1 id="heading">Mural de pedidos</h1>
            </div>

            <div id="formulario_mural">
                <form id="mural" method="post">
                    <p class="input_label">Nome:</p>
                    <input type="text" name="nome" class="inputs" id="nome"/><br/>
                    <p class="input_label">Email:</p>
                    <input type="text" name="email" class="inputs" id="email"/><br/>
                    <p class="input_label">Mensagem:</p>
                    <textarea name="msg" class="inputs" id="msg"></textarea><br/>
                    <input type="submit" value="Publicar no Mural" name="cadastra" class="btn" id="send_btn"/>
                </form>
            </div>

            <?php
            $seleciona = mysqli_query($conexao, "SELECT * FROM user ORDER BY id DESC");
            while ($res = mysqli_fetch_assoc($seleciona)) {
                echo '<ul class="recados">';
                echo '<li><strong>ID:</strong> ' . $res['id'] . '</li>';
                echo '<li><strong>Nome:</strong> ' . htmlspecialchars($res['nome']) . '</li>';
                echo '<li><strong>Email:</strong> ' . htmlspecialchars($res['email']) . '</li>';
                echo '<li><strong>Mensagem:</strong> ' . nl2br(htmlspecialchars($res['mensagem'])) . '</li>';
                echo '</ul>';
            }
            ?>

            <div id="footer"></div>
        </div>
    </div>
</body>
<style>
    *{
        font-family: sans-serif;
    }
    body {
        margin: 0;
        padding: 0;
        display:flex;
        flex-direction: column;
        align-items: center; 
        justify-content: center; 
        height: 100vh;
        background-image: linear-gradient(#12C2E9, #F64F59);
    }
    #main {
        width: 800px;
        height: 500px;
        display:flex;
        flex-direction: column;
        align-items: center;
    }
    .inputs {
        border: 1px solid #ffff;
        border-radius: 7px;
    }
    #nome, #email {
        height: 40px;
    }
    #msg {
        width: 300px;
        height: 100px;
        margin-bottom: 30px;
    }
    #send_btn {
        height: 60px;
        width: 200px;
        margin-bottom:30px;
        border-radius: 5px;
    }
    .input_label {
        color: #ffff;
    }
    #heading {
        color: #ffff;
    }
</style>
</html>
