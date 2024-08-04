document.addEventListener('DOMContentLoaded', function() {
    function carregarTabelaSorteios() {
        fetch('http://localhost:8080/sorteios')
            .then(response => response.json())
            .then(data => {
                const tabelaBody = document.querySelector('#sorteios-table tbody');
                if (data.success) {
                    tabelaBody.innerHTML = '';
                    data.sorteios.forEach(sorteio => {
                        const linha = document.createElement('tr');
                        const colunaId = document.createElement('td');
                        colunaId.textContent = sorteio.id;
                        const colunaData = document.createElement('td');
                        colunaData.textContent = sorteio.data;
                        linha.appendChild(colunaId);
                        linha.appendChild(colunaData);
                        tabelaBody.appendChild(linha);
                    });
                } else {
                    alert("Erro ao buscar sorteios: " + data.message);
                }
            })
            .catch(error => {
                console.error('Erro ao carregar sorteios:', error);
                alert("Erro ao conectar com a API.");
            });
    }
    carregarTabelaSorteios();

    document.querySelector('.btn-winning').addEventListener('click', function() {
        criarSorteio(); 
    });

    function criarSorteio() {        
        fetch('http://localhost:8080/sorteios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert("Sorteio criado com sucesso!");
                carregarTabelaSorteios();
            } else {
                alert("Erro ao criar sorteio: " + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert("Erro ao conectar com a API.");
        });
    }
});
