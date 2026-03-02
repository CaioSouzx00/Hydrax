📝 COMANDOS ÚTEIS DO PROJETO LARAVEL - HYDRAX

1️⃣ Criar link da pasta storage para acesso via navegador

Comando: php artisan storage:link

Explicação: Cria um atalho da pasta “storage/app/public” para
“public/storage”. Assim, os arquivos salvos podem ser acessados pela
URL: /storage/nome-do-arquivo.ext

2️⃣ Iniciar o servidor Laravel

Comando: php artisan serve

Explicação: Inicia o servidor local do Laravel, geralmente acessível em:
http://127.0.0.1:8000

3️⃣ Criar uma nova migration

Comando: php artisan make:migration nome_da_migration

Explicação: Cria um arquivo de migration para criar ou alterar tabelas
no banco de dados.

4️⃣ Rodar as migrations

Comando: php artisan migrate

Explicação: Executa todas as migrations pendentes e cria/atualiza
tabelas no banco.

5️⃣ Reverter a última migration

Comando: php artisan migrate:rollback

Explicação: Desfaz a última execução de migrations (útil para testes de
estrutura).

6️⃣ Criar um novo model com controller e migration

Comando: php artisan make:model NomeDoModel -mc

Explicação: Cria o Model, o Controller e a Migration juntos. Economiza
tempo na estrutura do projeto.

7️⃣ Criar um controller

Comando: php artisan make:controller NomeDoController

Explicação: Gera um novo controller para organizar a lógica do sistema.

8️⃣ Criar um seeder

Comando: php artisan make:seeder NomeDoSeeder

Explicação: Usado para popular tabelas com dados iniciais (útil em
testes).

Rodar seeders: php artisan db:seed

9️⃣ Limpar cache de rotas, configs e views

Comandos: php artisan config:clear 
php artisan route:clear 
php artisan cache:clear 
php artisan view:clear

Explicação: Remove arquivos de cache para garantir que o Laravel use
sempre as alterações mais recentes.

🔟 Compilar caches para produção

Comandos: php artisan config:cache 
php artisan route:cache 
php artisan view:cache

Explicação: Gera arquivos de cache otimizados, deixando o sistema mais
rápido em produção.

1️⃣1️⃣ Rodar fila de jobs (emails automáticos, notificações, etc.)

Comando: php artisan queue:work

Explicação: Executa jobs em fila (como envio de emails automáticos). ⚠️
Se esse comando não estiver rodando, os emails automáticos não serão
disparados.

1️⃣2️⃣ Criar um middleware

Comando: php artisan make:middleware NomeDoMiddleware

Explicação: Cria middlewares para validar requisições (ex.:
autenticação, permissões).

1️⃣3️⃣ Listar rotas do projeto

Comando: php artisan route:list

Explicação: Mostra todas as rotas registradas no sistema, com seus
métodos e controllers.

1️⃣4️⃣ Criar uma nova request

Comando: php artisan make:request NomeDaRequest

Explicação: Cria uma classe para validar dados de formulários e
requisições.

1️⃣5️⃣ Atualizar autoload (composer dump)

Comando: composer dump-autoload
composer dump-autoload -o

Explicação: Recarrega todas as classes e arquivos registrados no
projeto. Útil quando o Laravel não reconhece novos arquivos.





composer require laravel/socialite
