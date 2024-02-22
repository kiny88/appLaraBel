<?php

function debuguear($variable) : string{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string{
    $s = htmlspecialchars($html);
    return $s;
}

// Función para saber cual es el último id para poner el total a pagar
function esUltimo(string $actual,string $proximo) : bool{
    if($actual !== $proximo){
        return true;
    }

    return false;
}

// Función que revisa que el usuario está autenticado
function isAuth() : void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}

// Función para proteger el panel de administración
function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}