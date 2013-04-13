<?php

namespace Api;

class ApiHandler
{
    private $post;
    private $get;
    private $isPost;
    private $result;
    private $success = true;
    private $status = 200;

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
            $this->success =  false;
            $this->status = 404;
            $this->result = array('error'=>'Unknown Action');
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

            $perPage = max($perPage,50);

            $potholes = $potholeMapper->getAll($page,$perPage);

            $result = array();

            foreach($potholes as $pothole) {
                $result[] = $pothole->getPublic();
            }

            $this->result = $result;

        } else if(count($query)==2) {
            $pothole = new \Pothole\Pothole((int)$query[1]);
            if($pothole->get('pothole_id')!==false) { 
                $this->result = $pothole->getPublic();
            } else {
                $this->result = array();
            }
        } else {
            $this->result = array();
        }

        $this->renderJson();

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
            
            
        }
        $this->renderJson();
    }

    private function renderJson()
    {
        $this->sendHeaders();
        echo json_encode(array('success'=>$this->success,'result'=>$this->result));
    }

    private function sendHeaders() {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $this->sendHTTPStatus();
    }


    private function sendHTTPStatus() 
    {
        $http = array(
            100 => 'HTTP/1.1 100 Continue',
            101 => 'HTTP/1.1 101 Switching Protocols',
            200 => 'HTTP/1.1 200 OK',
            201 => 'HTTP/1.1 201 Created',
            202 => 'HTTP/1.1 202 Accepted',
            203 => 'HTTP/1.1 203 Non-Authoritative Information',
            204 => 'HTTP/1.1 204 No Content',
            205 => 'HTTP/1.1 205 Reset Content',
            206 => 'HTTP/1.1 206 Partial Content',
            300 => 'HTTP/1.1 300 Multiple Choices',
            301 => 'HTTP/1.1 301 Moved Permanently',
            302 => 'HTTP/1.1 302 Found',
            303 => 'HTTP/1.1 303 See Other',
            304 => 'HTTP/1.1 304 Not Modified',
            305 => 'HTTP/1.1 305 Use Proxy',
            307 => 'HTTP/1.1 307 Temporary Redirect',
            400 => 'HTTP/1.1 400 Bad Request',
            401 => 'HTTP/1.1 401 Unauthorized',
            402 => 'HTTP/1.1 402 Payment Required',
            403 => 'HTTP/1.1 403 Forbidden',
            404 => 'HTTP/1.1 404 Not Found',
            405 => 'HTTP/1.1 405 Method Not Allowed',
            406 => 'HTTP/1.1 406 Not Acceptable',
            407 => 'HTTP/1.1 407 Proxy Authentication Required',
            408 => 'HTTP/1.1 408 Request Time-out',
            409 => 'HTTP/1.1 409 Conflict',
            410 => 'HTTP/1.1 410 Gone',
            411 => 'HTTP/1.1 411 Length Required',
            412 => 'HTTP/1.1 412 Precondition Failed',
            413 => 'HTTP/1.1 413 Request Entity Too Large',
            414 => 'HTTP/1.1 414 Request-URI Too Large',
            415 => 'HTTP/1.1 415 Unsupported Media Type',
            416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
            417 => 'HTTP/1.1 417 Expectation Failed',
            500 => 'HTTP/1.1 500 Internal Server Error',
            501 => 'HTTP/1.1 501 Not Implemented',
            502 => 'HTTP/1.1 502 Bad Gateway',
            503 => 'HTTP/1.1 503 Service Unavailable',
            504 => 'HTTP/1.1 504 Gateway Time-out',
            505 => 'HTTP/1.1 505 HTTP Version Not Supported',
        );
     
        header($http[$this->status]);
    }


}
