<?php

define('_BASE_', __DIR__.'/..');

$command = $argv[1];

/**
 * Copy template of module into the actual module
 *
 * @param $path   string
 * @param $module string
 *
 * @return void
 */
function createTemplate(string $path, string $module): void
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

/**
 * @param string $module
 *
 * @return void
 */
function updateNamespace(string $module): void
{
    $composer = _BASE_.'/composer.json';

    $oldJson = json_decode(file_get_contents($composer), true);
    unset($oldJson['autoload']['psr-4'][$module.'\\']);

    file_put_contents(
        $composer,
        json_encode(array_merge_recursive(
            ['autoload' => ['psr-4' => [$module.'\\' => 'module/'.$module.'/src/']]],
            $oldJson
        ), JSON_PRETTY_PRINT)
    );
}

/**
 * @param string $module
 *
 * @return void
 */
function updateApplicationModule(string $module): void
{
    $appModule = _BASE_.'/config/modules.config.php';

    if (in_array($module, include($appModule))) {
        return;
    }

    $config = file_get_contents($appModule);
    file_put_contents(
        $appModule,
        substr_replace(
            $config,
            "\t'{$module}',\n",
            strpos($config, "];"),
            0
        )
    );
}

switch ($command) {
    case "create":
        if (empty($argv[2])) {
            die("Module name is empty\n");
        }

        $module = ucfirst($argv[2]);
        system("rm -rf "._BASE_.'/module/'.$module.'/');

        createTemplate('', $module);
        updateNamespace($module);
        updateApplicationModule($module);
        system('composer dump-autoload');
        echo "End.\n";
        break;
    default:
        echo "Welcome to ZF2 Module Creator\n";
        break;
}
