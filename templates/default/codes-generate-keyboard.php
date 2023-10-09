<?php
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

$keyboard = new InlineKeyboardMarkup([
    [[ 'text' => '🧨 Создать коды', 'callback_data' => "codegen_{$codes_count}_{$codes_days}_{$codes_valid}_{$codes_activations}" ]]
]);

echo serialize($keyboard);