#!/bin/bash

echo Se procedera a crear el archivo que contendra las credenciales para acceder a la base de datos mediante PHP

read -p "Ingrese el nombre de usuario (default es root): " username
if [ -z "$username" ]; then
	username="root"
fi

read -p "Ingrese la clave (default es ''): " clave
if [ -z "$clave" ]; then
	clave=""
fi

echo "[CREDENCIALES]" > mysql.ini
echo usuario = $username >> mysql.ini
echo clave = $clave >> mysql.ini

