<?php
namespace Code;

session_start();

include_once 'constant.php';

include_once DB_CLASS;
include_once FUN_CLASS;

use Code\Database as DB;

$dbc           = new DB;

use Code\Functions as FUN;
$code_fun = new FUN;
