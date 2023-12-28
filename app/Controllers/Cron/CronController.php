<?php

/**  
 * CronController file Doc Comment
 * 
 * PHP version 7
 *
 * @category CronController_Class
 * @package  CronController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */


namespace App\Controllers\Cron;

use App\Controllers\BaseController;
use App\Models\PartsModel;
use App\Models\JobsHistoryModel;
use App\Models\JobActionsModel;
use App\Models\jobsModel;

use DateTime;

/**
 * CronController Class Doc Comment
 * 
 * CronController Class
 * 
 * @category CronController_Class
 * @package  CronController_Class
 * @author   Author <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class CronController extends BaseController
{
    protected $partModel;
    protected $jobshistoryModel;
    protected $jobActionModel;
    protected $jobsModel;
    /**
     * Constructor for the CronController class.
     */
    function __construct()
    {
        $this->partModel = new PartsModel();
        $this->jobshistoryModel = new JobsHistoryModel();
        $this->jobActionModel = new JobActionsModel();
        $this->jobsModel = new JobsModel();
 
    }
    /**
     * Method for handling completed jobs in the cron controller.
     * 
     * @return bool; 
     */
    public function cronCompletedJob()
    {
        
        $this->jobActionModel->select('
            parts.*,
            jobs.job_action_id,
            jobs.pins as job_pins,
            job_actions.id as job_action_id,
            job_actions.part_id,
            job_actions.side,
            job_actions.image_url,
            job_actions.wrong_pins,
            job_actions.correct_pins,
            job_actions.detail_pins,
            job_actions.start_time,
            job_actions.end_time,
            job_actions.created_by,
            job_actions.updated_by, 
            parts.pins as total_pins
        ');
        $this->jobActionModel->join('parts', 'job_actions.part_id = parts.id');
        $this->jobActionModel->join('jobs', 'job_actions.id = jobs.job_action_id');
        $this->jobActionModel->where('job_actions.end_time IS NOT NULL');
        $this->jobActionModel->where('job_actions.mail_send', '0');
        $result = $this->jobActionModel->findAll(1);
        foreach ($result as $result_job) {       
            $total_pins_arr = explode(',', $result_job['total_pins']);
            $total_pin_count = count($total_pins_arr);           
            $body = '<p>Dear Sir/Madam,</p>';
            $body .= '<p>Job details:</p>';

            // Start of the table
            $body .= '<table border="1" width="600px" class="info-table">';
            $totalTime = strtotime($result_job['end_time']) - strtotime($result_job['start_time']);
            
            if (!empty($result_job['correct_pins']) && !empty($total_pin_count)) {
                $correct_pins_count = ((int)$result_job['correct_pins'] / (int)$total_pin_count) * 100;
            } else {
                $correct_pins_count = 000; // or handle it in a way that makes sense for your application
            }          

            $correct_pins_count_formatted = number_format($correct_pins_count, 2); // Format to 2 decimal places
            $startTime = new DateTime($result_job['start_time']);
            $endTime = new DateTime($result_job['end_time']);
            $body .= '
            <tr>
                <td ><b>Part Name</b></td>
                <td >'. $result_job['part_name'] .'</td>
                <td ><b>Ok Pins</b></td>
                <td >' . $result_job['correct_pins'] . '</td>
            </tr>
            <tr> 
                <td><b>Part No.</b></td>
                <td>'. $result_job['part_no'] .' </td>
                <td><b>Not Ok Pins</b></td>
                <td>'. $result_job['wrong_pins'] .'</td>
            </tr>
            <tr>
                <td><b>Die No.</b></td>
                <td>'. $result_job['die_no'] .' </td>
                <td><b> Total Pins</b></td>
                <td>'. $total_pin_count .'</td>
            </tr>
            <tr>
                <td><b> Start Time</b></td>
                <td>'.$startTime->format('d/m/Y h:i A') .'</td>
                <td class="green_color"><b> Ok Pins(%)</b></td>
                <td class="green_color"><b>'.$correct_pins_count_formatted .'</b></td>
            </tr>
            <tr>
                <td><b> End Time</b></td>
                <td>'.$endTime->format('d/m/Y h:i A') .'</td>
                <td class="green_color"><b> Total Time</b></td>
                <td class="green_color"><b>'. gmdate("H:i:s", $totalTime) .'</b></td>               
            </tr>
            </table><br/>';           


            helper('common');

            $body .= '<div class="row">
                <div class="col-12">';
            
            $body .= display_pins($result_job['job_pins']);    
            
            $body .= '
                </div>
            </div>';
            $body .= '<br/><div>Thank You,</div>';
            $body .= '<div>IT Team</div><hr>';
            $body .= '<p>This is an automated email, Please do not reply to this email.</p>
            <style>
            .info-table td {
                padding: 5px;
            }
            .pins-display .pin-box {
                float: left;
                width: 26px;
                height: 26px;
                margin: 2px;
                text-align: center;
                background-color: #ffffff;
                line-height: 26px;
                font-size: 9px;
                cursor: pointer;
                border-radius: 50%;
                color: rgba(255, 255, 255, 1);
            }        
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            .front {
                font-size: 15px;
                font-weight: bold;
                color: red;
                position: relative;
            }
            .green_color{
                background: #9add9a;
            }
            .pins-display {
                overflow: hidden;
                position: relative;
                background-color: #FFF;
            }
            .pins-display-wrapper {
                overflow: auto;
                position: relative;
            }
            .arrow-center {
                text-align: center;
                background: #fff;
                padding: 10px;
            }
            .pins-display, .arrow-center {
                width: 850px;
            }
            .pins-display div.gray-pin {
                background-color: #808080;
            }
            .pins-display div.red-pin {
                background-color: #ff0000;
            }
            .pins-display div.green-pin {
                background-color: #008000;
            }
            .pins-display div.orange-pin {
                background-color: #feab13;
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
                width: 1.5px;
                height: 30px;
                background-color: black;
                float: left;
                margin-bottom: -11px;
                margin: -2px 0px;
            }
            .pins-display .y-axis-line {
                width: 99%;
                background-color: black;
                height: 2px;
                float: left;
                margin: 3px 0px;
            }
            </style>';
       
            if (send_email(env('To_Email'), 'Jobs Details', $body)) {
                $data['mail_send'] =  '1';
                $id = $result_job['job_action_id'];
                $this->jobActionModel->update($id, $data);
                echo "Job details sent through email";
                sleep(30);
            }
        }
    }
}
