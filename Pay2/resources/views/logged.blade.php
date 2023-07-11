<!DOCTYPE html>
<html>
<head>
    <title>Logged</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Logged</h1>

        <!-- Display token -->
       

        <!-- Fetch user data button -->
        <button id="fetch-user-data-button" class="btn btn-primary">User Data</button>
        <div id="user-data-container"></div>

        <!-- Fetch conta data button -->
        <button id="fetch-conta-data-button" class="btn btn-primary">Conta Data</button>
        <div id="conta-data-container"></div>

        <!-- Fetch all users button -->
        <button id="fetch-all-users-button" class="btn btn-primary">All Users</button>
        <div id="all-users-container"></div>

        <!-- Movimentos button -->
        <button id="fetch-movimentos-button" class="btn btn-primary">Movimentos</button>
        <div id="movimentos-container"></div>

        <!-- Deposito form -->
        <h3>Deposito</h3>
        <form id="deposito-form">
            <div class="form-group">
                <label for="valor-deposito">Valor</label>
                <input type="text" id="valor-deposito" name="valor-deposito" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Depositar</button>
        </form>

        
       <!-- Transferencia Form -->
       <h3>Transferencia</h3>
<form id="transferencia-form">
    <div class="form-group">
        <label for="valor-transferencia">Valor</label>
        <input type="number" id="valor-transferencia" name="valor-transferencia" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="codigo-transferencia">Código</label>
        <input type="text" id="codigo-transferencia" name="codigo-transferencia" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Transferencia</button>
</form>



        <!-- Logoff button -->
        <button id="logoff-button" class="btn btn-danger">Logoff</button>
    </div>

    <script>
        // Retrieve the token from local storage
        const token = localStorage.getItem('token');

      
        // Function to handle the fetch user data button click
        function handleFetchUserData() {
            fetch('/api/user', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => response.json())
            .then(data => {
                const userDataContainer = document.getElementById('user-data-container');
                userDataContainer.textContent = JSON.stringify(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to handle the fetch conta data button click
        function handleFetchContaData() {
            fetch('/api/conta', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => response.json())
            .then(data => {
                const contaDataContainer = document.getElementById('conta-data-container');
                contaDataContainer.textContent = JSON.stringify(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to handle the fetch all users button click
        function handleFetchAllUsers() {
            fetch('/api/users', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => response.json())
            .then(data => {
                const allUsersContainer = document.getElementById('all-users-container');
                allUsersContainer.textContent = JSON.stringify(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to handle the fetch movimentos button click
        function handleFetchMovimentos() {
            fetch('/api/movimentos', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => response.json())
            .then(data => {
                const movimentosContainer = document.getElementById('movimentos-container');
                movimentosContainer.textContent = JSON.stringify(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to handle the deposito form submission
        function handleDeposito(event) {
            event.preventDefault();

            const valorDeposito = document.getElementById('valor-deposito').value;

            fetch('/api/depo', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ valor: valorDeposito })
         
            })
            .then(response => {
                // Handle the response here
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to handle the transferencia form submission
        function handleTransferencia(event) {
            event.preventDefault();

            const valorTransferencia = document.getElementById('valor-transferencia').value;
            const codigoTransferencia = document.getElementById('codigo-transferencia').value;

            fetch('/api/trans', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ valor: valorTransferencia, receiver: codigoTransferencia })
            })
            .then(response => {
                // Handle the response here
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to handle the logoff button click
        function handleLogoff() {
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                // Handle the logoff response here
                // Redirect to the login page or perform any other actions
            })
            .catch(error => {
                console.error('Error:', error);
            });
            window.location.href = '/';
        }

        // Add event listeners to the buttons and forms
        const fetchUserDataButton = document.getElementById('fetch-user-data-button');
        fetchUserDataButton.addEventListener('click', handleFetchUserData);

        const fetchContaDataButton = document.getElementById('fetch-conta-data-button');
        fetchContaDataButton.addEventListener('click', handleFetchContaData);

        const fetchAllUsersButton = document.getElementById('fetch-all-users-button');
        fetchAllUsersButton.addEventListener('click', handleFetchAllUsers);

        const fetchMovimentosButton = document.getElementById('fetch-movimentos-button');
        fetchMovimentosButton.addEventListener('click', handleFetchMovimentos);

        const depositoForm = document.getElementById('deposito-form');
        depositoForm.addEventListener('submit', handleDeposito);

        // Add an event listener to the transferencia form
        const transferenciaForm = document.getElementById('transferencia-form');
        transferenciaForm.addEventListener('submit', handleTransferencia);


        const logoffButton = document.getElementById('logoff-button');
        logoffButton.addEventListener('click', handleLogoff);
    </script>
</body>
</html>
