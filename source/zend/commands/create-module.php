<?php

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
    $lcModule= strtolower($module);

    $currentDirectory = dir($templateDir);
    while ($entry = $currentDirectory->read()) {
        if ($entry != "." && $entry != "..") {

            if (is_dir($templateDir.$entry)) {
                $dir = str_replace('template', $lcModule, $moduleDir.$entry);
                system("mkdir {$dir} -p");
                createTemplate($path.'/'.$entry, $module);
            } else {
                $template = file_get_contents($templateDir.$entry);
                $template = str_replace('{$module}', $module, $template);
                $template = str_replace('{$lowerModule}', $lcModule, $template);
                $template = str_replace('/* REMOVE', '', $template);

                $entry = str_replace('template', $module, $entry);
                $moduleDir = str_replace('template', $lcModule, $moduleDir.$entry);
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

    if (isset($oldJson['autoload']['psr-4'][$module.'\\'])) {
        echo "Namespace autoload is already exist.\n";
        return;
    }

    file_put_contents(
        $composer,
        json_encode(array_merge_recursive(
            ['autoload' => ['psr-4' => [$module.'\\' => 'module/'.$module.'/src/']]],
            $oldJson
        ), JSON_PRETTY_PRINT)
    );
    system('composer dump-autoload');
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


return function(string $module) {
    echo "______________________________\nCreating module...\n";
    system("rm -rf "._BASE_.'/module/'.$module.'/');

    createTemplate('', $module);
    updateNamespace($module);
    updateApplicationModule($module);
    echo "\nModule is created successfully.".
         "\n-------------------------------".
         "\n";
};
