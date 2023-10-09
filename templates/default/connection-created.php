Создано новое подключение:

🔌 <b><u><?=$connection->description;?></u></b> (/<?=$connection->login;?>)

👨 Имя пользователя: <b><?=$connection->login;?></b>
🗝 Пароль: <b><span class="tg-spoiler"><?=$connection->password;?></span></b>
⏱ Активно до: <b><?=$connection->valid_till->format('d-m-Y H:i');?></b>

Для просмотра инструкций по настройке введите /help