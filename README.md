# Controle Financeiro de Contas a Pagar

## Descrição do Projeto

Este projeto consiste em um sistema de controle financeiro para gerenciar contas a pagar. Ele foi desenvolvido em PHP com arquitetura MVC (Model-View-Controller), utilizando MySQL como banco de dados. O sistema permite adicionar novas contas, listar contas existentes, editar informações e marcar contas como pagas ou pendentes.

## Funcionalidades

- Adicionar novas contas a pagar
- Listar todas as contas cadastradas
- Editar informações das contas (valor, data de pagamento)
- Marcar contas como pagas ou pendentes
- Excluir contas do sistema

## Pré-requisitos

- PHP >= 7.0
- MySQL
- Apache (ou servidor web similar)

## Instalação

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/seu-usuario/nome-do-repositorio.git
   cd nome-do-repositorio
   ```

2. **Configuração do Banco de Dados:**
    - Renomeie o arquivo `database.example.php` para `database.php`.
    - Edite o arquivo `database.php` com as credenciais do seu banco de dados MySQL.
3. **Inicialize o Banco de Dados:**
    - Importe o arquivo SQL fornecido (`script.sql`) para criar as tabelas necessárias.
4. **Configuração do Servidor Web:**
    - Certifique-se de configurar o servidor web para apontar para o diretório raiz do projeto.
5. **Acesso ao Sistema:**
    - Abra o navegador e acesse o sistema pelo URL configurado no seu servidor web.

## Estrutura do Projeto

- `app/`: Contém o código PHP da aplicação MVC.
- `public/`: Arquivos públicos acessíveis pelo navegador (CSS, JavaScript).
- `database.example.php`: Exemplo de arquivo de configuração. Renomeie para `database.php` e configure com suas credenciais.
- `script.sql`: Arquivo SQL para criação das tabelas no banco de dados.

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests para melhorias no código.

### database.example.php

Crie um arquivo chamado `database.example.php` com o seguinte conteúdo:

### Considerações Finais

- O arquivo `script.sql` deve conter o script SQL para criar as tabelas necessárias no banco de dados.