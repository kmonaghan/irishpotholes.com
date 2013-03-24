<?php
class Pothole 
{
	private $_email;
	private $_date;
	private $_lat;
	private $_lng;
	
	
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
			$this->_email = $details['report-email'];
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
			$this->_lat = $details['lat'];
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
			$this->_lng = $details['lng'];
		}
		else
		{
			$result = false;
		}
		
		return $result;
	}
	
	private function _save()
	{
		
	}
}