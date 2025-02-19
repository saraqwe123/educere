<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CadastroUser.css">
    <script src="CadastroUser.js" defer></script>
</head>

<body>
    <button class="botao1" id="botao">
        &#9776
    </button>
    <ul class="menu_lista" id="menu">
        <div class="menu_conteudo">
            <li><a href="../Login/Login.php">LOGIN</a></li>
            <li><a href="../Modulos/Modulo1">MÓDULO 01</a></li>
            <li><a href="../Modulos/Modulo2">MÓDULO 02</a></li>
            <li><a href="../SalasReservadas/SalasReservadas.php">SALAS RESERVADAS</a></li>

        </div>
    </ul>
    <div class="formulario">
        <form id="iformulario" method="POST" action="../../DAOS/UsuarioDAO.php">
            <label for="icpf">CPF</label>
            <br>
            <input type="text" name="cpf" id="icpf" required maxlength="11" required size="35" style="background-color: #F1F3F6" placeholder="">
            <br>
            <label for="irg">RG</label>
            <br>
            <input type="text" name="rg" id="irg" required maxlength="9" size="35" style="background-color: #F1F3F6">
            <br>
            <label for="iemail">Email</label>
            <br>
            <input type="email" name="email" id="iemail" required  maxlength="50" size="35" style="background-color: #F1F3F6">
            <br>
            <label for="inome">Nome User</label>
            <br>
            <input type="text" name="nome" id="inome" required  maxlength="30" size="35" style="background-color: #F1F3F6">
            <br>
            <label for="isenha">Senha User</label>
            <br>
            <input type="password" name="senha" id="isenha" required  maxlength="15" minlength="5" placeholder="5 digitos" size="35"
                style="background-color: #F1F3F6">
            <br>
            <label for="">Chave de acesso</label>
            <br>
            <input type="text" name="premium" id="ipremium"  maxlength="15" placeholder="Users supremos" size="35" style="background-color: #F1F3F6">
            <br>
            <input class="btn" type="submit" name="submit" id="ibtn">
        </form> 
    </div>
</body>
</html>

