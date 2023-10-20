<?= $this->extend('theme-default') ?>

<?= $this->section('content') ?>
<?php

use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLS;
use App\Models\PartsModel;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$result = [];
$affected_row = 0;
$updated_row  = 0;

$arr_file_types = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/csv'];

function check_part_exists($array) {
    global $con;

    $part = new PartsModel();
    $row = $part->where('LOWER(part_no)', strtolower($array['part_no']))->first();
    $count = count($row);
    return $count;
}

if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    $result['message'] = "Wrong file format, only .csv, .xlsx, and .xls are allowed.";
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
        if (($open = fopen($file_path, "r")) !== FALSE) {
            while (($data = fgetcsv($open)) !== FALSE) 
            { 
                $csv_data[] = $data; 
            }
            fclose($open);
            
            // fclose($open);

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
            $part_name = isset($rows[$i]['part name']) ? trim($rows[$i]['part name']) : '';
            $part_no = isset($rows[$i]['part no']) ? trim($rows[$i]['part no']) : '';
            $model = isset($rows[$i]['model']) ? trim($rows[$i]['model']) : '';
            $pins = isset($rows[$i]['pins']) ? trim($rows[$i]['pins']) : '';
            $is_active = isset($rows[$i]['status']) && trim(strtolower($rows[$i]['status'])) == 'active' ? 1 : 0;

            $check_part_id = 0;
            $check_part_no = check_part_exists(['part_no' => $part_no]);

            $data = [
                'part_name' => $part_name,
                'part_no' => $part_no,
                'model' => $model,
                'pins' => $pins,
                'is_active' => $is_active
            ];

            if ($check_part_no > 0) {
                $check_part_no = 0;
            } else {
                $part = new PartsModel();
                $res['is_inserted'] = $part->insert($data);
                if ($res['is_inserted']) {
                    $affected_row += $part->affectedRows();
                }
            }
        }

        $msg  = $affected_row . " details imported from the uploaded document. ";
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
?>
