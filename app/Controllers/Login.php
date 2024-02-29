<?php

namespace App\Controllers;
use App\Models\M_login;
use App\Models\M_level;

class Login extends BaseController
{

 protected function isLoggedIn()
 {
    return session()->has('id');
}

public function index()
{
    if ($this->isLoggedIn()) {
        return redirect()->to('dashboard');
    }

    $data['title']='Login';
    echo view ('hopeui/partial_login/header', $data);
    echo view('hopeui/auth/login');
    echo view('hopeui/partial_login/footer');
}

public function aksi_login()
{
    $u=$this->request->getPost('username');
    $p=$this->request->getPost('password');

    $model= new M_login();
    $data=array(
        'username'=>$u,
        'password'=>$p

    );
    $cek=$model->getLoginWithPassword('user', $u, $p);
    if ($cek !== null) {
        session()->set('id', $cek['UserID']);
        session()->set('username', $cek['Username']);
        session()->set('email', $cek['Email']);
        session()->set('namalengkap', $cek['NamaLengkap']);
        session()->set('alamat', $cek['Alamat']);
        session()->set('level', $cek['level']);

        $data1 = array(
            'UserID' => session()->get('id'),
            'nama_log' => 'Melakukan Login di website',
        );

            // Simpan data ke dalam database
        $model = new M_level();
        $model->simpan('log_activity', $data1);

        return redirect()->to('dashboard');
    }else {
            // Tambahkan peringatan username atau password salah
        session()->setFlashdata('error', ' Username atau password Anda salah');
        return redirect()->to('/');
    }

}

public function log_out()
{
    $data1 = array(
        'UserID' => session()->get('id'),
        'nama_log' => 'Melakukan Log Out dari website',
    );

    // Simpan data ke dalam database
    $model = new M_level();
    $model->simpan('log_activity', $data1);

    session()->destroy();
    return redirect()->to('/');
}
}