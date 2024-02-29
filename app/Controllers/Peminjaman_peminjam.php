<?php

namespace App\Controllers;
use App\Models\M_peminjaman;
use App\Models\M_buku;
use App\Models\M_durasi_peminjaman;

class Peminjaman_peminjam extends BaseController
{

    public function index()
    {
        if (session()->get('level') == 3) {
            $model = new M_peminjaman();
            $model2 = new M_buku();

            $idUser = session()->get('id');

            $data['jojo'] = $model2->join4user($idUser);

            $data['title'] = 'Data Peminjaman';
            $data['desc'] = 'Anda dapat melihat Data Peminjaman di Menu ini.';

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/peminjaman_peminjam/view', $data);
            echo view('hopeui/partial/footer');
        } else {
            return redirect()->to('/');
        }
    }

    public function create($id)
    {
        if (session()->get('level') == 1 || session()->get('level') == 2 || session()->get('level') == 3) {
            $model=new M_peminjaman();

            $data['title'] = 'Data Peminjaman';
            $data['desc'] = 'Anda dapat menambah Data Peminjaman di Menu ini.';  
            $data['subtitle'] = 'Tambah Peminjaman';

            $data['user'] = $model->tampil('user');
            $data['buku'] = $model->tampilid('buku', $id);
            $data['jojo2'] = $id;

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/peminjaman_peminjam/create', $data);
            echo view('hopeui/partial/footer');
        }else {
            return redirect()->to('/');
        }
    }

    public function aksi_create()
    {
        if (session()->get('level') == 3) {
            $jumlah_peminjaman = $this->request->getPost('jumlah_peminjaman');
            $tanggal_pengembalian = $this->request->getPost('tgl_pengembalian');
            $id = $this->request->getPost('id');

        // Ambil lama durasi peminjaman dari tabel durasi_peminjaman
            $modelDurasiPeminjaman = new M_durasi_peminjaman();
            $durasi = $modelDurasiPeminjaman->getNotDeleted();

        // Ambil lama durasi dari array
            $lama_durasi = $durasi['lama_durasi'];

        // Hitung tanggal pengembalian berdasarkan lama durasi peminjaman
            $tanggal_pengembalian_diizinkan = date('Y-m-d', strtotime("+$lama_durasi days"));

        // Jika tanggal pengembalian yang dimasukkan lebih besar dari tanggal pengembalian yang diizinkan
            if ($tanggal_pengembalian > $tanggal_pengembalian_diizinkan) {
            // Set flash data
                session()->setFlashdata('error', 'Tanggal pengembalian melebihi durasi peminjaman yang diizinkan. Durasi paling lama: ' . $tanggal_pengembalian_diizinkan);

            // Redirect kembali ke halaman peminjaman dengan pesan error
                return redirect()->to('peminjaman_peminjam/create/' . $id);
            }

        // Data yang akan disimpan
            $data = [
                'UserID' => session()->get('id'),
                'BukuID' => $id,
                'stok_buku' => $jumlah_peminjaman,
                'TanggalPeminjaman' => date('Y-m-d'),
                'TanggalPengembalian' => $tanggal_pengembalian,
                'StatusPeminjaman' => 0,
            ];

        // Simpan data ke dalam database
            $modelPeminjaman = new M_peminjaman();
            $modelPeminjaman->simpan('peminjaman', $data);

            return redirect()->to('peminjaman_peminjam');
        } else {
            return redirect()->to('/');
        }
    }


    public function aksi_edit($id)
    {
        if (session()->get('level') == 1 || session()->get('level') == 2) {

            // Data yang akan disimpan
            $data1 = array(
                'status_peminjaman' => '2',
            );

            $where = array('id_peminjaman' => $id);
            $model = new M_peminjaman();

            $stok_keluar = $model->getBukuByIdPeminjaman($id);
            $id_buku = $stok_keluar->buku;

            $model->qedit('peminjaman', $data1, $where);

            return redirect()->to('peminjaman/menu_peminjaman/' . $id_buku);
        } else {
            return redirect()->to('/');
        }
    }

    public function delete($id)
    { 
       if(session()->get('level')== 3) {
        $model=new M_peminjaman();
        $where = array('PeminjamanID' => $id);
        $model->hapus('peminjaman', $where);
        return redirect()->to('peminjaman_peminjam');
    }else {
        return redirect()->to('/');
    }

}
}