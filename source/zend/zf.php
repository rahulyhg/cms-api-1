<?php

define('_BASE_', __DIR__.'/..');

$command = $argv[1];

switch ($command) {
    case "create":
        if (empty($argv[2])) {
            die("Module name is empty\n");
        }

        (include(__DIR__.'/commands/create-module.php'))(ucfirst($argv[2]));
        break;

    case "remove":
        if (empty($argv[2])) {
            die("Module name is empty\n");
        }

        (include(__DIR__.'/commands/remove-module.php'))(ucfirst($argv[2]));
        break;
    default:
        echo "Welcome to ZF2 Module Creator\n";
        break;
}
