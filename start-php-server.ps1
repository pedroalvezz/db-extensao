#!/usr/bin/env pwsh
<#
  start-php-server.ps1
  Script para iniciar o servidor PHP embutido apontando para a pasta public.
  Uso: & 'C:\xampp\htdocs\db-extensao\start-php-server.ps1'
#>

$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Definition
$public = Join-Path $scriptDir 'public'

if (-not (Test-Path $public)) {
    Write-Error "Pasta public/ não encontrada em: $public"; exit 1
}

$candidates = @('C:\xampp\php\php.exe')
$phpExe = $candidates | Where-Object { Test-Path $_ } | Select-Object -First 1
if (-not $phpExe) {
    $phpExe = Read-Host "Não encontrei php.exe automaticamente. Informe o caminho completo para php.exe"
    if (-not (Test-Path $phpExe)) { Write-Error "php.exe não encontrado."; exit 1 }
}

$port = Read-Host "Porta para o servidor (Enter = 8000)"
if ([string]::IsNullOrWhiteSpace($port)) { $port = '8000' }

Write-Host "Iniciando servidor PHP embutido em http://localhost:$port/ (CTRL+C para parar)"
Write-Host "Diretório público: $public"

# Executa o servidor e mantém o processo no console atual
& $phpExe -S "localhost:$port" -t "$public"
