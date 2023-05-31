<?php

function basePath()
{
    return str_replace('/'.basename($base = $_SERVER['SCRIPT_NAME']), '', $base);
}

function route($path)
{
    return basePath().'/'.ltrim($path, '/');
}
