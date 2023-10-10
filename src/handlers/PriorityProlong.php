<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace losthost\SwanBot\handlers;
use losthost\SwanBot\handlers\abst\ConnectionPriorityMessage;
use TelegramBot\Api\Types\Message;
use losthost\swanctlModel\Model;
use losthost\BotView\BotView;
use losthost\SwanBot\Sync;
use losthost\telle\Bot;
use losthost\telle\Env;
/**
 * Description of PriorityProlong
 *
 * @author drweb
 */
class PriorityProlong extends ConnectionPriorityMessage {

    protected function handle(Message &$message): bool {
    
        $model = Model::getModel();
        try {
            $model->connection->prolong($this->connection, $message->getText());
        } catch (\Exception $e) {
            $view = new BotView(Bot::$api, Env::$user->id);
            $view->show(Env::$language_code, 'prolong-error');
            return true;
        }

        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'connection', 'connection-keyboard', [
            'connection' => $this->connection
        ]);
        
        Bot::runAt(date_create(), Sync::class);
        
        static::unsetPriority();
        return true;
    }

}
