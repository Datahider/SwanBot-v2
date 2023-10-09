<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace losthost\SwanBot\handlers;
use losthost\SwanBot\handlers\abst\ConnectionPriorityMessage;
use TelegramBot\Api\Types\Message;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of PriorityRename
 *
 * @author drweb
 */
class PriorityRename extends ConnectionPriorityMessage {
    
    protected function handle(Message &$message): bool {
        
        $this->connection->description = $message->getText();
        $this->connection->write();
        
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'connection', 'connection-keyboard', [
            'connection' => $this->connection
        ]);
        
        static::unsetPriority();
        return true;
    }
}
