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
   * Slack client.
   *
   * @var ClientFactory;
   */
  public $client;

  /**
   * Pomodoro options.
   *
   * @var array|string[]
   */
  private $pomodoroSettings;

  public function __construct($yourToken, $message = NULL, $icon = NULL, $duration = NULL)
  {
    $this->client = ClientFactory::create($yourToken);
    $message = isset($message) ? $message : 'Pomodoro time!!';
    $this->setMessage($message);
    $icon = isset($icon) ? $icon : ':tomato:';
    $this->setIcon($icon);
    $duration = isset($duration) ? $duration : '+25 minutes';
    $this->setDuration($duration);
  }

  /**
   * Pomodoro status message.
   *
   * @param string $message
   *  Status message.
   */
  public function setMessage($message = 'Pomodoro time!!') {
    $this->pomodoroSettings['message'] = $message;
  }

  /**
   * Pomodoro status icon.
   *
   * @param string $icon
   *   Status icon.
   */
  public function setIcon($icon = ':tomato:') {
    $this->pomodoroSettings['icon'] = $icon;
  }

  /**
   * Pomodoro status duration.
   *
   * @param string $duration
   *   Status duration.
   */
  public function setDuration($duration = '+25 minutes'){
    $this->pomodoroSettings['duration'] = $duration;
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
    $this->setStatus($this->pomodoroSettings['message'], $this->pomodoroSettings['icon'], $this->pomodoroSettings['duration']);
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
  public function setStatus($status_message = '', $status_emoji = '', $status_expiration = '+25 minutes') {
    try {
      $status = [
         "status_text" => $status_message,
         "status_emoji" => $status_emoji,
         "status_expiration" => strtotime($status_expiration),
      ];
      $status_json = json_encode($status);
      // This method requires your token to have the scope "users.profile:write"
      $result = $this->client->usersProfileSet([
        "profile" => $status_json,
      ]);

      echo 'Status changed.' . PHP_EOL;
    } catch (SlackErrorResponse $e) {
      echo 'Fail to set status.', PHP_EOL, $e->getMessage() . PHP_EOL;
    }
  }

}
