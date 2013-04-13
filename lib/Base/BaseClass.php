<?php

namespace Base;

class BaseClass 
{
    protected static $instance;

    protected $_table;
    protected $_index;

    protected $_columns = array();
    protected $_publicColumns = array();

    protected $_dirty = false;

    protected $_error = false;

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
        $index = ($index) ? $index : $this->_index;

        $mysql = \DB\Mysql::getInstance();

        $where = array(array($index, 'equal', $id));

        $query = $mysql->buildSelectQuery($this->_table, array('*'), $where);

        $result = $mysql->select($query, true);

        if ($result) {
            foreach ($result as $key => $value) {
                $this->_columns[$key] = $value;
            }
        }
    }

    public function save()
    {
        if (!count($this->_columns)) {
            return false;
        }

        $mysql = \Db\Mysql::getInstance();

        $columns = $this->_columns;

        foreach ($columns as $key => $value) {
            $values[$key] = array($key, 'equal', $value);
        }

        if (isset($this->_columns[$this->_index])) {
            $where = array(array($this->_index, 'equal', $this->_columns[$this->_index]));

            unset($values[$this->_index]);

            $query = $mysql->updateQuery($this->_table, $values, $where);
        } else {
            $query = $mysql->insertQuery($this->_table, $values);
        }

        if (!$mysql->execute($query)) {
            return false;
        }

        if (!isset($this->_columns[$this->_index])) {
            $this->_columns[$this->_index] = $mysql->lastInsertId();
        }

        return $this->_columns[$this->_index];
    }

    public function delete()
    {
        $mysql = \DB\Mysql::getInstance();

	    $query = $mysql->deleteQuery($this->_table, $this->_index, $this->_columns[$this->_index]);

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
        if (isset($this->_columns[$column])) {
            return $this->_columns[$column];
        }

        return false;
    }

    public function getAll()
    {
        return $this->_columns;
    }

    public function getPublic()
    {
	$return = array();

	foreach ($this->_publicColumns as $allowed) {
		$return[$allowed] = $this->_columns[$allowed];
	}

	return $return;
    }

    public function set($column, $value)
    {
        $this->_columns[$column] = $value;

        $this->_dirty = true;
    }

    public function getError()
    {
        return $this->_error;
    }

    public function toJSON()
    {
        return json_encode($this->getPublic());
    }
}
