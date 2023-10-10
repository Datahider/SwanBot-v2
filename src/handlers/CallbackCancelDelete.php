<?php

namespace losthost\SwanBot\handlers;
use losthost\SwanBot\handlers\abst\ConnectionHandlerCallback;
use TelegramBot\Api\Types\CallbackQuery;
use losthost\swanctlModel\Model;
use losthost\BotView\BotView;
use losthost\passg\Pass;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CallbackCancelDelete
 *
 * @author drweb
 */
class CallbackCancelDelete extends ConnectionHandlerCallback {
    
    const PREG_PATTERN = "/^canceldelete_(\d+)$/";
    
    protected function handle(CallbackQuery &$callback_query): bool {
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'connection', 'connection-keyboard', [
            'connection' => $this->connection
        ], $callback_query->getMessage()->getMessageId());

        try {
            Bot::$api->answerCallbackQuery($callback_query->getId());
        } catch (\Exception $e) {}
        return true;
    }
}
