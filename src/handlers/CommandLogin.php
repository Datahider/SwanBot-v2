<?php

namespace losthost\SwanBot\handlers;

use losthost\telle\abst\AbstractHandlerMessage;
use losthost\swanctlModel\data\DBConnection;
use TelegramBot\Api\Types\Message;
use losthost\swanctlModel\Model;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CommandLogin
 *
 * @author drweb
 */
class CommandLogin extends AbstractHandlerMessage {
    
    protected DBConnection $connection;
    
    protected function check(Message &$message): bool {
        if (preg_match("/^\/[Hh][Ee][Ll][Pp](\s.*)*$/", $message->getText())) {
            return false;
        }

        $m = [];
        if (!preg_match("/^\/([a-zA-Z0-9]+)(\s.*)*$/", $message->getText(), $m)) {
            return false;
        }
        
        $model = Model::getModel();
        $user = $model->user->getIntegrationUser(Env::$user->id); 
        try {
            $connection = $model->connection->get($m[1]);
        } catch (\Exception $e) {
            return false;
        }
        if ($connection->user != $user->id) {
            return false;
        }
        
        $this->connection = $connection;
        return true;
    }

    protected function handle(Message &$message): bool {

        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'connection', 'connection-keyboard', [
            'connection' => $this->connection
        ]);
        return true;
    }

    protected function init(): void {}

    public function isFinal(): bool { return false; }
}
