<?php
class mysql 
{
	private static $instance;

	private $_mysqli;
	
	function __construct() 
	{
		$this->_connect();
	}
	
	public function __destruct()
	{
		$this->_mysqli->close();
	}
	
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new Mysql();
		}
		
		return self::$instance;
	}
	
	private function _connect()
	{
		$this->_mysqli = new mysqli(MYSQLI_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE, MYSQL_PORT);

		if ($this->_mysqli->connect_errno) 
		{
			die("Failed to connect to MySQL: (" . $this->_mysqli->connect_errno . ") " . $this->_mysqli->connect_error);
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string 	$query	The query to be performed
	 * @param bool 		$single	If only a single row should be returned then set this to true
	 */
	public function select($query, $single = false)
	{
		$result = $this->execute($query);

		$return = false;
		
		if ($single)
		{
			$return = $result->fetch_assoc();
		}
		else
		{
			while ($row = $result->fetch_assoc())
			{
				$return[] = $row;
			}
		}
		
		$result->close();
		
		return $return;
	}
	
	public function execute($query)
	{
		$result = $this->_mysqli->query($query);
		
		if (!$result)
		{
			die('Invalid query: ' . $query . ' ' . $this->_mysqli->error);
		}
	
		return $result;
	}
	
	public function buildSelectQuery($table, $columns, $where = false, $limit = false, $order = false)
	{
		$queryString = '';
		
		$queryString .= 'SELECT ' . implode(',', $columns) . ' FROM ' . $table;
		
		if ($where)
		{
			if (is_array($where))
			{
				$queryString .= ' WHERE ' . $this->andWhere($where);
			}
			else 
			{
				$queryString .= ' WHERE ' . $where;
			}
		}
		
		if (is_array($limit))
		{
			$queryString .= ' LIMIT ' . (int)$limit[0] . ', ' . (int)$limit[1];
		}
		
		if ($order)
		{
			if (is_array($order))
			{
				$queryString .= ' ORDER BY ' . implode(',', $order);
			}
			else
			{
				$queryString .= ' ORDER BY ' . $order;
			}
		}
		
		return $queryString;
	}
	
	public function updateQuery($table, $values, $where)
	{
		$queryString = "UPDATE $table SET ";
		
		$statementArray = array();
		
		foreach ($values as $item)
		{
			$statementArray[] = $this->statement($item);
		}
		
		if (count($statementArray))
		{
			$queryString .= implode(' , ', $statementArray);
		}
		
		if ($where)
		{
			$queryString .= ' WHERE ' . $this->andWhere($where);
		}
		
		return $queryString;
	}
	
	public function insertQuery($table, $values)
	{
		$queryString = "INSERT INTO $table SET ";
		
		$statementArray = array();

		foreach ($values as $item)
		{
			$statementArray[] = $this->statement($item);
		}

		if (count($statementArray))
		{
			$queryString .= implode(' , ', $statementArray);
		}
		
		return $queryString;
	}
	
	public function andWhere($items)
	{
		$where = '';
		
		$statementArray = array();
		
		foreach ($items as $item)
		{
			$statementArray[] = $this->statement($item);
		}
		
		if (count($statementArray))
		{
			$where = implode(' AND ', $statementArray);
		}
		
		return $where;
	}
	
	/**
	 * 
	 * @param array $item - expected in the form of {column, [equals|greater|less|greaterequal|lessequal], value}
	 * @return string
	 */
	public function statement($item)
	{
		$statement = '';
		
		if ($item[1] == 'equal')
		{
			$statement = $item[0] . ' = "' . $this->_mysqli->real_escape_string($item[2]) . '"';
		}
		else if ($item[1] == 'greater')
		{
			$statement = $item[0] . ' > "' . $this->_mysqli->real_escape_string($item[2]) . '"';
		}
		else if ($item[1] == 'less')
		{
			$statement = $item[0] . ' < "' . $this->_mysqli->real_escape_string($item[2]) . '"';
		}
		else if ($item[1] == 'greaterequal')
		{
			$statement = $item[0] . ' >= "' . $this->_mysqli->real_escape_string($item[2]) . '"';
		}
		else if ($item[1] == 'lessequal')
		{
			$statement = $item[0] . ' <= "' . $this->_mysqli->real_escape_string($item[2]) . '"';
		}
		return $statement;
	}

	public function lastInsertId()
	{
		return $this->_mysqli->insert_id;
	}
}