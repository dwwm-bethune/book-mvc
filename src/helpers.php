<?php

function basePath()
{
    return str_replace('/'.basename($base = $_SERVER['SCRIPT_NAME']), '', $base);
}

function route($path)
{
    return basePath().'/'.ltrim($path, '/');
}

function query($parameter, $default = null)
{
    return $_GET[$parameter] ?? $default;
}

function request($parameter, $default = null)
{
    return $_POST[$parameter] ?? $default;
}

function uploaded($parameter)
{
    return $_FILES[$parameter] ?? ['error' => 4, 'tmp_name' => null, 'size' => 0, 'name' => null];
}

function isSubmitted()
{
    return ! empty($_POST);
}

function redirect($url)
{
    header('Location: '.$url);
}

function value($value, $values = [], $default = null)
{
    return in_array($value, $values) ? $value : $default;
}

function user()
{
    return $_SESSION['user'] ?? null;
}
