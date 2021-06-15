<?php
namespace Code;

defineConstant('ABSPATH', dirname(dirname(__FILE__)));
defineConstant('INCPATH', ABSPATH . '/includes/');
defineConstant('CLSPATH', INCPATH . 'classes/');

defineConstant('DB_CLASS', CLSPATH . 'database.class.php');
defineConstant('FUN_CLASS', CLSPATH . 'function.class.php');

global $dbc;
global $code_fun;

function defineConstant($path, $value)
{
    if (!defined($path)) {
        define($path, $value);
    }
}
