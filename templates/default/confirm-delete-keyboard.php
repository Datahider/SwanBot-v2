<?php
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

$keyboard = new InlineKeyboardMarkup([
    [[ 'text' => '🧨 Да, удалить', 'callback_data' => 'confirmdelete_'. $connection->id ], [ 'text' => '🔙 Нет, не удалять', 'callback_data' => 'canceldelete_'. $connection->id ]]
]);

echo serialize($keyboard);