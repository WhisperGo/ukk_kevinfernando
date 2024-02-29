<?php

namespace App\Controllers;
use App\Models\M_log_activity;

class Log_activity extends BaseController
{
    public function index()
    {
     if(session()->get('level')== 1) {
        $model=new M_log_activity();

        $on = 'log_activity.UserID = user.UserID';
        $data['jojo']=$model->joinUser('log_activity', 'user', $on);

        $data['title']='Log Activity';
        $data['desc']='Anda dapat melihat Log Activity di Menu ini.';

        echo view('hopeui/partial/header', $data);
        echo view('hopeui/partial/side_menu');
        echo view('hopeui/partial/top_menu', $data);
        echo view('hopeui/log_activity/view', $data);
        echo view('hopeui/partial/footer');
    }else {
        return redirect()->to('/');
    }
}

}