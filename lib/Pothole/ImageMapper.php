<?php

namespace Pothole;

class ImageMapper extends \Base\Mapper
{
    protected $_table = 'image';
    protected $_index = 'image_id';
    protected $_class = '\\Pothole\\Image';

    public function getByName($filename)
    {
        $mysql = \DB\Mysql::getInstance();

        $where = array(array('filename', 'equal', $filename));

        $query = $mysql->buildSelectQuery($this->_table, array($this->_index), $where);

        return $this->fetchResults($query, true);
    }

    public function getByPothole($potholeId, $single = false)
    {
        $mysql = \DB\Mysql::getInstance();

        $where = array(array('pothole_id', 'equal', $potholeId));

        $query = $mysql->buildSelectQuery($this->_table, array($this->_index), $where);

        return $this->fetchResults($query, $single);
    }

    public function deleteImage($imageId) {
        $mysql = \DB\Mysql::getInstance();
        $mysql->execute($mysql->deleteQuery($this->_table,$this->_index,$imageId));
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

        $source = $this->resizeImage($filename, $width, $height, 100, 100);

        $source = $this->resizeImage($filename, $width, $height, 238, 238);

        $source = $this->resizeImage($filename, $width, $height, 600, 600);
    }

    public function resizeImage($file, $width, $height, $maxWidth = MAX_DIMENSION, $maxHeight = MAX_DIMENSION)
    {
        if ($width == $height) {
            $newwidth = $maxWidth;
            $newheight = $maxHeight;
        } elseif ($width < $height) {
            $newwidth = floor(($width * $maxHeight) / $height);
            $newheight = $maxHeight;
        } else {
            $newwidth = $maxWidth;
            $newheight = floor(($height * $maxWidth) / $width);
        }

        $fullpath = UPLOAD_DIR . '/' . $file;
        $filetype = exif_imagetype($fullpath);

        if ($filetype == IMAGETYPE_JPEG) {
            $src = imagecreatefromjpeg($fullpath);
        } elseif ($filetype == IMAGETYPE_PNG) {
            $src = imagecreatefrompng($fullpath);
        } else {
            return false;
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        if ($filetype == IMAGETYPE_JPEG) {
            imagejpeg($dst, UPLOAD_DIR . "/{$maxWidth}x{$maxHeight}_" . $file);
        } elseif ($filetype == IMAGETYPE_PNG) {
            imagepng($dst, UPLOAD_DIR . "/{$maxWidth}x{$maxHeight}_" . $file);
        }

        return $dst;
    }
}
