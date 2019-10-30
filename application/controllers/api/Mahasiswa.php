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
        $nim = $this->get('nim');
        if($nim==''){
            $sql = "select * from mahasiswa order by nama";
            $data = $this->db->query($sql)->result();
        }else {
            $sql = "select * from mahasiswa where nim=?";
            $data = $this->db->query($sql,array($nim))->result();
            $data = $data[0];
        }
      
        return $this->response($data,200);
    } 

    public function getbyid_get($nim){
        $sql = "select * from mahasiswa where nim=?";
        $data = $this->db->query($sql,array($nim))->result();
        if(count($data)==0){
            return $this->response("Data $nim tidak ditemukan ",400); 
        }
        else {
            return $this->response($data[0],200); 
        }
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

    public function index_delete($nim){
        $data = "Data nim ".$nim." berhasil didelete";
        return $this->response($data,200);
    }
}

?>