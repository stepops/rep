////////////////////Описание
Разработка приложения велась в следующей среде:
uname -a:
Linux vaiobox 4.4.0-157-generic #185-Ubuntu SMP Tue Jul 23 09:17:01 UTC 2019 x86_64 x86_64 x86_64 GNU/Linux
docker -v:
Docker version 18.09.7, build 2d0083d
docker-compose -v:
docker-compose version 1.8.0, build unknown

Приложение работает в контейнеризованной среде
Результат вывода sudo docker ps:
CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                                NAMES
a61980f87ba3        httpd:2.4           "httpd-foreground"       22 minutes ago      Up 22 minutes       0.0.0.0:80->80/tcp                   openprovider_apache_1
192fb53301e9        openprovider_php    "docker-php-entrypoi…"   22 minutes ago      Up 22 minutes       9000/tcp                             openprovider_php_1
7f1a6b0906b2        mysql:5.7           "docker-entrypoint.s…"   22 minutes ago      Up 22 minutes       33060/tcp, 0.0.0.0:33061->3306/tcp   mysql

Среда поднимается при помощи docker-compose:
sudo docker-compose up в папке с файлом docker-compose.yml

Язык программирования и база данных:
В качестве языка программирования был выбран PHP, в качестве базы данных MySQL, в качестве web-сервера apache.
php                 7.2-fpm
mysql               5.7
httpd               2.4

Поддерживаемые методы приложения и примеры их вызова:
//все записи из БД
curl -v http://localhost/api/people/
//конкретная запись из БД по id
curl -v http://localhost/api/people/3
// создание записи в БД - дата в американском формате YYYMMDD или YYYY-MM-DD '1000-01-01' - '9999-12-31'
curl -v http://localhost/api/people/ -d '{"name":"Ivan Petrov","salary":"55","birthday":"19960201"}'
curl -v http://localhost/api/people/ -d '{"name":"Ivan Petrov","salary":"55"}'
curl -v http://localhost/api/people/ -d '{"name":"Ivan Petrov"}'
//удаление записи из БД по id
curl -v -X DELETE http://localhost/api/people/3
//редактирование записи в БД
//небольшое отступление от задания - здесь id помещен в uri
curl -v -X PUT http://localhost/api/people/3 -d '{"name":"Vasily Petrovich","salary":"10","birthday":"20051231"}'
curl -v -X PUT http://localhost/api/people/3 -d '{"salary":"10"}'
curl -v -X PUT http://localhost/api/people/3 -d '{"birthday":"20051231"}'
curl -v -X PUT http://localhost/api/people/3 -d '{"name":"Vasily Petrovich"}'
//прииложение возвращает данные или ошибку в формате json.

Поставка:
Дерево каталогов с файлами:
httpd\httpd.conf - конфигурационный файл apache
php\Dockerfile - последовательности команд и аргументов, необходимых для создания образа контейнера с php
php\php.ini - конфигурационный файл php
src\ - содержит все файлы с кодом приложения
docker-compose.yml - конфигурационный файл для запуска среды в контейнерах
init.sql - скрипт первоначальной инициализации базы данных
README.TXT - этот файл

Чего не хватает в приложении\ что не успел сделать:
https
дополнительных проверок входных данных
в такой реализации можно изменить id записи запросом PUT
привычного формата даты


////////////////////ЗАДАНИЕ
Общее описание: написать приложение работы с таблицей базы данных, выполняющее простейшие CRUD операции.
Требования к методам и средствам программирования:
Задание принимается на одном из следующих языков программирования: python, php, go.
В случае использования python или php код оформить в ООП-парадигме. При написании кода следовать принципам SOLID и GRASP.

Требования к базе данных:
Данные должны храниться в реляционной СУБД.
Структура данных следующая:
`id`, `name`, `salary`, `birthday`
Решение о типах данных для полей принимается испытуемым.

Требования к архитектуре:
Приложение должно работать по REST API. Поддерживаемые методы:
.../people POST
.../people/id GET
.../people PUT
.../people/id DELETE

Требования к поставке:
Тестовое задание принимается в одном из перечисленных форматов (в порядке уменьшения предпочтительности):
    Docker контейнер(ы)
    Ссылка на репозиторий в github или Bitbucket
    Архив с файлами
Во втором и третьем случае должен быть приложен sql script создания (и, возможно, первичного заполнения) базы данных
Вместе с проектом должен идти readme, в котором обязательно нужно описать:
    Среду, в которой запускать проект (ОС, СУБД, их версии, и т.п.)
    Процедуру установки
