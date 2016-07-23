<?php

/*
 * Painwise autoloader
 */

spl_autoload_register(function($class) {
    // project-specific namespace prefix
    $prefix = 'Painwise';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/../painwise/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

/*
 * Include other autoloaders
 */

call_user_func(function() {
    $autoloadPaths = [
        PAINWISE_VENDOR_BASE . "/autoload.php", // composer vendor autoloader
    ];

    foreach($autoloadPaths as $path) {
        if(file_exists($path)) {
            require($path);
            break;
        }
    }
});

/*
 * Include the TGMPA plugin
 */

/*
call_user_func(function() {
    $tgmpaPluginPath = PAINWISE_VENDOR_BASE . "/tgmpa/class-tgm-plugin-activiation.php";

    if(file_exists($tgmpaPluginPath)) {
        require($tgmpaPluginPath);
    }
});
 */
