<?php

namespace losthost\SwanBot;
use losthost\swanctlServer\Server;

/**
 * Description of Sync
 *
 * @author drweb
 */
class Sync extends \losthost\telle\abst\AbstractBackgroundProcess {
    
    const PATH_TO_SERVERS_PHP = 'etc/servers.php';
    
    public function run() {
        $servers = [];
        include self::PATH_TO_SERVERS_PHP;
        
        foreach ($servers as $server) {
            $server->updateSecrets();
        }
    }
}
