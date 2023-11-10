<?php

namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

use Mpdf\Mpdf;

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
    if (isset($pdf_data['sheet']) && $pdf_data['sheet']  == 'completed-jobs') {
      $sheet->mergeCells('A1:G1'); // Merge cells for the title
      $sheet->setCellValue('A1', 'Completed Jobs'); // Set the title
      $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center'); // Center align the title
      $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('FF34659B');
      $sheet->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); // Add this line
      $sheet->getStyle('A1:G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
      $sheet->getStyle('A1:G2')->getFill()->getStartColor()->setARGB('FF34659B');
      $sheet->getStyle('A2:G2')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
      $sheet->getStyle('A2:G2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); // Add this line
      $columnCount = count($pdf_data['headers']);
      $equalWidth = 20; // Adjust the width as needed

      for ($i = 1; $i <= $columnCount; $i++) {
        $sheet->getColumnDimensionByColumn($i)->setWidth($equalWidth);
      }


      foreach ($pdf_data['data'] as $cell => $value) {
        $sheet->setCellValue($cell, $value);
        $styleArray = [
          'borders' => [
            'allBorders' => [
              'borderStyle' => Border::BORDER_THIN,
            ],
          ],
        ];
        $sheet->getStyle($cell)->applyFromArray($styleArray);
      }    
      foreach ($pdf_data['data'] as $cell => $value) {
        
        if (strpos($cell, 'G') !== false && !empty($value)) {
        $columnGValue = ''; 
        $rowIndex = (int)filter_var($cell, FILTER_SANITIZE_NUMBER_INT) + 1; // Adjust row index to 1-based index
        $sheet->setCellValue('G' . $rowIndex, $columnGValue);
        
          $absolute_path = FCPATH . $value;
          if (file_exists($absolute_path)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath($absolute_path);
            $drawing->setHeight(50);
            $drawing->setWidth(50);
            $drawing->setCoordinates($cell);
            $drawing->setWorksheet($sheet);
            $sheet->getRowDimension((int)filter_var($cell, FILTER_SANITIZE_NUMBER_INT))->setRowHeight(150);  // Adjust this based on your needs
          }
        }
      }
    }
    // exit;
    $writer = new Xlsx($spreadsheet);
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
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
    foreach ($excel_data['data'] as $key => $exl_data) {
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

  function set_header($sheet, $header_data)
  {
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
  function set_pdf($pdf_data)
  {

    $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'default_font' => 'Arial', 'allow_output_buffering' => true, 'allow_remote_images' => true]);
    ob_end_clean();
    $inputPath ='' . FCPATH . '\assets\img\Mahindra_Logo.jpg';
  $pdf->SetHeader('{PAGENO} / {nb}');
  $pdf->SetHeader('<img src="' . $inputPath . '" height="60" width="100">');
 
    $pdf->SetFooter('{PAGENO}');
    $pdf->WriteHTML($pdf_data['pdfdata']);
    $pdfData = $pdf->output($pdf_data['title'] . '.pdf', 'D'); // Generate PDF content
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $pdf_data['title'] . '.pdf"');
    echo $pdfData;
    exit;
  }
}
