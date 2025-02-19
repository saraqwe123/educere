<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8' />
    <title>Agendamento de Salas</title>
    <link rel="stylesheet" href="SalasReservadas.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js' defer></script>
    <script src="SalasReservadas.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'resourceTimelineWeek',
                resources: [
                    { id: 'a', title: 'Sala A' },
                    { id: 'b', title: 'Sala B' },
                    { id: 'c', title: 'Sala C' },
                    { id: 'd', title: 'Sala D' }
                ],
                events: function (fetchInfo, successCallback, failureCallback) {
                    var xrh = new XMLHttpRequest();
                    xrh.open("POST", "../../DVOS/SalasReservadasDVO.php", true);
                    xrh.setRequestHeader("Content-Type", "application/json");

                    xrh.onreadystatechange = function () {
                        if (xrh.readyState == 4 && xrh.status == 200) {
                            try {
                                var data = JSON.parse(xrh.responseText); // Processa a resposta JSON
                                successCallback(data); // Passa os dados para o calendário
                            } catch (error) {
                                console.error("Erro ao analisar JSON:", error);
                                failureCallback(error); // Se houver erro ao analisar a resposta
                            }
                        } else if (xrh.readyState == 4) {
                            console.error('Erro ao carregar eventos:', xrh.status, xrh.statusText);
                            failureCallback(xrh.statusText); // Erro de carregamento
                        }
                    };

                    xrh.send();
                },
                editable: true,
                resourceAreaHeaderContent: 'Salas',
                eventClick: function (info) {
                    var accessKey = prompt('Digite sua chave de acesso para remover este evento:');
                    var xrh = new XMLHttpRequest();
                    xrh.open("POST", "../../DVOS/ItemDVO/ProcuraChave.php");
                    xrh.setRequestHeader("content-type", "application/x-www-form-urlencoded");

                    xrh.onreadystatechange = function () {
                        if (xrh.status == 200 && xrh.readyState == 4) {
                            var resposta = JSON.parse(xrh.responseText);
                            if (resposta.status == "valido") {
                                if (confirm('Deseja remover este evento: ' + info.event.title + '?')) {
                                    // Remove o evento do calendário (interface)
                                    calendar.getEventById(info.event.id).remove();

                                    // Requisição para remover o evento do banco de dados
                                    var deleteRequest = new XMLHttpRequest();
                                    deleteRequest.open("POST", "../../DVOS/SalasExcluiDVO.php", true);
                                    deleteRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                    deleteRequest.onreadystatechange = function () {
                                        if (deleteRequest.readyState == 4 && deleteRequest.status == 200) {
                                            var deleteResponse = JSON.parse(deleteRequest.responseText);
                                            if (deleteResponse.success) {
                                                alert(deleteResponse.message); // Exibe a mensagem de sucesso
                                            } else {
                                                alert(deleteResponse.message); // Exibe a mensagem de erro
                                            }
                                        }
                                    };

                                    // Envia o id do evento para exclusão no banco de dados
                                    deleteRequest.send("id=" + encodeURIComponent(info.event.id));
                                }
                            } else {
                                alert("Você não tem permissão para remover este evento.");
                            }
                        }
                    };

                    xrh.send("premium2=" + encodeURIComponent(accessKey));
                } // Esta chave fecha a função eventClick
            });

            calendar.render();

            document.getElementById('reserveForm').addEventListener('submit', function (e) {
                e.preventDefault();

                var sala = document.getElementById('sala').value;
                var responsavel = document.getElementById('responsavel').value;
                var inicio = document.getElementById('inicio').value;
                var fim = document.getElementById('fim').value;

                // Verifica se a data de início é anterior à data de término
                if (new Date(inicio) > new Date(fim)) {
                    alert('A data de início deve ser anterior à data de término.');
                    return;
                }

                // Adicionando o evento ao calendário
                calendar.addEvent({
                    id: Date.now().toString(),
                    resourceId: sala, // Referencia a sala
                    title: responsavel,
                    start: inicio,
                    end: fim,
                    description: responsavel,
                });

                // Enviando os dados para o servidor
                var xrh = new XMLHttpRequest();
                xrh.open("POST", "../../DAOS/SalasReservadasDAO.php", true);
                xrh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                var params = "sala=" + encodeURIComponent(sala) +
                    "&responsavel=" + encodeURIComponent(responsavel) +
                    "&inicio=" + encodeURIComponent(inicio) +
                    "&fim=" + encodeURIComponent(fim);

                xrh.onreadystatechange = function () {
                    if (xrh.readyState == 4) {
                        console.log(xrh.responseText); // Exibe a resposta no console

                        if (xrh.status == 200) {
                            try {
                                var resposta = JSON.parse(xrh.responseText); // Tenta analisar a resposta como JSON
                                if (resposta.success) {
                                    alert('Reserva realizada com sucesso!');
                                } else {
                                    alert('Erro ao realizar a reserva: ' + resposta.error);
                                }
                            } catch (error) {
                                console.error("Erro ao analisar JSON:", error); // Exibe o erro no console
                                alert('Erro ao processar a resposta do servidor.'); // Mensagem de erro para o usuário
                            }
                        } else {
                            console.error('Erro ao carregar eventos:', xrh.status, xrh.statusText); // Exibe erro de status
                            alert('Erro ao realizar a reserva. Status: ' + xrh.status); // Mensagem de erro para o usuário
                        }
                    }
                };

                xrh.send(params); // Envia os dados para o servidor

                this.reset(); // Limpa o formulário após a reserva
            });
        });

        
        document.addEventListener('DOMContentLoaded', function() {
    const menu = document.getElementById('menu');
    const botao = document.getElementById('botao');

    function adc_menu(event) {
        if (!menu.contains(event.target) && event.target !== botao) {
            menu.classList.remove("aparecer");
        } else {
            menu.classList.toggle("aparecer");
        }
    }

    // Adiciona o listener de evento de clique após o DOM estar carregado
    document.addEventListener("click", adc_menu);
})

    </script>
</head>

<body>
    <div class="pai">
        <button class="botao1" id="botao">
            &#9776;
        </button>
        <ul class="menu_lista" id="menu">
            <div class="menu_conteudo">
                <li class="liMenu"><a class="menu" href="../Login/Login.php">LOGIN</a></li>
                <li class="liMenu"><a class="menu" href="../Modulos/Modulo1">MÓDULO 01</a></li>
                <li class="liMenu"><a class="menu" href="../Modulos/Modulo2">MÓDULO 02</a></li>
                <li class="liMenu"><a class="menu" href="../Item/CadastroItem">ITENS</a></li>
            </div>
        </ul>
        <h1>Sala de Reuniões: Agende Aqui</h1>
    </div>
    <div id='calendar' style="margin-bottom: 20px;"></div>

    <div>
        <h2>Agendar Sala</h2>
        <form id="reserveForm" method="POST" action="../../DAOS/SalasReservadasDAO.php">
            <label for="sala">Sala:</label>
            <select id="sala" name="sala" required>
                <option value="a">Sala A</option>
                <option value="b">Sala B</option>
                <option value="c">Sala C</option>
                <option value="d">Sala D</option>
            </select>
            <br>
            <label for="responsavel">Responsável:</label>
            <input type="text" id="responsavel" name="responsavel" required />
            <br>
            <label for="inicio">Início:</label>
            <input type="datetime-local" id="inicio" name="inicio" required />
            <br>
            <label for="fim">Fim:</label>
            <input type="datetime-local" id="fim" name="fim" required />
            <br>
            <button type="submit" class="botao_reserva">Reservar</button>
        </form>

    </div>
    <div class="mostrar">
        <label for="">Para agendar uma sala, entre com sua chave de acesso</label>
        <br>
        <input type="password" name="premium" id="ipremium" placeholder="Users supremos">
        <br>
        <button class="botao_verifica" id="ibotao_veri">Verificar</button>
    </div>
</body>

</html>
