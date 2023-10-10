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

$sync_cron_job = new losthost\DB\DBView("SELECT id FROM [telle_cron_entries] WHERE job_class = ?", losthost\SwanBot\Sync::class);
if (!$sync_cron_job->next()) {
    Bot::runAt('*/5 * * * *', losthost\SwanBot\Sync::class);
}
Bot::run();

