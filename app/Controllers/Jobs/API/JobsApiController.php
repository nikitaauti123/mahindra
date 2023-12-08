<?php

namespace App\Controllers\Jobs\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Phpspreadsheet;
use App\Models\JobsModel;
use App\Models\PartsModel;
use App\Models\JobsHistoryModel;
use App\Models\JobActionsModel;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLS;
use DateTime;
use Exception;

class JobsApiController extends BaseController
{
    use ResponseTrait;
    private $jobsModel;
    private $PartsModel;
    private $session;
    private $jobshistoryModel;
    private $JobActionsModel;
    private $phpspreadsheet;

    public function __construct()
    {
        $this->jobsModel = new JobsModel();
        $this->PartsModel = new PartsModel();
        $this->jobshistoryModel = new JobsHistoryModel();
        $this->session = \Config\Services::session();
        $this->JobActionsModel = new JobActionsModel();
        $this->phpspreadsheet = new Phpspreadsheet();
    }

    public function list()
    {
        $result = $this->jobsModel->findAll();
        $combinedData = [];
        foreach ($result as $result_arr) {
            $created_at = new DateTime($result_arr['created_at']);
            $formatted_date = $created_at->format('d-m-Y h:i A');
            $result_arr['created_at'] =   $formatted_date;

            $updated_at = new DateTime($result_arr['updated_at']);
            $formatted_date_update = $updated_at->format('d-m-Y h:i A');
            $result_arr['updated_at'] =   $formatted_date_update;

            $combinedData[] = $result_arr;
        }
        return $this->respond($combinedData, 200);
    }

    public function getOne($id)
    {
        try {
            $result = $this->jobsModel->find($id);
            if (!empty($result)) {
                return $this->respond($result, 200);
            }
            return $this->respond([], 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function add()
    {

        try {
            helper(['form']);

            $rules = [
                'part_name'  => 'required|min_length[2]|max_length[100]',
                'part_no'  => 'required|min_length[3]|max_length[100]',
                'model'  => 'required|min_length[3]|max_length[100]',
                'is_active'  => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['part_name']  = $this->request->getVar('part_name');
            $data['part_no']    = $this->request->getVar('part_no');
            $data['model']      = $this->request->getVar('model');
            $data['is_active']  = $this->request->getVar('is_active') ? $this->request->getVar('is_active') : 0;
            $data['pins']      =  $this->request->getVar('selected_pins');

            $result['id'] = $this->jobsModel->insert($data, true);
            $result['msg'] = lang('Jobs.JobsSuccessMsg');

            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function update($id)
    {

        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $rules = [
                'part_name'  => 'required|min_length[2]|max_length[100]',
                'part_no'  => 'required|min_length[3]|max_length[100]',
                'model'  => 'required|min_length[3]|max_length[100]',
                'is_active'  => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['part_name'] = $this->request->getVar('part_name');
            $data['part_no']   = $this->request->getVar('part_no');
            $data['model']     = $this->request->getVar('model');
            $data['is_active'] = $this->request->getVar('is_active') ? $this->request->getVar('is_active') : 0;
            $data['pins']      =  $this->request->getVar('selected_pins');

            $result['is_updated'] = $this->jobsModel->update($id, $data);
            $result['msg'] = lang('Jobs.JobsSuccessUpdateMsg');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function delete($id)
    {
        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $result['is_deleted'] = $this->jobsModel->delete($id);
            $result['msg'] = "Job deleted successfully!";
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    public function update_is_active()
    {
        try {
            $id = $this->request->getVar('id');
            $is_Active = $this->request->getVar('is_active');
            if (($is_Active) == 1) {
                $data['is_active'] = '0';
            } else {
                $data['is_active'] = '1';
            }
            $result['msg'] =  lang('Jobs.StatusUpdateMsg');
            $result['id'] = $this->jobsModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    public function get_api_data()
    {

        $part_id = $this->request->getVar('part_id');

        if (!empty($part_id)) {
            $result = $this->jobsModel
                ->select('jobs.pins, jobs.side, parts.id, parts.die_no,parts.part_name,parts.part_no,parts.model')
                ->join('parts', 'jobs.part_id = parts.id', 'right')
                ->orderBy('jobs.id', 'DESC')
                // ->where('jobs.side', $this->request->getVar('side'))
                ->where('parts.id', $this->request->getVar('part_id'))
                ->limit(1) // Set the limit to 1 to fetch only one row
                ->get()
                ->getRow();
        } else {
            $result = $this->jobsModel
                ->select('jobs.pins, jobs.side, parts.id, parts.die_no,parts.part_name,parts.part_no,parts.model')
                ->join('parts', 'jobs.part_id = parts.id', 'right')
                ->orderBy('jobs.id', 'DESC')
                // ->where('jobs.side', $this->request->getVar('side'))
                //->where('parts.id', $this->request->getVar('part_id'))
                ->limit(1) // Set the limit to 1 to fetch only one row
                ->get()
                ->getRow();
        }


        if ($result) {
            return $this->respond($result, 200);
        }
        return $this->respond(['error' => 'No data available'], 404);
    }
    public  function completed_list()
    {
        if ($this->request->getVar('from_date') && $this->request->getVar('to_date')) {
            $from_date = $this->request->getVar('from_date');
            $f_date = date("Y-m-d", strtotime($from_date));
            $to_date = $this->request->getVar('to_date');
            $t_date = date("Y-m-d", strtotime($to_date));
            $date = date("Y-m-d", strtotime('2023-10-31 00:00:00'));
            $this->jobsModel->where("DATE_FORMAT(created_at, '%Y-%m-%d') >= '" . $f_date . "'", null, false);
            $this->jobsModel->where("DATE_FORMAT(created_at, '%Y-%m-%d') <= '" . $t_date . "'", null, false);
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->jobsModel->where('part_id', $this->request->getVar('part_name'));
        }

        if (!empty($this->request->getVar('part_no'))) {
            $this->jobsModel->where('part_id', $this->request->getVar('part_no'));
        }
        if (!empty($this->request->getVar('model'))) {
            $this->jobsModel->where('part_id', $this->request->getVar('model'));
        }
        if (!empty($this->request->getVar('die_no'))) {
            $this->jobsModel->where('part_id', $this->request->getVar('die_no'));
        }
        $result = $this->jobsModel->findAll();
        $combinedResults  = array();
        foreach ($result as $result_arr) {
            $partId = $result_arr['part_id']; // Assuming 'part_id' is a field in the jobs table.
            $this->PartsModel->where('id', $result_arr['part_id']);
            $partData = $this->PartsModel->first();
            if ($partData) {
                // Combine the data from the two tables and store it in the results array.
                $combinedResult = array_merge($result_arr, $partData);
                $combinedResults[] = $combinedResult;
            }
        }

        return $this->respond($combinedResults, 200);
    }
    public function history_list()
    {
        if (!empty($this->request->getVar('die_no'))) {
            $this->jobshistoryModel->where('jobs_history.part_id', $this->request->getVar('die_no'));
        }
        if (!empty($this->request->getVar('part_no'))) {
            $this->jobshistoryModel->where('jobs_history.part_id', $this->request->getVar('part_no'));
        }
        if (!empty($this->request->getVar('model'))) {
            $this->jobshistoryModel->where('jobs_history.part_id', $this->request->getVar('model'));
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->jobshistoryModel->where('jobs_history.part_id', $this->request->getVar('part_name'));
        }

        if ($this->request->getVar('from_date') && $this->request->getVar('to_date')) {
            $from_date = $this->request->getVar('from_date');
            $f_date = date("Y-m-d", strtotime($from_date));
            $to_date = $this->request->getVar('to_date');
            $t_date = date("Y-m-d", strtotime($to_date));
            $this->jobshistoryModel->where("DATE_FORMAT(jobs_history.created_at, '%Y-%m-%d') >= '" . $f_date . "'", null, false);
            $this->jobshistoryModel->where("DATE_FORMAT(jobs_history.created_at, '%Y-%m-%d') <= '" . $t_date . "'", null, false);
        }

        $this->jobshistoryModel->select('parts.*');
        $this->jobshistoryModel->join('parts', 'jobs_history.part_id = parts.id');
        $result = $this->jobshistoryModel->findAll();
        return $this->respond($result, 200);
        //    return $result;
    }
    public function set_api_jobs()
    {
        $array = $this->request->getVar('pins');
        $result = array();
        foreach ($array as $key => $value) {
            $correct_inserted = trim($value['correct_inserted']);
            $correct_inserted_value = ($correct_inserted === 'true') ? 1 : 0;
            $result[$key] = $correct_inserted_value;
        }
        ksort($result);
        $json_pins = json_encode($result);

        $this->jobsModel->where('part_id', $this->request->getVar('part_id'));
        $jobs =  $this->jobsModel->first();
        if (empty($jobs)) {
            $data = [
                'part_id' => $this->request->getVar('part_id'),
                'side' => $this->request->getVar('side'),
                'pins' => $json_pins,
                'created_by' => $this->session->get('id'),
                'start_time' => date('Y-m-d H:i:s')
            ];
            $result_arr['id'] = $this->jobsModel->insert($data, true);
            $history_data = [
                'part_id' => $this->request->getVar('part_id'),
                'job_id' => $result_arr['id'],
                'pins' => $json_pins,
                'is_active' => '1',
            ];
            $result_history['id'] = $this->jobshistoryModel->insert($history_data, true);
            $result_history['msg'] =  lang('Jobs.JobsapiSuccessMsg');
        } else {
            $data = [
                'part_id' => $this->request->getVar('part_id'),
                'side' => $this->request->getVar('side'),
                'pins' => $json_pins,
                'updated_by' => $this->session->get('id'),
                'end_time' => date('Y-m-d H:i:s')
            ];
            $id = $jobs['id'];
            $result_arr['id'] = $this->jobsModel->update($id, $data);
            $history_data = [
                'part_id' => $this->request->getVar('part_id'),
                'job_id' => $result_arr['id'],
                'pins' => $json_pins,
                'is_active' => '1',
            ];
            $result_history['id'] = $this->jobshistoryModel->insert($history_data, true);
            $result_history['msg'] =  lang('Jobs.JobsapiSuccessUpdateMsg');
        }
        return $this->respond($result_history, 200);
    }

    public function add_job()
    {

        try {

            $part_id = $this->request->getVar('part_id');

            if (empty($part_id)) {
                throw new Exception("Please provide 'part_id' parameter value");
            }

            $json_pins = $this->request->getVar('pins');

            if (empty($json_pins)) {
                throw new Exception("Please provide 'pins' parameter value");
            }

            $side = $this->request->getVar('side');

            if (empty($side)) {
                throw new Exception("Please provide 'side' parameter value");
            }


            /*$result = array();
            foreach ($array as $key => $value) {
                $correct_inserted = trim($value['correct_inserted']);
                $correct_inserted_value = ($correct_inserted === 'true') ? 1 : 0;
                $result[$key] = $correct_inserted_value;
            }
            ksort($result);
            $json_pins = json_encode($result); */

            $this->jobsModel->where('part_id', $part_id);
            $this->jobsModel->orderBy('id', 'desc');
            $jobs =  $this->jobsModel->first();

            if (empty($jobs)) {
                $data = [
                    'part_id' => $part_id,
                    'side' => $side,
                    'pins' => $json_pins,
                    'created_by' => 1,
                    'start_time' => date('Y-m-d H:i:s')
                ];
                $result_arr['id'] = $this->jobsModel->insert($data, true);
                $history_data = [
                    'part_id' => $part_id,
                    'job_id' => $result_arr['id'],
                    'pins' => $json_pins,
                    'is_active' => '1',
                ];
                $result_history['id'] = $this->jobshistoryModel->insert($history_data, true);
                $result_history['msg'] =  lang('Jobs.JobsapiSuccessMsg');
            } else {
                $data = [
                    'part_id' => $part_id,
                    'side' => $side,
                    'pins' => $json_pins,
                    'updated_by' => 1,
                    'end_time' => date('Y-m-d H:i:s')
                ];
                $id = $jobs['id'];
                $result_arr['id'] = $this->jobsModel->update($id, $data);
                $history_data = [
                    'part_id' => $part_id,
                    'job_id' => $result_arr['id'],
                    'pins' => $json_pins,
                    'is_active' => '1',
                ];
                $result_history['id'] = $this->jobshistoryModel->insert($history_data, true);
                $result_history['msg'] =  lang('Jobs.JobsapiSuccessUpdateMsg');
            }
            return $this->respond($result_history, 200);
        } catch (Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }


    public function set_job_actions()
    {
        try {
            $user_id = $this->session->get('id') ? $this->session->get('id') : 1;

            if ($this->request->getVar('time') == 'start_time') {
                $data = [
                    'part_id' => $this->request->getVar('part_id'),
                    'side' => $this->request->getVar('side'),
                    'start_time' => date('Y-m-d H:i:s'),
                    'created_by' => $user_id,
                ];
                $result['id'] = $this->JobActionsModel->insert($data, false);
                $result['msg'] = lang('Jobs.AddJobbActionSuccss');
                $result['lastInsertid'] = $this->JobActionsModel->insertID();

                $data = [
                    'part_id' => $this->request->getVar('part_id'),
                    'side' => $this->request->getVar('side'),
                    'pins' => '',
                    'created_by' => 1,
                    'start_time' => date('Y-m-d H:i:s')
                ];
                $result_arr['id'] = $this->jobsModel->insert($data, true);
            } else {
                $id  = $this->request->getVar('id');

                $affected = $this->JobActionsModel->update_data($id, $this->request->getVar('side'), $user_id, date('Y-m-d H:i:s'));
                if ($affected > 0) {
                    $result['msg'] = lang('Jobs.UpdateJobbActionSuccss');
                } else {
                    throw new Exception("Not updated");
                }
                $result_job = $this->JobActionsModel
                    ->select('parts.*,job_actions.id,job_actions.part_id,job_actions.image_url, job_actions.part_id, job_actions.side, job_actions.start_time, job_actions.end_time,job_actions.correct_pins,job_actions.wrong_pins, parts.pins as total_pins')
                    ->join('parts', 'parts.id = job_actions.part_id', 'left') // Assuming 'id' is the primary key in the 'parts' table and 'part_id' is the foreign key in the 'job_actions' table
                    ->where('job_actions.id', $id)
                    ->get()
                    ->getFirstRow();

                $pins_detail = $this->jobsModel
                    ->select('jobs.pins')
                    ->where('jobs.part_id', $result_job->part_id)
                    ->get()
                    ->getFirstRow();
                $details_pins = $pins_detail->pins;

                $array = explode(',', $result_job->total_pins);
                $countedValues = array_count_values($array);
                //print_r(count($countedValues));exit;

                $body = '<p>Dear User,</p>';
                $body .= '<p>Here are the job details:</p>';

                // Start of the table
                $body .= '<table border="1">';

                // First row (Left and Right Columns)
                $body .= '<tr>';
                $totalTime = strtotime($result_job->end_time) - strtotime($result_job->start_time);
                if ($result_job->correct_pins != 0 && $result_job->total_pins != 0) {

                    $correct_pins_count = ($result_job->correct_pins / $result_job->total_pins) * 100;
                } else {

                    $correct_pins_count = 000; // or handle it in a way that makes sense for your application
                }

                $correct_pins_count_formatted = number_format($correct_pins_count, 2); // Format to 2 decimal places
                $defaultImagePath = FCPATH . 'assets/img/no_image_found.png';
                $imageContent = isset($result_job->image_url) ? file_get_contents($result_job->image_url) : file_get_contents($defaultImagePath);
                $base64Image = 'data:image/png;base64,' . base64_encode($imageContent);
                $startTime = new DateTime($result_job->start_time);
                $endTime = new DateTime($result_job->end_time);
                $body .= '<th>Part Name</th>
                <th>Part No</th>
                <th>Die No</th>
                <th>Start Time</th>
                <th>End Time Name</th>
                <th>Total Time</th>
                <th>Ok Pins</th>
                <th>Not Ok Pins</th>
                <th>Total Pins</th>
                <th>Correct Pins (%)</th>
                <th>Image</th></tr><tr>';

                $body .= '<td>' . $result_job->part_name . '</td>';
                $body .= '<td>' . $result_job->part_no . '</td>';
                $body .= '<td>' . $result_job->die_no . '</td>';
                $body .= '<td' . $result_job->part_no . '</td>';
                $body .= '<td>' . $startTime->format('d-m-y h:i A') . '</td>';
                $body .= '<td>' . $endTime->format('d-m-y h:i A') . '</td>';
                $body .= '<td>' .  gmdate("H:i:s", $totalTime) . '</td>';
                $body .= '<td>' . $result_job->correct_pins . '</td>';
                $body .= '<td>' . $result_job->wrong_pins . '</td>';
                $body .= '<td>' . count($countedValues) . '</td>';
                $body .= '<td>' . $correct_pins_count_formatted . '</td>';

                $body .= '<td > <div class="">
                <div class="col-12">
                    <div class="pins-display-wrapper">
                        <div class="arrow-center">
                            <i>sd</i>
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
    </div></td>';


                // End of the table
                $body .= '</table>';

                $body .= '<p>Thank You</p><style>
                .pins-display .pin-box {
                    float: left;
                    width: 34px;
                    height: 34px;
                    margin: 2px;
                    text-align: center;
                    background-color: #ffffff;
                    line-height: 14px;
                    font-size: 6px;
                    cursor: pointer;
                    border-radius: 50%;
                    color: rgba(255, 255, 255, 1);
                }
                .gray-pin{
                    background: grey;
                }
                .pins-display {
                    width: 1110px;
                    overflow: hidden;
                    margin: 0 auto;
                    padding: 10px 10px 10px 17px;
                    position: relative;
                    background-color: #FFF;
                }
                .pins-display-wrapper {
                    overflow: auto;
                    width: 225%;
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
               
                .col-12 {
                  
                    max-width: 50%;
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

                send_email(env('To_Email'), 'Jobs Details', $body);
            }
            return $this->respond($result, 200);
        } catch (Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function update_image($id)
    {

        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $rules = [
                'image_url'  => 'required|min_length[2]|max_length[255]'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $this->JobActionsModel = new JobActionsModel();

            $data['image_url'] = $this->request->getVar('image_url');
            $data['wrong_pins'] = $this->request->getVar('wrong_pins');
            $data['correct_pins'] = $this->request->getVar('correct_pins');

            $result['is_updated'] = $this->JobActionsModel->update($id, $data);
            $result['msg'] = lang('Jobs.JobsSuccessUpdateMsg');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function get_job_status()
    {

        $this->JobActionsModel = new JobActionsModel();

        $side = $this->request->getVar('side');

        if (!empty($side)) {
            $result = $this->JobActionsModel
                ->select('id, part_id, side, start_time, end_time')
                ->orderBy('id', 'DESC')
                ->where('end_time IS NULL')
                ->where('side', $side)
                //->limit(1) // Set the limit to 1 to fetch only o ne row
                ->get()
                ->getResult();
        } else {
            $result = $this->JobActionsModel
                ->select('id, part_id, side, start_time, end_time')
                ->orderBy('id', 'DESC')
                ->where('end_time IS NULL')
                //->limit(1) // Set the limit to 1 to fetch only o ne row
                ->get()
                ->getResult();
        }

        if ($result) {
            return $this->respond($result, 200);
        }
        return $this->respond([['error' => true, 'message' => 'No job started']], 404);
    }

    private function change_date_format($str)
    {
        $date_str = explode("/", $str);
        return $date_str[2] . "-" . $date_str[0] . "-" . $date_str[1];
    }

    public  function report_completed_list()
    {
        $result = [];
        $this->JobActionsModel = new JobActionsModel();
        if ($this->request->getVar('from_date') && $this->request->getVar('to_date')) {
            $from_date = $this->request->getVar('from_date');
            $f_date = $this->change_date_format($from_date) . " 00:00:00";
            $to_date = $this->request->getVar('to_date');
            $t_date = $this->change_date_format(($to_date)) . " 23:59:59";
            $this->JobActionsModel->where("start_time >= '" . $f_date . "'", null, false);
            $this->JobActionsModel->where("end_time <= '" . $t_date . "'", null, false);
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->JobActionsModel->where('parts.part_name', $this->request->getVar('part_name'));
        }

        if (!empty($this->request->getVar('part_no'))) {
            $this->JobActionsModel->where('parts.part_no', $this->request->getVar('part_no'));
        }
        if (!empty($this->request->getVar('model'))) {
            $this->JobActionsModel->where('parts.model', $this->request->getVar('model'));
        }
        if (!empty($this->request->getVar('die_no'))) {
            $this->JobActionsModel->where('parts.die_no', $this->request->getVar('die_no'));
        }
        if (!empty($this->request->getVar('job_Action_id'))) {
            $this->JobActionsModel->where('job_actions.id', $this->request->getVar('job_Action_id'));
        }

        $this->JobActionsModel->select('*');
        $this->JobActionsModel->join('parts', 'job_actions.part_id = parts.id');
        $result = $this->JobActionsModel->findAll();

        foreach ($result as $key => $result_arr) {

            if (isset($result_arr['start_time'])) {
                $result[$key]['start_time'] = date("d-m-Y h:i A", strtotime($result_arr['start_time']));
            }

            if (isset($result_arr['end_time'])) {
                $result[$key]['end_time'] = date("d-m-Y h:i A", strtotime($result_arr['end_time']));
            }

            $startTime = strtotime($result_arr['start_time']);
            $endTime = strtotime($result_arr['end_time']);
            $timeDiffSeconds = $endTime - $startTime;
            $totalTime = gmdate('H:i:s', $timeDiffSeconds);
            $result[$key]['total_time'] = $totalTime;

            /* $partId = $result_arr['part_id']; // Assuming 'part_id' is a field in the jobs table.
            $this->PartsModel->where('id', $result_arr['part_id']);
            $partData = $this->PartsModel->first();


            if ($partData) {
                // Combine the data from the two tables and store it in the results array.
                $combinedResult = array_merge($result_arr, $partData);
                $combinedResults[] = $combinedResult;
            } */
        }

        return $this->respond($result, 200);
    }

    public function report_list_dashboard()
    {
        $result = $this->JobActionsModel
            ->select('parts.*,job_actions.id,job_actions.part_id,job_actions.end_time')
            ->join('parts', 'job_actions.part_id = parts.id')
            ->orderBy('job_actions.id', 'DESC')
            ->where('job_actions.end_time IS NOT NULL', null, false)
            ->limit(10)
            ->get()
            ->getResult();
        $combinedData = [];
        foreach ($result as $result_arr) {
            $created_at = new DateTime($result_arr->end_time);
            $formatted_date = $created_at->format('d-m-Y h:i A');
            $result_arr->completed_time = $formatted_date;
            $combinedData[] = $result_arr;
        }
        return $this->respond($combinedData, 200);
    }
    public function export_completed_job()
    {
        $pdf_data = array();
        $date = date('Y-m-d H:i:s');
        $from_date =  date('d_m_Y', strtotime($this->request->getVar('from_date')));
        $to_date = date('d_m_Y', strtotime($this->request->getVar('to_date')));

        $file_name = "completed_jobs";


        $pdf_data['title'] = $file_name;
        $pdf_data['file_name'] = $file_name . '_' . $from_date . '_to_' . $to_date . '.xlsx';

        $col[] = 'Part No.';
        $col[] = 'Part Name';
        $col[] = 'Model';
        $col[] = 'Die No.';
        $col[] = 'Start Time';
        $col[] = 'End Time';
        $col[] = 'Total Time';
        $col[] = 'Image';
        $headers = excel_columns($col, 2);
        $pdf_data['headers'] = $headers;
        if ($this->request->getVar('from_date') && $this->request->getVar('to_date')) {

            $from_date = $this->request->getVar('from_date');
            $f_date = $this->change_date_format($from_date) . " 00:00:00";
            $to_date = $this->request->getVar('to_date');
            $t_date = $this->change_date_format(($to_date)) . " 23:59:59";

            $this->JobActionsModel->where("start_time >= '" . $f_date . "'", null, false);
            $this->JobActionsModel->where("end_time <= '" . $t_date . "'", null, false);
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->JobActionsModel->where('parts.part_name', $this->request->getVar('part_name'));
        }

        if (!empty($this->request->getVar('part_no'))) {
            $this->JobActionsModel->where('parts.part_no', $this->request->getVar('part_no'));
        }
        if (!empty($this->request->getVar('model'))) {
            $this->JobActionsModel->where('parts.model', $this->request->getVar('model'));
        }
        if (!empty($this->request->getVar('die_no'))) {
            $this->JobActionsModel->where('parts.die_no', $this->request->getVar('die_no'));
        }

        $this->JobActionsModel->select('*');
        $this->JobActionsModel->join('parts', 'job_actions.part_id = parts.id');
        $result = $this->JobActionsModel->findAll();
        $data = array();
        $i = 1;
        if (count($result) > 0) {
            foreach ($result as $row) {
                $data[$i][] = ((isset($row['part_no']) && !empty($row['part_no'])) ? $row['part_no'] : " ");
                $data[$i][] = ((isset($row['part_name']) && !empty($row['part_name'])) ? $row['part_name'] : " ");
                $data[$i][] = ((isset($row['model']) && !empty($row['model'])) ? $row['model'] : " ");
                $data[$i][] = ((isset($row['die_no']) && !empty($row['die_no'])) ? $row['die_no'] : " ");

                $created_at = new DateTime($row['start_time']);
                $formatted_date = $created_at->format('d-m-Y h:i A');

                $created_at_start = new DateTime($row['end_time']);
                $formatted_date_start = $created_at_start->format('d-m-Y h:i A');
                $startTime = strtotime($row['start_time']);
                $endTime = strtotime($row['end_time']);
                $timeDiffSeconds = $endTime - $startTime;
                $totalTime = gmdate('H:i:s', $timeDiffSeconds);

                $data[$i][] = ((isset($formatted_date) && !empty($formatted_date)) ? $formatted_date : " ");
                $data[$i][] = ((isset($formatted_date_start) && !empty($formatted_date_start)) ? $formatted_date_start : " ");
                $data[$i][] = ((isset($totalTime) && !empty($totalTime)) ? $totalTime : " ");

                $data[$i][] = ((isset($row['image_url']) && !empty($row['image_url'])) ? $row['image_url'] : " ");

                $i++;
            }
        }
        $body = excel_columns($data, 2);

        $pdf_data['data'] = $body;
        $pdf_data['sheet'] = 'completed-jobs';
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
        $this->phpspreadsheet->set_data($pdf_data);
    }

    public function pdf_completed_job()
    {
        $pdf_data = array();
        $date = date('Y-m-d H:i:s');
        $from_date =  date('d_m_Y', strtotime($this->request->getVar('from_date')));
        $to_date = date('d_m_Y', strtotime($this->request->getVar('to_date')));
        $file_name = "completed_jobs";
        $file_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $file_name);
        $pdf_data['title'] =  $file_name . '_' . $from_date . '_to_' . $to_date;
        if ($this->request->getVar('from_date') && $this->request->getVar('to_date')) {
            $from_date = $this->request->getVar('from_date');
            $f_date = $this->change_date_format($from_date) . " 00:00:00";
            $to_date = $this->request->getVar('to_date');
            $t_date = $this->change_date_format(($to_date)) . " 23:59:59";
            $this->JobActionsModel->where("start_time >= '" . $f_date . "'", null, false);
            $this->JobActionsModel->where("end_time <= '" . $t_date . "'", null, false);
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->JobActionsModel->where('parts.part_name', $this->request->getVar('part_name'));
        }
        if (!empty($this->request->getVar('part_no'))) {
            $this->JobActionsModel->where('parts.part_no', $this->request->getVar('part_no'));
        }
        if (!empty($this->request->getVar('model'))) {
            $this->JobActionsModel->where('parts.model', $this->request->getVar('model'));
        }
        if (!empty($this->request->getVar('die_no'))) {
            $this->JobActionsModel->where('parts.die_no', $this->request->getVar('die_no'));
        }
        $this->JobActionsModel->select('*');
        $this->JobActionsModel->join('parts', 'job_actions.part_id = parts.id');
        $result = $this->JobActionsModel->findAll();
        $inputPath = '' . FCPATH . '\assets\img\Mahindra_Logo_hor.jpg';
        // Start building the HTML content
        $htmlContent = '<h3 style="text-align:center">Completed Jobs</h3><table border="1" style="border-collapse:collapse,width: 100%;">
        <thead>
            <tr style="background-color:#3465a4;width: 100%;color:white">
            <th  style="color:white">Sr. No.</th>
                <th  style="width: 80px;color:white">Part No.</th>
                <th  style="width: 120px;color:white">Part Name</th>
                <th  style="width: 80px;color:white">Model</th>
                <th style="width: 80px;color:white">Die No.</th>
                <th style="width: 80px;color:white">Start Time</th>
                <th style="width: 80px;color:white">End Time</th>
                <th style="width: 80px;color:white">Total Time</th>
                <th style="width: 80px;color:white">Not Ok Pins</th>
                <th style="width: 80px;color:white">OK Pins</th>
                <th style="width: 80px;color:white">Total Pins</th>
                <th style="width: 80px;color:white">OK Pins (%)</th>
                <th style="width: 120px;color:white">Image</th>
            </tr>
        </thead>
        <tbody>';

        $k = 1;
        foreach ($result as $row) {
            $created_at = new DateTime($row['start_time']);
            $formatted_date = $created_at->format('d-m-Y h:i A');

            $created_at_start = new DateTime($row['end_time']);
            $formatted_date_start = $created_at_start->format('d-m-Y h:i A');

            $startTime = strtotime($row['start_time']);
            $endTime = strtotime($row['end_time']);
            $timeDiffSeconds = $endTime - $startTime;
            $totalTime = gmdate('H:i:s', $timeDiffSeconds);
            $defalut_img = '' . FCPATH . '\assets\img\no_image_found.png';
            $htmlContent .= '<tr>';
            $htmlContent .= '<td  style="width: 40px;" >' . $k++ . '</td>';

            $htmlContent .= '<td  style="width: 80px;">' . htmlspecialchars(isset($row['part_no']) ? $row['part_no'] : '') . '</td>';
            $htmlContent .= '<td  style="width: 120px;">' . htmlspecialchars(isset($row['part_name']) ? $row['part_name'] : '') . '</td>';
            $htmlContent .= '<td  style="width: 80px;">' . htmlspecialchars(isset($row['model']) ? $row['model'] : '') . '</td>';
            $htmlContent .= '<td  style="width: 80px;">' . htmlspecialchars(isset($row['die_no']) ? $row['die_no'] : '') . '</td>';
            $htmlContent .= '<td style="width: 80px;">' . htmlspecialchars(isset($formatted_date) ? $formatted_date : '') . '</td>';
            $htmlContent .= '<td style="width: 80px;">' . htmlspecialchars(isset($formatted_date_start) ? $formatted_date_start : '') . '</td>';
            $htmlContent .= '<td style="width: 80px;">' . htmlspecialchars(isset($totalTime) ? $totalTime : '') . '</td>';
            $htmlContent .= '<td style="width: 80px;">' . htmlspecialchars(isset($row['wrong_pins']) ? $row['wrong_pins'] : 0) . '</td>';
            $htmlContent .= '<td style="width: 80px;">' . htmlspecialchars(isset($row['correct_pins']) ? $row['correct_pins'] : 0) . '</td>';
            $htmlContent .= '<td style="width: 80px;">' . htmlspecialchars(isset($row['pins']) ? count(explode(",", $row['pins'])) : 0) . '</td>';
            $htmlContent .= '<td style="width: 80px;">' . htmlspecialchars(isset($row['correct_pins']) && $row['correct_pins'] > 0 ? number_format($row['correct_pins'] / count(explode(",", $row['pins'])) * 100, 2) : 0) . '</td>';
            $htmlContent .= '<td style="width: 120px;">' . (isset($row['image_url']) ? '<a href="' . base_url() . 'assets/img/' . $row['image_url'] . '" target="_blank"><img src="' . FCPATH . 'assets/img/' . $row['image_url'] . '" height="120" width="120"></a>' : '<img src="' . $defalut_img . '" height="60" width="100">') . '</td>';
            $htmlContent .= '</tr>';
        }

        // print_r($htmlContent);exit;

        $htmlContent .= '</tbody></table>';
        // print_r($htmlContent);exit;
        $pdf_data['pdfdata'] = $htmlContent;

        $this->phpspreadsheet->set_pdf($pdf_data);
    }
}
