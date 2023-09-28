<?php
$servername = ${{ secrets.servername }};
$username = ${{ secrets.username }};
$password = ${{ secrets.password }};
$dbname = {{ secrets.dbname }};

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// echo 'Conectado';

