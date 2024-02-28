<?php

namespace App\Controllers;
use App\Models\M_buku;
use App\Models\M_user;
use App\Models\M_peminjaman;

class Dashboard extends BaseController
{
    public function index()
    {
        if(session()->get('id')>0) {
            $model = new M_buku();
            $jumlah_buku = $model->hitungsemua();

            $model2 = new M_user();
            $jumlah_user = $model2->hitungsemua();

            $model3 = new M_peminjaman();
            $jumlah_peminjaman = $model3->hitungSemuaHariIni();

            $data['title']='Dashboard';
            $data['desc']='Anda dapat melihat Dashboard di Menu ini.';

            $data['jumlah_buku'] = $jumlah_buku;
            $data['jumlah_user'] = $jumlah_user;
            $data['jumlah_peminjaman'] = $jumlah_peminjaman;

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu', $data); 
            echo view('hopeui/dashboard/view', $data);
            echo view('hopeui/partial/footer');

        }else{
            return redirect()->to('/');
        }
    }
}
