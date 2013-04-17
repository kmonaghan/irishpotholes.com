<?php

namespace Pothole;

class Image extends \Base\BaseClass 
{
    protected $table = 'image';
    protected $index = 'image_id';
    protected $publicColumns = array('image_id',
					'pothole_id',
					'filename',
					'width',
					'height',
					'image_created');

    public function getPublic()
    {
	$return = parent::getPublic();
	$return['uri'] = WWW . WWW_UPLOADS . $this->columns['filename'];

	return $return;
    }
}
