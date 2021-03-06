## depends
- docker
- docker-compose

## start
- `docker run --rm -v $(pwd):/app composer install --ignore-platform-reqs`
- `cp .env.example .env`
- `docker-compose up -d` 
- `docker-compose exec forLina-app bash`
- `php artisan migrate`
- `php artisan country-code:set`
- `php artisan customer:load`

## error files

- storage.app

# Migrate data
### Задача:
Используя Laravel/Lumen фреймворк, написать консольную команду которая перенесет данные из файла random.csv в базу данных в таблицу customers

### Условия:
Данные должны быть нормализованы и приведены к следующим типам и из них должны быть извлечены соответствующие данные:
- name – VARCHAR(255)
- surname – VARCHAR(255)
- email – VARCHAR(255)
- age - DATE
- location – VARCHAR(255)
- country_code – VARCHAR(3) формат https://www.iban.com/country-codes

#### Перед записью в БД необходимо провести валидацию:
- Записи с невалидным email не должны быть созданы (проверки по RFC, DNS)
- Записи с невалидным age не должны быть созданы (допустимые значения 18 - 99)
- Записи с невалидным location должны быть созданы, однако невалидные значения должны быть заменены на Unknown
- Консольная команда должна после исполнения должна выводить отчет в Excel, содержащий в себе все не созданные записи и причину их невалидности. Например, если email был не валиден, необходимо вывести исходную строку из файла полностью и добавить в поле error название (не значение) невалидной колонки (email)
- Перед каждым запуском консольная команда не должна очищать таблицу customers и должна добавлять только новых клиентов, не затирая данные по старым

### Результат:
Ссылка на гит репозиторий, содержащий в себе Readme файл с описанием шагов для выполнения задачи.
