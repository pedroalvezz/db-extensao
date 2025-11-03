# Charity Portal (PHP OOP MVC)

Projeto acadêmico: site dinâmico para instituições de caridade, com POO em PHP, MVC simples, autenticação, segurança (CSRF, XSS, SQL Injection), CRUDs, relatórios e gamificação (pontos e leaderboard) + mural de transparência.

## Requisitos
- PHP 8+ (XAMPP)
- MySQL (MariaDB do XAMPP)
- Apache com mod_rewrite habilitado

## Estrutura
- `public/` front controller (`index.php`) e assets
- `app/Core/` núcleo: Router, Controller, Database, Auth, BaseModel
- `app/Controllers/`, `app/Models/`, `app/Views/`
- `config/config.php` configurações
- `database/schema.sql` criação das tabelas e seeds

## Passo a passo (XAMPP – Windows)
1) Copie a pasta do projeto para: `C:\\xampp\\htdocs\\db-extensao`
2) Inicie Apache e MySQL no XAMPP Control Panel.
3) Importe o banco:
   - Abra `http://localhost/phpmyadmin`
   - Crie o banco `charity_portal` (utf8mb4)
   - Importe o arquivo `database/schema.sql`
4) Configure o app:
   - Edite `config/config.php` se necessário:
     - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` (padrão XAMPP: root sem senha)
     - `APP_URL` deve ser `/db-extensao/public`
5) Acesse: `http://localhost/db-extensao/public`.

Usuário seed (admin):
- email: `admin@local`
- senha: `password` (se necessário, crie um admin via registro e ajuste no phpMyAdmin)

Obs: se o admin não entrar, edite a senha no phpMyAdmin para um hash de `password` gerado por `password_hash('password', PASSWORD_BCRYPT)`.

## Principais Funcionalidades
- Autenticação: registro, login, logout (sessões, senhas com hash)
- Segurança: CSRF tokens, prepared statements (PDO), saída escapada (XSS)
- CRUDs: Instituições, Usuários (admin), Doações, Eventos
- Relatórios: Doações por período; Rankings por instituição e por doador
- Inovação: Gamificação (pontos por doação e leaderboard) e Mural da Transparência

## Observações de Segurança
- Sempre usar prepared statements (já aplicado)
- Saída com `e()` que usa `htmlspecialchars`
- CSRF em todo POST via `csrf_field()` e `verify_csrf()`
- `session_regenerate_id(true)` após login e logout

## Empacotar para envio
- Zipe a pasta inteira do projeto (sem `vendor` – não usamos) incluindo `public`, `app`, `config`, `database`, `README.md`.
- Nome sugerido: `charity-portal-pedro.zip`

## Próximos Passos (opcional)
- Implementar edição de doações/eventos
- Badges automáticos com base no total doado
- Upload de imagens para instituições/eventos