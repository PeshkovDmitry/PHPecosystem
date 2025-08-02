## Основные команды

### Создание напоминания (через консоль)

php runner -c save_event --name 'name' --receiver 1 --text 'text' --cron '* * * * *'

### Работа с супервизором

sudo supervisorctl status
sudo supervisorctl restart all