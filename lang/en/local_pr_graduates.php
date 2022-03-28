<?php

$string['pluginname'] = 'PR and work with graduates';

$string['link_name'] = 'Graduate card';
$string['link_short_name'] = 'Graduates';


//setting
$string['host_graduate'] = 'Хост';
$string['host_graduate_desc'] = 'Хост для подключения к информационной системе с выпускниками';

$string['login_graduate'] = 'Логин';
$string['login_graduate_desc'] = 'Логин для подключения к информационной системе выпускниками';

$string['password_graduate'] = 'Пароль';
$string['password_graduate_desc'] = 'Пароль для подключения к информационной системе выпускниками';

$string['endpoint_get_graduate_info'] = 'Точка получение данных выпускника';
$string['endpoint_get_graduate_info_desc'] =
	'Точка подключения для получения информации о выпускнике. 
</br>Будет сформирована в следующем формате <code>host_graduate/endpoint_get_graduate_info?user_id="user_id"</code>';

$string['endpoint_set_graduate_info'] = 'Точка обновления данных выпускника';
$string['endpoint_set_graduate_info_desc'] = '
Точка подключения для обновления информации о выпускнике. 
</br>Будет сформирована в следующем формате <code>host_graduate/endpoint_get_graduate_info</code>, все основные данные будут переданы в теле <code>POST</code>';

$string['endpoint_change_publication_consent'] = 'Точка подключения для подачи/отзыва согласия на обработку персональных данных';
$string['endpoint_change_publication_consent_desc'] = 'Точка подключения для подачи/отзыва согласия на обработку персональных данных. 
</br>Будет сформирована в следующем формате <code>host_graduate/endpoint_get_graduate_info?user_id="user_id"&consent="1\0"</code>';

$string['host_chat'] = 'Хост';
$string['host_chat_desc'] = 'Хост для подключения к информационной системе чата';

$string['login_chat'] = 'Логин';
$string['login_chat_desc'] = 'Логин для подключения к информационной системе чата';

$string['password_chat'] = 'Пароль';
$string['password_chat_desc'] = 'Пароль для подключения к информационной системе чата';

$string['endpoint_get_messages'] = 'Точка получения истории чата';
$string['endpoint_get_messages_desc'] = '
Точка подключения для получения истории чата. 
</br>Будет сформирована в следующем формате <code>host_chat/endpoint_get_messages?application="application"</code>';

$string['endpoint_send_message'] = 'Точка отправки сообщения в чат';
$string['endpoint_send_message_desc'] = '
Точка подключения для отправки сообщения в чат. 
</br>Будет сформирована в следующем формате <code>host_chat/endpoint_send_message?application="application"&sender="sender"&uid_quote="uid_quote"</code>,
 сообщение будут передано в теле <code>POST</code>';

$string['interval_upload_chat'] = 'Интервал обновления чата';
$string['interval_upload_chat_desc'] = 'Число в миллисекундах с какой частотой чат будет запрашивать информацию с сервера для обработки новых сообщений.
</br> Если 0 обновления происходить не будут.';

$string['enable_test_mode'] = 'Включить режим тестирования';
$string['enable_test_mode_desc'] = 'Если включен режим тестирования, в поле <code>test_mode_user_id</code> можно указать 
идентификатор пользователя по которому будет запрашиваться информация, в поле <code>test_mode_application</code> можно 
указать идентификатор application для чата';

$string['test_user_id'] = 'Идентификатор пользователя';
$string['test_user_id_desc'] = 'При включенном поле <code>enable_test_mode</code> выполнится подмена идентификатора текущего пользователя на указанный здесь';

$string['test_application_id'] = 'Идентификатор application';
$string['test_application_id_desc'] = 'При включенном поле <code>enable_test_mode</code> выполнится подмена идентификатора application на указанный здесь';

$string['localization_parameters'] = 'Названия для параметров';
$string['localization_parameters_desc'] = 'Вводятся ключ, название и локализация для различных параметров плагина.
 Заполняется по следующему типу <code>ключ|название|локализация</code>';

$string['check_permission'] = 'Дополнительная проверка прав при входе на страницу';
$string['check_permission_desc'] = 'Задайте необходимый <code>PHP</code> код, будет выполнен при проверке отображения меню и доступа к странице <code>index.php</code>';
//setting

//errors
$string['not_found'] = 'Ну удалось найти {$a->message}';
//errors