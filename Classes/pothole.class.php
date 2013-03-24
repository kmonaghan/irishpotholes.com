<?php
class Pothole extends Object
{
	protected $_table = 'pothole';
	protected $_index = 'pothole_id';
	
	function __construct() 
	{
		
	}
	
	public function create($details)
	{
		if (!$this->_validate($details))
		{
			return false;
		}
		
		return $this->_save();
	}
	
	private function _validate($details)
	{
		$result = false;
		
		if (filter_var($details['report-email'], FILTER_VALIDATE_EMAIL)) 
		{
			$this->_columns['email'] = $details['report-email'];
		}
		else
		{
			$result = false;
		}
		
		$options = array(
			'options' => array(
				'min_range' => 0,
				'max_range' => 90,
			)
		);
		
		if (filter_var($details['lat'], FILTER_VALIDATE_FLOAT, $options))
		{
			$this->_columns['lat'] = $details['lat'];
		}
		else
		{
			$result = false;
		}
		
		$options = array(
				'options' => array(
						'min_range' => -180,
						'max_range' => 180,
				)
		);
		
		if (filter_var($details['lng'], FILTER_VALIDATE_FLOAT, $options))
		{
			$this->_columns['lng'] = $details['lng'];
		}
		else
		{
			$result = false;
		}
		
		return $result;
	}
}