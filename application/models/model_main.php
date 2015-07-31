<?php
class ModelMain extends Model
{
    public function numbersTable($kay, $value = '')
    {
        if (A) $where = array();
        else   $where = array($kay=>$value);
        $numbers = Numbers::getAll("*", array($kay=>$value), $this->filter);
        if ($numbers) {
            return $numbers;
        } else {
            $this->error .= 'Не найдено текущих номеров!';
            return false;
        }
    }
    
    public function work($num_id)
    {
        $this->DB->insert('work', array('num_id' => $num_id));
    }
    
    public function requestTable()
    {
        $where['kyrjer'] = '';
        $where['status'] = 2;
        if (!A) $where['operator'] = Registry::get('user')->fio;
        
        $where = array_merge($where, $this->filter['where']);

        if ($numbers = Numbers::getAll("*", $where, $this->filter)) {
            return $numbers;
        } else {
            $this->error .= 'Не найдено заявок!';
            return false;
        }
    }
    
    public function denyTable()
    {
        $where['status'] = 3;
        if (!A) $where['operator'] = Registry::get('user')->fio;
        
        $where = array_merge($where, $this->filter['where']);
        
        $numbers = Numbers::getAll("*", $where, $this->filter);

        if ($numbers) {
            return $numbers;
        } else {
            $this->error .= 'Отказов нет!';
            return false;
        }
    }
    
    public function confirmTable()
    {
        $where['status'] = 4;
        if (!A) $where['operator'] = Registry::get('user')->fio;
        
        $where = array_merge($where, $this->filter['where']);
        
        $numbers = Numbers::getAll("*", $where, $this->filter);

        if ($numbers) {
            return $numbers;
        } else {
            $this->error .= 'Договоров нет!';
            return false;
        }
    }
    
    public function kyrjers()
    {
        $kyrjers = $this->DB->select(
        "SELECT * FROM `users` WHERE `status` = 'kyrjer'");
        if ($kyrjers) {
            return $kyrjers;
        } else {
            $this->error .= 'Не найдено курьеров!';
            return false;
        }
    }
    
    public function number($number)
    {
        $numberData = $this->DB->selectRow(
        "SELECT * FROM `numbers` 
         WHERE `number` = {?} 
         ORDER BY `id` DESC LIMIT 1",
         array($number));
         if ($number = new Numbers($numberData)) {
            if ($number->operator && $number->operator != Registry::get('user')->fio) {
                $this->error .= 'Номер уже обрабатывается. ';
                return false;
            } else {
                $number->operator = Registry::get('user')->fio;
                $number->save();
                return $number;
            }
         } else {
            $this->error .= 'Номер не найден.';
            return false;
         }
     }
     
     public function change($number)
     {
        if (!empty($number['add_comment'])) {
            $query = 
            " SELECT `comment` ".
            " FROM `numbers` ".
            " WHERE `number` = {?}";
            $params = array($number['number']);
            $number['comment'] = $this->DB->selectCell($query, $params);
            if (!empty($number['comment'])) {
                $number['comment'] = json_decode($number['comment'], true);
            } else {
                $number['comment'] = array();
            }
            $number['comment'][] = array('date'=>date('d.m.Y'), 'comment'=>trim($number['add_comment']));
            unset($number['add_comment']);
        }
        $number = new Numbers($number);
        if ($number->status == 2 && !$number->request_date) {
            $number->request_date = date('d.m.Y');
        }
        
        if (!$number->save(false, 'number')) {
            $this->error .= 'Данные не сохранены.';
            return false;
        } else return $number;
    }
}