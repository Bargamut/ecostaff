<?php
/**
 * User: Bargamut
 * Date: 06.10.12
 * Time: 4:29
 */

class Economic {
    /**
     * Зарплата Преподавателя
     * @param $hours
     * @param $wagerate
     * @return mixed
     */
    function salTeacher($hours, $wagerate, $penaltys = 0) {
        return $hours * $wagerate - $penaltys;
    }

    /**
     * Зарплата Менеджера
     * @param $money
     * @return mixed
     */
    function salManager($money, $penaltys = 0) {
        return ($money['kassa'] + $money['noystady'] + $money['mbcschool'] - 200000) * .05 + 20000 - $penaltys;
    }

    /**
     * Зарплата Старшего менеджера
     * @param $money
     * @return mixed
     */
    function salBigManager($money, $penaltys = 0) {
        return ($money['kassa'] + $money['noystady'] + $money['mbcschool'] - 200000) * .05 + 22000 - $penaltys;
    }

    /**
     * Зарплата Методиста
     * @param $hours
     * @param $wagerate
     * @return mixed
     */
    function salMetodist($hours, $wagerate, $penaltys = 0) {
        return $hours * $wagerate - $penaltys;
    }

    /**
     * Зарплата Исполнительного директора
     * @param $money
     * @return mixed
     */
    function salFilialBoss($money, $penaltys = 0) {
        return ($money['kassa'] + $money['noystady'] + $money['mbcschool']) * .03 + 25000 - $penaltys;
    }

    function salInitDirector ($money, $penaltys = 0) {
        $sum = 0;
        foreach($money as $k => $val) {
            $sum += $val['kassa'] + $val['noystady'] + $val['mbcschool'];
        }
        return ($sum) * .02 + 40000 - $penaltys;
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
    function debt($proj) {
        return $proj['cost'] - ($proj['etap1'] + $proj['etap2'] + $proj['etap3'] + $proj['etap4']);
    }
}