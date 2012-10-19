<?php
class Economic {
    private $DB = null;
    public function __construct($DB) {
        $this->DB = $DB;
    }

    /**
     * Функция записи отчитанных часов при обновлении проекта
     * @param $pid - ID проекта
     * @param $tid - ID преподавателя
     * @param $oh - было отчитано ранее
     * @param $h - на сколько изменилось
     */
    function countHours($pid, $tid, $oh, $h, $w) {
        if ($oh < $h) {
            $dh = $h - $oh;
            $vals = [$tid, $pid, $dh, $w, date('Y-m-d')];
            $this->DB->db_query('INSERT INTO teachers_hours (`tid`, `pid`, `hours`, `wagerate`, `date`) VALUES (%d, %d, %d, %d, %s)', $vals);
        }
    }

    /**
     * Запись платежей по проекту
     * @param $pid - ID проекта
     * @param $mid - ID менеджера
     * @param $pays - платежи
     */
    function makePay($pid, $mid, $pay, $pvariant) {
        if (!empty($pay)) {
            $proj_pays = array($mid, $pid, $pay, $pvariant, date('Y-m-d'));
            $q_str = 'INSERT INTO projects_pays (`mid`, `pid`, `pay`, `payvariant`, `date`) VALUES (%d, %d, %d, %d, %s)';
            $this->DB->db_query($q_str, $proj_pays);
        }
    }

    /**
     * Зарплата Преподавателя
     * @param $hours
     * @param $wagerate
     * @param $mod
     * @return mixed
     */
    function salTeacher($hours, $wagerate, $mod = array()) {
        return $hours * $wagerate - $mod['penaltys'] + $mod['bonuses'];
    }

    /**
     * Зарплата Менеджера
     * @param $projects
     * @param $mod
     * @return mixed
     */
    function salManager($p_pays, $mod = array()) {
        $sum = array_sum($p_pays);

        return ($sum - 200000) * .05 + 20000 - $mod['penaltys'] + $mod['bonuses'];
    }

    /**
     * Зарплата Старшего менеджера
     * @param $projects
     * @param $mod
     * @return mixed
     */
    function salBigManager($p_pays, $mod = array()) {
        $sum = array_sum($p_pays);

        return ($sum - 200000) * .05 + 22000 - $mod['penaltys'] + $mod['bonuses'];
    }

    /**
     * Зарплата Методиста
     * @param $hours
     * @param $wagerate
     * @param $mod
     * @return mixed
     */
    function salMetodist($hours, $wagerate, $mod = array()) {
        return $hours * $wagerate - $mod['penaltys'] + $mod['bonuses'];
    }

    /**
     * Зарплата Руководителя филиала
     * @param $projects
     * @param $mod
     * @return mixed
     */
    function salFilialDirector($p_pays, $mod = array()) {
        $sum = array_sum($p_pays);

        return $sum * .03 + 25000 - $mod['penaltys'] + $mod['bonuses'];
    }

    /**
     * Зарплата Исполнительного директора
     * @param $projects
     * @param $mod
     * @return mixed
     */
    function salInitDirector ($p_pays, $mod = array()) {
        $sum = array_sum($p_pays);

        return $sum * .02 + 40000 - $mod['penaltys'] + $mod['bonuses'];
    }

    /**
     * Прибыль за месяц
     * @param $p_money
     */
    function Income($p_money, $salarys) {
        $res = $p_money - ($salarys);
        return $res;
    }

    /**
     * Долг по договору
     * @param $proj
     */
    function debt($cost, $pays) {
        return $cost - $this->payed($pays);
    }

    /**
     * Покрытая часть суммы договора
     * @param $proj
     * @return mixed
     */
    function payed($pays) {
        return array_sum($pays);
    }
}