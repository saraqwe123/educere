document.addEventListener("DOMContentLoaded", function () {

  const formularioReserva = document.getElementById("reserveForm");
  let mensagem = document.querySelector(".mostrar");
  let botao_veri = document.getElementById("ibotao_veri");
  let premium = document.getElementById("ipremium");




  botao_veri.addEventListener("click", function (event) {
    event.preventDefault();
    var xrh = new XMLHttpRequest();
    xrh.open("POST", "../../DVOS/ItemDVO/ProcuraChave.php");
    xrh.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    xrh.onreadystatechange = function () {
      if (xrh.status == 200 && xrh.readyState == 4) {
        var resposta = JSON.parse(xrh.responseText);

        if (resposta.status == "valido") {
          formularioReserva.style.display = "block";
          mensagem.style.display = "none";
        } else {
          alert("Acesso para agendar sala negado!");
        }
      }
    };

    xrh.send("premium2=" + encodeURIComponent(premium.value));
  });
  
});



