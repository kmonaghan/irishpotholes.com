<?php

namespace Base;

class BaseClass 
{
    protected static $instance;

    protected $table;
    protected $index;

    protected $columns = array();
    protected $publicColumns = array();

    protected $error = false;

    public function __construct($id = false)
    {
        if ($id) {
            $this->load($id);
        }
    }

    public static function getInstance($id = false)
    {
        if (!self::$instance) {
            self::$instance = new Object($id);
        }

        return self::$instance;
    }

    public function load($id, $index = false)
    {
        $index = ($index) ? $index : $this->index;

        $mysql = \DB\Mysql::getInstance();

        $where = array(array($index, 'equal', $id));

        $query = $mysql->buildSelectQuery($this->table, array('*'), $where);

        $result = $mysql->select($query, true);

        if ($result) {
            foreach ($result as $key => $value) {
                $this->columns[$key] = $value;
            }
        }
    }

    public function save()
    {
        if (!count($this->columns)) {
            return false;
        }

        $mysql = \Db\Mysql::getInstance();

        $columns = $this->columns;

        foreach ($columns as $key => $value) {
            $values[$key] = array($key, 'equal', $value);
        }

        if (isset($this->columns[$this->index])) {
            $where = array(array($this->index, 'equal', $this->columns[$this->index]));

            unset($values[$this->index]);

            $query = $mysql->updateQuery($this->table, $values, $where);
        } else {
            $query = $mysql->insertQuery($this->table, $values);
        }

        if (!$mysql->execute($query)) {
            return false;
        }

        if (!isset($this->columns[$this->index])) {
            $this->columns[$this->index] = $mysql->lastInsertId();
        }

        return $this->columns[$this->index];
    }

    public function delete()
    {
        $mysql = \DB\Mysql::getInstance();

	    $query = $mysql->deleteQuery($this->table, $this->index, $this->columns[$this->index]);

        $result = $mysql->execute($query);

        if($result !== false) {
             //Delete from file system
            $mask = UPLOAD_DIR.DIRECTORY_SEPARATOR."*".$filename;
            array_map( "unlink", glob( $mask ) );
        }

        return $result;
    }

    public function get($column)
    {
        if (isset($this->columns[$column])) {
            return $this->columns[$column];
        }

        return false;
    }

    public function getAll()
    {
        return $this->columns;
    }

    public function getPublic()
    {
	$return = array();

	foreach ($this->publicColumns as $allowed) {
		$return[$allowed] = $this->columns[$allowed];
	}

	return $return;
    }

    public function set($column, $value)
    {
        $this->columns[$column] = $value;
    }

    public function getError()
    {
        return $this->error;
    }

    public function toJSON()
    {
        return json_encode($this->getPublic());
    }
}
