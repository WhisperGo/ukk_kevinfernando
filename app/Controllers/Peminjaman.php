<?php

namespace App\Controllers;
use App\Models\M_peminjaman;
use App\Models\M_buku;
use App\Models\M_durasi_peminjaman;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Peminjaman extends BaseController
{

    public function index()
    {
        if (session()->get('level') == 1 || session()->get('level') == 2) {
            $model = new M_peminjaman();
            $model2 = new M_buku();

            $data['jojo'] = $model2->join4biasa();
            $data['title'] = 'Data Peminjaman';
            $data['desc'] = 'Anda dapat melihat Data Peminjaman di Menu ini.';

            echo view('hopeui/partial/header', $data);
            echo view('hopeui/partial/side_menu');
            echo view('hopeui/partial/top_menu');
            echo view('hopeui/peminjaman/view', $data);
            echo view('hopeui/partial/footer');
        } else {
            return redirect()->to('/');
        }
    }

    public function tidak_beri_izin($id)
    { 
       if (session()->get('level') == 1 || session()->get('level') == 2) {

            // Data yang akan disimpan
        $data1 = array(
            'StatusPeminjaman' => '4',
        );

        $where = array('PeminjamanID' => $id);
        $model = new M_peminjaman();

        $model->qedit('peminjaman', $data1, $where);

        return redirect()->to('peminjaman');
    } else {
        return redirect()->to('/');
    }
}

public function beri_izin($id)
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {

            // Data yang akan disimpan
        $data1 = array(
            'StatusPeminjaman' => '1',
        );

        $where = array('PeminjamanID' => $id);
        $model = new M_peminjaman();

        $model->qedit('peminjaman', $data1, $where);

        return redirect()->to('peminjaman');
    } else {
        return redirect()->to('/');
    }
}

public function edit_status($id)
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {

            // Data yang akan disimpan
        $data1 = array(
            'StatusPeminjaman' => '2',
        );

        $where = array('PeminjamanID' => $id);
        $model = new M_peminjaman();

        $model->qedit('peminjaman', $data1, $where);

        return redirect()->to('peminjaman');
    } else {
        return redirect()->to('/');
    }
}

    // --------------------------------------- PRINT LAPORAN --------------------------------------

public function menu_laporan()
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {
        $model=new M_peminjaman();

        $data['title'] = 'Laporan Peminjaman';
        $data['desc'] = 'Anda dapat mengprint Data Peminjaman di Menu ini.';      
        $data['subtitle'] = 'Print Laporan Peminjaman';             
        $data['subtitle2'] = 'Print Laporan Peminjaman Per Hari';             

        echo view('hopeui/partial/header', $data);
        echo view('hopeui/partial/side_menu');
        echo view('hopeui/partial/top_menu');
        echo view('hopeui/laporan_peminjaman/menu_laporan', $data);
        echo view('hopeui/partial/footer');
    }else {
        return redirect()->to('/');
    }
}

public function export_windows()
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {
        $model = new M_peminjaman();

        $awal = $this->request->getPost('awal');
        $akhir = $this->request->getPost('akhir');

        // Get data absensi kantor berdasarkan filter
        $data['peminjaman'] = $model->getAllPeminjamanInRange($awal, $akhir);

        $data['awal'] = $awal;
        $data['akhir'] = $akhir;

        $data['title'] = 'Laporan Peminjaman';
        echo view('hopeui/partial/header', $data);
        echo view('hopeui/laporan_peminjaman/print_windows_view', $data);
        echo view('hopeui/partial/footer_print');  
    } else {
        return redirect()->to('/');
    }
}

public function export_pdf()
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {
        $model = new M_peminjaman();

        $awal = $this->request->getPost('awal');
        $akhir = $this->request->getPost('akhir');

            // Get data absensi kantor berdasarkan filter
        $data['peminjaman'] = $model->getAllPeminjamanInRange($awal, $akhir);

        $data['awal'] = $awal;
        $data['akhir'] = $akhir;

            // Load the dompdf library
        $dompdf = new Dompdf();

            // Set the HTML content for the PDF
        $data['title'] = 'Laporan Peminjaman';
        $dompdf->loadHtml(view('hopeui/laporan_peminjaman/print_pdf_view',$data));
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();

            // Generate file name with start and end date
        $file_name = 'laporan_peminjaman_' . str_replace('-', '', $awal) . '_' . str_replace('-', '', $akhir) . '.pdf';

            // Output the generated PDF (inline or attachment)
        $dompdf->stream($file_name, ['Attachment' => 0]);

    } else {
        return redirect()->to('/');
    }
}

public function export_excel()
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {
        $model = new M_peminjaman();

        $awal = $this->request->getPost('awal');
        $akhir = $this->request->getPost('akhir');

        $peminjaman = $model->getAllPeminjamanInRange($awal, $akhir);

        $spreadsheet = new Spreadsheet();

            // Get the active worksheet and set the default row height for header row
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getDefaultRowDimension()->setRowHeight(20);

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Data Laporan Peminjaman');

        $periode = date('d F Y', strtotime($awal)) . ' - ' . date('d F Y', strtotime($akhir));
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'Periode: ' . $periode);

            // $sheet->setCellValue('G3', 'Jumlah Penjualan : ' . count($penjualan));

            // Set the header row values
        $sheet->setCellValueByColumnAndRow(1, 4, 'No.');
        $sheet->setCellValueByColumnAndRow(2, 4, 'Judul Buku');
        $sheet->setCellValueByColumnAndRow(3, 4, 'Jumlah Pinjam');
        $sheet->setCellValueByColumnAndRow(4, 4, 'Peminjam');
        $sheet->setCellValueByColumnAndRow(5, 4, 'Tgl. Peminjaman');
        $sheet->setCellValueByColumnAndRow(6, 4, 'Tgl. Pengembalian');
        $sheet->setCellValueByColumnAndRow(7, 4, 'Status Peminjaman');

            // Fill the data into the worksheet
        $row = 5;
        $no = 1;
        foreach ($peminjaman as $riz) {
            $sheet->setCellValueByColumnAndRow(1, $row, $no++);
            $sheet->setCellValueByColumnAndRow(2, $row, $riz->Judul);
            $sheet->setCellValueByColumnAndRow(3, $row, $riz->stok_buku_peminjaman . ' buah');

                // Mengisi sel dengan nilai yang diformat sebagai accounting
            $sheet->setCellValueByColumnAndRow(4, $row, $riz->Username);
            $sheet->setCellValueByColumnAndRow(5, $row, date('d M Y', strtotime($riz->TanggalPeminjaman)));
            $sheet->setCellValueByColumnAndRow(6, $row, date('d M Y', strtotime($riz->TanggalPengembalian)));

                // Mendefinisikan nilai StatusPeminjaman
            $statusPeminjaman = $riz->StatusPeminjaman;

                // Mendefinisikan nilai Status berdasarkan StatusPeminjaman
            $status = '';
            if ($statusPeminjaman == 1) {
                $status = 'Dipinjam';
            } elseif ($statusPeminjaman == 2) {
                $status = 'Dikembalikan';
            }

            $sheet->setCellValueByColumnAndRow(7, $row, $status);

            $row++;
        }

        // Apply the Excel styling
        $sheet->getStyle('A1')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);

        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A4:G4')->getFont()->setBold(true);
        $sheet->getStyle('A4:G4')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A4:G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $alignmentArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];


        $lastRow = count($peminjaman) + 4; // Add 4 for the header rows
        $sheet->getStyle('A4:G' . $lastRow)->applyFromArray($styleArray);
        $sheet->getStyle('A5:A' . $lastRow)->applyFromArray($alignmentArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        // Generate file name with start and end date
        $file_name = 'laporan_peminjaman_' . str_replace('-', '', $awal) . '-' . str_replace('-', '', $akhir) . '.xlsx';

        // Create the Excel writer and save the file
        $writer = new Xlsx($spreadsheet);
        $filename = $file_name;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    } else {
        return redirect()->to('/');
    }
}


// --------------------------------- PRINT LAPORAN PER HARI -----------------------------------


public function export_windows_per_hari()
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {
        $model = new M_peminjaman();

        $tanggal = $this->request->getPost('tanggal');

        // Get data penjualan berdasarkan tanggal
        $data['peminjaman'] = $model->getAllPeminjamanPerHari($tanggal);
        $data['tanggal'] = $tanggal;

        $data['title'] = 'Data Peminjaman';
        echo view('hopeui/partial/header', $data);
        echo view('hopeui/laporan_peminjaman/print_windows_view', $data);
        echo view('hopeui/partial/footer_print');
    } else {
        return redirect()->to('/');
    }
}

public function export_pdf_per_hari()
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {
        $model = new M_peminjaman();

        $tanggal = $this->request->getPost('tanggal');

        // Get data penjualan berdasarkan tanggal
        $data['peminjaman'] = $model->getAllPeminjamanPerHari($tanggal);
        $data['tanggal'] = $tanggal;

            // Load the dompdf library
        $dompdf = new Dompdf();

            // Set the HTML content for the PDF
        $data['title'] = 'Laporan Peminjaman';
        $dompdf->loadHtml(view('hopeui/laporan_peminjaman/print_pdf_view',$data));
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();

            // Generate file name with start and end date
        $file_name = 'laporan_peminjaman_' . str_replace('-', '', $awal) . '_' . str_replace('-', '', $akhir) . '.pdf';

            // Output the generated PDF (inline or attachment)
        $dompdf->stream($file_name, ['Attachment' => 0]);

    } else {
        return redirect()->to('/');
    }
}

public function export_excel_per_hari()
{
    if (session()->get('level') == 1 || session()->get('level') == 2) {
        $model = new M_peminjaman();

        $tanggal = $this->request->getPost('tanggal');

        $peminjaman = $model->getAllPeminjamanPerHari($tanggal);

        $spreadsheet = new Spreadsheet();

            // Get the active worksheet and set the default row height for header row
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getDefaultRowDimension()->setRowHeight(20);

        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Data Laporan Peminjaman');

        $periode = date('d F Y', strtotime($tanggal));
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'Periode: ' . $periode);

            // $sheet->setCellValue('G3', 'Jumlah Penjualan : ' . count($penjualan));

            // Set the header row values
        $sheet->setCellValueByColumnAndRow(1, 4, 'No.');
        $sheet->setCellValueByColumnAndRow(2, 4, 'Judul Buku');
        $sheet->setCellValueByColumnAndRow(3, 4, 'Jumlah Pinjam');
        $sheet->setCellValueByColumnAndRow(4, 4, 'Peminjam');
        $sheet->setCellValueByColumnAndRow(5, 4, 'Tgl. Peminjaman');
        $sheet->setCellValueByColumnAndRow(6, 4, 'Tgl. Pengembalian');
        $sheet->setCellValueByColumnAndRow(7, 4, 'Status Peminjaman');

            // Fill the data into the worksheet
        $row = 5;
        $no = 1;
        foreach ($peminjaman as $riz) {
            $sheet->setCellValueByColumnAndRow(1, $row, $no++);
            $sheet->setCellValueByColumnAndRow(2, $row, $riz->Judul);
            $sheet->setCellValueByColumnAndRow(3, $row, $riz->stok_buku_peminjaman . ' buah');

                // Mengisi sel dengan nilai yang diformat sebagai accounting
            $sheet->setCellValueByColumnAndRow(4, $row, $riz->Username);
            $sheet->setCellValueByColumnAndRow(5, $row, date('d M Y', strtotime($riz->TanggalPeminjaman)));
            $sheet->setCellValueByColumnAndRow(6, $row, date('d M Y', strtotime($riz->TanggalPengembalian)));

                // Mendefinisikan nilai StatusPeminjaman
            $statusPeminjaman = $riz->StatusPeminjaman;

                // Mendefinisikan nilai Status berdasarkan StatusPeminjaman
            $status = '';
            if ($statusPeminjaman == 1) {
                $status = 'Dipinjam';
            } elseif ($statusPeminjaman == 2) {
                $status = 'Dikembalikan';
            }

            $sheet->setCellValueByColumnAndRow(7, $row, $status);

            $row++;
        }

        // Apply the Excel styling
        $sheet->getStyle('A1')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);

        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A4:G4')->getFont()->setBold(true);
        $sheet->getStyle('A4:G4')->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A4:G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $alignmentArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];


        $lastRow = count($peminjaman) + 4; // Add 4 for the header rows
        $sheet->getStyle('A4:G' . $lastRow)->applyFromArray($styleArray);
        $sheet->getStyle('A5:A' . $lastRow)->applyFromArray($alignmentArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        // Generate file name with start and end date
        $file_name = 'laporan_peminjaman_' . $tanggal . '.xlsx';

        // Create the Excel writer and save the file
        $writer = new Xlsx($spreadsheet);
        $filename = $file_name;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    } else {
        return redirect()->to('/');
    }
}

}