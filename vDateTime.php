<?php
/**
 * Created by PhpStorm.
 * User: Сергей Белоусов
 * Date: 2017-09-22
 * Time: 15:16
 *
 * Класс разработан для удобства работы с датой в первую очередь для sql,
 * при создании может принимать строку с дадой, null, DateTime
 * Имеет методы для приражения времени, секунды / минуты / часы / дни / месяцы / годы
 * Метод приращения, Прибавляет количество месяцев, а не 31 день * количество месяцев,
 * тоесть если к 31му января прибавить 1 месяц, то получим 28/29 февраля, в зависимости от високосного года
 * Если приращиваемая дата это последний день месяца,
 * то и прибавление месяца даст последний день месяца (31 Октября + 1мес = 30 Ноября) или (28 Февраля + 1мес = 31 Марта)
 */

class vDateTime {
    /** @var  DateTime $date */
    private $dateTime;

    /**
     * Принимает на вход стандартные параметры как и у DateTime, также можно передовать Null, DateTime и vDateTime
     * vDateTime constructor.
     * @param vDateTime|DateTime|null|string $dateTime
     * @return $this
     */
    public function __construct($dateTime = 'now') {
        $this->setDateTime($dateTime);
        return $this;
    }

    /**
     * Устанавливает новую дату время
     * @param vDateTime|DateTime|null|string $dateTime
     * @return $this
     */
    public function setDateTime($dateTime = 'now') {
        switch (gettype($dateTime)) {
            case 'string' :
                if (empty(trim($dateTime))) {
                    break;
                }
                $this->dateTime = new DateTime($dateTime);
                return $this;
                break;
            case 'object':
                $class = get_class($dateTime);
                if ($class == 'DateTime') {
                    $this->dateTime = $dateTime;
                    return $this;
                } else if ($class == 'vDateTime') {
                    $this->dateTime = $dateTime->getDateTime();
                    return $this;
                }
                break;
        }
        $this->dateTime = null;
        return $this;
    }

    /**
     * Принудительно клонируем внутренне свойство объекта, иначе при клонировании объекта
     * , при изменении в новом объекте оно будет изменяться и в родителе
     */
    public function __clone() {
        if (gettype($this->dateTime) == 'object') {
            $this->dateTime = clone $this->dateTime;
        }
    }

    /**
     * Проверяет является ли дата NULL
     * @return bool
     */
    public function isNull() : bool {
        return $this->dateTime == null;
    }

    /**
     * Проверяет не является ли дата null
     * @return bool
     */
    public function isNotNull() : bool {
        return !$this->isNull();
    }

    /**
     * Сравнениет внутренней даты с переданной в параметре, если внуткенняя дата  |  < возвращает -1  |  = возвращает 0  |  > возвращает 1  |
     *  Если одна из дат NULL будет выброшено исключение, преждем чем проводить сравнение дат, необходимо их проверить на null ( isNull || isNotNull )
     * @param vDateTime $dateTime
     * @return int
     * @throws Exception
     */
    public function compareTo(vDateTime $dateTime) : int {
        if ($this->isNull() || $dateTime->isNull()) {
            throw new Exception("Comparison is not possible if one of the dates is null", 0);
        }
        return $this->getDateTime() == $dateTime->getDateTime() ? 0 : ($this->getDateTime() > $dateTime->getDateTime() ? 1 : -1);
    }

    /**
     * Добавляет заданное количество дней, месяцев, лет, часов, минут и секунд к объекту DateTime
     * Редирект к внутреннему объект DateTime
     * @param DateInterval $interval
     */
    public function add(DateInterval $interval) {
        $this->dateTime->add($interval);
    }
    /**
     * Вычитает заданное количество дней, месяцев, лет, часов, минут и секунд из времени объекта DateTime
     * Редирект к внутреннему объект DateTime
     * @param DateInterval $interval
     */
    public function sub(DateInterval $interval) {
        $this->dateTime->sub($interval);
    }
    /**
     * Изменение временной метки
     * Редирект к внутреннему объект DateTime
     * @param string $modify
     */
    public function modify(string $modify) {
        $this->dateTime->modify($modify);
    }

    /**
     * Устанавливает дату и время, основываясь на метке времени Unix
     * Редирект к внутреннему объект DateTime
     * @param int $timestamp
     */
    public function setTimestamp(int $timestamp) {
        $this->dateTime->setTimestamp($timestamp);
    }
    /**
     * Возвращает дату и время, основываясь на метке времени Unix
     * Редирект к внутреннему объект DateTime
     * @return int
     */
    public function getTimestamp() : int {
        return $this->dateTime->getTimestamp();
    }

    /**
     * Установка даты
     * Редирект к внутреннему объект DateTime
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function setDate(int $year, int $month, int $day) {
        $this->dateTime->setDate($year, $month, $day);
    }

    /**
     * Установка времени
     * Редирект к внутреннему объект DateTime
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param int $microsecond
     */
    public function setTime(int $hour, int $minute, int $second = 0, int $microsecond = 0) {
        $this->dateTime->setTime($hour, $minute, $second, $microsecond);
    }

    /**
     * Возвращает разницу между двумя vDateTime объектами
     * Редирект к внутреннему объект DateTime
     * @param vDateTime $dateTime
     * @param bool     $absolute
     * @return bool|DateInterval
     */
    public function diff(vDateTime $dateTime, bool $absolute = false) {
        return $this->dateTime->diff($dateTime->getDateTime(), $absolute);
    }

    /**
     * Возвращает смещение часовой зоны
     * Редирект к внутреннему объект DateTime
     * @return int
     */
    public function getOffset() : int {
        return $this->dateTime->getOffset();
    }

    /**
     * Возвращает часовую зону относительно текущему значению DateTime
     * Редирект к внутреннему объект DateTime
     * @return DateTimeZone
     */
    public function getTimezone() : DateTimeZone {
        return $this->dateTime->getTimezone();
    }

    /**
     * Устанавливает часовую зону относительно текущему значению DateTime
     * Редирект к внутреннему объект DateTime
     * @param DateTimeZone $timeZone
     */
    public function setTimezone(DateTimeZone $timeZone){
        $this->dateTime->setTimezone($timeZone);
    }

    /**
     * Возвращает объект DateTime
     * @return DateTime
     */
    public function getDateTime() : ?DateTime {
        return $this->dateTime;
    }

    /**
     * Возвращает строку с датой по заданному формату по умолчанию Y-m-d
     * @param string $format
     * @return string
     */
    public function getDateStr(string $format = 'Y-m-d') : string {
        if ($this->dateTime == null) {
            $val = "";
        } else {
            $val = $this->dateTime->format($format);
        }
        return $val;
    }

    /**
     * Возвращает строку с датой по заданному формату по умолчанию Y-m-d H:i:s
     * @param string $format
     * @return string
     */
    public function getDateTimeStr($format = 'Y-m-d H:i:s') : string {
        return $this->getDateStr($format);
    }

    /**
     * Возвращает дату готовую для вставки в sql выражение, без последующей необходимости в escape`инге
     * @param string $format
     * @return string
     */
    public function getDateSql(string $format = 'Y-m-d') : string {
        if ($this->dateTime == null) {
            return "NULL";
        } else {
            $val = $this->dateTime->format($format);
        }
        return "\"" . $this->escape($val) . "\"";
    }

    /**
     * Возвращает дату готовую для вставки в sql выражение, без последующей необходимости в escape`инге
     * @param string $format
     * @return string
     */
    public function getDateTimeSql($format = 'Y-m-d H:i:s') : string {
        return $this->getDateSql($format);
    }

    /**
     * Добавляет заданое количество секунд
     * @param int $seconds
     * @return vDateTime
     */
    public function addSeconds(int $seconds) : vDateTime {
        if ($this->dateTime == null) return $this;
        $intDateTime = $this->dateTime->getTimestamp();
        $intNewDateTime = $intDateTime + $seconds;
        $this->dateTime->setTimestamp($intNewDateTime);
        return $this;
    }

    /**
     * Добавляет заданое количество минут
     * @param int $minuts
     * @return vDateTime
     */
    public function addMinuts(int $minuts) : vDateTime {
        if ($this->dateTime == null) return $this;
        $intDateTime = $this->dateTime->getTimestamp();
        $intNewDateTime = $intDateTime + ($minuts * 60);
        $this->dateTime->setTimestamp($intNewDateTime);
        return $this;
    }

    /**
     * Добавляет заданое количество часов
     * @param int $hours
     * @return vDateTime
     */
    public function addHours(int $hours) : vDateTime {
        if ($this->dateTime == null) return $this;
        $intDateTime = $this->dateTime->getTimestamp();
        $intNewDateTime = $intDateTime + ($hours * 3600);
        $this->dateTime->setTimestamp($intNewDateTime);
        return $this;
    }

    /**
     * Добавляет заданое количество дней
     * @param int $days
     * @return vDateTime
     */
    public function addDays(int $days) : vDateTime {
        if ($this->dateTime == null) return $this;
        $intDateTime = $this->dateTime->getTimestamp();
        $intNewDateTime = $intDateTime + ($days * 86400);
        $this->dateTime->setTimestamp($intNewDateTime);
        return $this;
    }

    /**
     * Добавляет заданное колличество месяцев
     * Прибавляет количество месяцев, а не 31 день * количество месяцев,
     * тоесть если к 31му января прибавить 1 месяц, то получим 28/29 февраля, в зависимости от високосного года
     * Если приращиваемая дата это последний день месяца,
     * то и прибавление месяца даст последний день месяца (31 Октября + 1мес = 30 Ноября) или (28 Февраля + 1мес = 31 Марта)
     * @param int $months
     * @return $this
     */
    public function addMonths(int $months) {
        if ($this->dateTime == null) return $this;
        list($intYear, $intMonth, $intDay, $lastDay) = explode('|', $this->dateTime->format('Y|m|d|t'));
        $prevIsLastDay = $intDay == $lastDay;
        $intMonth = $intMonth + $months;
        $intYear += floor($intMonth / 12);
        $intMonth = $intMonth % 12;
        $lastDayInNewDate = $this->getMaxDaysInMonth($intYear, $intMonth);
        $intDay = (($intDay > $lastDayInNewDate) || ($prevIsLastDay)) ? $lastDayInNewDate : $intDay;
        $this->dateTime->setDate($intYear, $intMonth, $intDay);
        return $this;
    }

    /**
     * Добавляет заданное количество лет
     * @param int $years
     * @return vDateTime
     */
    public function addYaers(int $years) : vDateTime {
        if ($this->dateTime == null) return $this;
        list($intYear, $intMonth, $intDay) = explode('|', $this->dateTime->format('Y|m|d'));
        $intYear  += $years;
        $lastDayInNewDate = $this->getMaxDaysInMonth($intYear, $intMonth);
        $intDay = $intDay > $lastDayInNewDate ? $lastDayInNewDate : $intDay;
        $this->dateTime->setDate($intYear, $intMonth, $intDay);
        return $this;
    }

    /**
     * Меняет внутренней дате день на первый день в месяце
     * @return $this
     */
    public function setFirstDayOfMonth() {
        if ($this->dateTime == null) return $this;
        list($intYear, $intMonth) = explode('|', $this->dateTime->format('Y|m'));
        $this->dateTime->setDate($intYear, $intMonth, 1);
        return $this;
    }

    /**
     * Меняет внутренней дате день на последний в месяце
     * @return $this
     */
    public function setLastDayOfMonth() {
        if ($this->dateTime == null) return $this;
        list($intYear, $intMonth, $lastDay) = explode('|', $this->dateTime->format('Y|m|t'));
        $this->dateTime->setDate($intYear, $intMonth, $lastDay);
        return $this;
    }

    private function getMaxDaysInMonth(int $intYear, int $intMonth) : int {
        if ($intMonth == 2) {
            if (($intYear%4 == 0 && $intYear%100 != 0) || ($intYear%400 == 0)) {
                $lastDayInNewDate = 29;
            } else {
                $lastDayInNewDate = 28;
            }
        } else if (in_array($intMonth, [4,6,9,11])) {
            $lastDayInNewDate = 30;
        } else {
            $lastDayInNewDate = 31;
        }
        return $lastDayInNewDate;
    }

    /**
     * Возвращает номер года
     * @return int
     */
    public function getYear() : int {
        if ($this->dateTime == null) return null;
        return intval($this->dateTime->format('Y'));
    }
    /**
     * Возвращает номер месяца в году
     * @return int
     */
    public function getMonth() : int {
        if ($this->dateTime == null) return null;
        return intval($this->dateTime->format('m'));
    }
    /**
     * Возвращает номер дня в месяце
     * @return int
     */
    public function getDay() : int {
        if ($this->dateTime == null) return null;
        return intval($this->dateTime->format('d'));
    }
    /**
     * Возвращает последний номер деня в месяце
     * @return int
     */
    public function getLastDayInMonth() : int {
        if ($this->dateTime == null) return null;
        list($yy, $mm) = explode('|', intval($this->dateTime->format('Y|m')));
        return $this->getMaxDaysInMonth($yy, $mm);
    }

    private function escape(string $value) : string {
        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
        return str_replace($search, $replace, $value);
    }
}