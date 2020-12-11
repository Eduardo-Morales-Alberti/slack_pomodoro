<?php

require __DIR__ . '/vendor/autoload.php';

use EduardoMoralesAlberti\SlackPomodoro\Pomodoro;

if (!is_cli()) {
  throw new \Exception('Not on client context');
}

$ini = parse_ini_file('app.ini');
if (!isset($ini['user_token'])) {
  throw new \Exception("User token is not set");
}
$token = $ini['user_token'];
if (!isset($token)) {
  throw new \Exception("User token is not set");
}

$pomodoro = new Pomodoro($token);
switch ($argv[1]) {
  case 'start':
    $pomodoro->start();
    break;
  case 'stop':
  default:
    $pomodoro->stop();
    break;
}

function is_cli()
{
  if (defined('STDIN')) {
    return true;
  }

  if (php_sapi_name() === 'cli') {
    return true;
  }

  if (array_key_exists('SHELL', $_ENV)) {
    return true;
  }

  if (empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) {
    return true;
  }

  if (!array_key_exists('REQUEST_METHOD', $_SERVER)) {
    return true;
  }

  return false;
}
