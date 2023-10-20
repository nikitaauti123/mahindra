<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
<?php  
require_once(__DIR__ . '/vendor/phpspreadsheet/phpspreadsheet.php');


use App\Models\PartsModel;
function findObjectLpn($array, $lpn) {        
    foreach ( $array as $element ) {
        if ( strtolower($lpn) == strtolower($element->lpn) ) {
            return $element;
        }
    }
    return false;
}

$pdf_data = array();
$file_name = "Part List";
$pdf_data['title'] = $file_name;


$col[] = 'Part No';
$col[] = 'Part Name';
$col[] = 'Model';
$col[] = 'Pins';

$col[] = 'Status'; 

$headers = excel_columns($col);
  

$pdf_data['headers'] = $headers;

$is_active = $_REQUEST['is_active'];
$where = '';

$part = new PartsModel();

$part_data = $part->findAll();

$data = array();

if (count($part_data) > 0) {
    foreach ($part_data as $row) {         
        $data[$i][] = ((isset($row['part_no'])&&!empty($row['part_no'])) ? $row['emp_id'] : " ");
        $data[$i][] = ((isset($row['part_name'])&&!empty($row['part_name'])) ? $row['email_address'] : " ");
      
        $data[$i][] = $row['model'];
        $data[$i][] = $row['pins'];
        
        $data[$i][] = ($row['v_active']==1 )?'Active':'Deactivated';
         
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

$obj = new phpspreadsheet();
$obj->set_data($pdf_data);
 ?>