<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CadastroItem.css">
    <script src="CadastroItem.js" defer></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
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
            <img class="impressora" src="../../imagem/impressora1.png" alt="">
            <img src="../../imagem/salve1.png" alt="">
            <img class="cancelar" src="../../imagem/cancelar1.png" alt="">
        </header>

        <input type="text" id="searchInput" placeholder="Pesquisar...">
        <div class="consultar_cadastrar">
            <p id="um">Consultar</p>
            <p id="dois">Cadastrar</p>
        </div>
        <div class="titulo_pagina">
            Identificação do bem
        </div>
        
        <form method="POST" action="../../DAOS/ItensDAO.php" id="iformulario">
            <input type="hidden" id="iid" name="id" value="">
            <div class="principais">
            <label for="icategoria">Tipo do bem</label>
            <div class="select">
                    <br>
                <select disabled selected id="icategoria" class="cat" name="categoria" required >
                    <option value="Equipamentos">Equipamentos</option>
                    <option value="Moveis">Móveis</option>
                    <option value="Roupas">Máquinas</option>
                    <option value="Veículos">Veículos</option>
                    <option value="Eletrodomésticos">Eletrodomésticos</option>
                    <option value="Utensílios">Utensílios</option>
                    <option value="Eletroeletônicos">Eletroeletônicos</option>
                </select>
            </div>
                <br>
                <label for="inome">Descrição do bem</label>
                <input type="text" id="inome" name="nome" required disabled>
                <label for="idata_compra">Data de aquisição</label>
                <input type="date" id="idata_compra" name="data_compra" disabled required>
                <label for="idata_exclusao">Data da baixa</label>
                <input type="date" id="idata_exclusao" name="data_exclusao" disabled>
                <label for="ijustificativa">Justificativa da baixa</label>
                <input type="text" id="ijustificativa" name="justificativa"  disabled>
                <label for="idepeciacao">Depreciação anual</label>
                <input type="text" id="idepreciacao" name="depreciacao"  max="2025-12-31" required disabled>

            </div>
            <div class="informacao">
                <label for="ivalor">Valor da aquisição</label>
                <input type="text" id="ivalor" name="valor" disabled required>
                <label for="iresidual">Valor residual</label>
                <input type="text" id="iresidual" name="residual" disabled>
                <label for="imarca">Marca</label>
                <input type="text" id="imarca" name="marca" disabled required>
                <label for="ilocal">Localização</label>
                <input type="text" id="ilocal" name="local" disabled required>
                <label for="imodelo">Modelo</label>
                <input id="imodelo" name="modelo" disabled></input>
                <label for="iestado">Estado de conservação</label>
                <div class="select">
                    <br>
                    <select disabled required selected id="iestado" class="cat" name="estado" >
                        <option value="Novo">Novo</option>
                        <option value="Usado">Usado recente</option>
                        <option value="Usado">Anos de uso</option>
                        <option value="Avariado">Avariado</option>
                    </select>
                </div>
                <img id="ifotos" src="cadastro.jpg" alt="">
            </div>
            
                <img id="ifotos" src="cadastro.jpg" alt="">
            </div>
            <button type="submit" class="botao2" id="botao2">Adicionar</button>
            <button type="submit" class="botao2" id="botao3" style="display: none;">Editar</button>
        </form>
    </div> 
    <div class="mostrar" style="display: none">
        <label for="">Para conseguir cadastrar itens, entre com sua chave de acesso</label>
        <br>
        <input type="password" name="premium" id="ipremium" placeholder="Chave" required minlength="3">
        <br>
        <div class="botoes">
            <button id="icancelar" class="botao_verifica">Cancelar</button>
            <button class="botao_verifica" id="ibotao_veri">Enviar</button>
        </div>
    </div>
</body>
</html>