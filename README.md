##Тестовое задание
[ТЗ](https://docs.google.com/document/d/1rtdVubP_npJR5Q_u6CPBuG_O3bbZiir39DeEt_V_eVQ/edit?usp=sharing "Тех Задание")
Задание сделанно на основе yii2-advanced-template.
Основное приложение - backend
Приложение для тестов (куда я встраивал скрипт отслеживания) - frontend.

##Технические подробности
При создании теста пользователю предлогается установить скрипт на сайт. [Скрипт для вставки](https://github.com/pavel-ms/ab-test-demo/blob/master/backend/widgets/views/watchScript.php) содержит в себе id созданного теста, по которому получает необходимые настройки.
Далее сравнивая url пользователя с url из настроек, скрипт редиректит пользователя к одной из страниц AB-теста (которые были заданы в админке при создании теста) и отправляет данные на [контроллер для сбора аналитики](https://github.com/pavel-ms/ab-test-demo/blob/master/backend/controllers/AnalyticsController.php). Сам [скрипт отслеживания](https://github.com/pavel-ms/ab-test-demo/blob/master/watch-script/main.js) использует jsonp и написан на js c применением библиотек [Q](https://github.com/kriskowal/q) и [Cookies.js](https://github.com/ScottHamper/Cookies)(в глобальную область библиотеки не экспортируется, сборка и минификация с помощью [Gulp](http://gulpjs.com/)).

Для хранения данных используется MySQL, база данных была создана с помощью стандартного механизма миграций Yii2. [Вот код](https://github.com/pavel-ms/ab-test-demo/tree/master/console/migrations)

## Screenshots
Вход в приложение - http://imagy.me/ej8pk94tdk
Главная страница - http://imagy.me/va2hc3o3i6
Создание теста - http://imagy.me/cejpxclpmm
Просмотр созданного теста - http://imagy.me/4f4tv7e8o0 (тут же аналитика)