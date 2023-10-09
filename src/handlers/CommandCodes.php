<?php

namespace losthost\SwanBot\handlers;
use losthost\telle\abst\AbstractHandlerMessage;
use losthost\swanctlModel\Model;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CommandCodes
 *
 * @author drweb
 */
class CommandCodes extends AbstractHandlerMessage {
    
    protected function check(\TelegramBot\Api\Types\Message &$message): bool {
        $admins = preg_split("/[\s\;\,]+/", Bot::param('bot_admins', ''));
        if (array_search(Env::$user->id, $admins) === false) {
            return false;
        }
        
        if (Env::$session->command == 'codes') {
            return true;
        }
        return (bool)preg_match("/^\/[Cc][Oo][Dd][Ee][Ss](\s.*)*$/", $message->getText());
    }

    protected function handle(\TelegramBot\Api\Types\Message &$message): bool {
        $m = [];
        if (preg_match_all("/\d+/", $message->getText(), $m, PREG_PATTERN_ORDER)) {
            return $this->handleParams($m[0]);
        } else {
            return $this->handleNoParams();
        }
    }

    protected function handleNoParams() : bool {
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'codes-prompt');
        Env::$session->set('command', 'codes');
        return true;
    }
    
    protected function handleParams($params) : bool {
        $data['codes_count'] = $params[0];
        $data['codes_days']  = empty($params[1]) ? 30 : $params[1];
        $data['codes_valid'] = empty($params[2]) ? 365 : $params[2];
        $data['codes_activations'] = empty($params[3]) ? 1 : $params[3];
        
        Env::$session->set('command', null);
        
        $view = new BotView(Bot::$api, Env::$user->id);
        $view->show(Env::$language_code, 'codes-generate', 'codes-generate-keyboard', $data);
        return true;
    }
    
    protected function init(): void {}

    public function isFinal(): bool { return false; }
}
