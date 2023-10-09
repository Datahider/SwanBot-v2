<?php

use losthost\telle\Bot;

require_once 'vendor/autoload.php';

Bot::setup();

losthost\swanctlModel\data\DBActivationCodeEvent::initDataStructure();

Bot::addHandler(losthost\SwanBot\handlers\CallbackProlong::class);
Bot::addHandler(\losthost\SwanBot\handlers\CallbackRename::class);
Bot::addHandler(losthost\SwanBot\handlers\CallbackNewPass::class);
Bot::addHandler(losthost\SwanBot\handlers\CallbackDelete::class);
Bot::addHandler(\losthost\SwanBot\handlers\CallbackConfirmDelete::class);
Bot::addHandler(losthost\SwanBot\handlers\CallbackCancelDelete::class);

Bot::addHandler(\losthost\SwanBot\handlers\CallbackCodeGen::class);

Bot::addHandler(losthost\SwanBot\handlers\CommandStart::class);
Bot::addHandler(losthost\SwanBot\handlers\CommandNew::class);
Bot::addHandler(losthost\SwanBot\handlers\CommandLogin::class);
Bot::addHandler(\losthost\SwanBot\handlers\CommandCodes::class);
Bot::addHandler(losthost\SwanBot\handlers\CommandHelp::class);

Bot::run();

