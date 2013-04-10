<?php

namespace Fine;

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class UploadedFileForm
{
    private $fileFieldName = 'qqfile';

    public function __construct() 
    {
        if(!isset($_FILES['qqfile'])) {
            if(isset($_FILES['image'])) {
                $this->fileFieldName = 'image';
            } else {
                throw new \Pothole\Exception('No image uploaded');
            }
        }
    }
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    public function save($path)
    {
        return move_uploaded_file($_FILES[$this->fileFieldName]['tmp_name'], $path);
    }

    /**
     * Get the original filename
     * @return string filename
     */
    public function getName()
    {
        return $_FILES[$this->fileFieldName]['name'];
    }

    /**
     * Get the file size
     * @return integer file-size in byte
     */
    public function getSize()
    {
        return $_FILES[$this->fileFieldName]['size'];
    }
}
