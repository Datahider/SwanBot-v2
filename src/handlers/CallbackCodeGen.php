<?php

namespace losthost\SwanBot\handlers;
use losthost\telle\abst\AbstractHandlerCallback;
use losthost\swanctlModel\Model;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CallbackCodeGen
 *
 * @author drweb
 */
class CallbackCodeGen extends AbstractHandlerCallback {
    //put your code here
    protected function check(\TelegramBot\Api\Types\CallbackQuery &$callback_query): bool {
        $admins = preg_split("/[\s\;\,]+/", Bot::param('bot_admins', ''));
        if (array_search(Env::$user->id, $admins) === false) {
            return false;
        }
        
        return (bool)preg_match("/^codegen_/", $callback_query->getData());
    }

    protected function handle(\TelegramBot\Api\Types\CallbackQuery &$callback_query): bool {
        $m = [];
        if (preg_match_all("/\d+/", $callback_query->getData(), $m, PREG_PATTERN_ORDER)) {
            $model = Model::getModel();
            
            $codes = [];
            foreach (range(1, $m[0][0]) as $index) {
                $valid_till = date_create()->add(date_interval_create_from_date_string($m[0][2]. ' days'));
                $period_days = $m[0][1];
                $max_activations = $m[0][3];
                $codes[] = $model->activation_code->create($valid_till, $period_days, $max_activations);
            }
            
            $view = new BotView(Bot::$api, Env::$user->id);
            $view->show(Env::$language_code, 'codes', null, [ 'codes' => $codes]);
        }
        Bot::$api->answerCallbackQuery($callback_query->getId());
        return true;
    }

    protected function init(): void {}

    public function isFinal(): bool { return false; }
}
