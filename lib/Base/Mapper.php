<?php

namespace Base;

class Mapper
{
    protected static $instance;

    protected $_table;
    protected $_index;
    protected $_class;

    public static function getInstance($id = false)
    {
        if (!self::$instance) {
            self::$instance = new Mapper($id);
        }

        return self::$instance;
    }

    public function fetchResults($query, $single = false)
    {
        $mysql = \DB\Mysql::getInstance();

        $results = $mysql->select($query, $single);

        $objects = array();

        if ($results) {
            if ($single) {
                $objects = new $this->_class($results[$this->_index]);
            } else {
                foreach ($results as $result) {
                    $objects[] = new $this->_class($result[$this->_index]);
                }
            }
        }

        return $objects;
    }

    public function getAll($page = 0, $perPage = 20)
    {
        $mysql = \DB\Mysql::getInstance();

        $limit = array(($page * $perPage),  $perPage);

        $query = $mysql->buildSelectQuery($this->_table, array($this->_index), false, $limit);

        return $this->fetchResults($query);
    }

    public function getPagination($page = 0, $perPage = 20)
    {
        $mysql = \DB\Mysql::getInstance();

        $query = $mysql->buildSelectQuery($this->_table, array('count(*) as total'));

        $result = $mysql->select($query, true);

        $result['perPage'] = $perPage;
        $result['currentPage'] = ($page + 1);

        if ($result['total'] > $perPage) {
            $result['pages'] = ceil($result['total'] / $perPage);
        } else {
            $result['pages'] = 1;
        }

        return $result;
    }
}
