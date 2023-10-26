<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Phpspreadsheet
{

  // Methods
  function set_data($pdf_data)
  {

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle($pdf_data['title']);
    /* $first_key = $last_key = '';
    $i = 0;
    foreach ($pdf_data['headers'] as $key => $value) {
      if ($i == 0) {
        $first_key = $key;
      }
      $sheet->setCellValue($key, $value);
      $last_key = $key;
      $i++;
    }
    $sheet->getStyle("$first_key:$last_key")->getFont()->setBold(true); */
    $this->set_header($sheet, $pdf_data['headers']);

    foreach ($pdf_data['data'] as $key => $value) {
      $sheet->setCellValue($key, $value);
    }
    if (isset($pdf_data['style_array'])) {
      //$sheet->getStyle('A2:E5')->applyFromArray($pdf_data['style_array']);
    }
    $writer = new Xlsx($spreadsheet);
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $pdf_data['file_name'] . '"');
    $writer->save('php://output');
  }
  function output_multiple($sheets, $excel_data)
  {
    $spreadsheet = new Spreadsheet();

    // create new worksheet for each employee
    foreach ($sheets as $key => $sheet) {
      $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $sheet);
      $spreadsheet->addSheet($myWorkSheet, $key);
    }

    // Fill data in the each worksheet in the sequence.
    foreach($excel_data['data'] as $key=>$exl_data) {
      //echo $key;
      $sheet = $spreadsheet->getSheet($key);
      // set header row data
      $this->set_header($sheet, $excel_data['headers']);
      foreach ($exl_data as $key => $value) {
        $sheet->setCellValue($key, $value);
      }
    }
    
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $excel_data['file_name'] . '"');
    $writer->save('php://output');

  }

  function set_header($sheet, $header_data){
    $first_key = $last_key = '';
    $i = 0;
    foreach ($header_data as $key => $value) {
      if ($i == 0) {
        $first_key = $key;
      }
      $sheet->setCellValue($key, $value);
      $last_key = $key;
      $i++;
    }
    $sheet->getStyle("$first_key:$last_key")->getFont()->setBold(true);
    return $sheet;
  }

}
