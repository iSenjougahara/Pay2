<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <!-- Login Form -->
        <form id="login-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <!-- Registration Form -->
        <form id="registration-form">
            <div class="form-group">
                <label for="reg-nomeCompleto">Nome Completo</label>
                <input type="text" id="reg-nomeCompleto" name="reg-nomeCompleto" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg-DataNasc">Data de Nascimento</label>
                <input type="date" id="reg-DataNasc" name="reg-DataNasc" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg-CPF">CPF</label>
                <input type="text" id="reg-CPF" name="reg-CPF" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg-email">Email</label>
                <input type="email" id="reg-email" name="reg-email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg-password">Password</label>
                <input type="password" id="reg-password" name="reg-password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg-CEP">CEP</label>
                <input type="text" id="reg-CEP" name="reg-CEP" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="pesquisacep()">Validar CEP</button>
            </div>
            <div class="form-group">
                <label for="reg-Complemento">Complemento</label>
                <input type="text" id="reg-Complemento" name="reg-Complemento" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reg-NumeroEndereco">Número do Endereço</label>
                <input type="text" id="reg-NumeroEndereco" name="reg-NumeroEndereco" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <!-- Display response -->
        <div id="response"></div>

        <!-- Redirect button -->
        
    </div>

    <script>
        function limpa_formulario_cep() {
            document.getElementById('reg-Complemento').value = '';
        }

        function pesquisacep() {
            var cep = document.getElementById('reg-CEP').value.replace(/\D/g, '');

            if (cep != '') {
                var validacep = /^[0-9]{8}$/;

                if (validacep.test(cep)) {
                    document.getElementById('reg-Complemento').value = '...';

                    fetch('https://viacep.com.br/ws/' + cep + '/json/')
                        .then(response => response.json())
                        .then(data => {
                            if (!data.erro) {
                                document.getElementById('reg-Complemento').value = data.complemento;
                            } else {
                                limpa_formulario_cep();
                                alert("CEP não encontrado.");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                } else {
                    limpa_formulario_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limpa_formulario_cep();
            }
        }

        // Function to handle the login form submission
        function handleLogin(event) {
            event.preventDefault();

            // Retrieve the user input from the form
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Make the API request to login
            fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            })
            .then(response => response.json())
            .then(data => {
                // Check if the response contains the token
                if (data.access_token) {
                    // Store the token in local storage
                    localStorage.setItem('token', data.access_token);

                    // Redirect to the logged page
                    window.location.href = '/logged';
                } else {
                    // Handle login error
                    console.error('Login failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to handle the registration form submission
        function handleRegistration(event) {
            event.preventDefault();

            // Retrieve the user input from the form
            const nomeCompleto = document.getElementById('reg-nomeCompleto').value;
            const DataNasc = document.getElementById('reg-DataNasc').value;
            const CPF = document.getElementById('reg-CPF').value;
            const email = document.getElementById('reg-email').value;
            const password = document.getElementById('reg-password').value;
            const CEP = document.getElementById('reg-CEP').value;
            const Complemento = document.getElementById('reg-Complemento').value;
            const NumeroEndereco = document.getElementById('reg-NumeroEndereco').value;

            // Make the API request to register
            fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ nomeCompleto, DataNasc, CPF, email, password, CEP, Complemento, NumeroEndereco }),
            })
            .then(response => response.json())
            .then(data => {
                // Check if the response contains the token
                if (data.access_token) {
                    // Store the token in local storage
                    localStorage.setItem('token', data.access_token);

                    // Redirect to the logged page
                    window.location.href = '/logged';
                } else {
                    // Handle registration error
                    console.error('Registration failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Function to redirect to /logged
        function redirectToLogged() {
            window.location.href = '/logged';
        }

        // Add an event listener to the login form
        const loginForm = document.getElementById('login-form');
        loginForm.addEventListener('submit', handleLogin);

        // Add an event listener to the registration form
        const registrationForm = document.getElementById('registration-form');
        registrationForm.addEventListener('submit', handleRegistration);
    </script>
</body>
</html>
