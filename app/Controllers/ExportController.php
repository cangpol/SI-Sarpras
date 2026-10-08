<?php
namespace App\Controllers;

use App\Models\RoomBookingModel;
use App\Models\VehicleBookingModel;
use App\Models\MaintenanceRequestModel;
use App\Models\SupplyRequestModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class ExportController extends BaseController
{
    public function exportExcel($type)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
        
        switch ($type) {
            case 'rooms':
                $sheet->setCellValue('A1', 'ID')->setCellValue('B1', 'Booking Code')->setCellValue('C1', 'Event Name')->setCellValue('D1', 'Start')->setCellValue('E1', 'End')->setCellValue('F1', 'Status');
                $model = new RoomBookingModel();
                if ($month && $year) $model->where('MONTH(start_time)', $month)->where('YEAR(start_time)', $year);
                $data = $model->findAll();
                $row = 2;
                foreach ($data as $item) {
                    $sheet->setCellValue('A'.$row, $item['id'])
                          ->setCellValue('B'.$row, $item['booking_code'])
                          ->setCellValue('C'.$row, $item['event_name'])
                          ->setCellValue('D'.$row, $item['start_time'])
                          ->setCellValue('E'.$row, $item['end_time'])
                          ->setCellValue('F'.$row, $item['status']);
                    $row++;
                }
                $filename = 'Export_Room_Bookings.xlsx';
                break;
            case 'vehicles':
                $sheet->setCellValue('A1', 'ID')->setCellValue('B1', 'Booking Code')->setCellValue('C1', 'Destination')->setCellValue('D1', 'Departure')->setCellValue('E1', 'Return')->setCellValue('F1', 'Status');
                $model = new VehicleBookingModel();
                if ($month && $year) $model->where('MONTH(departure_time)', $month)->where('YEAR(departure_time)', $year);
                $data = $model->findAll();
                $row = 2;
                foreach ($data as $item) {
                    $sheet->setCellValue('A'.$row, $item['id'])
                          ->setCellValue('B'.$row, $item['booking_code'])
                          ->setCellValue('C'.$row, $item['destination'])
                          ->setCellValue('D'.$row, $item['departure_time'])
                          ->setCellValue('E'.$row, $item['return_time'])
                          ->setCellValue('F'.$row, $item['status']);
                    $row++;
                }
                $filename = 'Export_Vehicle_Bookings.xlsx';
                break;
            case 'maintenance':
                $sheet->setCellValue('A1', 'ID')->setCellValue('B1', 'Asset Type')->setCellValue('C1', 'Asset ID')->setCellValue('D1', 'Issue')->setCellValue('E1', 'Status');
                $model = new MaintenanceRequestModel();
                if ($month && $year) $model->where('MONTH(created_at)', $month)->where('YEAR(created_at)', $year);
                $data = $model->findAll();
                $row = 2;
                foreach ($data as $item) {
                    $sheet->setCellValue('A'.$row, $item['id'])
                          ->setCellValue('B'.$row, $item['asset_type'])
                          ->setCellValue('C'.$row, $item['asset_id'])
                          ->setCellValue('D'.$row, $item['issue_description'])
                          ->setCellValue('E'.$row, $item['status']);
                    $row++;
                }
                $filename = 'Export_Maintenance.xlsx';
                break;
            case 'supplies':
                $sheet->setCellValue('A1', 'ID')->setCellValue('B1', 'Request Date')->setCellValue('C1', 'Status');
                $model = new SupplyRequestModel();
                if ($month && $year) $model->where('MONTH(request_date)', $month)->where('YEAR(request_date)', $year);
                $data = $model->findAll();
                $row = 2;
                foreach ($data as $item) {
                    $sheet->setCellValue('A'.$row, $item['id'])
                          ->setCellValue('B'.$row, $item['request_date'])
                          ->setCellValue('C'.$row, $item['status']);
                    $row++;
                }
                $filename = 'Export_Supplies.xlsx';
                break;
            default:
                return 'Type not found';
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function exportPdf($type)
    {
        $dompdf = new Dompdf();
        $html = '<h2>Laporan SIM Sarpras - ' . ucfirst($type) . '</h2><table border="1" cellpadding="5" cellspacing="0">';
        
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
        
        switch ($type) {
            case 'rooms':
                $html .= '<tr><th>ID</th><th>Event Name</th><th>Start</th><th>End</th><th>Status</th></tr>';
                $model = new RoomBookingModel();
                if ($month && $year) $model->where('MONTH(start_time)', $month)->where('YEAR(start_time)', $year);
                $data = $model->findAll();
                foreach ($data as $item) {
                    $html .= '<tr><td>'.$item['id'].'</td><td>'.$item['event_name'].'</td><td>'.$item['start_time'].'</td><td>'.$item['end_time'].'</td><td>'.$item['status'].'</td></tr>';
                }
                break;
            case 'vehicles':
                $html .= '<tr><th>ID</th><th>Destination</th><th>Departure</th><th>Return</th><th>Status</th></tr>';
                $model = new VehicleBookingModel();
                if ($month && $year) $model->where('MONTH(departure_time)', $month)->where('YEAR(departure_time)', $year);
                $data = $model->findAll();
                foreach ($data as $item) {
                    $html .= '<tr><td>'.$item['id'].'</td><td>'.$item['destination'].'</td><td>'.$item['departure_time'].'</td><td>'.$item['return_time'].'</td><td>'.$item['status'].'</td></tr>';
                }
                break;
            case 'maintenance':
                $html .= '<tr><th>ID</th><th>Asset Type</th><th>Asset ID</th><th>Issue</th><th>Status</th></tr>';
                $model = new MaintenanceRequestModel();
                if ($month && $year) $model->where('MONTH(created_at)', $month)->where('YEAR(created_at)', $year);
                $data = $model->findAll();
                foreach ($data as $item) {
                    $html .= '<tr><td>'.$item['id'].'</td><td>'.$item['asset_type'].'</td><td>'.$item['asset_id'].'</td><td>'.$item['issue_description'].'</td><td>'.$item['status'].'</td></tr>';
                }
                break;
            case 'supplies':
                $html .= '<tr><th>ID</th><th>Request Date</th><th>Status</th></tr>';
                $model = new SupplyRequestModel();
                if ($month && $year) $model->where('MONTH(request_date)', $month)->where('YEAR(request_date)', $year);
                $data = $model->findAll();
                foreach ($data as $item) {
                    $html .= '<tr><td>'.$item['id'].'</td><td>'.$item['request_date'].'</td><td>'.$item['status'].'</td></tr>';
                }
                break;
            default:
                return 'Type not found';
        }
        $html .= '</table>';
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Laporan_'.$type.'.pdf', ['Attachment' => true]);
    }
}
