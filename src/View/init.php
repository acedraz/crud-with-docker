<?php

//timezone

date_default_timezone_set('America/Sao_Paulo');

function namespaceAutoload($rawClass)
{
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $rawClass);

    $path = str_replace(["\\", "file"], [DIRECTORY_SEPARATOR, $class], $rawClass);
    if (file_exists("../" .$path . ".php")) {
        require_once "../$path.php";
    }
}
spl_autoload_register("namespaceAutoload");