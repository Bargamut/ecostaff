<?php
/**
 * User: Bargamut
 * Date: 04.08.12
 * Time: 17:25
 */

class Site{
    public $err = array();
    /**
     * Функция проверки и экранирования значения переменной
     * @param $var - переменная
     * @param $reg - регулярное выражение
     * @param $vname - соответствующее имя в форме
     * @return string
     */
    function var2send_pm($var, $reg, $vname) {
        if (!empty($var)) {
            if (!preg_match($reg, $var)) {
                $this->err['send'][] = $vname;
            }
        } else {
            $this->err['send'][] = $vname . ': пустое';
        }
        return $var;
    }

    /**
     * Функция проверки и экранирования значения переменной
     * @param $var - переменная
     * @return string
     */
    function var2send($var){
        if (empty($var)) {
            $this->err['send'][] = $var . ': пустое';
        }
        return $var;
    }
}