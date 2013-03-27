<?php
class ImageMapper extends Mapper
{
	protected $_table = 'image';
	protected $_index = 'image_id';
	protected $_class = 'Image';
	
	function getByName($filename)
	{
		$mysql = Mysql::getInstance();
		
		$where = array(array('filename', 'equal', $filename));
			
		$query = $mysql->buildSelectQuery($this->_table, array($this->_index), $where);
		
		return $this->fetchResults($query, true);
	}
	
	function getByPothole($potholeId, $single = false)
	{
		$mysql = Mysql::getInstance();
		
		$where = array(array('pothole_id', 'equal', $potholeId));
			
		$query = $mysql->buildSelectQuery($this->_table, array($this->_index), $where);

		return $this->fetchResults($query, $single);
	}

	public function addImage($filename)
	{		
		list($width, $height) = getimagesize(UPLOAD_DIR . '/' . $filename);

		$image = new Image();
		$image->set('filename', $filename);
		$image->set('width', $width);
		$image->set('height', $height);
		$image->set('image_created', time());
		$image->save();
		
		$source = $this->resizeImage($filename, $width, $height, 150, 150);

		$source = $this->resizeImage($filename, $width, $height, 300, 300);

		$source = $this->resizeImage($filename, $width, $height, 600, 600);
	}
	
	public function resizeImage($file, $width, $height, $maxWidth = MAX_DIMENSION, $maxHeight = MAX_DIMENSION)
	{
		if ($width == $height)
		{
			$newwidth = $maxWidth;
			$newheight = $maxHeight;
		}
		else if ($width < $height)
		{
			$newwidth = floor(($width * $maxHeight) / $height);
			$newheight = $maxHeight;
		}
		else
		{
			$newwidth = $maxWidth;
			$newheight = floor(($height * $maxWidth) / $width);
		}
	
		$fullpath = UPLOAD_DIR . '/' . $file;
		$filetype = exif_imagetype($fullpath);
		
		if ($filetype == IMAGETYPE_JPEG)
		{
			$src = imagecreatefromjpeg($fullpath);
		}
		else if ($filetype == IMAGETYPE_PNG)
		{
			$src = imagecreatefrompng($fullpath);
		}
		else 
		{
			return false;
		}
		
		$dst = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		if ($filetype == IMAGETYPE_JPEG)
		{
			imagejpeg($dst, UPLOAD_DIR . "/{$maxWidth}x{$maxHeight}_" . $file);
		}
		else if ($filetype == IMAGETYPE_PNG)
		{
			imagepng($dst, UPLOAD_DIR . "/{$maxWidth}x{$maxHeight}_" . $file);
		}
		
		return $dst;
	}
}