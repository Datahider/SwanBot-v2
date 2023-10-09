<?php
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

$keyboard = new InlineKeyboardMarkup([
    [[ 'text' => '🚀 Продлить', 'callback_data' => 'prolong_'. $connection->id ], [ 'text' => '❌ Удалить', 'callback_data' => 'delete_'. $connection->id ]],
    [[ 'text' => '🔐 Новый пароль', 'callback_data' => 'newpass_'. $connection->id ], [ 'text' => '📝 Переименовать', 'callback_data' => 'rename_'. $connection->id ]],
]);

echo serialize($keyboard);