<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Login.css">
    <script src="Login.js" defer></script>
</head>

<body>
    <button class="botao1" id="botao">
        &#9776
    </button>
    <ul class="menu_lista" id="menu">
        <div class="menu_conteudo">
            <li><a href="../Usuario/CadastroUser.php">CADASTRO</a></li>
            <li><a href="../Modulos/Modulo1">MÓDULO 01</a></li>
            <li><a href="../Modulos/Modulo2">MÓDULO 02</a></li>
            <li><a href="../SalasReservadas/SalasReservadas.php">SALAS RESERVADAS</a></li>

        </div>
    </ul>
    <div class="formulario">
        <form method="POST" action="">
            <label for="inome">Nome User</label>
            <br>
            <input type="text" name="nome" id="inome" required maxlength="30" size="35" style="background-color: #F1F3F6">
            <br>
            <label for="isenha">Senha User</label>
            <br>
            <input type="password" name="senha" id="isenha" required minlength="5" maxlength = "15" placeholder="5 digitos" size="35"
                style="background-color: #F1F3F6">
            <br>
            <input class="btn" id="ibtn" type="submit">
        </form>
    </div>
</body>

</html>