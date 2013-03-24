<?php
class Pothole extends Object
{
	protected $_table = 'pothole';
	protected $_index = 'pothole_id';
	
	public function create($details)
	{
		if (!$this->_validate($details))
		{
			return false;
		}
		
		$this->_columns['report_created'] = time();
		
		return $this->save();
	}
	
	private function _validate($details)
	{
		$result = true;
		$this->_error = '';
		
		if (filter_var($details['report-email'], FILTER_VALIDATE_EMAIL)) 
		{
			$this->_columns['email'] = $details['report-email'];
		}
		else
		{
			$this->_error = 'Invalid Email/n';
			$result = false;
		}
		
		$now = time();
		$potholedate = strtotime($details['report-date']);
		
		if ($potholedate > $now)
		{
			$this->_error .= 'Date is in the future!/n';
			$result = false;
		}
		else
		{
			$this->_columns['report_date'] = $potholedate;
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
			$this->_error .= "Invalid latitude/n";
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
			$this->_error .= "Invalid longitude/n";
			$result = false;
		}
		
		$options = array(
				'options' => array(
						'min_range' => 1,
						'max_range' => 5,
				)
		);
		
		if (filter_var($details['bad'], FILTER_VALIDATE_INT, $options))
		{
			$this->_columns['rating'] = $details['bad'];
		}
		else
		{
			$this->_error .= "Please rate the pothole/n";
			$result = false;
		}

		return $result;
	}
}