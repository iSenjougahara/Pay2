Aqui vou falar um pouco sobre a minha experiencia desenvolvendo o projeto de avaliação e sua estrutura

resumo:
  nunca usei boa parte das ferramentas pedidas nos requisitos, me perdi bastante em certos pontos, e aprendi muito.

estrutura:

  tabelas do banco: conta, usuario, movimento  
      -cada usuario tem uma conta
      -uma conta pode ter diversas movimentações
      -uma movimentação pertence a uma conta

  dentro do sistema tentei aplicar a estrutura de repository pattern onde
    1- rota recebe um request e o envia ao controller
    2- controller filtra o request e o envia ao repositorio (se necessario)
    3- repositorio faz alterações no banco de dados

repositorio tem ambos interface e repository para cada model (com exceção de movimento já que achei melhor manter seus metodos dentro de conta)
repository herda os metodos base da interface
controller consegue os metodos existentes dentro de repository pelo construtor que faz referencia ao mesmo


quanto as tratativas do back:

o cadastro de usuario automaticamente cria tambem uma conta
os codigos TRANSF0000 e DEP0000 são feitos usando um prefixo + o proprio id de movimento recem criado
autenticação de usuario é feita utilizando jwt tokens que são armazenados no localstore do browser e enviados por header em cada request via json
dados do usuario logado são recuperados ao validar o token presente no header 
a tabela movimentos age como um historico de movimentações para ambos transferencias e depositos, onde a unica diferença entre as duas transações é o fato de que uma movimentação de transferencia tem um valor no atributo 'receiver' representando quem recebeu a transferencia, e uma movimentação de deposito tem o atributo 'receiver' como nulo, ja que o deposito é uma adição de valores a propria conta
uma transferencia só pode ser feita se a conta tiver um valor maior ou igual ao valor transferido
cpf é um valor unico no banco de dados

quanto ao front:

a tela inicial ('/') age ambos como login e cadastro, um form pra cada na mesma pagina
um usuario cadastrado é automaticamente logado no sistema
a validação usando a api viaCep é feita ao pressionar o botao abaixo de cep, onde será avaliado se o cep é real, e se sim o campo complemento será preenchido automaticamento (se o json retornado da api conter informações sobre complemento, o cep de mongaguá por exemplo (11730000) tem vários dos atributos como null

uma vez logado o usuario tem 6 operações disponiveis após ser redirecionado para /logged
ao clicar em User Data, será apresentado um json com os dados do usuario
ao clicar em Conta Data, será apresentado um json com os dados da conta e seu saldo
ao clicar em All Users , será apresentado um json com dados de todos os usuarios existentes no banco
ao clicar em movimentos, será apresentado um json com todos os movimentos feitos por este usuario

ao inserir um valor e clicar em depositar, será feito um deposito na conta to usuario adicionando o valor inserido ao saldo atual
ao inserir um valor, um codigo de conta e clicar em transferencia, será feita uma transferencia subtraindo o saldo do usuario pelo valor inserido, e acrescentando este mesmo valor ao saldo da conta cujo codigo foi especificado 

as movimentações podem ser checadas clicando novamente em movimentações após fazer uma transferencia ou deposito, assim será exibido a movimentação recem feita 

ao clicar em Logoff, o token atual é invalidado e o usuario é redirecionado a tela inicial ('/')


log diario:

dia-1
    recebi o email com o form dando as requisições pro projeto a tarde, usei o resto do dia me introduzindo a o que era lumen, docker (já tinha ouvido falar sobre       mas muito superficialmente), e outros detalhes de avaliação como repository pattern e SOLID seguido de criar uma estrutura teorica inicial para o projeto quanto a banco de dados e classes
                    

dia-2
    criei a aplicação laravel/lumen tentando implementar ambos um sistema com base em repository pattern e autenticação de usuarios via token
tive problemas com flipbox lumen generator relacionado a endereço de pastas, foi resolvido abrindo as pastas referentes e só, não fiz alteração nenhuma, só chequei as pastas e o problema sumiu literalmente, o que nao faz muito sentido pra mim.
    tive problemas com a autenticação via token com jwt-auth, acabei tendo que criar um projeto novo inteiro e fazer questao de começar por essa parte uma vez que já tinha feito a estrutura de model/repository/controller no primeiro projeto e tinha certeza que seria mais facil implementar os tokens antes de implementar a estrutura de dados. acredito que o problema tenha sido o enderaço de pastas e ordem de instalação de pacotes, mas tentar resolver consumiu muito tempo, e por isso o titulo deste repositori é Pay"2".
    tudo deu certo na segunda tentativa e terminei 80% do backend .
     meu proximo passo foi utilizar o docker para armazenar a aplicação como pedido, até o momento tinha utilizado xampp como localhost.
     tentei utilizar laravel sail depois de confirmer que havia suporte para lumen, mas sem sucesso, tentei diversos metodos porem terminei o dia sem docker.

dia-3(hoje)
    terminei o backend 100% e testei de maneira definitiva todas as rotas com middlewares
    meu proximo passo foi usar snack expo para criar uma interface que pudesse se comunicar com a api, sem sucesso, tentei por bastante tempo resolver esse problema e cheguei até a tentar configurar permissoes CORS já que se tratava do problema apontado pelo inspecionar, utilizando composer require barryvdh/laravel-cors, que me permitiu receber dados da api via get, mas nunca enviar requisições, sendo assim decidi utilizar as blades no lumen como interface e fazer as requisições pra api com fetch().
    quando terminei todas as funçoes do front decidi tentar novamente a implementação do docker, desta vez tendo conhecimento sobre algumas das configurações necessarias referentes a wsl, sem sucesso, o arquivo docker-compose.yml é criado mas sail up trava em uma linha especifca, o arquivo dockerfile tambem é criado com as configurações especificadas pelo sail, então talvez ele possa funcionar em outro ambiente, mas no meu não funcionou.
    e assim terminei o dia reservando os ultimos 30 minutos para tentar escrever esse relatorio.
    
    

observações finais:

queria muito não ter desperdiçado tanto tempo tentando fazer a aplicação no snack expo funcionar com a minha api, mas como esse era o unico ambiente de desenvolvimento react que eu tinha "pronto", assumi que perderia tanto tempo quanto se tivesse que criar um ambiente local do zero.

queria tambem ter tido tempo implementado mais tratativas de erros e validações no projeto

tenho muito a agradecer a todas as fontes de informação que pude encontrar sobre as ferramentas que eu nunca tinha usado.
eu entrego este projeto com a dor de que ele podia ter sido mais polido, e a certeza de que farei melhor daqui em diante.
por que eu aprendi muito
e foi um prazer.



