<?php

namespace losthost\SwanBot\handlers;
use losthost\telle\abst\AbstractHandlerMessage;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;
/**
 * Description of CommandHelp
 *
 * @author drweb
 */
class CommandHelp extends AbstractHandlerMessage {
    
    protected function check(\TelegramBot\Api\Types\Message &$message): bool {
        return true;
    }

    protected function handle(\TelegramBot\Api\Types\Message &$message): bool {
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'help-message');
        return true;
    }

    protected function init(): void {}

    public function isFinal(): bool { return false; }
}
