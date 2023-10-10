<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace losthost\SwanBot\handlers;
use losthost\telle\abst\AbstractHandlerMessage;
use losthost\swanctlModel\data\DBUser;
use losthost\templateHelper\Template;
use TelegramBot\Api\Types\Message;
use losthost\swanctlModel\Model;
use losthost\BotView\BotView;
use losthost\SwanBot\Sync;
use losthost\passg\Pass;
use losthost\telle\Bot;
use losthost\telle\Env;

/**
 * Description of CommandStart
 *
 * @author drweb
 */
class CommandStart extends AbstractHandlerMessage {
    //put your code here
    protected function check(Message &$message): bool {
        return false
            || preg_match("/^\/[Ss][Tt][Aa][Rr][Tt](\s.*)*$/", $message->getText())
            || preg_match("/^\/[Ll][Ii][Ss][Tt](\s.*)*$/", $message->getText());
    }

    protected function handle(Message &$message): bool {
        $model = Model::getModel();
        $model_user = $model->user->getIntegrationUser(Env::$user->id);
        
        if ($model_user === false) {
            $this->handleNewUser($model);
        } else {
            $this->handleExistingUser($model, $model_user);
        }
        
        return true;
    }
    
    protected function handleNewUser(Model &$model) {
        $new_model_user = $model->user->create(Pass::generate(), Pass::generate());
        $new_model_user->login = Env::$user->first_name. $new_model_user->id;
        $new_model_user->integration_id = Env::$user->id;
        $new_model_user->write();
        
        $grace_period = date_interval_create_from_date_string(Bot::param('default_grace_period_days', 7). " days");
        $description = (new Template('default-connection-description.php', Env::$language_code))->process();
        $new_connection = $model->connection->create($new_model_user, $grace_period, $description);
        $view = new BotView(Bot::$api, Env::$chat->id);
        $view->show(Env::$language_code, 'initial-message', null, [
            'model_user' => $new_model_user,
            'telegram_user' => Env::$user,
            'connection' => $new_connection
        ]);
        
        Bot::runAt(date_create(), Sync::class);
        
    }
    
    protected function handleExistingUser(Model &$model, DBUser &$model_user) {
        $view = new BotView(Bot::$api, Env::$chat->id);
        $connections = $model->connection->list('user=?', $model_user->id, 'id');
        
        if (count($connections)) {
            $view->show(Env::$language_code, 'user-connections', null, [ 
                'connections' => $connections
            ]);
        } else {
            $view->show(Env::$language_code, 'no-connections');
        }
    }

    protected function init(): void {}

    public function isFinal(): bool { return false; }
}
