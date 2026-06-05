# ASoftMedia - Plataforma Corporativa e Educacional

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

Aplicação Web institucional, e-commerce simplificado e plataforma E-Learning (LMS) desenvolvida sob medida para a **ASoftMedia**, empresa angolana focada em inovação tecnológica, vendas de software de gestão, consultoria e treinamento em TI.

## 🚀 Módulos da Plataforma

A plataforma está dividida em 4 grandes eixos perfeitamente integrados:

1. **Portal Institucional**
   - Apresentação da empresa (Visão, Missão, Valores).
   - Catálogo de Serviços Corporativos (Consultoria, Redes, Homologação).
   - Landing pages dinâmicas com suporte nativo a **Dark Mode**.
   - Integração com Google Maps e formulários avançados de captação de Leads.

2. **E-Commerce (Loja de Produtos & Cursos)**
   - Catálogo com pesquisa e filtragem.
   - Sistema de Carrinho de Compras interativo (gerido por sessão).
   - Área de *Checkout* com resumo do pedido e cálculo de valores (Kz).

3. **Plataforma E-Learning (LMS)**
   - Dashboard exclusiva do Aluno para acompanhamento de progresso.
   - **Visualizador de Aulas** moderno e otimizado (estilo Udemy), com suporte a *iframes* do YouTube, navegação lateral de módulos e partilha de recursos anexos (PDFs, Códigos, etc).
   - Layout dedicado focado na imersão e foco no estudo.

4. **Painel de Administração Global**
   - Dashboard interativa com métricas gerais, gráficos (Chart.js) e atalhos rápidos.
   - Gestão de Utilizadores (Alunos, Formadores, Admins) e Controle de Acessos (ACL).
   - Gestão integrada de Produtos e Cursos (`/admin/produtos`).
   - Gestão de Leads recebidas pelo portal.
   - Configurações globais da plataforma.

## 🛠️ Tecnologias Utilizadas

* **Back-End:** Laravel 10 (PHP 8.1+)
* **Banco de Dados:** MySQL 8+
* **Front-End:** Blade Templates, Bootstrap 5.3 (com suporte nativo a `data-bs-theme="dark"`), HTML5, CSS3, Vanilla JS.
* **Autenticação:** Laravel Breeze
* **Gráficos & Data Visualization:** Chart.js
* **Ícones:** FontAwesome 6

## ⚙️ Pré-requisitos

Para executar este projeto localmente, vai necessitar das seguintes ferramentas instaladas:

* [PHP](https://www.php.net/) >= 8.1
* [Composer](https://getcomposer.org/)
* [Node.js](https://nodejs.org/) & NPM
* Banco de Dados MySQL / MariaDB

## 📦 Instalação

Siga os passos abaixo para preparar o ambiente de desenvolvimento:

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/seu-usuario/asoftmedia-app.git
   cd asoftmedia-app
   ```

2. **Instale as dependências do PHP:**
   ```bash
   composer install
   ```

3. **Instale e compile os recursos de Front-End:**
   ```bash
   npm install
   npm run build
   ```

4. **Configuração de Variáveis de Ambiente:**
   Duplique o ficheiro `.env.example` para `.env` e configure os dados do seu banco de dados:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Execute as Migrações e Seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Inicie o Servidor Local:**
   ```bash
   php artisan serve
   ```

A aplicação estará acessível em `http://localhost:8000` (ou a porta especificada).

## 🗂️ Estrutura de Rotas Principais

* `/` - Página Inicial (Portal)
* `/treinamento` - Catálogo de Cursos
* `/produtos` - Catálogo de Produtos
* `/carrinho` e `/checkout` - Fluxo de Compras
* `/lms/dashboard` - Painel do Aluno
* `/lms/curso/{id}/aula/{id}` - Sala de Aula do Aluno
* `/admin/dashboard` - Painel de Controle (Acesso Restrito)

## 🤝 Desenvolvido Por

Criado como solução customizada pela empresa **ASoftMedia** para acelerar a digitalização e treinamento em TI.

---
*© ASoftMedia. Todos os direitos reservados.*
