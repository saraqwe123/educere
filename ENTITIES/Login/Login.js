const menu = document.getElementById("menu");
const botao = document.getElementById("ibtn");
const verificacao = "";
function adc_menu(event) {
  if (!menu.contains(event.target) && event.target.id !== "botao") {
    menu.classList.remove("aparecer");
  } else {
    menu.classList.toggle("aparecer");
  }
}

document.addEventListener("click", adc_menu);

botao.addEventListener("click", function (event) {
  event.preventDefault();

  var nome = document.getElementById("inome").value;
  var senha = document.getElementById("isenha").value;

  if (nome === "" || senha === "") {
    alert("Por favor, preencha todos os campos.");
    return;
  }

  var xrh = new XMLHttpRequest();
  xrh.open("POST", "../../DVOS/UsuarioDVO/ProcuraLogin.php");
  xrh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xrh.onreadystatechange = function () {
    if (xrh.readyState === 4 && xrh.status === 200) {
      var resposta = JSON.parse(xrh.responseText);

      if (resposta.status === "invalido") {
        alert("Usuário não cadastrado!");
      } else if (resposta.status === "valido") {
        window.location.href = "../../ENTITIES/Item/CadastroItem.php";
      }
    }
  };

  xrh.send(
    "nome=" + encodeURIComponent(nome) + "&senha=" + encodeURIComponent(senha)
  );
});
