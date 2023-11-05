<?php // index.php
require_once __DIR__ . '/vendor/autoload.php';

$ds = DIRECTORY_SEPARATOR;
$log = new \Monolog\Logger("my_log");
$log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . $ds . 'monolog.log', \Monolog\Logger::DEBUG));
$log->error("This is some error.");
$log->warning("This is some warning.");
$log->notice("This is some notice.");
$log->info("This is some info.");
$log->debug("This is some debug.");

$duck = new \Hskorupka\LabComposer\Duck($log);
$duck->quack();
$duck->quack();
$duck->quack();
?>