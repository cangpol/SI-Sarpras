<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VisitorModel;
use App\Models\LostFoundModel;

class SecurityController extends BaseController
{
    // VISITOR LOGGING
    public function visitors()
    {
        $model = new VisitorModel();
        // S3.1 Default Query Current Month Filtering
        $month = $this->request->getGet('month') ?? date('m');
        $year = $this->request->getGet('year') ?? date('Y');
        
        $model->where('MONTH(check_in_time)', $month)
              ->where('YEAR(check_in_time)', $year);
              
        $data['visitors'] = $model->findAll();
        $data['month'] = $month;
        $data['year'] = $year;
        return view('admin/security/visitors', $data);
    }

    public function visitorCheckIn()
    {
        $model = new VisitorModel();
        $model->insert([
            'visitor_name' => $this->request->getPost('visitor_name'),
            'id_card_type' => $this->request->getPost('id_card_type'),
            'id_card_number' => $this->request->getPost('id_card_number'),
            'purpose' => $this->request->getPost('purpose'),
            'host_name' => $this->request->getPost('host_name'),
            'check_in_time' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to('/admin/security/visitors')->with('message', 'Visitor checked in');
    }

    public function visitorCheckOut($id)
    {
        $model = new VisitorModel();
        $model->update($id, [
            'check_out_time' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to('/admin/security/visitors')->with('message', 'Visitor checked out');
    }

    // LOST AND FOUND
    public function lostFound()
    {
        $model = new LostFoundModel();
        $data['items'] = $model->findAll();
        return view('admin/security/lost_found', $data);
    }

    public function verifyClaim($id)
    {
        $model = new LostFoundModel();
        $model->update($id, [
            'status' => 'Claimed',
            'claimer_name' => $this->request->getPost('claimer_name'),
            'claim_date' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to('/admin/security/lost-found')->with('message', 'Claim verified');
    }
}

