@echo off
rem Atelier Ivoirien Des Cuisiniers - demarrage local (double-clic).
rem Ouvre le site sur http://127.0.0.1:8090 . Fermez la fenetre pour l'arreter.

cd /d "%~dp0"

set PORT=8090

set PHP=php
if exist "C:\laragon\bin\php\php-8.4.26-nts-Win32-vs17-x64\php.exe" set PHP=C:\laragon\bin\php\php-8.4.26-nts-Win32-vs17-x64\php.exe

start "Atelier Ivoirien Des Cuisiniers - 127.0.0.1:%PORT%" cmd /k %PHP% artisan serve --host=127.0.0.1 --port=%PORT%
