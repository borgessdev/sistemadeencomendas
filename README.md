# Sistema de Controle de Encomendas

Aplicação web para controlar as encomendas de uma confeitaria. O projeto nasceu de um problema real: os pedidos ficavam espalhados entre caderno e WhatsApp, o que levava a datas de entrega esquecidas e dificuldade para saber quanto foi recebido no mês.

## Funcionalidades

- Cadastro de encomendas (cliente, telefone, descrição, valor e data de entrega)
- Controle de status: **pendente**, **pronto** e **entregue**
- Destaque visual para pedidos **atrasados** e entregas **do dia**
- Filtro por status e busca instantânea por cliente ou pedido
- Link direto para o WhatsApp do cliente
- Total recebido no mês e quantidade de pedidos a entregar
- Layout responsivo (funciona no celular)

## Prints

![Tela principal](prints/tela-principal.png)

## Tecnologias

- **PHP** (PDO)
- **MySQL**
- **JavaScript**
- **HTML5 e CSS3**

## Boas práticas aplicadas

- **Prepared statements** (PDO) em todas as consultas, para evitar SQL Injection
- **Escape de saída** com `htmlspecialchars`, para evitar XSS
- Validação do status no servidor antes de atualizar o banco
- Confirmação antes de excluir um pedido
- Foco visível no teclado e respeito à preferência de movimento reduzido

## Como rodar localmente

1. Instale o [XAMPP](https://www.apachefriends.org) e inicie o **Apache** e o **MySQL**.
2. Copie a pasta do projeto para `C:\xampp\htdocs\encomendas`.
3. Acesse `http://localhost/phpmyadmin`, vá na aba **Importar** e envie o arquivo `banco.sql`.
4. Abra `http://localhost/encomendas` no navegador.

> A conexão usa o usuário `root` sem senha, que é o padrão do XAMPP. Ajuste em `db.php` se o seu ambiente for diferente.

## Estrutura

```
encomendas/
├── banco.sql    # criação do banco e da tabela, com dados de exemplo
├── db.php       # conexão com o MySQL
├── index.php    # tela principal (listagem, filtros e formulário)
├── acoes.php    # criar, atualizar status e excluir
├── style.css    # estilos
└── script.js    # busca instantânea e confirmação de exclusão
```

## Próximos passos

- Editar uma encomenda já cadastrada
- Login para proteger o acesso
- Relatório de faturamento por mês

## Autor

**Arthur Borges Lima**
[LinkedIn](https://www.linkedin.com/in/arthur-borges-lima-245a263a5/) | [GitHub](https://github.com/borgessdev)
