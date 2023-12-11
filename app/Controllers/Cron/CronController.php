<?php

namespace App\Controllers\Cron;

use App\Controllers\BaseController;
use App\Models\PartsModel;
use App\Models\JobsHistoryModel;
use App\Models\JobActionsModel;
use App\Models\jobsModel;

use DateTime;

class CronController extends BaseController
{
    protected $partModel;
    protected $jobshistoryModel;
    protected $jobActionModel;
    protected $jobsModel;
    function __construct()
    {
        $this->partModel = new PartsModel();
        $this->jobshistoryModel = new JobsHistoryModel();
        $this->jobActionModel = new JobActionsModel();
        $this->jobsModel = new JobsModel();
 
    }
    public  function cron_completed_job(){
        
        $this->jobActionModel->select('parts.*,job_actions.part_id,job_actions.side,job_actions.image_url,job_actions.wrong_pins,job_actions.correct_pins,job_actions.detail_pins,job_actions.start_time,job_actions.end_time,job_actions.created_by,job_actions.updated_by, parts.pins as total_pins');
        $this->jobActionModel->join('parts', 'job_actions.part_id = parts.id');
        $result = $this->jobActionModel->findAll();
       // echo "ok";exit;
     
        foreach ($result as $key => $result_job) {
            if($result_job['part_id'] != ''){
            
             
            $pins_detail = $this->jobsModel
            ->select('jobs.pins')
            ->where('jobs.part_id', $result_job['part_id'])
            ->get()
            ->getFirstRow();
            if ($pins_detail !== null) {
        $details_pins = $pins_detail->pins;
            $array = explode(',', $result_job['total_pins']);
            $countedValues = array_count_values($array);
           
            $body = '<p>Dear Sir/Madam,</p>';
            $body .= '<p>Here are the job details:</p>';

             // Start of the table
            $body .= '<table border="1">';


            $totalTime = strtotime($result_job['end_time']) - strtotime($result_job['start_time']);
            if ($result_job['correct_pins'] != 0 && $result_job['total_pins'] != 0) {

                $correct_pins_count = ($result_job['correct_pins'] / $result_job['total_pins']) * 100;
            } else {

                $correct_pins_count = 000; // or handle it in a way that makes sense for your application
            }
           

            $correct_pins_count_formatted = number_format($correct_pins_count, 2); // Format to 2 decimal places
            $defaultImagePath = FCPATH . 'assets/img/no_image_found.png';
             $startTime = new DateTime($result_job['start_time']);
            $endTime = new DateTime($result_job['end_time']);

            $body .= '<tr>
            <td style="width: 25%;"><b>Part Name</b></td>
            <td style="width: 25%;">'. $result_job['part_name'] .'</td>
            <td style="width: 25%;"><b>Ok Pins</b></td>

            <td style="width: 25%;">' . $result_job['correct_pins'] . '</td>
            </tr>
            <tr> 
            <td><b>Part No.</b></td><td>'. $result_job['part_no'] .' </td>
            <td><b>Not Ok Pins</b></td><td>'. $result_job['wrong_pins'] .'</td>
            </tr>
            <tr> <td><b>Die No.</b></td><td>'. $result_job['die_no'] .' </td>
            <td><b> Total Pins</b></td><td>'. count($countedValues) .'</td>
            </tr>
            <tr><td><b> Start Time</b></td><td>'.$startTime->format('d-m-y h:i A') .'</td>
            <td class="green_color"><b> Ok Pins(%)</b></td><td class="green_color"><b>'.$correct_pins_count_formatted .'</b></td>
            </tr>
            <tr>
            <td><b> End Time</b></td><td>'.$endTime->format('d-m-y h:i A') .'</td>
            <td class="green_color"><b> Total Time</b></td><td class="green_color"><b>'. gmdate("H:i:s", $totalTime) .'</b></td>               
            </tr>';
           

            $body .= '</table><div class="row">
            <div class="col-12">
                <div class="pins-display-wrapper">
                    <div class="arrow-center">
                    <div class="front">Front</div>
                    </div>
                    <div class="pins-display no-click">
';


            $pin_states = $pins_detail->pins;
            $pin_states = json_decode($pin_states, true);


            $alphabets = 'A B C D E F G H I J K L M N O P Q R S T U V W X Y Z AA AB';
            $col_array = explode(" ", $alphabets);


            for ($i = 1; $i <= 14; $i++) {
                for ($j = 0; $j < count($col_array); $j++) {
                    $pin_id = $col_array[$j] . $i;

                    // Check if pin_id exists in the array
                    if (isset($pin_states[$pin_id])) {
                        // If pin_id is available, set pin_class based on the condition
                        $pin_value = $pin_states[$pin_id];
                        $pin_class = ($pin_value == 1) ? 'pin-box green-pin' : 'pin-box red-pin';
                    } else {
                        // If pin_id is not available, set pin_class to 'gray-pin'
                        $pin_class = 'pin-box gray-pin';
                    }

                    // Concatenate the HTML string
                    $body .= '<div id="' . $pin_id . '" title="' . $pin_id . '" class="' . $pin_class . '">' . $pin_id . '</div>';

                    // Add x-axis line after every 14th element in the row
                    if (($j + 1) % 14 == 0 && ($j / 14) % 2 == 0) {
                        $body .= '<div class="x-axis-line"></div>';
                    }
                }

                // Add y-axis line after every 8 rows
                if (($i + 1) % 8 == 0) {
                    $body .= '<div class="y-axis-line"></div>';
                }
            }


       

            $body .= '</div>
            <div class="arrow-center">
                <i class="fa fa-arrow-alt-circle-up"></i>
            </div>
        </div>
    </div>
</div>';



            // End of the table

            $body .= '<p>Thank You</p>';
            $body .= '<p>
==========================================================================
Do no reply on this email, this is an automated email.
</p>
            <style>
            .pins-display .pin-box {
                float: left;
                width: 34px;
                height: 34px;
                margin: 2px;
                text-align: center;
                background-color: #ffffff;
                line-height: 35px;
                font-size: 10px;
                cursor: pointer;
                border-radius: 50%;
                color: rgba(255, 255, 255, 1);
            }
            table{
                width: 1069px;
            }
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
              }
            .gray-pin{
                background: grey;
            }
            .green_color{
                background: #9add9a;
            }
            .pins-display {
                width: 1110px;
                overflow: hidden;
              
                position: relative;
                background-color: #FFF;
            }
            .pins-display-wrapper {
                overflow: auto;
                position: relative;
            }
            .pins-display div.gray-pin {
                background-color: var(--gray);
                background: gray;
            }
            .arrow-center {
                margin: 0 auto;
                width: 1110px;
                text-align: center;
                background: #fff;
                padding: 10px;
            }
           
            
            .pins-display div.gray-pin {
                background-color: var(--gray);
                background: gray;
            }
            .pins-display div.red-pin {
                background-color: var(--gray);
                background: red;
            }
            .pins-display div.green-pin {
                background-color: var(--gray);
                background: green;
            }
            *, ::after, ::before {
                box-sizing: border-box;
            }
            .dark-mode .card {
                background-color: #343a40;
                color: #fff;
            }
            .card {
               
                word-wrap: break-word;
                
            }
            .pins-display .x-axis-line {
                width: 3px;
                height: 30px;
                background-color: black;
                float: left;
                margin-bottom: -11px;
                margin: 0 3px;
            }
            .pins-display .y-axis-line {
                width: 99%;
                background-color: black;
                height: 3px;
                float: left;
                margin: 3px 0px;
            }
            </style>';
// print_r($body);exit;
           if( send_email(env('To_Email'), 'Jobs Details', $body)){
            echo "Job details sent through email";
           }
        }
        }
       
        }
    }
}