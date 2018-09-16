<?php

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
        json_encode($oldJson, JSON_PRETTY_PRINT)
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

    if (!in_array($module, include($appModule))) {
        return;
    }

    $config = file_get_contents($appModule);
    file_put_contents(
        $appModule,
        str_replace("\t'{$module}',\n", '', $config)
    );
}


return function(string $module) {
    echo "______________________________".
         "\nRemoving module...\n";
    system("rm -rf "._BASE_.'/module/'.$module.'/');

    updateNamespace($module);
    updateApplicationModule($module);
    echo "\nModule is removed successfully.".
        "\n-------------------------------".
        "\n";
};
