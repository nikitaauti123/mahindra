<?php
/**  
 * PartsController file Doc Comment
 * 
 * PHP version 7
 *
 * @category PartsController_Class
 * @package  PartsController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Parts;


use Exception;
use App\Libraries\Phpspreadsheet;
use App\Controllers\BaseController;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLS;
use App\Models\PartsModel;

/**  
 * PartsController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category PartsController_Class
 * @package  PartsController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class PartsController extends BaseController
{

    protected $PartModel;
    protected $phpspreadsheet;
    /**
     * Constructor for the partController class.
     */
    public function __construct()
    {
        $this->PartModel = new PartsModel();
        $this->phpspreadsheet = new Phpspreadsheet();
    }
    /**
     * Method for handling list page.
     * 
     * @return view; 
     */
    public function list()
    {
        $data['request'] = $this->request;
        return view('parts/list', $data);
    }
    /**
     * Method for handling add page.
     * 
     * @return view; 
     */
    public function create()
    {
        $data['request'] = $this->request;
        return view('parts/add', $data);
    }
     /**
      * Method for handling import page.
      * 
      * @return view; 
      */
    public function import()
    {
        $data['request'] = $this->request;
        return view('parts/import', $data);
    }
    /**
     * Method for handling edit page.
     * 
     * @param $id for  the edit operation.
     * 
     * @return view; 
     */
    public function edit($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;

        return view('parts/edit', $data);
    }
    /**
     * Method for handling remove page.
     * 
     * @return view; 
     */
    public function remove()
    {
        $data['request'] = $this->request;
        return view('parts/remove', $data);
    }
    /**
     * Method for handling import page.
     * 
     * @return view; 
     */
    public function bulkImportParts()
    {
        $result = [];
        $affected_row = 0;
        $updated_row  = 0;

        $arr_file_types = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
            'text/csv',
        ];
        if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
            $result['message'] = "Wrong file format, only " .
                                ".csv, .xlsx, and .xls are allowed.";
            $result['error'] = true;
            echo json_encode($result);
            exit;
        }
        if (!file_exists('/uploads')) {
            mkdir('/uploads', 0777, true);
        }
        $filename = time() . '_' . $_FILES['file']['name'];
        $destinationDirectory = FCPATH . 'uploads/';
        $destinationPath = $destinationDirectory . $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], $destinationPath);
        $file_path = $destinationPath;
        try {
            $header_values = $rows = [];
            if ($_FILES['file']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                if ($xlsx = SimpleXLSX::parse($file_path)) {
                    foreach ($xlsx->rows() as $k => $r) {
                        if ($k === 0) {
                            foreach ($r as $rk => $rv) {
                                $header_values[$rk] = strtolower($rv);
                            }
                            continue;
                        }
                        $rows[] = array_combine($header_values, $r);
                    }
                } else {
                    throw new Exception(".xlsx file is not readable");
                }
            } elseif ($_FILES['file']['type'] == 'application/vnd.ms-excel') {
                if ($xls = SimpleXLS::parse($file_path)) {
                    foreach ($xls->rows() as $k => $r) {
                        if ($k === 0) {
                            foreach ($r as $rk => $rv) {
                                $header_values[$rk] = strtolower($rv);
                            }
                            continue;
                        }
                        $rows[] = array_combine($header_values, $r);
                    }
                } else {
                    throw new Exception(SimpleXLS::parseError());
                }
            } elseif ($_FILES['file']['type'] == 'text/csv') {
                if (($open = fopen($file_path, "r")) !== false) {
                    while (($data = fgetcsv($open)) !== false) {
                        $csv_data[] = $data;
                    }
                    fclose($open);
                    foreach ($csv_data as $k => $r) {
                        if ($k === 0) {
                            foreach ($r as $rk => $rv) {
                                $header_values[$rk] = strtolower($rv);
                            }
                            continue;
                        }
                        $rows[] = array_combine($header_values, $r);
                    }
                } else {
                    throw new Exception(".csv file is not readable");
                }
            }

            if (!empty($rows)) {
                for ($i = 0; $i < count($rows); $i++) {
                    $part_name = isset($rows[$i]['part name']) 
                    ? trim($rows[$i]['part name']) 
                    : '';
                
                    $part_no = isset($rows[$i]['part no']) 
                        ? trim($rows[$i]['part no']) 
                        : '';
                    
                    $model = isset($rows[$i]['model']) 
                        ? trim($rows[$i]['model']) 
                        : '';
                    
                    $pins = isset($rows[$i]['pins']) 
                        ? trim($rows[$i]['pins']) 
                        : '';
                    $die_no = isset($rows[$i]['die_no']);
                        $die_no = $die_no
                            ? trim($rows[$i]['die_no'])
                            : '';
                        
                    $is_active = isset($rows[$i]['status']) && 
                    trim(strtolower($rows[$i]['status'])) == 'active';

                    $is_active = $is_active ? 1 : 0;

                    $check_part_id = 0;
                    $check_part_no = $this->checkPartExists(['part_no' => $part_no]);

                    $data = [
                        'part_name' => $part_name,
                        'part_no' => $part_no,
                        'model' => $model,
                        'pins' => $pins,
                        'die_no' => $die_no,
                        'is_active' => $is_active
                    ];


                    if ($check_part_no > 0) {
                        $check_part_no = 0;
                    } else {
                        $part = new PartsModel();
                        $res['is_inserted'] = $this->PartModel->insert($data);
                        if ($res['is_inserted']) {
                            $affected_row += $part->affectedRows();
                        }
                    }
                }

                $msg  = $affected_row . 
                " details imported from the uploaded document. ";
                if ($updated_row > 0) {
                    $msg  .=  $updated_row . " parts details update.";
                }

                $result['message'] = $msg;
                $result['success'] = true;
                echo json_encode($result);
                exit;
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
            $result['error'] = true;
            echo json_encode($result);
            exit;
        }

    }
    /**
     * Method for checking exist part.
     *
     * @param array $array Description of the $array parameter.
     *
     * @return mixed
     */
    function checkPartExists($array)
    {
        global $con;

        $row = $this->PartModel
            ->where('LOWER(part_no)', strtolower($array['part_no']))
            ->first();
        if ($row !== null && is_array($row) && count($row) > 0) {
                    $count = count($row);
                    return $count;
        }
    }
    /**
     * Method for handling part exist or not page.
     * 
     * @params $array  is array to check part exist or not
     * 
     * @return view; 
     */
    public function exportPart()
    {
        $pdf_data = array();
        $date = date('Y-m-d H:i:s');
        $file_name = "Part-List-$date";
        $file_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $file_name);
        $pdf_data['title'] = $file_name;
        $col[] = 'Part No';
        $col[] = 'Part Name';
        $col[] = 'Model';
        $col[] = 'Pins';
        $col[] = 'Die No';
        $col[] = 'Status';
        $headers = excel_columns($col);
        $pdf_data['headers'] = $headers;

        $part = new PartsModel();
        $part_data = $part->findAll();

        $data = array();
        $i = 0;
        if (count($part_data) > 0) {
            foreach ($part_data as $row) {
                $data[$i][] = (
                    (isset($row['part_no']) && !empty($row['part_no'])) 
                    ? $row['part_no'] 
                    : " "
                );
                $data[$i][] = (
                    (isset($row['part_name']) && !empty($row['part_name'])) 
                    ? $row['part_name']
                     : " "
                );

                $data[$i][] = (
                    (isset($row['model']) && !empty($row['model'])) 
                    ? $row['model']
                     : " "
                );
                $data[$i][] = (
                    (isset($row['pins']) && !empty($row['pins'])) 
                    ? $row['pins'] 
                    : " "
                );
                
                if (isset($row['die_no']) && !empty($row['die_no'])) {
                    $data[$i][] = $row['die_no'];
                } else {
                    $data[$i][] = " ";
                }
                  $data[$i][] = ($row['is_active'] == 1) ? 'Active' : 'Deactivated';
                $i++;
            }
        }
        $body = excel_columns($data, 2);

        $pdf_data['data'] = $body;
        $style_array =  array(
            'fill' => array(
                'color' => array('rgb' => 'FF0000')
            ),
            'font'  => array(
                'bold'  =>  true,
                'color' =>     array('rgb' => 'FF0000')
            )
        );
        $pdf_data['style_array'] = $style_array;
        $pdf_data['file_name'] = $file_name . '.xlsx';
        $this->phpspreadsheet->set_data($pdf_data);
    }
    /**
     * Method for handling view page.
     *  
     * @param $id is id of part to view details
     * 
     * @return view; 
     */
    public function view($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
        $this->PartModel->where('id', $id);
        $data['single'] = $this->PartModel->first();
        return view('parts/view', $data);
    }
}
