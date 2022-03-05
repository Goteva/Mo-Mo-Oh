<?php

namespace Core\Table;

use App;
use Core\Database\MysqlDatabase;

class Table
{
    protected $table;
    protected $db;

    public function __construct(MysqlDatabase $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            $c = explode('\\', get_class($this));
            $className = end($c);
            $this->table = strtolower(str_replace('Table', '', $className)) . 's';
        }
    }

    public function q($statement, $attributes = null, $list = true, $debug = false)
    {
        if ($attributes) {

            $requestStatement = $this->db->prepare(
                $statement,
                $attributes,
                str_replace('Table', 'Entity', get_class($this)),
                $list,
                $debug
            );

            return $requestStatement;
        } else {

            $requestStatement = $this->db->query(
                $statement,
                str_replace('Table', 'Entity', get_class($this)),
                $list
            );

            return $requestStatement;
        }

    }

    public function getList($key, $value)
    {
        $results = $this->getAll();
        $return = [];
        foreach ($results as $v) {
            $return[$v->$key] = $v->$value;
        }

        return $return;
    }

    public function getAll()
    {
        return $this->q('SELECT * FROM ' . $this->table);
    }

    public function create($fields, $debug = false, $LastInsertId = false)
    {
        $fieldsArray = $valuesArray = [];

        foreach ($fields as $n => $f) {
            $fieldsArray[] = "$n = ?";
            $valuesArray[] = $f;
        }

        $sqlFields = implode(', ', $fieldsArray);

        if($LastInsertId){
            $this->q('INSERT INTO ' . $this->table . ' SET ' . $sqlFields, $valuesArray, false, $debug);
            return $this->db->getLastInsertId();
        }else{
            return $this->q('INSERT INTO ' . $this->table . ' SET ' . $sqlFields, $valuesArray, false, $debug);
        }
    }

    public function update($id, $fields, $debug = false)
    {
        $fieldsArray = $valuesArray = [];

        foreach ($fields as $n => $f) {
            $fieldsArray[] = "$n = ?";
            $valuesArray[] = $f;
        }
        $valuesArray[] = $id['value'];

        $sqlFields = implode(', ', $fieldsArray);

        return $this->q('UPDATE ' . $this->table . ' SET ' . $sqlFields . ' WHERE ' . $id['name'] . ' = ?', $valuesArray, false, $debug);
    }

    public function delete($id, $debug = false)
    {
        $valuesArray = [];
        $valuesArray[] = $id['value'];
        return $this->q('DELETE FROM ' . $this->table . ' WHERE ' . $id['name'] . ' = ?', $valuesArray, false, $debug);
    }


}
