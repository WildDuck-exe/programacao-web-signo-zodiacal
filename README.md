# 🔮 Signo Zodiacal — Projeto PHP + XML

> Aplicação web para descobrir o signo zodiacal a partir da data de nascimento.  
> Desenvolvida com **PHP puro**, **XML**, **HTML5**, **CSS3** e **Bootstrap 5**.

---

## 📋 Índice

1. [Pré-requisitos](#pré-requisitos)
2. [Estrutura do projeto](#estrutura-do-projeto)
3. [Como instalar e iniciar](#como-instalar-e-iniciar)
4. [Como usar a aplicação](#como-usar-a-aplicação)
5. [Solução de problemas](#solução-de-problemas)
6. [Tecnologias utilizadas](#tecnologias-utilizadas)

---

## ✅ Pré-requisitos

Antes de começar, você precisa ter instalado em seu computador:

| Ferramenta | Versão mínima | Download |
|---|---|---|
| **XAMPP** | 7.4+ (PHP 7.4 ou 8.x) | [apachefriends.org](https://www.apachefriends.org/pt_br/index.html) |
| **Navegador** | Qualquer moderno | Chrome, Edge, Firefox… |

> **VSCode** é opcional — apenas para visualizar ou editar o código.

---

## 📁 Estrutura do projeto

```
projeto-ian/
│
├── 📄 index.php                  → Página inicial (formulário)
├── 📄 show_zodiac_sign.php       → Página de resultado (lógica PHP)
├── 📄 signos.xml                 → Dados dos 12 signos do zodíaco
├── 📄 README.md                  → Este arquivo
│
├── 📂 layouts/
│   └── 📄 header.php             → Cabeçalho HTML reutilizável
│
└── 📂 assets/
    ├── 📂 css/
    │   └── 📄 style.css          → Estilos personalizados
    ├── 📂 imgs/                  → Pasta para imagens (reservada)
    └── 📂 js/                    → Pasta para scripts (reservada)
```

---

## 🚀 Como instalar e iniciar

### Passo 1 — Instale o XAMPP

1. Acesse [apachefriends.org](https://www.apachefriends.org/pt_br/index.html)
2. Baixe e instale o XAMPP para Windows
3. Siga o assistente de instalação (deixe o caminho padrão `C:\xampp\`)

---

### Passo 2 — Copie o projeto para o XAMPP

1. Abra o **Explorador de Arquivos**
2. Navegue até a pasta de instalação do XAMPP:
   ```
   C:\xampp\htdocs\
   ```
3. **Cole a pasta do projeto** dentro de `htdocs`. O resultado deve ser:
   ```
   C:\xampp\htdocs\projetoIan\
   ```

> ⚠️ **Atenção:** Se o nome da pasta tiver espaço (ex: `projeto ian`), renomeie para `projeto-ian` (com hífen) ou '`projetoIan` (camelCase)  . Espaços em nomes de pasta podem causar problemas na URL.

---

### Passo 3 — Inicie o servidor Apache

1. Abra o **XAMPP Control Panel**  
   *(procure por "XAMPP" no Menu Iniciar)*

2. Clique em **Start** na linha do **Apache**:

   ```
   [ Apache ]  [ Start ]  ← clique aqui
   [ MySQL  ]  [ Start ]  ← não é necessário para este projeto
   ```

3. Aguarde o status ficar **verde**. Se aparecer a porta `80` confirmada, está tudo certo.

---

### Passo 4 — Abra a aplicação no navegador

Digite o seguinte endereço na barra do navegador:

```
http://localhost/projetoIan/index.php
```

A tela inicial da aplicação será exibida. ✅

---

## 🪐 Como usar a aplicação

### Tela inicial

![Tela inicial](assets/imgs/.gitkeep)

1. Na tela inicial, você verá o título **"Descubra seu Signo"**
2. Clique no campo de data e **selecione sua data de nascimento** (ou digite no formato `DD/MM/AAAA`)
3. Clique no botão **"Descobrir meu signo"**

---

### Tela de resultado

Após enviar o formulário, você será redirecionado para a página de resultado, que exibirá:

- 🔮 **Emoji do signo**
- ✨ **Nome do signo** (ex.: Escorpião)
- 📅 **Período** do signo (ex.: 23/10 — 21/11)
- 👤 **Data que você informou** (em formato legível)
- 📝 **Descrição** com as características do signo

Para consultar outro signo, clique em **"Descobrir outro signo"** para voltar ao início.

---

## 🛠 Solução de problemas

### ❌ "Página não encontrada" ou erro 404

- Verifique se o Apache está rodando (status verde no XAMPP)
- Confirme que a pasta está em `C:\xampp\htdocs\projeto-ian\`
- Confirme a URL: `http://localhost/projeto-ian/index.php`

---

### ❌ Página em branco ou erro PHP

- Certifique-se de que está usando **PHP 7.4 ou superior**
- Verifique se o arquivo `signos.xml` está na raiz do projeto (junto com `index.php`)
- No XAMPP Control Panel, clique em **Logs → Apache Error Log** para ver detalhes do erro

---

### ❌ Estilos não carregam (página sem visual)

- Confirme que a pasta `assets/css/style.css` existe
- Verifique sua **conexão com a internet** — Bootstrap e as fontes são carregados via CDN (online)
- Tente pressionar `Ctrl + Shift + R` no navegador para forçar o recarregamento

---

### ❌ O Apache não inicia (porta ocupada)

Outro programa pode estar usando a porta 80. Solução:

1. No XAMPP Control Panel, clique em **Config → Apache (httpd.conf)**
2. Procure por `Listen 80` e troque para `Listen 8080`
3. Salve e reinicie o Apache
4. Acesse via: `http://localhost:8080/projeto-ian/index.php`

---

## 🧰 Tecnologias utilizadas

| Tecnologia | Função |
|---|---|
| **PHP 7.4+** | Lógica de back-end e leitura do XML |
| **XML + SimpleXML** | Armazenamento dos dados dos signos |
| **HTML5** | Estrutura das páginas |
| **CSS3** | Estilos personalizados e animações |
| **Bootstrap 5** | Layout responsivo e componentes visuais |
| **Bootstrap Icons** | Ícones da interface |
| **Google Fonts (Inter)** | Tipografia moderna |

---

## 📌 Observações finais

- A aplicação **não usa banco de dados** — todos os dados estão no arquivo `signos.xml`
- A lógica de identificação do signo funciona corretamente inclusive para **Capricórnio**, que atravessa a virada do ano (22/12 a 20/01)
- Nenhuma informação inserida é salva ou armazenada

---

*Desenvolvido como atividade prática acadêmica — PHP + XML + Bootstrap.*
