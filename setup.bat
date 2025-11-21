@echo off
title Setup do Projeto Hydrax - TCC
color 0A

echo ==============================================
echo     💧 Configurando Projeto Hydrax - TCC
echo ==============================================
echo.

REM ---- Verifica se Composer está instalado ----
echo Verificando Composer...
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ Composer não encontrado! Instale o Composer e tente novamente.
    pause
    exit /b
)
echo ✅ Composer encontrado.
echo.

REM ---- Verifica se Node.js está instalado ----
echo Verificando Node.js...
where node >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ Node.js não encontrado! Instale o Node.js e tente novamente.
    pause
    exit /b
)
echo ✅ Node.js encontrado.
echo.

REM ---- Instala dependências PHP apenas se necessário ----
if exist vendor (
    echo ⚙️ Dependências PHP já instaladas.
) else (
    echo Instalando dependências do PHP...
    call composer install || (
        echo ❌ Erro ao instalar dependências PHP!
        pause
        exit /b
    )
    echo ✅ Dependências PHP instaladas.
)
echo.

REM ---- Instala dependências Node apenas se necessário ----
if exist node_modules (
    echo ⚙️ Dependências Node já instaladas.
) else (
    echo Instalando dependências do Node.js...
    call npm install || (
        echo ❌ Erro ao instalar dependências Node!
        pause
        exit /b
    )
    echo ✅ Dependências Node instaladas.
)
echo.

REM ---- Cria o arquivo .env se não existir ----
if not exist .env (
    echo Criando arquivo .env...
    copy .env.example .env >nul
    echo ✅ Arquivo .env criado.
) else (
    echo ⚙️ Arquivo .env já existe.
)
echo.

REM ---- Gera chave da aplicação ----
echo Gerando chave da aplicação...
call php artisan key:generate || (
    echo ❌ Erro ao gerar chave!
    pause
    exit /b
)
echo ✅ Chave gerada.
echo.

REM ---- Exibição de imagens de produtos ----
echo Iniciando a exibição das imagens...
start cmd /k "php artisan storage:link"

REM ---- Inicia o servidor Laravel ----
echo Iniciando servidor Laravel...
start cmd /k "php artisan serve"

REM ---- Inicia o Vite (front-end) ----
echo Iniciando Vite (npm run dev)...
start cmd /k "npm run dev"

echo.
echo 🚀 Projeto Hydrax iniciado com sucesso!
echo ==============================================
pause
exit
