<?php

namespace losthost\SwanBot\handlers;
use losthost\telle\abst\AbstractHandlerMessage;
use losthost\swanctlModel\data\DBUser;
use losthost\templateHelper\Template;
use TelegramBot\Api\Types\Message;
use losthost\swanctlModel\Model;
use losthost\BotView\BotView;
use losthost\telle\Bot;
use losthost\telle\Env;
/**
 * Description of CommandNew
 *
 * @author drweb
 */
class CommandNew extends AbstractHandlerMessage {
    
    protected function check(Message &$message): bool {
        return (bool)preg_match("/^\/[Nn][Ee][Ww](\s.*)*$/", $message->getText());
    }

    protected function handle(Message &$message): bool {
        
        $model = Model::getModel();
        $user = $model->user->getIntegrationUser(Env::$user->id);

        $view = new BotView(Bot::$api, Env::$user->id);
        
        if ($this->limitReached($model, $user)) {
            $view->show(Env::$language_code, 'connection-limit-reached');
            return true;
        }
        
        $grace_period = date_interval_create_from_date_string(Bot::param('additional_grace_period_days', 1). " days");
        $description = (new Template('default-connection-description.php', Env::$language_code))->process();
        $new_connection = $model->connection->create($user, $grace_period, $description);
        $view->show(Env::$language_code, 'connection-created', null, [
            'connection' => $new_connection
        ]);
        
        return true;
    }
    
    protected function limitReached(Model &$model, DBUser &$user) {
        $connections = $model->connection->list('user=?', $user->id);
        if (count($connections) >= Bot::param('max_connections_per_user', 20)) {
            return true;
        }
        return false;
    }

    protected function init(): void {}

    public function isFinal(): bool { return false; }
}
