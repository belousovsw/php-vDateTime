# vDateTime

Данный класс реализует удобную обертку над стандартным DateTime для работы с датой временем.

Основной функционал:

1. Принимает NULL значение. Это позволяет вставлять дату/время из базы данных без каких либо проверок.
2. Позволяет двигать дату вперед назад с помощью методов addYear(), addMonth(), addDay(), addHour() и.т.д.
3. Метод addMonth() работает как положено прибавляет именно месяц а не 31 день.
4. Метод setFirstDayOfMonth() переведет дату на первое число месяца.
5. Метод setLastDayOfMonth() переведет дату на последний день месяца.
6. Специальные методы для получения даты/времени для базы данных getDateSQL() getDateTimeSQL()


# Примеры


`$dt1 = new vDateTime();`

`echo $dt1->getDateTimeSql(); // '"2017-01-31 15:15:15"' - текущая дата `

`$dt1->addMonth(1);`

`echo $dt1->getDateTimeSql(); // '"2017-02-28 15:15:15"' - + 1 месяц `

`$dt1->addMonth(1);`

`echo $dt1->getDateTimeSql(); // '"2017-03-31 15:15:15"' - + 1 месяц если последние число месяца, то и в устанавливаемом месяце также последнее число `

`$dt2 = clone $dt1;`

`$dt2->setFirstDayOfMonth();`

`echo $dt2->getDateTimeSql(); // '"2017-03-01 15:15:15"' `

`echo $dt1->getDateTimeStr(); // '2017-03-31 15:15:15' `

`$dtNull = new vDateTime(null);`

`echo $dtNull->getDateTimeSql(); // NULL`

`$dtNull = new vDateTime('2017-08-06 05:06:52');`

`echo $dtNull->getDateTimeSql(); // '"2017-08-06 05:06:52"'`
