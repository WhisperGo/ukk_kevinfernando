<?php

namespace App\Controllers;
use App\Models\M_user;

class Register extends BaseController
{
    public function index()
    {
        $model=new M_user();

        $data['title']='Registrasi Akun';
        $data['desc']='Anda akan diarahkan ke halaman login setelah register.'; 
        $data['subtitle'] = 'Form Registrasi Akun';

        $data['level']=$model->tampil('level');

        echo view('hopeui/partial_login/header', $data);
        echo view('hopeui/partial/top_menu_special', $data);
        echo view('hopeui/auth/register', $data);
        echo view('hopeui/partial_login/footer');
    }

    public function aksi_register()
    { 
        $a = $this->request->getPost('username');
        $b = $this->request->getPost('password');
        $c = $this->request->getPost('email');
        $d = $this->request->getPost('nama_lengkap');
        $e = $this->request->getPost('alamat');

        $foto_profil = $this->request->getFile('foto_profil');

        if ($foto_profil->isValid() && !$foto_profil->hasMoved()) {
            $ext = $foto_profil->getClientExtension();

            $imageName = 'profile_' . session()->get('id') . '_' . time() . '.' . $ext;

            $foto_profil->move('profile', $imageName);
        } else {
            $imageName = 'default.png';
        }

        // Validasi Register
        if ($a == $d) {
            session()->setFlashdata('error', 'Username dan Nama Lengkap tidak boleh sama.');
            return redirect()->to('register');
        }

        $model = new M_user();
        $user_exists = $model->where('Username', $a)->first();
        if ($user_exists) {
            session()->setFlashdata('error', 'Username sudah tidak tersedia.');
            return redirect()->to('register');
        }

        $email_exists = $model->where('Email', $c)->first();
        if ($email_exists) {
            session()->setFlashdata('error', 'Email ini sudah pernah terdaftar.');
            return redirect()->to('register');
        }

        // Tambahkan validasi CAPTCHA
        $captcha_response = $this->request->getPost('g-recaptcha-response');

        if (empty($captcha_response)) {
            session()->setFlashdata('error', 'Harap isi CAPTCHA');
            return redirect()->to('register');
        }

        // Verifikasi CAPTCHA menggunakan Google reCAPTCHA API
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => '6LcEfuojAAAAAHEty4frYz3AtlZ39sx7OsvHVT5K',
            'response' => $captcha_response,
        ];
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result_json = json_decode($result, true);

        if ($result_json['success'] !== true) {
            session()->setFlashdata('error', 'CAPTCHA tidak valid');
            return redirect()->to('register');
        }

        // Data yang akan disimpan
        $data1 = array(
            'Username' => $a,
            'Password' => md5($b),
            'Email' => $c,
            'NamaLengkap' => $d,
            'Alamat' => $e,
            'level' => 3,
            'foto' => $imageName
        );

        // Simpan data ke dalam database
        $model = new M_user();
        $isRegistered = $model->simpan('user', $data1);

        if ($isRegistered) {
            session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('error', 'Registrasi gagal. Silakan coba lagi.');
            return redirect()->to('register');
        }
    }
}