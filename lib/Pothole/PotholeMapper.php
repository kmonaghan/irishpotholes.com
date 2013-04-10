<?php

namespace Pothole;

class PotholeMapper extends \Base\Mapper
{
    protected $_table = 'pothole';
    protected $_index = 'pothole_id';
    protected $_class = '\\Pothole\\Pothole';

    public function getAll($page = 0, $perPage = 20)
    {
        $mysql = \DB\Mysql::getInstance();

        $limit = array(($page * $perPage),  $perPage);

        $query = $mysql->buildSelectQuery($this->_table, array($this->_index), array(array('status', 'equal', 1)), $limit);
        
	return $this->fetchResults($query);
    }

    public function getPagination($page = 0, $perPage = 20)
    {
        $mysql = \DB\Mysql::getInstance();

        $query = $mysql->buildSelectQuery($this->_table, array('count(*) as total'), array(array('status', 'equal', 1)));

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
