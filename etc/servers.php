<?php

use losthost\swanctlServer\Server;

$private_key = 'etc/id_rsa';

$servers[] = new Server(
        'root', 
        'connect.losthost.online', 
        'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIIU9YdrC809a/NB4r4jEZqqnDJSr2z9trCAm1cqshB6D', 
        file_get_contents($private_key)
        );

/**
 * Add more server(s) here
 */

//$servers[] = new Server(
//        'root', 
//        'connect.losthost.online', 
//        'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIIU9YdrC809a/NB4r4jEZqqnDJSr2z9trCAm1cqshB6D', 
//        file_get_contents($private_key)
//        );
