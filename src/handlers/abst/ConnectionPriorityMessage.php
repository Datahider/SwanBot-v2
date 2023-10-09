<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace losthost\SwanBot\handlers\abst;
use losthost\telle\abst\AbstractHandlerMessage;
use losthost\swanctlModel\data\DBConnection;
use losthost\swanctlModel\Model;
use losthost\telle\Env;
/**
 * Description of PriorityRename
 *
 * @author drweb
 */
abstract class ConnectionPriorityMessage extends AbstractHandlerMessage {
   
    protected DBConnection $connection;
    
    protected function check(\TelegramBot\Api\Types\Message &$message): bool {
        
        if ( false 
                || ! $message->getText()
                || preg_match("/^\//", $message->getText())
                || empty (Env::$session->data['connection_id'])) {
            
            static::unsetPriority();
            return false;
        }
        
        $model = Model::getModel();
        $user = $model->user->getIntegrationUser(Env::$user->id);
        $connection = $model->connection->get(Env::$session->data['connection_id']);
        if ($connection->user != $user->id) {
            static::unsetPriority();
            return false;
        }
        
        $this->connection = $connection;
        return true;
    }

    protected function init(): void {}

    public function isFinal(): bool { return false; }
}
