<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Mahasiswa extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    //http://localhost/samplerestapi/index.php/api/mahasiswa
    //http://localhost/samplerestapi/index.php/api/mahasiswa?nim=72006666
    /*public function index_get(){
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
    }*/

    public function index_get()
    {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            $token = Authorization::validateToken($headers["Authorization"]);
            if ($token != false) {
                $data = $this->db->get('mahasiswa')->result();
                return $this->response($data, 200);
            } else {
                $response = ['status' => 403, 'message' => "Forbidden"];
                return $this->set_response($response, 403);
            }
        } else {
            $response = ['status' => 401, 'message' => "unauthorized"];
            return $this->set_response($response, 401);
        }
    }

    public function getbyid_get($nim)
    {
        $this->db->where('nim', $nim);
        $data = $this->db->get('mahasiswa')->result();
        if (count($data) == 0) {
            return $this->response("Data $nim tidak ditemukan ", 400);
        } else {
            return $this->response($data[0], 200);
        }
    }

    //https://codeigniter.com/userguide2/database/active_record.html#select
    public function getbynama_get($nama)
    {
        $this->db->like('nama', $nama);
        $data = $this->db->get('mahasiswa')->result();
        return $this->response($data, 200);
    }

    //http://localhost/samplerestapi/index.php/api/mahasiswa/getbyid/72006666
    /*public function getbyid_get($nim){
        $sql = "select * from mahasiswa where nim=?";
        $data = $this->db->query($sql,array($nim))->result();
        if(count($data)==0){
            return $this->response("Data $nim tidak ditemukan ",400); 
        }
        else {
            return $this->response($data[0],200); 
        }
    }*/

    public function tampil_get()
    {
        $arrNama = array(
            array("id" => "12345", "nama" => "budi", "alamat" => "pekanbaru"),
            array("id" => "12389", "nama" => "erick", "alamat" => "jogja")
        );
        return $this->response($arrNama, 200);
    }

    /*public function index_post()
    {
        $nim = $this->post('nim');
        $nama = $this->post('nama');
        $email = $this->post('email');
        $ipk = $this->post('ipk');

        $sql = "insert into mahasiswa(nim,nama,email,ipk) values(?,?,?,?)";
        $result = $this->db->query($sql,array($nim,$nama,$email,$ipk));
        if($result!=1){
            return $this->response("Gagal menambah data",400);
        }
        else {
            return $this->response("Data berhasil ditambah",200);
        }
    }*/

    public function index_post()
    {
        $headers = $this->input->request_headers();
        if (Authorization::tokenIsExist($headers)) {
            $token = Authorization::validateToken($headers["Authorization"]);
            if ($token != false) {
                $nim = $this->post('nim');
                $nama = $this->post('nama');
                $email = $this->post('email');
                $ipk = $this->post('ipk');

                $data = array("nim" => $nim, "nama" => $nama, "email" => $email, "ipk" => $ipk);
                $result = $this->db->insert('mahasiswa', $data);
                if ($result != 1) {
                    return $this->response("Gagal menambah data", 400);
                } else {
                    return $this->response(array("status" => "201", "data" => $data), 201);
                }
            } else {
                $response = ['status' => 403, 'message' => "Forbidden"];
                return $this->set_response($response, 403);
            }
        } else {
            $response = ['status' => 401, 'message' => "unauthorized"];
            return $this->set_response($response, 401);
        }
    }

    /*public function index_put(){
        $nim = $this->put('nim');
        $nama = $this->put('nama');
        $email= $this->put('email');
        $ipk = $this->put('ipk');
        
        $this->db->where('nim', $nim);
        $data = $this->db->get('mahasiswa')->result();
        if(count($data)!=0){
            $sql = "update mahasiswa set nama=?, email=?, ipk=? where nim=?";
            $result = $this->db->query($sql,array($nama,$email,$ipk,$nim));
            if($result==1){
                return $this->response("Data berhasil diupdate",200);
            }
            else {
                $err = "Gagal update data";
            }
        }else {
            $err = "Data nim tidak ditemukan";
        }
        return $this->response($err,400);
    }*/

    public function index_put()
    {
        $nim = $this->put('nim');
        $nama = $this->put('nama');
        $email = $this->put('email');
        $ipk = $this->put('ipk');

        $this->db->where('nim', $nim);
        $data = $this->db->get('mahasiswa')->result();
        if (count($data) != 0) {
            $update = array("nama" => $nama, "email" => $email, 'ipk' => $ipk);
            $this->db->where('nim', $nim);
            $result = $this->db->update('mahasiswa', $update);
            if ($result == 1) {
                return $this->response("Data berhasil diupdate", 200);
            } else {
                $err = "Gagal update data";
            }
        } else {
            $err = "Data nim tidak ditemukan";
        }
        return $this->response($err, 400);
    }



    /*public function index_put()
    {
        $nim = $this->put('nim');
        $nama = $this->put('nama');

        $data = "Data " . $nim . " dan " . $nama . " berhasil di edit ";
        return $this->response($data, 200);
    }*/

    /*public function index_delete($nim)
    {
        $data = "Data nim " . $nim . " berhasil didelete";
        return $this->response($data, 200);
    }*/


    public function index_delete($nim)
    {
        $this->db->where('nim', $nim);
        $data = $this->db->get('mahasiswa')->result();
        if (count($data) != 0) {
            $cek = true;
        } else {
            $cek = false;
        }

        if ($cek) {
            //$sql = "delete from mahasiswa where nim=?";
            //$result = $this->db->query($sql, array($nim));
            $this->db->where('nim', $nim);
            $result = $this->db->delete('mahasiswa');

            if ($result != 1) {
                return $this->response("Gagal delete data", 400);
            } else {
                return $this->response("Berhasil Delete data $nim", 200);
            }
        } else {
            return $this->response("Nim tidak ditemukan ", 400);
        }
    }
}
