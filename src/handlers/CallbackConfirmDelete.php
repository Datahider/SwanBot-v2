<?php

namespace losthost\SwanBot\handlers;
use losthost\SwanBot\handlers\abst\ConnectionHandlerCallback;
use TelegramBot\Api\Types\CallbackQuery;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CallbackConfirmDelete
 *
 * @author drweb
 */
class CallbackConfirmDelete extends ConnectionHandlerCallback {
    
    const PREG_PATTERN = "/^confirmdelete_(\d+)$/";
    
    protected function handle(CallbackQuery &$callback_query): bool {
        
        $this->connection->delete();
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'connection-deleted', null, [], $callback_query->getMessage()->getMessageId());
        
        return true;
    }
}
