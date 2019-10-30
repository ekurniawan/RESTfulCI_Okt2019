<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Mahasiswa extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }

    public function index_get(){
        $nama = $this->get('nama');
        return $this->response($nama,200);
    } 

    public function tampil_get(){
        $arrNama = array(array("id"=>"12345","nama"=>"budi","alamat"=>"pekanbaru"),
        array("id"=>"12389","nama"=>"erick","alamat"=>"jogja"));
        return $this->response($arrNama,200);
    }

    public function index_post(){
        $nim = $this->post('nim');
        $nama = $this->post('nama');

        $data = array('nim'=>$nim,'nama'=>$nama);

        return $this->response($data,200);
    }

    public function index_put(){
        $nim = $this->put('nim');
        $nama = $this->put('nama');

        $data = "Data ".$nim." dan ".$nama." berhasil di edit ";
        return $this->response($data,200);
    }

    
}

?>