<?php

namespace Pothole;

class Pothole extends \Base\BaseClass
{
    protected $table = 'pothole';
    protected $index = 'pothole_id';

    protected $publicColumns = array('pothole_id',
					'nickname',
					'description',
					'rating',
					'lat',
					'lng',
					'report_date',
					);

    protected $images = false;

    public function create($details)
    {
        if (!$this->_validate($details)) {
            return false;
        }

        $this->_columns['report_created'] = time();

        $potholeId = $this->save();

        if (!$potholeId) {
            return false;
        }

        if (isset($details['images'])) {
            $mapper = new ImageMapper();

            foreach ($details['images'] as $filename) {
                $file = $mapper->getByName($filename);

                if ($file) {
                    $file->set('pothole_id', $potholeId);
                    $file->save();
                }
            }
        }

        return $potholeId;
    }

    private function _validate($details)
    {
        $result = true;
        $this->_error = '';

        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'b,i.em.strong');
        $purifier = new \HTMLPurifier($config);

        if (filter_var($details['report-email'], FILTER_VALIDATE_EMAIL)) {
            $this->_columns['email'] = $details['report-email'];
        } else {
            throw new Exception('Invalid Email');
        }

        $now = time();
        $potholedate = strtotime($details['report-date']);

        if ($potholedate > $now) {
            throw new Exception('Date is in the future!');
        } else {
            $this->_columns['report_date'] = $potholedate;
        }

        $options = array(
            'options' => array(
                'min_range' => 0,
                'max_range' => 90,
            )
        );

        if (filter_var($details['lat'], FILTER_VALIDATE_FLOAT, $options)) {
            $this->_columns['lat'] = $details['lat'];
        } else {
            throw new Exception("Invalid latitude");
        }

        $options = array(
                'options' => array(
                        'min_range' => -180,
                        'max_range' => 180,
                )
        );

        if (filter_var($details['lng'], FILTER_VALIDATE_FLOAT, $options)) {
            $this->_columns['lng'] = $details['lng'];
        } else {
            throw new Exception("Invalid longitude");
            $result = false;
        }

        $options = array(
                'options' => array(
                        'min_range' => 1,
                        'max_range' => 5,
                )
        );

        if (filter_var($details['bad'], FILTER_VALIDATE_INT, $options)) {
            $this->_columns['rating'] = $details['bad'];
        } else {
            throw new Exception("Invalid pothole rating");
        }

        if (isset($details['report-nick']) && $details['report-nick']) {
            $this->_columns['nickname'] = $purifier->purify($details['report-nick']);
        } else {
            throw new Exception("Please enter a nickname");
        }

        if (isset($details['report-description'])) {
            $this->_columns['description'] = $purifier->purify($details['report-description']);
        }

        return $result;
    }

    public function getImages()
    {
	if (!$this->images)
	{
        	$mapper = new ImageMapper();

        	$this->images = $mapper->getByPothole($this->get('pothole_id'));
	}

	return $this->images;
    }

    public function getFirstImage()
    {
        $mapper = new ImageMapper();

        return $mapper->getByPothole($this->get('pothole_id'), true);
    }

    public function getPublic()
    {
	$return = parent::getPublic();

	$this->getImages();

	$return['images'] = array();
	foreach ($this->images as $image)
	{
		$return['images'][] = $image->getPublic();
	}

	return $return;
    }
}
