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
    <style>
        * {
            font-family: sans-serif;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(180deg, #f6fbff 0%, #eef6ff 50%, #ffffff 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        #geral {
            display: flex;
            flex-direction: row;
            gap: 20px;
            align-items: flex-start;
            justify-content: center;
            width: 100%;
            max-width: 980px;
        }

        #formulario_mural {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 0;
            border: 1px solid rgb(218, 217, 213);
            border-radius: 10px;
            width: 430px;
            box-shadow: 0px 8px 24px rgba(32, 54, 100, 0.08);
            background-color: #ffffff;
            padding: 20px;
        }

        #pedidos-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 0;
            border: 1px solid rgb(218, 217, 213);
            border-radius: 10px;
            width: 430px;
            box-shadow: 0px 8px 24px rgba(32, 54, 100, 0.08);
            padding: 20px;
            background-color: #ffffff;
        }

        #mural {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        #pedidos {
            margin-top: 0;
            margin-bottom: 20px;
        }

        h1 {
            width: 100%;
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 1px solid rgb(218, 217, 213);
            color: #203664;
        }

        .inputs {
            border: 1px solid rgb(218, 217, 213);
            border-radius: 6px;
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            background-color: #fbfdff;
        }

        #nome, #email {
            height: 44px;
        }

        #msg {
            height: 100px;
            resize: none;
            overflow: auto;
        }

        #send_btn {
            height: 52px;
            background-color: rgb(70, 126, 201);
            color: white;
            border-radius: 6px;
            border: 1px solid rgb(70, 126, 201);
            cursor: pointer;
            width: 100%;
            font-weight: 600;
        }

        .recados {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            padding: 12px;
            border-top: 1px solid rgb(240, 240, 242);
            border-bottom: 1px solid rgb(240, 240, 242);
            margin: 20px;
            list-style: none;
            gap: 6px;
            background: linear-gradient(90deg, rgba(255,255,255,0.6), rgba(250,250,252,0.6));
            border-radius: 6px;
        }


    </style>
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
        </div>
    </div>
</body>
</html>
