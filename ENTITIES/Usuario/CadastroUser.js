const menu = document.getElementById('menu');
const botao = document.getElementById('ibtn')

function adc_menu(event) {
    if (!menu.contains(event.target) && event.target.id !== 'botao') {
        menu.classList.remove("aparecer");
        
    } else {
        menu.classList.toggle("aparecer");
    }
}

document.addEventListener("click", adc_menu);

botao.addEventListener("click", function (event) {
    var cpf = document.getElementById("icpf").value;
    var rg = document.getElementById("irg").value;
    var email = document.getElementById("iemail").value;
    var nome = document.getElementById("inome").value;
    var senha = document.getElementById("isenha").value;
    var premium = document.getElementById("ipremium").value;

    if (
        cpf === "" ||
        rg === "" ||
        email === "" ||
        nome === "" ||
        senha === "" ||
        email.indexOf("@") === -1 ||
        senha.length < 5) {
        alert("Por favor, preencha todos os campos corretamente!");
        return;
    }

    fetch('../../DAOS/UsuarioDAO.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'cpf': cpf,
            'rg': rg,
            'email': email,
            'nome': nome,
            'senha': senha,
            'premium': premium
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            event.preventDefault()
        } else {
            
            window.location.href = '../Item/CadastroItem.php';
        }
    })
    .catch(error => console.error('Erro:', error));
    event.preventDefault(); 
});