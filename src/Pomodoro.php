<?php

namespace EduardoMoralesAlberti\SlackPomodoro;

use JoliCode\Slack\ClientFactory;
use JoliCode\Slack\Exception\SlackErrorResponse;

/**
 * Pomodoro slack actions.
 */
class Pomodoro
{

  /**
   * @var \JoliCode\Slack\ClientFactory;
   */
  public $client;
  public function __construct($yourToken)
  {
    $this->client = ClientFactory::create($yourToken);
  }

  /**
   * Stop pomodoro.
   */
  public function stop() {
    $this->setStatus('', '', '');
    echo 'Pomodoro stopped' . PHP_EOL;
  }

  /**
   * Start pomodoro.
   */
  public function start() {
    $this->setStatus('Pomodoro time!!', ':tomato:');
    echo 'Pomodoro started' . PHP_EOL;
  }

  /**
   * Set profile slack status.
   *
   * @param string $status_message
   *   Status message.
   * @param string $status_emoji
   *   Status emoji.
   * @param string $status_expiration
   *   Status string time (+25 minutes by default).
   */
  private function setStatus($status_message = '', $status_emoji = '', $status_expiration = '+25 minutes') {
    try {
      $status = [
         "status_text" => $status_message,
         "status_emoji" => $status_emoji,
         "status_expiration" => strtotime($status_expiration),
      ];
      $status_json = json_encode($status);
      // This method requires your token to have the scope "chat:write"
      $result = $this->client->usersProfileSet([
        "profile" => $status_json,
      ]);

      echo 'Status changed.' . PHP_EOL;
    } catch (SlackErrorResponse $e) {
      echo 'Fail to set status.', PHP_EOL, $e->getMessage() . PHP_EOL;
    }
  }
}
