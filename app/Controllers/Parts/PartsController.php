<?php

namespace App\Controllers\Parts;


use Exception;
use App\Controllers\BaseController;
use App\Models\PartsModel;
// use App\Libraries\Phpspreadsheet;


class PartsController extends BaseController
{
    
   protected $PartModel;
   protected $phpspreadsheet;

    public function __construct()
    {
        $this->PartModel = new PartsModel();
        // $this->phpspreadsheet = new Phpspreadsheet();
    }
    public function List()
    {
        $data['request'] = $this->request;
        return view('parts/list', $data);
    }

    public function Create()
    {
        $data['request'] = $this->request;
        return view('parts/add', $data);
    }
    public function Import()
    {
        $data['request'] = $this->request;
        return view('parts/import', $data);
    }

    public function Edit($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
       
        return view('parts/edit', $data);
    }

    public function Remove()
    {
        $data['request'] = $this->request;
        return view('parts/remove', $data);
    }
    public function bulk_import_parts()
    {
        $data['request'] = $this->request;
        return view('parts/bulk_import_parts', $data);
    }
    public function export_part(){
       // $spreadsheet = new Spreadsheet();
       
       $pdf_data = array();
       $file_name = "Part List";
       $pdf_data['title'] = $file_name;
       
       $col[] = 'Part No';
       $col[] = 'Part Name';
       $col[] = 'Model';
       $col[] = 'Die No';
       $col[] = 'Status'; 
       
       $headers = excel_columns($col);
       $pdf_data['headers'] = $headers;
       
       $part = new PartsModel();
       $part_data = $part->findAll();
       
       $data = array();
       $i = 1;
       if (count($part_data) > 0) {
           foreach ($part_data as $row) { 
               $data[$i][] = ((isset($row['part_no'])&&!empty($row['part_no'])) ? $row['part_no'] : " ");
               $data[$i][] = ((isset($row['part_name'])&&!empty($row['part_name'])) ? $row['part_name'] : " ");
             
               $data[$i][] = ((isset($row['model'])&&!empty($row['model'])) ? $row['model'] : " ");
               $data[$i][] = ((isset($row['die_no'])&&!empty($row['die_no'])) ? $row['die_no'] : " ");
               $data[$i][] = ($row['is_active']==1 )?'Active':'Deactivated';
               $i++;
           }
       } 
       
       $body = excel_columns($data, 2);
       
       $pdf_data['data'] = $body;
       $style_array =  array(
                   'fill' => array(
                       'color' => array('rgb' => 'FF0000' )
                   ),
                   'font'  => array(
                       'bold'  =>  true,
                       'color' => 	array('rgb' => 'FF0000')
                   )
               );
       
       $pdf_data['style_array'] = $style_array;
       $pdf_data['file_name'] = $file_name.'.xlsx';
       
      
       $this->phpspreadsheet->set_data($pdf_data);
       
        $data['request'] = $this->request;
        return view('parts/export_part', $data);
       
    }
    public function View($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
        $this->PartModel->where('id',$id);
        $data['single'] = $this->PartModel->first();
        return view('parts/view', $data);
    }
}
