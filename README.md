# 💈 Barbearia Ivan

Sistema web desenvolvido para gerenciamento de uma barbearia, permitindo cadastro de usuários, login e gerenciamento de agendamentos com regras automáticas de disponibilidade.

Projeto desenvolvido utilizando **PHP**, **MySQL**, **Bootstrap**, **HTML/CSS** e **JavaScript**, com banco de dados estruturado para controle completo dos serviços e agendamentos.

---

## 🚀 Funcionalidades

### 👤 Sistema de Usuários

* Cadastro de usuários
* Login com autenticação
* Sessão de usuário
* Diferenciação de perfis:

  * Administrador
  * Usuário comum
* Controle de status:

  * ATIVO
  * INATIVO

---

### 🔐 Controle de Acesso

Administrador:

* Gerenciar agendamentos
* Criar novos agendamentos
* Criar novos clientes
* Visualizar clientes
* Gerenciar clientes
* Gerenciar serviços

  <img width="1439" height="730" alt="Captura de tela 2026-05-25 173326" src="https://github.com/user-attachments/assets/6943c8eb-7ccb-4d06-b889-d6c7ded70bb3" />


Usuário:

* Realizar login
* Agendar horários
* Visualizar informações pessoais
* Gerenciar agendamentos

  <img width="1422" height="383" alt="Captura de tela 2026-05-25 172958" src="https://github.com/user-attachments/assets/c11d7d86-3dab-4d7f-bf06-31220f34c07c" />
  <img width="1000" height="500" alt="Captura de tela 2026-05-25 172939" src="https://github.com/user-attachments/assets/2b32eaf7-0cd6-4c2c-a053-4701557f4af5" />
  <img width="1000" height="500" alt="Captura de tela 2026-05-25 172923" src="https://github.com/user-attachments/assets/417dee76-ad5a-40f2-b6e2-8b3ae29a2f0b" />

  


---

### ✂️ Gerenciamento de Serviços

* Cadastro de serviços
* Nome do serviço
* Descrição
* Preço
* Duração
* Status do serviço

Exemplo:

* Corte Degradê
* Barba
* Corte + Barba
* Lavagem e Hidratação

  <img width="1439" height="730" alt="Captura de tela 2026-05-25 173338" src="https://github.com/user-attachments/assets/ac573640-ec40-4bd4-bcc7-12f967c9fdb4" />


---

### 📅 Sistema Inteligente de Agendamentos

Funcionalidades implementadas:

✅ Criação de agendamento

✅ Seleção de cliente

✅ Seleção de serviço

✅ Campo de observações

✅ Horários gerados automaticamente

✅ Horários exibidos em intervalos de 30 minutos

Exemplo:

09:00
09:30
10:00
10:30

---

### 🧠 Regras automáticas do sistema

O sistema possui regras automáticas para impedir erros de agendamento.

#### Datas passadas bloqueadas

O usuário não pode selecionar dias anteriores à data atual.

---

#### Horários ocupados ocultos

Se existir um agendamento:

15/06/2026 — 10:30

o horário desaparece automaticamente da lista.

---

#### Dia totalmente lotado

Caso todos os horários estejam preenchidos:

"Todos os horários estão ocupados"

<img width="567" height="149" alt="image" src="https://github.com/user-attachments/assets/c7eefaee-7348-4e22-b038-6de8e507b2f5" />


---

#### Controle por dia da semana

Segunda a Sexta:

09:00 às 19:00

Sábado:

09:00 às 14:00

Domingo:

Fechado

Mensagem exibida:

"Não atendemos aos domingos"

---
### 🌙 Modo Dark / Light

O sistema possui suporte para alternância de tema, permitindo ao usuário escolher entre:

☀️ **Modo Claro (Light Mode)**
🌙 **Modo Escuro (Dark Mode)**

Funcionalidades:

* Alternância entre temas em tempo real
* Interface responsiva
* Preferência visual mais confortável para o usuário
* Melhor experiência de uso em ambientes claros ou escuros
* Mantém a identidade visual do sistema

<img width="1424" height="729" alt="Captura de tela 2026-05-25 172844" src="https://github.com/user-attachments/assets/b3554bd3-c56c-4e11-9310-f30831628373" />


---

### 🗄️ Banco de Dados

Estrutura principal:

Tabela **usuarios**

Campos:

* id
* nome
* email
* telefone
* role
* status
* senha
* created_at
* updated_at

---

Tabela **servico**

Campos:

* id
* nome
* descricao
* preco
* duracao
* status

---

Tabela **agendamento**

Campos:

* id
* data
* horario
* observacoes
* status
* cliente_id
* servico_id

---

Tabela **horario_funcionamento**

Campos:

* id
* dia_semana
* hora_inicio
* hora_fim
* status

---

### ⚙️ Recursos do Banco

* Chaves estrangeiras
* Integridade relacional
* Trigger para impedir horários duplicados
* Controle automático de disponibilidade
* Registro de data de criação
* Registro de atualização

---

## 🛠️ Tecnologias Utilizadas

Frontend:

* HTML5
* CSS3
* Bootstrap
* JavaScript

Backend:

* PHP

Banco de dados:

* MySQL
* XAMPP

---

## 📂 Estrutura do Projeto

```bash
admin/
│
├── includes/
│   ├── footer.php
│   └── header.php
│
├── agendamentos.php
├── clients.php
├── config.php
├── editar_agendamento.php
├── editar_cliente.php
├── editar_servico.php
├── excluir_agendamento.php
├── historico_cliente.php
├── index.php
├── novo_agendamento.php
├── novo_cliente.php
├── novo_servico.php
└── services.php

assets/
│
├── img/
│
└── js/
    └── theme-toggle.js

page/
│
├── auth/
│    ├── login.php
│    ├── logout.php
│    └── register.php
│
├── produtos.php
├── servicos.php
└── sobre.php

cliente/
│
├── cancelar_agendamento.php
├── editar_agendamento.php
├── editar_perfil.php
├── meus_agendamentos.php
└── perfil.php

config/
│
└── conection.php

styles/
│
├── auth.css
├── global.css
├── produtos.css
└── servicos.css

database.sql
index.php

```

---

## ▶️ Como executar o projeto

1. Instalar XAMPP

2. Iniciar:

* Apache
* MySQL

3. Importar o arquivo:

database.sql

4. Colocar o projeto na pasta:

```bash
htdocs
```

Exemplo:

```bash
C:\xampp\htdocs\Barbearia-Ivan
```

5. Acessar:

```bash
http://localhost/Barbearia-Ivan
```

---

## 📌 Melhorias futuras

* Dashboard com gráficos
* Sistema de pagamento
* Pesquisa de clientes
* Upload de imagem de perfil
* Sistema de notificações

---

## 👨‍💻 Desenvolvido por 

* Leandro Silva
* Gabriel Lima (Ranskyth)

Projeto acadêmico desenvolvido para a disciplina de Desenvolvimento Web.
