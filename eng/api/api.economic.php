<?php
class Economic {
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
    function salManager($projects, $mod = array()) {
        $sum = 0; // Сумма по способам оплаты
        $money = array();
        if (!isset($projects['id'])) {
            // Шерстим все проекты за месяц
            foreach($projects as $k => $v) {
                // Определение типа и суммы оплаты - оно надо вообще?
                switch ($v['payvariant']) {
                    case 1: $money['kassa']     += $this->payed($v); break;
                    case 2: $money['noystudy']  += $this->payed($v); break;
                    case 3: $money['mbcschool'] += $this->payed($v); break;
                    default: break;
                }
            }
        } else {
            // Определение типа и суммы оплаты - оно надо вообще?
            switch ($projects['payvariant']) {
                case 1: $money['kassa']     += $this->payed($projects); break;
                case 2: $money['noystudy']  += $this->payed($projects); break;
                case 3: $money['mbcschool'] += $this->payed($projects); break;
                default: break;
            }
        }

        // Суммируем все варианты оплаты
        $sum += $money['kassa'] + $money['noystudy'] + $money['mbcschool'];
        return ($sum - 200000) * .05 + 20000 - $mod['penaltys'] + $mod['bonuses'];
    }

    /**
     * Зарплата Старшего менеджера
     * @param $projects
     * @param $mod
     * @return mixed
     */
    function salBigManager($projects, $mod = array()) {
        $sum = 0; // Сумма по способам оплаты
        $money = array();
        if (!isset($projects['id'])) {
            // Шерстим все проекты за месяц
            foreach($projects as $k => $v) {
                // Определение типа и суммы оплаты - оно надо вообще?
                switch ($v['payvariant']) {
                    case 1: $money['kassa']     += $this->payed($v); break;
                    case 2: $money['noystudy']  += $this->payed($v); break;
                    case 3: $money['mbcschool'] += $this->payed($v); break;
                    default: break;
                }
            }
        } else {
            // Определение типа и суммы оплаты - оно надо вообще?
            switch ($projects['payvariant']) {
                case 1: $money['kassa']     += $this->payed($projects); break;
                case 2: $money['noystudy']  += $this->payed($projects); break;
                case 3: $money['mbcschool'] += $this->payed($projects); break;
                default: break;
            }
        }

        // Суммируем все варианты оплаты
        $sum += $money['kassa'] + $money['noystudy'] + $money['mbcschool'];
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
    function salFilialDirector($projects, $mod = array()) {
        $sum = 0; // Сумма по способам оплаты
        $money = array();
        if (!isset($projects['id'])) {
            // Шерстим все проекты за месяц
            foreach($projects as $k => $v) {
                // Определение типа и суммы оплаты - оно надо вообще?
                switch ($v['payvariant']) {
                    case 1: $money['kassa']     += $this->payed($v); break;
                    case 2: $money['noystudy']  += $this->payed($v); break;
                    case 3: $money['mbcschool'] += $this->payed($v); break;
                    default: break;
                }
            }
        } else {
            // Определение типа и суммы оплаты - оно надо вообще?
            switch ($projects['payvariant']) {
                case 1: $money['kassa']     += $this->payed($projects); break;
                case 2: $money['noystudy']  += $this->payed($projects); break;
                case 3: $money['mbcschool'] += $this->payed($projects); break;
                default: break;
            }
        }

        // Суммируем все варианты оплаты
        $sum += $money['kassa'] + $money['noystudy'] + $money['mbcschool'];
        return $sum * .03 + 25000 - $mod['penaltys'] + $mod['bonuses'];
    }

    /**
     * Зарплата Исполнительного директора
     * @param $projects
     * @param $mod
     * @return mixed
     */
    function salInitDirector ($projects, $mod = array()) {
        $sum = 0; // Сумма по способам оплаты
        $money = array();
        // Шерстим все проекты за месяц
        foreach($projects as $k => $v) {
            // Определение типа и суммы оплаты - оно надо вообще?
            switch ($v['payvariant']) {
                case 1: $money['kassa']     += $this->payed($v); break;
                case 2: $money['noystudy']  += $this->payed($v); break;
                case 3: $money['mbcschool'] += $this->payed($v); break;
                default: break;
            }
        }

        // Суммируем все варианты оплаты
        $sum += $money['kassa'] + $money['noystudy'] + $money['mbcschool'];
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
    function debt($proj) {
        return $proj['cost'] - $this->payed($proj);
    }

    /**
     * Покрытая часть суммы договора
     * @param $proj
     * @return mixed
     */
    function payed($proj) {
        return $proj['etap1'] + $proj['etap2'] + $proj['etap3'] + $proj['etap4'];
    }
}