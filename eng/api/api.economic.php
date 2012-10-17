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
     * Запись платежейпо проекту
     * @param $pid - ID проекта
     * @param $pays - платежи
     */
    function makePay($pid, $pays) {
        $i = count($pays);
        $pay = ($i > 1) ? $pays[$i - 1] : $pays[0];

        if ($i > 1) {
            if ($pay != '') {
                $proj_pays = array($pay, date('Y-m-d'), $pid);
                $q_str = 'UPDATE projects_pays SET `pay' . $i . '`=%d, `date' . $i . '`=%s WHERE `id` = %d';
            }
        } else {
            $proj_pays = array($pay, date('Y-m-d'));
            $q_str = 'INSERT INTO projects_pays (`pay1`, `date1`) VALUES (%d, %s)';
        }
        $this->DB->db_query($q_str, $proj_pays);
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
    function debt($cost, $pays) {
        return $cost - $this->payed($pays);
    }

    /**
     * Покрытая часть суммы договора
     * @param $proj
     * @return mixed
     */
    function payed($pays) {
        $sum = 0;
        foreach($pays as $k => $v) { $sum += $v; }
        return $sum;
    }
}