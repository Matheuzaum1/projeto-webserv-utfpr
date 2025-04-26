@echo off
echo Garantindo que as pastas existam...

rem Cria as pastas caso não existam
mkdir controllers
mkdir models
mkdir views
mkdir views\auth
mkdir views\event
mkdir views\dashboard
mkdir public
mkdir public\css
mkdir public\js
mkdir public\img

echo Criando arquivos .gitkeep...

rem Cria o .gitkeep dentro de cada pasta
type nul > controllers\.gitkeep
type nul > models\.gitkeep
type nul > views\.gitkeep
type nul > views\auth\.gitkeep
type nul > views\event\.gitkeep
type nul > views\dashboard\.gitkeep
type nul > public\.gitkeep
type nul > public\css\.gitkeep
type nul > public\js\.gitkeep
type nul > public\img\.gitkeep

echo .gitkeep criado com sucesso em todas as pastas!
pause
