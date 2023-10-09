<?php

namespace losthost\SwanBot\handlers;
use losthost\SwanBot\handlers\abst\ConnectionHandlerCallback;
use TelegramBot\Api\Types\CallbackQuery;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CallbackRename
 *
 * @author drweb
 */
class CallbackRename extends ConnectionHandlerCallback {
    
    const PREG_PATTERN = "/^rename_(\d+)$/";
    
    protected function handle(CallbackQuery &$callback_query): bool {
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'rename-prompt', null, ['connection' => $this->connection]);
        Bot::$api->answerCallbackQuery($callback_query->getId());
        
        PriorityRename::setPriority([ 'connection_id' => $this->connection->id ]);
        return true;
    }
}
