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
            <div id="formulario_mural">
                <h1 class="heading">Mural de pedidos</h1>
                <form id="mural" method="post">
                    <p class="input_label">Nome:</p>
                    <input type="text" name="nome" class="inputs" id="nome"/><br/>
                    <p class="input_label">Email:</p>
                    <input type="text" name="email" class="inputs" id="email" /><br/>
                    <p class="input_label">Mensagem:</p>
                    <textarea name="msg" class="inputs" id="msg"></textarea><br/>
                    <input type="submit" value="Publicar no Mural" name="cadastra" class="btn" id="send_btn"/>
                </form>
            </div>
                <section id="pedidos-box">
                    <div id="heading-pedidos">
                        <h1 id="pedidos">Pedidos</h1>
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
                </section>
            <div id="footer"></div>
        </div>
    </div>
</body>
<style>

    * {
        font-family: sans-serif;
    }

    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-image: linear-gradient(125deg, rgb(0, 128, 222), white, rgb(0, 128, 222));
        height: auto;
    }

    #formulario_mural {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        border: 1px solid rgb(218, 217, 213);
        border-radius: 10px;
        width: 430px;
        height: 550px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
        background-color: white;
    }

    #pedidos-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        border: 1px solid rgb(218, 217, 213);
        border-radius: 10px;
        width: 430px;
        height: auto;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
        padding-bottom: 60px; 
        background-color: white;
    }

    #mural {
        display: flex;
        flex-direction: column;
        width: 300px;
        height: 400px;
    }

    #pedidos {
        margin-top: 30px;
        margin-bottom: 70px;
    }

    h1 {
        border-bottom: 1px solid rgb(218, 217, 213);
    }

    #pedidos-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        width: 100%;
        border-top: 1px solid rgb(218, 217, 213);
    }

    .inputs {
        border: 1px solid rgb(218, 217, 213);
        border-radius: 5px;
    }

    #nome, #email {
        height: 40px;
    }

    #msg {
        height: 80px;
    }

    #send_btn {
        height: 50px;
        background-color: rgb(70, 126, 201);
        color: white;
        border-radius: 5px;
        border: 1px solid rgb(70, 126, 201);
    }

    ul {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-top: 1px solid rgb(218, 217, 213);
        border-bottom: 1px solid rgb(218, 217, 213);
        width: 80%;
    }
</style>
</html>
