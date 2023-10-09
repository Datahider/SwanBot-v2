<?php
namespace losthost\SwanBot\handlers\abst;
use losthost\telle\abst\AbstractHandlerCallback;
use losthost\swanctlModel\data\DBConnection;
use losthost\swanctlModel\Model;
use losthost\telle\Env;

/**
 * Description of MyHandlerCallback
 *
 * @author drweb
 */
abstract class ConnectionHandlerCallback extends AbstractHandlerCallback {
    
    protected DBConnection $connection;
    
    protected function check(\TelegramBot\Api\Types\CallbackQuery &$callback_query): bool {
        $data = $callback_query->getData();
        $m = [];
        if (!preg_match(static::PREG_PATTERN, $data, $m)) {
            return false;
        }
        
        $model = Model::getModel();
        $user = $model->user->getIntegrationUser(Env::$user->id);
        $connection = $model->connection->get((int)$m[1]);
        
        if ($connection->user != $user->id) {
            return false;
        }
        
        $this->connection = $connection;
        return true;
    }

    protected function init(): void {}

    public function isFinal(): bool { return false; }
}
