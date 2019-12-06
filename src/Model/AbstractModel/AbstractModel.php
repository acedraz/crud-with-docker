<?php

namespace model\AbstractModel;

abstract class AbstractModel
{

    /**
     * AbstractModel constructor.
     */
    public function __construct()
    {
        $this->conn = new \PDO(
            $_ENV['MYSQL_DSN'],
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASS']
        );
    }

    /**
     * @param $statement
     * @param array $parameters
     */
    private function setParams($statement, $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this->bindParam($statement, $key, $value);
        }
    }

    /**
     * @param $statement
     * @param $key
     * @param $value
     */
    private function bindParam($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    /**
     * Run on Query in Database
     * @param $rawQuery
     * @param array $params
     */
    public function query($rawQuery, $params = array())
    {
        try {
            $stmt = $this->conn->prepare($rawQuery);
            if (isset($params[0])) {
                $this->setParams($stmt, $params[0]);
            } else
                $this->setParams($stmt, $params);
            $stmt->execute();
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Return on Select Query in Database
     * @param $rawQuery
     * @param array $params
     * @return array
     */
    public function select($rawQuery, $params = array()):array
    {
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt, $params);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     */
    public function loadById($id)
    {
        $row = $this->select("SELECT * FROM " . $this->getTableName() ." WHERE id = :ID", array(
            ":ID" => $id
        ));
        $this->setData($row[0]);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->select("SELECT * FROM " . $this->getTableName());
    }

    /**
     * @return string
     */
    public function getCalledClass()
    {
        return get_called_class();
    }

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->getCalledClass()::TABLE_NAME;
    }

    /**
     * @return string
     */
    public function getFillTable()
    {
        $columns = $this->getCalledClass()::FILL_TABLE;
        return implode(",", $columns);
    }

    /**
     * Construct Relationship between tables
     * @param $table1 Table Main
     * @param $table2 Table to RelationShip
     */
    public function relationshipOneHasMany($table1, $table2)
    {
        $id = $this->getData('id');
        $select = "select tb2.* from ".$table2." tb2 INNER JOIN ". $table1 ." tb1 ON tb2.".$table1."_id = tb1.id AND tb2.".$table1."_id = ".$id;
        return $this->select($select);
    }

    /**
     * Construct Relationship between tables
     * @param $table1 Table Main
     * @param $table2 Table to RelationShip
     */
    public function relationshipOneHasOne($table1, $table2)
    {
        $id = $this->getData($table2.'_id');
        $select = "select tb2.* from ".$table2." tb2 INNER JOIN ". $table1 ." tb1 ON tb1.".$table2."_id = tb2.id AND tb1.".$table2."_id = ".$id." LIMIT 1";
        return $this->select($select);
    }

    /**
     * @param $data
     * @return |null
     */
    public function getData($data)
    {
        return (isset($this->getValues()[$data])) ? $this->getValues()[$data] : NULL;
    }


    /**
     * @param $name
     * @param $args
     * @return |null
     */
    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);
        $fieldName = substr($name, 3, strlen($name));
        $fieldName = strtolower($fieldName);
        switch ($method)
        {
            case "get":
                return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
                break;
            case "set":
                $this->values[$fieldName] = $args[0];
                break;
        }
    }

    /**
     * @param array $data
     */
    public function setData($data = array())
    {
        foreach ($data as $key => $value) {
            $this->{"set".$key}($value);
        }
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     *
     */
    public function delete()
    {
        $this->query("delete from ".$this->getTableName() . " where id = :ID", array(
            ":ID" => $this->getData('id')
        ));
    }

    /**
     *
     */
    public function save()
    {
        try {
            $this->query("INSERT INTO " . $this->getTableName() . "(" . $this->getFillTable() . ") VALUES(" . $this->prepareColumns() . ")", array(
                $this->getColumnsValue()
            ));
        } catch(\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * @return string
     */
    public function prepareColumns()
    {
        $columns = $this->getCalledClass()::FILL_TABLE;
        $columnsStatment = array();
        foreach ($columns as $c) {
            array_push($columnsStatment, ":".$c);
        }

        return implode(",", $columnsStatment);
    }

    /**
     * @return mixed
     */
    public function getColumnsValue()
    {
        $columns = $this->getCalledClass()::FILL_TABLE;
        foreach ($columns as $c) {
            $values[":".$c] = $this->getValues()[$c] ? $this->getValues()[$c] : NULL;
        }
        return $values;
    }

    /**
     * @param $col
     * @param $op
     * @param $value
     * @param $bind
     * @return array
     */
    public function where($col, $op, $value, $bind)
    {
        return $this->select("SELECT * FROM " . $this->getTableName() . " where " . $col ." " . $op . " " . $bind, array(
            $bind => $value
        ));
    }

    /**
     * @return false|string
     */
    public function updateFields()
    {
        $columns = $this->getCalledClass()::FILL_TABLE;
        $string = 'SET ';
        foreach ($columns as $c) {
            if ($c != 'id') {
                $string .= " $c=:" . $c . ",";
            }
        }
        $string = substr($string, 0, -1);
        $string .= " WHERE id=:ID";
        return $string;
    }


    /**
     *
     */
    public function update()
    {
        $this->query("UPDATE " . $this->getTableName() . ' ' . $this->updateFields(), array(
            $this->getColumnsValue(),
            ":ID" => $this->getData('id')
        ));
    }
}