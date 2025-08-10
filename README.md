## Основные консольные команды

### Создание напоминания 

php runner -c save_event --name 'name' --receiver 1 --text 'text' --cron '* * * * *'

### Проверка наличия напоминаний в базе и отправка их в очередь

php runner -c handle_events

### Выгрузка сообщений из очереди в Телеграм

php /home/dmitry/cur/runner -c queue_manager

### Получение сообщений из Телеграмма 

php /home/dmitry/cur/runner -c tgMessages

### Запуск простых юнит-тестов

php vendor/bin/phpunit ./tests/

## Работа с супервизором

sudo supervisorctl status
sudo supervisorctl restart all

## Мой ID 

Your own ID is: 6150807891