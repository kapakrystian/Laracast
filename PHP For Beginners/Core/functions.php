<?php


use Core\Response;


function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) {
        abort($status);
    }
}

/*------------------------------------------------
Funkcja pomocnicza określająca ścieżkę pliku
 (Folder główny aplikacji + ścieżka z parametru)
-------------------------------------------------*/
function base_path($path = '')
{
    return BASE_PATH . $path;
}

/*----------------------------------------------------
Funkcja pomocnicza odpowiedzialna za ładowanie widoków
 (extract - zamienia przekazywaną tablicę atrybutów
 do postaci zmienna(klucz) - wartość(wartość klucza))
Dzięki temu można odnosić się do danych z kontrolera
bezpośrednio w widoku.
-----------------------------------------------------*/
function view($path, $attributes = [])
{
    extract($attributes);

    require base_path('views/' . $path);
}

function login($user)
{
    $_SESSION['user'] = [
        'email' => $user['email']
    ];

    session_regenerate_id(true);
}

function logout()
{
    $_SESSION = [];
    session_destroy();

    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}
