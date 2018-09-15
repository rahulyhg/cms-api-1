<?php

define('_BASE_', __DIR__.'/..');

$command = $argv[1];

function createTemplate($path, $module)
{
    $moduleDir = _BASE_.'/module/'.$module.$path.'/';
    $templateDir = __DIR__.'/template'.$path.'/';

    $currentDirectory = dir($templateDir);
    while ($entry = $currentDirectory->read()) {
        if ($entry != "." && $entry != "..") {

            if (is_dir($templateDir.$entry)) {
                $dir = str_replace('template', strtolower($module), $moduleDir.$entry);
                system("mkdir {$dir} -p");
                createTemplate($path.'/'.$entry, $module);
            } else {
                $template = file_get_contents($templateDir.$entry);
                $template = str_replace('{$module}', $module, $template);
                $template = str_replace('/*', '', $template);

                $entry = str_replace('template', $module, $entry);
                $moduleDir = str_replace('template', strtolower($module), $moduleDir.$entry);
                file_put_contents($moduleDir, $template);
            }
        }
    }
    $currentDirectory->close();
}

switch ($command) {
    case "create":
        if (empty($argv[2])) {
                die("Module name is empty\n");
        }

        $module = ucfirst($argv[2]);
        system("rm -rf "._BASE_.'/module/'.$module.'/');

        createTemplate('', $module);
        echo "End.\n";
        break;
    default:
        echo "Welcome toMudule creator\n";
        break;
}
