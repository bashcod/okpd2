Запуск проекта
1. Подключить проект к БД PostgreeSQL. Изменить конфиг в файле config\db.php
2. запустить команду в консоли php yii migrate
    2.a набрать в диалоге yes
3. запустить команду в консоли php yii xml-import [file.name]
        где file.name - полный путь к файлу (вкл имя и расширение) с okpd2 в файловой системе сервера
        где file.name - необязательный параметр (приложение возметь файл из папки темп в корне проекта)

Очистка справочника выполняется командой php yii xml-import/clear