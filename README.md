<p align="center">
  <img src="public/assets/img/extras/guedes.png" alt="Toshokan Banner" width="100%" style="max-width: 920px; border-radius: 20px; box-shadow: 0 20px 60px rgba(1,22,30,0.35);">
</p>

<br>

<h1 align="center">📚 Projeto Toshokan</h1>

<p align="center">
  <b>Sistema de Gerenciamento de Livros</b>
</p>

<br>

<p align="center">
  <img src="https://img.shields.io/badge/version-1.0%20-%20Komi-261834?style=for-the-badge&logo=semver&logoColor=white" alt="Version">
  <img src="https://img.shields.io/badge/release-Novembro%202026-01161e?style=for-the-badge&logo=calendar&logoColor=white" alt="Release">
</p>

<br>

<p align="center">
  <a href="#-sobre">📖 Sobre</a> <b>·</b>
  <a href="#-status">📌 Status</a> <b>·</b>
  <a href="#-funcionalidades">✨ Funcionalidades</a> <b>·</b>
  <a href="#-tech-stack">🛠 Tecnologias e Ferramentas</a> <b>·</b>
  <a href="#-arquitetura">🏗 Arquitetura</a> <b>·</b>
  <a href="#-executar">🚀 Executar</a> <b>·</b>
  <a href="#-banco">🗄 Banco</a> <b>·</b>
  <a href="#-api">🧭 API</a> <b>·</b>
  <a href="#-seguranca">🛡 Segurança</a> <b>·</b>
  <a href="#-desenvolvedores">👥 Devs</a> <b>·</b>
</p>

<br>

---

<br>

<h2 id="-sobre" align="center">📖 Sobre</h2>

<p align="center">
  O <strong>Toshokan</strong> é um projeto acadêmico desenvolvido na disciplina de <strong>Programação Web (PWE)</strong>, sob orientação do <strong>Professor Rafael Russi Zamboni</strong>. É um sistema web completo para <strong>gerenciamento de biblioteca de livros</strong>, permitindo cadastrar, editar, listar e excluir livros com suporte a capas de imagem, busca por autor, ordenação e paginação.
</p>

<p align="center">
  Através de uma interface moderna construída com <strong>Bootstrap 5</strong> e <strong>SweetAlert2</strong>, o sistema oferece uma experiência fluida com modais estilizados, upload de imagens com cropper via <strong>CropperJS</strong> e notificações visuais em todas as ações.
</p>

<br>

<table align="center">
  <tr>
    <td align="center"><img src="https://img.shields.io/badge/-PHP%20Vanilla-777BB4?style=for-the-badge" alt="PHP Vanilla"></td>
  </tr>
</table>

<br>

---

<br>

<h2 id="-status" align="center">📌 Status</h2>

<p align="center">
  <blockquote>
    <strong>Versão:</strong> 1.0 - Komi <br>
    <strong>Lançamento:</strong> Novembro de 2026<br>
    <strong>Status:</strong> Concluído
  </blockquote>
</p>

<p align="center">
  O desenvolvimento do Toshokan foi finalizado com todas as funcionalidades planejadas implementadas: autenticação, CRUD completo de livros, gestão de perfil com upload e cropper de imagens, busca por autor, filtros, ordenação, paginação, troca de senha e sistema de notificações com SweetAlert2. :3
</p>

<br>

<p align="center">
  <img src="https://img.shields.io/badge/Auth%20%2B%20Cadastro-100%25-261834?style=for-the-badge" alt="Auth">
  <img src="https://img.shields.io/badge/CRUD%20Livros-100%25-261834?style=for-the-badge" alt="CRUD">
  <img src="https://img.shields.io/badge/Upload%20%2B%20Cropper-100%25-261834?style=for-the-badge" alt="Upload">
  <img src="https://img.shields.io/badge/Busca%20%2B%20Filtros-100%25-261834?style=for-the-badge" alt="Busca">
  <img src="https://img.shields.io/badge/Perfil%20%2B%20Senha-100%25-9F778F?style=for-the-badge" alt="Perfil">
</p>

<br>

---

<br>

<h2 id="-funcionalidades" align="center">✨ Funcionalidades</h2>

<br>

<table align="center">
  <tr>
    <td align="center" width="33%">
      <h3 align="center">🔐 Autenticação</h3>
      <p align="center">Login seguro com <strong>sessão PHP</strong>, mensagens de erro genéricas e <strong>password_hash()</strong> com bcrypt.</p>
    </td>
    <td align="center" width="33%">
      <h3 align="center">📚 CRUD Livros</h3>
      <p align="center">Cadastro, edição, listagem e exclusão de livros com ano de publicação (0 a 2026), capa de imagem opcional e upload de PDF do livro.</p>
    </td>
    <td align="center" width="33%">
      <h3 align="center">📸 Upload de Imagens</h3>
      <p align="center">Upload local com <strong>arrastar e soltar</strong> ou vinculação via URL externa. Proxy PHP para CORS.</p>
    </td>
  </tr>
  <tr>
    <td align="center">
      <h3 align="center">👤 Perfil</h3>
      <p align="center">Foto de perfil com <strong>CropperJS</strong> (recorte circular 400x400), upload local ou URL. Alteração de nome e senha.</p>
    </td>
    <td align="center">
      <h3 align="center">🔍 Busca e Filtros</h3>
      <p align="center">Buscar por <strong>título ou autor</strong>. Ordenar por ano (recente/antigo) e título (A-Z).</p>
    </td>
    <td align="center">
      <h3 align="center">🎉 Notificações</h3>
      <p align="center"><strong>SweetAlert2</strong> em todas as ações — login, logout, cadastro, edição, exclusão, erros e sucesso.</p>
    </td>
  </tr>
  <tr>
    <td align="center">
      <h3 align="center">📱 Design Responsivo</h3>
      <p align="center">Interface adaptável com <strong>Bootstrap 5</strong> e tema <strong>Biblioteca</strong> — paleta roxa personalizada.</p>
    </td>
    <td align="center">
      <h3 align="center">🌐 Proxy de Imagens</h3>
      <p align="center">Endpoint PHP que baixa imagens externas, resolve <strong>CORS</strong> e serve localmente no cropper.</p>
    </td>
    <td align="center">
      <h3 align="center">📋 Paginação</h3>
      <p align="center">Listagem paginada com controle de página ativa e navegação entre páginas.</p>
    </td>
  </tr>
</table>

<br>

---

<br>

<h2 id="-tech-stack" align="center">🛠 Tecnologias e Ferramentas</h2>

<p align="center">
  Abaixo estão as principais tecnologias, linguagens, bibliotecas e ferramentas utilizadas no desenvolvimento do nosso sistema:
</p>

<br>

<h3 align="center">💻 Linguagens de Programação e Marcação</h3>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
</p>

<br>

<h3 align="center">🗄️ Banco de Dados</h3>

<p align="center">
  <img src="https://img.shields.io/badge/MariaDB-12.3-4479A1?style=for-the-badge&logo=mariadb&logoColor=white" alt="MariaDB">
</p>

<br>

<h3 align="center">📚 Bibliotecas e Componentes</h3>

<p align="center">
  <img src="https://img.shields.io/badge/Bootstrap%205.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/SweetAlert2-7067CF?style=for-the-badge&logo=sweetalert2&logoColor=white" alt="SweetAlert2">
  <img src="https://img.shields.io/badge/CropperJS-6DB33F?style=for-the-badge&logoColor=white" alt="CropperJS">
  <img src="https://img.shields.io/badge/Font%20Awesome%206-528DD7?style=for-the-badge&logo=fontawesome&logoColor=white" alt="Font Awesome">
</p>

<br>

<h3 align="center">🧰 Ferramentas de Desenvolvimento</h3>

<p align="center">
  <img src="https://img.shields.io/badge/Visual%20Studio%20Code-007ACC?style=for-the-badge&logo=visualstudiocode&logoColor=white" alt="Visual Studio Code">
  <img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub">
  <img src="https://img.shields.io/badge/phpMyAdmin-6C78AF?style=for-the-badge&logo=phpmyadmin&logoColor=white" alt="phpMyAdmin">
  <img src="https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white" alt="XAMPP">
  <img src="https://img.shields.io/badge/Claude%20Code-Anthropic-261834?style=for-the-badge" alt="Claude Code">
  <img src="https://img.shields.io/badge/NVIDIA-Nemotron-76B900?style=for-the-badge" alt="NVIDIA Nemotron">
</p>

<br>

<h3 align="center">🔧 Back-end</h3>

<table align="center">
  <tr>
    <th align="center">Tecnologia</th>
    <th align="center">Aplicação</th>
  </tr>
  <tr>
    <td align="center"><strong>PHP 8.5</strong></td>
    <td align="center">Controllers organizados por ação — sem frameworks, roteamento manual</td>
  </tr>
  <tr>
    <td align="center"><strong>PDO (LivroORM)</strong></td>
    <td align="center">Prepared statements e operações de banco para livros</td>
  </tr>
  <tr>
    <td align="center"><strong>MySQLi</strong></td>
    <td align="center">Prepared Statements e conexão segura com MariaDB (perfil)</td>
  </tr>
  <tr>
    <td align="center"><strong>Sessão PHP</strong></td>
    <td align="center">Autenticação com verificação em todas as páginas protegidas</td>
  </tr>
</table>

<br>

<h3 align="center">⚙️ Middleware</h3>

<table align="center">
  <tr>
    <th align="center">Arquivo</th>
    <th align="center">Função</th>
  </tr>
  <tr>
    <td align="center"><code>verificador.php</code></td>
    <td align="center">Função <code>VerificarLogin()</code> — redireciona para login se não houver sessão ativa</td>
  </tr>
</table>

<br>

---

<br>

<h2 id="-arquitetura" align="center">🏗 Arquitetura</h2>

<p align="center">
  O projeto segue uma arquitetura MVC simplificada, com separação clara entre camada de apresentação (PHP + HTML + Bootstrap), lógica de negócio (controllers PHP) e dados (MariaDB via PDO/MySQLi).
</p>

<br>

```
Toshokan/
│
├── 📁 api/
│   ├── 📁 config/        — Conexão com o banco
│   ├── 📁 controllers/   — Lógica de cada ação
│   ├── 📁 helpers/       — Funções reutilizáveis
│   └── 📁 middleware/    — Autenticação
│
├── 📁 public/
│   ├── 📁 pages/         — Páginas PHP (views)
│   ├── 📁 components/    — Componentes reutilizáveis
│   └── 📁 assets/
│       ├── 📁 css/       — Estilos organizados
│       ├── 📁 js/        — Scripts organizados
│       └── 📁 img/       — Imagens organizadas
│
└── 📁 database/
    └── biblioteca.sql    — Script de criação do banco
```

---

<br>

<h2 id="-executar" align="center">🚀 Executar</h2>

<p align="center">
  Siga os passos abaixo para rodar o Toshokan no seu ambiente local.
</p>

<br>

<h3 align="center">📋 Pré-requisitos</h3>

<table align="center">
  <tr>
    <th align="center" width="50%">🪟 Windows / 🐧 Linux</th>
    <th align="center" width="50%">🍎 macOS</th>
  </tr>
  <tr>
    <td align="center"><b>XAMPP</b> (PHP 8.0+, MariaDB 10.4+)</td>
    <td align="center"><b>MAMP</b> ou <b>XAMPP</b> (PHP 8.0+, MariaDB 10.4+)</td>
  </tr>
  <tr>
    <td align="center">Servidor <b>Apache</b> rodando</td>
    <td align="center">Servidor <b>Apache</b> rodando</td>
  </tr>
  <tr>
    <td align="center"><b>phpMyAdmin</b> ou cliente MariaDB</td>
    <td align="center"><b>phpMyAdmin</b> ou cliente MariaDB</td>
  </tr>
</table>

<br>

<h3 align="center">👣 Passo a Passo</h3>

<br>

<details>
  <summary><strong>🪟 Windows</strong> (XAMPP em <code>C:\xampp\htdocs\</code>)</summary>

  <br>

  ```bash
  # 1️⃣ Clone o repositório
  git clone https://github.com/Lindverne/Toshokan.git

  # 2️⃣ Mova para a pasta do XAMPP
  move Toshokan C:\xampp\htdocs\

  # 3️⃣ Importe o banco de dados
  #    phpMyAdmin → Importar → database/biblioteca.sql

  # 4️⃣ Configure a conexão
  #    Edite api\config\conexao.php com suas credenciais MySQL/MariaDB

  # 5️⃣ Acesse no navegador
  #    http://localhost/Toshokan/public/
  ```

</details>

<br>

<details>
  <summary><strong>🐧 Linux</strong> (XAMPP em <code>/opt/lampp/htdocs/</code>)</summary>

  <br>

  ```bash
  # 1️⃣ Clone o repositório
  git clone https://github.com/Lindverne/Toshokan.git

  # 2️⃣ Mova para a pasta do XAMPP
  sudo mv Toshokan /opt/lampp/htdocs/

  # 3️⃣ Importe o banco de dados
  #    phpMyAdmin (http://localhost/phpmyadmin) → Importar → database/biblioteca.sql

  # 4️⃣ Configure a conexão
  #    Edite api/config/conexao.php com suas credenciais MySQL/MariaDB

  # 5️⃣ Acesse no navegador
  #    http://localhost/Toshokan/public/
  ```

</details>

<br>

<details>
  <summary><strong>🍎 macOS</strong> (MAMP em <code>/Applications/MAMP/htdocs/</code>)</summary>

  <br>

  ```bash
  # 1️⃣ Clone o repositório
  git clone https://github.com/Lindverne/Toshokan.git

  # 2️⃣ Mova para a pasta do MAMP
  mv Toshokan /Applications/MAMP/htdocs/

  # 3️⃣ Importe o banco de dados
  #    phpMyAdmin (http://localhost:8888/phpmyadmin) → Importar → database/biblioteca.sql

  # 4️⃣ Configure a conexão
  #    Edite api/config/conexao.php com suas credenciais MySQL/MariaDB

  # 5️⃣ Acesse no navegador
  #    http://localhost:8888/Toshokan/public/
  ```

</details>

<br>

---

<br>

<h2 id="-banco" align="center">🗄 Banco de Dados</h2>

<p align="center">
  O Toshokan utiliza a tabela <strong>livros</strong> no MariaDB, modelada para suportar gerenciamento completo de livros com capa de imagem opcional:
</p>

<br>

<table align="center">
  <tr>
    <th align="center">Tabela</th>
    <th align="center">Descrição</th>
    <th align="center">Campos-chave</th>
  </tr>
  <tr>
    <td align="center">🔐 <code>usuarios</code></td>
    <td align="center">Autenticação e perfil</td>
    <td align="center"><code>id</code>, <code>login</code>, <code>senha</code> (hash bcrypt), <code>foto_perfil</code></td>
  </tr>
  <tr>
    <td align="center">📚 <code>livros</code></td>
    <td align="center">Catálogo de livros da biblioteca</td>
    <td align="center"><code>id</code>, <code>titulo</code>, <code>autor</code>, <code>ano</code>, <code>imagem</code></td>
  </tr>
</table>

<br>

---

<br>

<h2 id="-api" align="center">🧭 Controllers (Backend)</h2>

<p align="center">
  O backend do Toshokan é organizado em <strong>controllers PHP</strong> — cada arquivo trata uma ação específica, com validação de sessão e respostas via redirect:
</p>

<br>

<details>
  <summary><strong>🔐 Autenticação</strong> (4 endpoints — público)</summary>

  <br>

  | Método | Endpoint | Descrição |
  |:-------|:---------|:----------|
  | GET | <code>/public/pages/login.php</code> | Página de login |
  | POST | <code>/api/controllers/doLogin.php</code> | Login — valida credenciais com <code>password_verify()</code> |
  | POST | <code>/api/controllers/doCadastro-do-usuario.php</code> | Registro — cria conta com <code>password_hash()</code> |
  | GET | <code>/api/controllers/logout.php</code> | Logout — destrói sessão |

</details>

<br>

<details>
  <summary><strong>📚 Livros</strong> (4 endpoints — requer sessão)</summary>

  <br>

  | Método | Endpoint | Descrição |
  |:-------|:---------|:----------|
  | GET | <code>/public/pages/cadastrar.php</code> | Página de cadastro de livro |
  | POST | <code>/api/controllers/doCadastro.php</code> | Cadastra livro com upload opcional de imagem |
  | POST | <code>/api/controllers/doAlterar.php</code> | Atualiza livro (mantém imagem atual se não enviar nova) |
  | GET | <code>/api/controllers/excluir.php</code> | Deleta livro por ID |

</details>

<br>

<details>
  <summary><strong>👤 Perfil</strong> (2 endpoints — requer sessão)</summary>

  <br>

  | Método | Endpoint | Descrição |
  |:-------|:---------|:----------|
  | POST | <code>/api/controllers/atualizarPerfil.php</code> | Atualiza foto, dados ou senha do perfil |
  | GET | <code>/api/controllers/proxy_imagem.php</code> | Proxy para baixar imagens externas (resolve CORS) |

</details>

<br>

> 📊 **Total: 10 endpoints** em 4 módulos — 4 públicos, 6 protegidos por sessão.

<br>

---

<br>

<h2 id="-seguranca" align="center">🛡 Segurança</h2>

<br>

<table align="center">
  <tr>
    <td width="50%">
      <h3 align="center">🔒 Prepared Statements</h3>
      <p align="center">100% das queries com prepared statements (PDO/MySQLi) — proteção completa contra SQL injection.</p>
    </td>
    <td width="50%">
      <h3 align="center">🔑 Senhas com bcrypt</h3>
      <p align="center"><code>password_hash()</code> + <code>password_verify()</code> — armazenamento seguro com custo adaptativo.</p>
    </td>
  </tr>
  <tr>
    <td>
      <h3 align="center">🍪 Sessão Segura</h3>
      <p align="center">Sessão PHP verificada em todas as páginas protegidas via middleware <code>VerificarLogin()</code>.</p>
    </td>
    <td>
      <h3 align="center">🚫 Controle Server-side</h3>
      <p align="center">Acesso verificado no servidor — páginas protegidas redirecionam se não há sessão.</p>
    </td>
  </tr>
  <tr>
    <td>
      <h3 align="center">🛑 Mensagem Genérica</h3>
      <p align="center">"Usuário ou senha incorretos!" — sem vazar qual campo está errado.</p>
    </td>
    <td>
      <h3 align="center">🌐 Proxy de Imagens</h3>
      <p align="center">Endpoint PHP que valida URLs (HTTP/HTTPS), previne SSRF e baixa imagens de forma segura.</p>
    </td>
  </tr>
</table>

<br>

<p align="center">
  <blockquote>
    ℹ️ Erros de banco são tratados internamente — mensagens amigáveis via SweetAlert2, sem expor detalhes técnicos ao usuário.
  </blockquote>
</p>

<br>

---

<br>

<h2 id="-desenvolvedores" align="center">👥 Desenvolvedores</h2>

<p align="center">
  O <strong>Toshokan</strong> foi desenvolvido como trabalho acadêmico da disciplina de <strong>Programação Web (PWE)</strong>, sob orientação do <strong>Professor Rafael Russi Zamboni</strong>.
</p>

<br>

<table align="center">
  <thead>
    <tr>
      <th align="center" width="120">Integrante</th>
      <th align="left">Nome</th>
      <th align="center" width="320">Responsabilidade</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="center" valign="middle">
        <img src="public/assets/img/extras/guedes.png" width="96" height="96" alt="Matheus Guedes">
      </td>
      <td valign="middle"><strong>Matheus Guedes</strong></td>
      <td align="center" valign="middle">
        <img src="https://img.shields.io/badge/💻%20Desenvolvimento%20Full%20Stack-261834?style=for-the-badge" alt="Desenvolvimento Full Stack">
      </td>
    </tr>
  </tbody>
</table>

<br>

---

<br>

<p align="center">
  <img src="public/assets/img/extras/sticker.png" width="220" alt="Toshokan" style="border-radius: 16px;">
</p>

<h3 align="center">
  📚 Sistema de gerenciamento de biblioteca com PHP e Bootstrap. Um Projeto de Programação Web (PWE).
</h3>

<br>

<p align="center">
  <img src="https://img.shields.io/badge/GitHub-01161e?style=for-the-badge&logo=github&logoColor=white" alt="GitHub">
</p>
