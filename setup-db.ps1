#!/usr/bin/env pwsh
<#
  setup-db.ps1
  Script simples para importar database/schema.sql usando o MySQL do XAMPP.
    Uso: execute a partir do PowerShell: & 'C:\xampp\htdocs\db-extensao\setup-db.ps1'
#>

$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Definition
$schema = Join-Path $scriptDir 'database\schema.sql'

if (-not (Test-Path $schema)) {
    Write-Error "Arquivo de schema não encontrado em: $schema"
    exit 1
}

$candidates = @('C:\xampp\mysql\bin\mysql.exe','C:\xampp\mysql\bin\mariadb.exe')
$mysqlExe = $candidates | Where-Object { Test-Path $_ } | Select-Object -First 1
if (-not $mysqlExe) {
    $mysqlExe = Read-Host "Não encontrei mysql.exe automaticamente. Informe o caminho completo para mysql.exe"
    if (-not (Test-Path $mysqlExe)) {
        Write-Error "mysql.exe não encontrado no caminho informado."; exit 1
    }
}

Write-Host "Usando cliente MySQL: $mysqlExe"

$user = Read-Host "Usuário MySQL (Enter = root)"
if ([string]::IsNullOrWhiteSpace($user)) { $user = 'root' }
$pwdPlain = Read-Host "Senha MySQL (Enter = vazia)"

Write-Host "Importando esquema... isso pode demorar alguns segundos"
try {
    if ([string]::IsNullOrEmpty($pwdPlain)) {
        Get-Content -Path $schema -Raw | & $mysqlExe -u $user
    } else {
        # -p must be concatenated with password
        Get-Content -Path $schema -Raw | & $mysqlExe -u $user -p$pwdPlain
    }
    Write-Host "Importação finalizada. Verifique no phpMyAdmin: http://localhost/phpmyadmin"
} catch {
    Write-Error "Falha durante a importação: $_"
    exit 1
}
