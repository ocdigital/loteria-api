document.addEventListener('DOMContentLoaded', function() {
    function carregarTripulantes() {
        fetch('http://localhost:8080/tripulantes')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('tripulante_id');                   
                        select.innerHTML = '';
                        data.tripulantes.forEach(tripulante => {
                            const option = document.createElement('option');
                            option.value = tripulante.id;
                            option.textContent = tripulante.nome;
                            select.appendChild(option);
                        });                 
                } else {
                    alert("Erro ao buscar tripulantes: " + data.message);
                }
            })
            .catch(error => {
                console.error('Erro ao carregar tripulantes:', error);
                alert("Erro ao conectar com a API.");
            });
    }

    function carregarSorteios() {
        fetch('http://localhost:8080/sorteios')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('sorteio_id');                   
                        select.innerHTML = '';
                        data.sorteios.forEach(sorteio => {
                            const option = document.createElement('option');
                            option.value = sorteio.id;
                            option.textContent = sorteio.data;
                            select.appendChild(option);
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

    carregarTripulantes();
    carregarSorteios();


    function criarBilhete(premiado = false) {     
        const sorteio_id = document.getElementById('sorteio_id').value; 
        const tripulante_id = document.getElementById('tripulante_id').value;
        const quantidade_dezena = document.getElementById('quantidade_dezena').value;
        const quantidade_bilhete = document.getElementById('quantidade_bilhete').value;

        const bilhete = {
            sorteio_id: parseInt(sorteio_id),
            tripulante_id: parseInt(tripulante_id),
            quantidade_dezena: parseInt(quantidade_dezena),
            quantidade_bilhete: parseInt(quantidade_bilhete),
            premiado: premiado
        };

        fetch('http://localhost:8080/bilhetes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(bilhete)
        })
        .then(response => response.text())
        .then(html => {
            const bilhetesList = document.getElementById('bilhetes-list');
            bilhetesList.innerHTML = html;
            alert("Bilhete criado com sucesso!");
        })
        .catch(error => {
            console.error('Erro:', error);
            alert("Erro ao conectar com a API.");
        });
    }

    document.getElementById('cadastroBilheteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        criarBilhete();
    });
});
