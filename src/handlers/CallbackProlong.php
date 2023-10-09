<?php

namespace losthost\SwanBot\handlers;
use losthost\SwanBot\handlers\abst\ConnectionHandlerCallback;
use TelegramBot\Api\Types\CallbackQuery;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;
/**
 * Description of CallbackProlong
 *
 * @author drweb
 */
class CallbackProlong extends ConnectionHandlerCallback {

    const PREG_PATTERN = "/^prolong_(\d+)$/";
    
    protected function handle(CallbackQuery &$callback_query): bool {
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'prolong-prompt', null, ['connection' => $this->connection]);
        Bot::$api->answerCallbackQuery($callback_query->getId());
        
        PriorityProlong::setPriority([ 'connection_id' => $this->connection->id ]);
        return true;
    }

}
