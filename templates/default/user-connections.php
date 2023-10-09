<b><u>Ваши подключения:</u></b>

<?php

foreach ($connections as $connection) {
    echo "/{$connection->login}: {$connection->description}\n";
}
?>

Для просмотра данных и редактирования подключения нажмите на имя пользователя
