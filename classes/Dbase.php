<?php

namespace Landingo\Resources;

use PDO;

class Dbase
{
    private $db = null;

    private $row = '*';
    private $where;
    private $join;
    private $joined_table;
    private $references;
    private $group_by;
    private $order_by;
    private $limit;
    private $many_join;

    private $last_query = null;
    private $last_data = array();

    public function __construct()
    {
        $conf = new Config();

        $host = $conf->get('database.host');
        $engine = $conf->get('database.engine');
        $dbname = $conf->get('database.dbname');
        $user = $conf->get('database.user');
        $pass = $conf->get('database.password');

        $conf->close();

        $this->db = new PDO("{$engine}:host={$host};dbname={$dbname}", $user, $pass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function reset(array $property)
    {
        foreach ($property as $value) 
        {
            if(property_exists($this, $value))
            {
                $this->$value = null;
            }
        }
    }

    public function __set($property, $val)
    {
        if(!property_exists($this, $property))
        {
            echo "<i>{$property}</i> not available on Database class !";
            return;
        }

        $this->$property = $val;
    }

    public function get($table)
    {
        $query = "SELECT {$this->row} FROM {$table}";

        if($this->join)
        {
            $query .= " {$this->join} {$this->joined_table} ON {$this->references}";
        }

        if($this->many_join)
        {
            foreach ($this->many_join as $key => $value) {
                $query .= " INNER JOIN {$key} ON $value";
            }
        }

        if($this->where)
        {
            $query .= " WHERE {$this->where}";
        }

        if($this->group_by)
        {
            $query .= " GROUP BY {$this->group_by}";
        }

        if($this->order_by)
        {
            $query .= " ORDER BY {$this->order_by}";
        }

        if($this->limit)
        {
            $query .= " LIMIT {$this->limit}";
        }

        $this->last_query = $query;
        return $this;
    }

    public function insert($table, array $data)
    {
        $index = '';
        foreach ($data as $key) {
            $index .= "?, "; 
        }
        $index = rtrim($index, ', ');

        $query = "INSERT INTO {$table} VALUES ({$index})";

        $this->last_query = $query;
        $this->last_data = $data;

        return $this;
    }

    public function update($table, array $data)
    {
        if(!$this->where)
        {
            echo '<i>Key</i> not defined !';
            return;
        }
        $row = implode(' = ?, ' , array_keys($data)) . ' = ?';
        $this->last_query = "UPDATE {$table} SET {$row} WHERE {$this->where}";
        $this->last_data = array_values($data);

        return $this;
    }

    public function delete($table)
    {
        if(!$this->where)
        {
            echo '<i>Key</i> not defined !';
            return;
        }

        $this->last_query = "DELETE FROM {$table} WHERE {$this->where}";

        return $this;

    }

    public function resultAll()
    {
        $sql = $this->db->prepare($this->last_query);
        $sql->execute();

        $this->last_query = null;

        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function result()
    {
        $sql = $this->db->prepare($this->last_query);
        $sql->execute();

        $this->last_query = null;
        
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount()
    {
        $sql = $this->db->prepare($this->last_query);
        $sql->execute($this->last_data);

        $this->last_query = null;
        $this->last_data = array();

        return $sql->rowCount();
    }

    public function close()
    {
        $this->db = null;
    }


}