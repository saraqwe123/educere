  let cadastrar = document.querySelector("#dois");
  let mensagem = document.querySelector(".mostrar");
  let botao_veri = document.getElementById("ibotao_veri");
  let consultar = document.getElementById("um");
  let premium = document.getElementById("ipremium");
  let categoria = document.getElementById("icategoria");
  let nome = document.getElementById("inome");
  let marca = document.getElementById("imarca");
  let local = document.getElementById("ilocal");
  let data = document.getElementById("idata_compra");
  let valor = document.getElementById("ivalor");
  let residual = document.getElementById("iresidual");
  let modelo = document.getElementById("imodelo");
  let dataEx = document.getElementById("idata_exclusao");
  let justificativa = document.getElementById("ijustificativa");
  let depreciacao = document.getElementById("idepreciacao");
  let estado = document.getElementById("iestado");
  let lista = [categoria, nome, data, dataEx, justificativa, depreciacao, valor, residual, marca, local, modelo, estado];
  const menu = document.getElementById("menu");
  let consulta_cadastro = document.querySelector(".consultar_cadastrar");
  let formulario = document.getElementById("iformulario");
  let container = document.querySelector(".container");
  let tabela = null;
  let botao2 = document.querySelector(".botao2");
  let cancelar = document.getElementById('icancelar')
  let valorRole = null
  let botao3 = document.querySelector("#botao3")
  let searchInput = document.getElementById("searchInput");

  botao3.style.display = "none"

  function adc_menu(event) {
    if (!menu.contains(event.target) && event.target.id !== "botao") {
      menu.classList.remove("aparecer");
      //!menu.contains ve se esta fora do menu, se nao tivesse a ! veria se esta dentro//
    } else {
      menu.classList.toggle("aparecer");
    }
  }

  document.addEventListener("click", adc_menu);

  function protecao(event) {
    if (event.target == cadastrar || event.target.id == "dois") {
      mensagem.style.display = "flex";
    } else {
      mensagem.style.display = "none";
    }
  }

  cadastrar.addEventListener("click", protecao);

  document.addEventListener("click", function (event) {
    if (
      !mensagem.contains(event.target) &&
      event.target !== cadastrar &&
      !cadastrar.contains(event.target)
    ) {
      mensagem.style.display = "none";
    }
  });

    function ativa() {
      for (let i = 0; i < lista.length; i++) {
          if (lista[i]) { // Verifica se o elemento existe
              lista[i].disabled = false;
              console.log('sararara')
          } else {
              console.warn(`Elemento na posição ${i} é null.`);
          }
      } 
  }

  function desativa() {
    for (let i = 0; i < lista.length; i++) {
        if (lista[i]) {
            lista[i].disabled = true;
            console.log('sararara')
        } else {
            console.warn(`Elemento na posição ${i} é null.`);
        }
    } 
  }


  consultar.addEventListener("click", function (event) {
    event.preventDefault();
    if (tabela && container.contains(tabela)) {
      container.removeChild(tabela);
      tabela = null
      searchInput.style.display ="block"
    } 



    var xrh = new XMLHttpRequest();
    xrh.open("POST", "../../DVOS/ItemDVO/MostrarItens.php");
    xrh.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    xrh.onreadystatechange = function () {
      if (xrh.status == 200 && xrh.readyState == 4) {
        var itens = JSON.parse(xrh.responseText);

        tabela = document.createElement("table");
        const headerRow = tabela.insertRow();

        const headers = ["Identifcador","Tipo do bem", "Descrição do bem", "Marca", "Localização", "Data da aquisição", "Data da exclusão", "Depreciação", "justifcativa da exclusão","Valor de aquisição", "Valor residual", "Modelo", "Estado de conservação", "QR code", ""];
        headers.forEach(header => {
          const headerCell = headerRow.insertCell();
          headerCell.textContent = header;
        });

        itens.forEach(item => {
          const row = tabela.insertRow();
          const idCell = row.insertCell();
          const categoriaCell = row.insertCell();
          const nomeCell = row.insertCell();
          const marcaCell = row.insertCell();
          const localCell = row.insertCell();
          const dataCell = row.insertCell();
          const dataExCell = row.insertCell(); 
          const depreciacaoCell = row.insertCell();
          const justificativaCell = row.insertCell();
          const valorCell = row.insertCell();
          const residualCell = row.insertCell();
          const modeloCell = row.insertCell()
          const estadoCell = row.insertCell();
          const qrcodeCell = row.insertCell();
          const editarCell = row.insertCell();
          let editarButton = document.createElement("button");
          editarButton.textContent = "Editar ✍🏻";
          let excluirButton = document.createElement("button");
          excluirButton.textContent = "Excluir 🗑️";
          editarCell.appendChild(editarButton);
          editarCell.appendChild(excluirButton);

          
          if (valorRole == null) { 
            editarButton.style.display = "none"
            excluirButton.style.display = "none"
          } else {
            editarButton.style.backgroundColor = "#2b2c83"; 
            excluirButton.style.backgroundColor = "#FF0000"
          }

       
          editarButton.addEventListener("click", function() {
            categoria.value = item.categoria;
            nome.value = item.nome;
            marca.value = item.marca;
            local.value = item.local;
            data.value = item.data_compra;
            dataEx.value = item.data_exclusao;
            depreciacao.value = item.depreciacao;
            justificativa.value = item.justificativa;
            valor.value = item.valor;
            residual.value = item.residual;
            modelo.value = item.modelo;
            estado.value = item.estado;
        
            // Definindo o ID do item no campo oculto
            document.getElementById("iid").value = item.id;
        
            formulario.style.display = "block";
            mensagem.style.display = "none";
            tabela.style.display = "none";
            botao3.style.display = "block"; 
            botao2.style.display = "none"; 
            
        });

        excluirButton.addEventListener("click", function() {
          if (confirm("Tem certeza que deseja excluir este item?")) {
              var xrh = new XMLHttpRequest();
              xrh.open("POST", "../../DAOS/ItensDAO.php"); // Endpoint para exclusão
              xrh.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  
              xrh.onreadystatechange = function () {
                  if (xrh.status == 200 && xrh.readyState == 4) {
                      var resposta = JSON.parse(xrh.responseText);
                      if (resposta.status === "sucesso") {
                          alert("Item excluído com sucesso!");
                          // Remove a linha da tabela
                          tabela.deleteRow(row.rowIndex);
                      } else {
                          alert("Erro ao excluir o item: " + resposta.mensagem);
                      }
                  }
              };
  
              // Envia o ID do item para exclusão
              xrh.send(`id=${encodeURIComponent(item.id)}`);
          }
      });

          idCell.textContent = item.id;
          categoriaCell.textContent = item.categoria;
          nomeCell.textContent = item.nome;
          marcaCell.textContent = item.marca;
          localCell.textContent = item.local;
          dataCell.textContent = item.data_compra;
          dataExCell.textContent = item.data_exclusao;
          depreciacaoCell.textContent = item.depreciacao;
          justificativaCell.textContent = item.justificativa; 
          valorCell.textContent = item.valor;
          residualCell.textContent = item.residual;
          modeloCell.textContent = item.modelo;
        
          estadoCell.textContent = item.estado;

          categoriaCell.style.width = "100px";
          nomeCell.style.width = "100px";
          marcaCell.style.width = "100px";
          localCell.style.width = "100px";
          dataCell.style.width = "100px";        
          valorCell.style.width = "100px";
          residualCell.style.width = "100px";
          dataExCell.style.width = "100px";
          justificativaCell.style.width = "100px";
          depreciacaoCell.style.width = "100px";
          idCell.style.width = "100px";
          estadoCell.style.width = "100px";
          modeloCell.style.width = "100px";;
          qrcodeCell.style.width = "100px";
          editarButton.style.padding = "5%";
          editarButton.style.width = "90px";
          editarButton.style.fontSize = "14px";
          editarButton.style.borderRadius = "10px";
          editarButton.style.marginLeft = "3%";
          editarButton.style.color = "white";
          editarButton.style.backgroundColor = "#2b2c83";
          editarButton.style.margin = "1%"
          excluirButton.style.padding = "5%";
          excluirButton.style.width = "90px";
          excluirButton.style.fontSize = "14px";
          excluirButton.style.borderRadius = "10px";
          excluirButton.style.marginLeft = "3%";
          excluirButton.style.color = "white";
          excluirButton.style.backgroundColor = "#ff0000";
          excluirButton.style.margin = "1%"
  
          
          row.style.fontSize = "13px"
          row.style.backgroundColor =  "#E0FFE0"

          let qrcode = document.createElement("img");
          qrcode.src = "../" + item.qr_code_path; 
          qrcode.style.maxWidth = "100px";
          qrcode.style.maxheight = "50px";
          qrcode.style.border = "1px solid black";
          
          qrcodeCell.appendChild(qrcode);
        });

      
        tabela.style.marginLeft = "0.5%";
        tabela.style.borderCollapse = "collapse";
        tabela.style.width = "99vw";
        tabela.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.2)";
        
        
        // Estilos para as células da tabela
        tabela.querySelectorAll("th, td").forEach(cell => {
          cell.style.border = "1px solid black";
          cell.style.padding = "8px";
          cell.style.textAlign = "left";
        });
        
        // Estilos para a linha de cabeçalho
        tabela.querySelector("tr:first-child").style.backgroundColor = "#f2f2f2";
        container.appendChild(tabela);
        formulario.style.display = "none";
        botao2.style.display = "none"

        searchInput.addEventListener("keyup", function() {
          const filter = searchInput.value.toLowerCase();
          const rows = tabela.getElementsByTagName("tr");

          for (let i = 1; i < rows.length; i++) { // Começa em 1 para ignorar o cabeçalho
              const cells = rows[i].getElementsByTagName("td");
              let rowContainsFilter = false;

              for (let j = 0; j < cells.length; j++) {
                  const cell = cells[j];
                  if (cell) {
                      const cellText = cell.textContent || cell.innerText;
                      if (cellText.toLowerCase().indexOf(filter) > -1) {
                          rowContainsFilter = true;
                          break; // Se encontrar uma correspondência, não precisa verificar mais células
                      }
                  }
              }

              // Mostra ou esconde a linha com base na pesquisa
              rows[i].style.display = rowContainsFilter ? "" : "none";
          }
        })

      }
    };

    xrh.send();
  });

  botao_veri.addEventListener("click", function (event) {
    event.preventDefault();
    var xrh = new XMLHttpRequest();
    xrh.open("POST", "../../DVOS/ItemDVO/ProcuraChave.php");
    xrh.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    xrh.onreadystatechange = function () {
      if (xrh.status == 200 && xrh.readyState == 4) {
        var resposta = JSON.parse(xrh.responseText);

        if (resposta.status == "valido" && premium.value.trim() !== "") {
          formulario.style.display = "block";
          botao2.style.display= "block"
          mensagem.style.display = "none";
          if (resposta.role !== null) {
            console.log(resposta.role)
            valorRole = "válido"
          }
          if (tabela) {
            container.removeChild(tabela)
          }
          ativa();
          
          localStorage.setItem('usuarioPremium', premium.value.trim());
        } else {
          mensagem.style.display = "none";
          alert("Acesso para cadastrar itens negado!");
          desativa();
        }
      }
    };

    xrh.send("premium2=" + encodeURIComponent(premium.value));
  });

  cancelar.addEventListener("click", function (event) {
    if (event.target == cancelar) {
      mensagem.style.display = "none"
  
    } 
  })

  function validaformulario() {
    let isValid = true;
    let errorMessage = "";

    let valor = valor.value.replace(',', '.');

    if (isNaN(valor.value) || valor.value <= 0) {
        isValid = false;
        errorMessage += "Valor estimado deve ser um número positivo.\n";
    }

    if (!isValid) {
        alert(errorMessage);
    }

    return isValid;
  }

  botao2.addEventListener("click", function (event) {
    if (!validaformulario()) {
        event.preventDefault(); 
    }
  });

  cancelar.addEventListener("click", function (event) {
    if (event.target == cancelar) {
        mensagem.style.display = "none";
    } 
  });


  botao3.addEventListener("click", function(event) {
    event.preventDefault(); // Prevenir o envio padrão do formulário

    // Obter o ID do item do campo oculto
    let idItem = document.getElementById("iid").value; // Obter o ID do campo oculto

    let categoriaValue = categoria.value;
    let nomeValue = nome.value;
    let marcaValue = marca.value;
    let localValue = local.value;
    let dataValue = data.value;
    let dataExValue = dataEx.value;
    let depreciacaoValue = depreciacao.value;
    let justificativaValue = justificativa.value;
    let valorValue = valor.value;
    let residualValue = residual.value;
    let modeloValue = modelo.value;
    let estadoValue = estado.value;

    var xrh = new XMLHttpRequest();
    xrh.open("POST", "../../DAOS/ItensDAO.php"); // Mudei para o mesmo arquivo que você está usando para adicionar e editar
    xrh.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    xrh.onreadystatechange = function () {
        if (xrh.status == 200 && xrh.readyState == 4) {
            console.log(xrh.responseText)
            var resposta = JSON.parse(xrh.responseText);
            
            if (resposta.status === "sucesso") {
                
                const successMessage = document.createElement("div");
                tabela.style.display = "block"
                 

                
                formulario.style.display = "none";
                botao3.style.display = "none";
                botao2.style.display = "block";
                document.getElementById("iid").value = "";
            } else {
                
                const errorMessage = document.createElement("div");
                errorMessage.textContent = resposta.mensagem;
                errorMessage.style.color = "red"; 
                document.body.appendChild(errorMessage); 
            }
        }
    };

    xrh.send(`id=${encodeURIComponent(idItem)}&categoria=${encodeURIComponent(categoriaValue)}&nome=${encodeURIComponent(nomeValue)}&marca=${encodeURIComponent(marcaValue)}&local=${encodeURIComponent(localValue)}&data_compra=${encodeURIComponent(dataValue)}&data_exclusao=${encodeURIComponent(dataExValue)}&depreciacao=${encodeURIComponent(depreciacaoValue)}&justificativa=${encodeURIComponent(justificativaValue)}&valor=${encodeURIComponent(valorValue)}&residual=${encodeURIComponent(residualValue)}&modelo=${encodeURIComponent(modeloValue)}&estado=${encodeURIComponent(estadoValue)}`);

});