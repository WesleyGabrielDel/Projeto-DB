<?php
include "conexao.php";
if (isset($_POST['atualiza'])) {
    $idatualiza = intval($_POST['id']);
    $nome       = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email      = mysqli_real_escape_string($conexao, $_POST['email']);
    $msg        = mysqli_real_escape_string($conexao, $_POST['msg']);

    $sql = "UPDATE user SET nome='$nome', email='$email', mensagem='$msg' WHERE id=$idatualiza";
    mysqli_query($conexao, $sql) or die("Erro ao atualizar: " . mysqli_error($conexao));
    header("Location: moderar.php");
    exit;
}
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    $id = intval($_GET['id']);
    mysqli_query($conexao, "DELETE FROM user WHERE id=$id") or die("Erro ao deletar: " . mysqli_error($conexao));
    header("Location: moderar.php");
    exit;
}
$editar_id = isset($_GET['acao']) && $_GET['acao'] == 'editar' ? intval($_GET['id']) : 0;
$recado_editar = null;
if ($editar_id) {
    $res = mysqli_query($conexao, "SELECT * FROM user WHERE id=$editar_id");
    $recado_editar = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Moderar pedidos</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <div id="main">
        <div id="geral">
            <div id="header">
                <h1 id="heading">Mural de pedidos</h1>
            </div>
            <?php if ($recado_editar): ?>
                <div id="formulario">
                    <form method="post">
                        <p>Nome:</p>
                        <input type="text" name="nome" class="inputs" id="nome" value="<?php echo htmlspecialchars($recado_editar['nome']); ?>"/><br/>
                        <p>Email:</p>
                        <input type="text" name="email" class="inputs" id="email" value="<?php echo htmlspecialchars($recado_editar['email']); ?>"/><br/>
                        <p>Mensagem:</p>
                        <textarea name="msg" class="inputs" id="msg"><?php echo htmlspecialchars($recado_editar['mensagem']); ?></textarea><br/>
                        <input type="hidden" name="id" value="<?php echo $recado_editar['id']; ?>"/>
                        <input type="submit" name="atualiza" value="Modificar Recado" id="send_btn" class="btn"/>
                    </form>
                </div>
            <?php endif; ?>
            <?php
            $seleciona = mysqli_query($conexao, "SELECT * FROM user ORDER BY id DESC");
            if (mysqli_num_rows($seleciona) <= 0) {
                echo "<p>Nenhum pedido no mural!</p>";
            } else {
                while ($res = mysqli_fetch_assoc($seleciona)) {
                    echo '<ul class="recados">';
                    echo '<li class="recados-top"><strong>ID:</strong> ' . $res['id'] . ' |
                          <a href="moderar.php?acao=excluir&id=' . $res['id'] . '">Remover</a> |
                          <a href="moderar.php?acao=editar&id=' . $res['id'] . '">Modificar</a></li>';
                    echo '<li><strong>Nome:</strong> ' . htmlspecialchars($res['nome']) . '</li>';
                    echo '<li><strong>Email:</strong> ' . htmlspecialchars($res['email']) . '</li>';
                    echo '<li><strong>Mensagem:</strong> ' . nl2br(htmlspecialchars($res['mensagem'])) . '</li>';
                    echo '</ul>';
                }
            }
            ?>
            <div id="footer"></div>
        </div>
    </div>
</body>
<style>
    * {
        font-family: sans-serif;
        box-sizing: border-box;
    }

    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-image: url("https://newtrade.com.br/wp-content/uploads/2015/07/Sorvetes-Blueberry.jpg");
        background-size: cover; 
        background-repeat: no-repeat; 
        background-position: center center; 
        background-attachment: fixed; 
        margin: 0;
        padding: 20px;
        min-height: 100vh;
    }

    #geral {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        border: 1px solid rgb(218, 217, 213);
        border-radius: 10px;
        width: 430px;
        height: auto;
        padding: 20px;
        box-shadow: 0 24px 60px rgba(32, 54, 100, 0.08);
        background-color: #ffffff;
    }

    #header {
        width: 100%;
        margin-bottom: 10px;
    }

    #heading {
        width: 100%;
        margin: 0 0 15px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid rgb(218, 217, 213);
        color: #203664;
    }

    #formulario {
        width: 100%;
        margin-bottom: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: linear-gradient(90deg, rgba(255,255,255,0.6), rgba(250,250,252,0.6));
        padding: 12px;
        border-radius: 8px;
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
        width: 100%;
    }

    #msg {
        height: 100px;
        width: 100%;
        resize: none;
        overflow: auto;
    }

    #send_btn {
        height: 52px;
        width: 100%;
        margin-top: 8px;
        background-color: rgb(70, 126, 201);
        color: white;
        border-radius: 6px;
        border: 1px solid rgb(70, 126, 201);
        cursor: pointer;
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

    .recados-top {
        width: 100%;
        margin-bottom: 6px;
        font-size: 14px;
    }

    a {
        color: #467ecd;
        text-decoration: none;
        margin-left: 8px;
    }

    a:hover {
        text-decoration: underline;
    }

</style>
</html>
