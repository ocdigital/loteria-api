document.addEventListener('DOMContentLoaded', function() {
    fetch('http://localhost:8080/tripulantes')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.querySelector('#tripulantesTable tbody');
                data.tripulantes.forEach(tripulante => {                   
                    const newRow = tbody.insertRow();
                    const cellNome = newRow.insertCell(0);
                    const cellEmail = newRow.insertCell(1);

                    cellNome.textContent = tripulante.nome;
                    cellEmail.textContent = tripulante.email;
                });
            } else {
                alert("Erro ao buscar tripulantes: " + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert("Erro ao conectar com a API.");
        });
});

document.getElementById('cadastroForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;

    const tripulante = {
        nome: nome,
        email: email
    };

    fetch('http://localhost:8080/tripulantes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(tripulante)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const tbody = document.querySelector('#tripulantesTable tbody');
            const newRow = tbody.insertRow();
            const cellNome = newRow.insertCell(0);
            const cellEmail = newRow.insertCell(1);

            cellNome.textContent = nome;
            cellEmail.textContent = email;

            document.getElementById('cadastroForm').reset();
        } else {
            alert("Erro ao cadastrar tripulante: " + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert("Erro ao conectar com a API.");
    });
});
