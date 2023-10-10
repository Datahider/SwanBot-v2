<?php

namespace losthost\SwanBot\handlers;
use losthost\SwanBot\handlers\abst\ConnectionHandlerCallback;
use TelegramBot\Api\Types\CallbackQuery;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CallbackDelete
 *
 * @author drweb
 */
class CallbackDelete extends ConnectionHandlerCallback {
    
    const PREG_PATTERN = "/^delete_(\d+)$/";
    
    protected function handle(CallbackQuery &$callback_query): bool {
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'connection', 'confirm-delete-keyboard', ['connection' => $this->connection], $callback_query->getMessage()->getMessageId());
        Bot::$api->answerCallbackQuery($callback_query->getId());
        
        try {
            Bot::$api->answerCallbackQuery($callback_query->getId());
        } catch (\Exception $e) {}
        return true;
    }
}
