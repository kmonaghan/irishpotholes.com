<?php

namespace Api;

class ApiHandler
{
    private $post;
    private $get;
    private $isPost;
    private $result;

    public function __construct() 
    {
        $this->post = $_POST;
        $this->get = $_GET;

        if(count($this->post)) {
            $this->isPost = true;
        }
    }


    public function handleRequest() 
    {
        if($this->isPost) {
            $this->handlePostRequest();
        } else {
            $this->handleGetRequest();
        }

    }

    public function handleGetRequest() 
    {
        $query = $this->getQueryAsArray();

        switch($query[0]) {
        case 'pothole':
            $this->handlePotholeGet($query);
            break;
        default:
            $this->result = array('success'=>false,'error'=>'Unknown Action');
            $this->renderJson();
        }
    }

    private function handlePotholeGet($query) 
    {
        if(count($query)==1) {
            //It's a get all
            $potholeMapper = new \Pothole\PotholeMapper();
            $page = isset($this->get['page']) ? $this->get['page'] : 0;
            $perPage = isset($this->get['perPage']) ? $this->get['perPage'] : 20;
            $potholes = $potholeMapper->getAll($page,$perPage);

            $result = '{"success":true,"result":[';

            foreach($potholes as $pothole) {
                $result .= $pothole->toJSON();
                $result .= ',';
            }

            $result = trim($result,',');

            $result .= ']}';

            $this->result = $result;
            $this->renderJson(false);

        } else if(count($query)==2) {
            $pothole = new \Pothole\Pothole($query[1]);
            $this->result = '{"success":true,"result":['.$pothole->toJSON().']}';
            $this->renderJson(false);
        }

    }

    private function getQueryAsArray() 
    {
        return explode("/",trim($this->get['q'],'/'));
    }

    private function handlePostRequest()
    {
        //Right now we don't need to worry about POSTing to ids
        //because we're not updating them
        //So we can just worry about the first element
        //if we explode $_GET['q'] on /

        $queryExplode = explode("/",$this->get['q']);
        $noun = $queryExplode[0];
        switch ($noun) {
        case 'pothole':
            $this->handlePotholePost();
            break;
        default:
            $this->result = array('success'=>false,'error'=>'Unknown Action');
            $this->renderJson();
        }
    }

    private function handlePotholePost() {
        $fileUploader = new \Fine\FileUploader(array('jpg','png','jpeg'),10*1024*1024);
        try {
            $response = $fileUploader->handleUpload(UPLOAD_DIR);
            
            $filename = $fileUploader->getUploadName();

            $this->post['images'] = array($filename);
        } catch (\Pothole\Exception $e) {
            $this->result = array('success'=>false,'error'=>$e->getMessage());
            $this->renderJson();
        }

        $pothole = new \Pothole\Pothole();

        try {
            $potholeId = $pothole->create($this->post);
            $this->result = array('success'=>true,'pothole_id'=>$potholeId);
        } catch (\Pothole\Exception $e) {
            $this->result = array('success'=>false,'error'=>$e->getMessage());

            //Delete the uploaded image from table.
            $imageMapper = new \Pothole\ImageMapper();
            $image = $imageMapper->getByName($filename);
            $image->delete();
            
            //Delete from file system
            $mask = UPLOAD_DIR.DIRECTORY_SEPARATOR."*".$filename;
            array_map( "unlink", glob( $mask ) );
        }
        $this->renderJson();
    }

    private function renderJson($encode=true)
    {
        if(!$this->result['success']) {
            header('HTTP/1.0 500 Internal Server Error');
        } 

        if($encode) {
            echo json_encode($this->result);
        } else {
            echo $this->result;
        }
    }

}
