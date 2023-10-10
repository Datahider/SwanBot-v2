<?php

namespace losthost\SwanBot\handlers;
use losthost\SwanBot\handlers\abst\ConnectionHandlerCallback;
use TelegramBot\Api\Types\CallbackQuery;
use losthost\swanctlModel\Model;
use losthost\BotView\BotView;
use losthost\SwanBot\Sync;
use losthost\passg\Pass;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CallbackNewPass
 *
 * @author drweb
 */
class CallbackNewPass extends ConnectionHandlerCallback {
    
    const PREG_PATTERN = "/^newpass_(\d+)$/";
    
    protected function handle(CallbackQuery &$callback_query): bool {
        
        $model = Model::getModel();
        $model->beginTransaction();

        try {
            $this->connection->password = Pass::generate();
            $this->connection->write();
            $view = new BotView(Bot::$api, Env::$user->id);
            $view->show(Env::$language_code, 'connection-newpass', 'connection-keyboard', ['connection' => $this->connection], $callback_query->getMessage()->getMessageId());
        } catch (\Exception $e) {
            $model->rollBack();
        }    
        
        $model->commit();
        try {
            Bot::$api->answerCallbackQuery($callback_query->getId());
        } catch (\Exception $e) {}
        
        Bot::runAt(date_create(), Sync::class);
        
        return true;
    }
}
