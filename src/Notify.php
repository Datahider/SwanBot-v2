<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace losthost\SwanBot;
use losthost\BotView\BotView;
use losthost\telle\Bot;

/**
 * Description of ConnectionOverdueNotify
 *
 * @author drweb
 */
class Notify extends \losthost\telle\abst\AbstractBackgroundProcess {
    
    public function run() {
        $params = explode(":", $this->param);
        $tg_user  = $params[0];
        $tg_lang  = $params[1];
        $template = $params[2];
        $data     = unserialize($params[3]);
        
        $view = new BotView(Bot::$api, $tg_user);
        $view->show($tg_lang, $template, null, $data);
    }
}
