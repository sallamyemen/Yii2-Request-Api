Тестовое задание
Общие положения
Постарайтесь показать свои лучшие практики написания кода
Используйте язык PHP, фреймворк Yii2. В качестве СУБД используйте MySQL
Код необходимо выложить в Git репозиторий. По возможности, ведите историю коммитов, чтобы мы могли отследить Ваш процесс разработки
Приветствуется чистота и элегантность кода
Общее описание
Необходимо реализовать систему принятия и обработки заявок пользователей с сайта. Любой пользователь может отправить данные по публичному API, реализованному нами, оставив заявку с каким-то текстом. Затем заявка рассматривается ответственным лицом и ей устанавливается статус Завершено. Чтобы установить этот статус, ответственное лицо должно оставить комментарий. Пользователь должен получить свой ответ по email.
При этом, ответственное лицо должно иметь возможность получить список заявок, отфильтровать их по статусу и по дате создания, а также иметь возможность ответить на заявку, пользователь должен получить ответ по email.

Сущности

Заявка
id
Уникальный идентификатор
name
Имя пользователя - строка
email
Email пользователя - строка
status
Статус - enum(“Active”, “Resolved”)
message
Сообщение пользователя - текст
comment
Ответ ответственного лица - текст, обязательный, если статус Resolved
created_at
Время создания заявки - timestamp
updated_at
Время изменения заявки


Endpoint-ы API
POST /requests - отправка заявки пользователями системы, доступен любому без авторизации
GET /requests - получение заявок ответственным лицом, с фильтрацией по статусу, доступен только ответственному лицу
PUT /requests/{id} - ответ на конкретную заявку ответственным лицом, доступен только ответственному лицу

В эндпоинтах необходимо настроить CORS, запросы должны приниматься только с одного домена на Ваш выбор.

Плюсом будет использование swagger для документирования API, либо других аналогичных инструментов.
