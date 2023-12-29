<?php

if (!function_exists('current_page_url')) {

    /**
     * use last_q function to print last query fired on the database.    
     */
    function current_page_url()
    {
        $request = \Config\Services::request();

        $uri = $request->getUri();
        $current_url['path'] = $uri->getPath();
        $current_url['segment'] = $uri->getSegments();
        return $current_url;
    }
}

if (!function_exists('excel_columns')) {

function excel_columns($column, $row_start=1) {
    $result = [];
    $alabets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $alp = [];

    for($i=1;$i<=26;$i++) {
        $alp[] = substr($alabets, ($i-1), 1);
    }

    foreach($column as $key=>$val) {
        if(!is_array($val)) {
            $result[$alp[$key].$row_start] = $val;
        } else {
            foreach($val as $in_key=>$in_val) {
                $result[$alp[$in_key].($row_start+$key)] = $in_val;
            }   
        }
    }
    return $result; 
}
}

if (!function_exists('crop_image')) {

    function crop_image($profile_img, $destination_path = null)
    {
         //$source_image = imagecreatefrompng($profile_img);
         $source_image = create_image_from_file($profile_img);

         $source_width = imagesx($source_image);
         $source_height = imagesy($source_image);
     
         // Calculate the crop dimensions
         $crop_size = 140;
         $crop_x = ($source_width - $crop_size) / 2;
         $crop_y = ($source_height - $crop_size) / 2;
     
         $cropped_image = imagecreatetruecolor($crop_size, $crop_size);
     
         // Crop the source image from the center
         imagecopy($cropped_image, $source_image, 0, 0, $crop_x, $crop_y, $crop_size, $crop_size);
     
         $filename = uniqid('cropped_') . '.jpg';

        // Construct the full path to the destination folder and the cropped image file
        $destination_path = $destination_path . '/' . $filename;

        // Save the cropped image to the destination folder
        imagejpeg($cropped_image, $destination_path);

        // Clean up the resources
        imagedestroy($source_image);

        // Return the path to the uploaded cropped image
        return $filename;
    }
}
if (!function_exists('websocket_js_code')) {
    function websocket_js_code()
    {
        $webSocketURL = $_ENV['WEBSOCKET_URL'];
        return "const webSocketURL = '$webSocketURL';";
    }
}


if (!function_exists('send_email')) {
    function send_email($to, $subject, $message,$attachment)
    {
        $email = \Config\Services::email();
        $init =  $email->initialize([
            'protocol' => 'smtp',
            'SMTPHost' => env('SMTP_HOST'),
            'SMTPPort' => env('SMTP_PORT'),
            'SMTPUser' => env('SMTP_USER'),
            'SMTPPass' => env('SMTP_PASS'),
        ]);
        $email->setFrom(env('FROM_EMAIL'), env('FROM_NAME'));
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->attach($attachment);
        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }
}
if(!function_exists('display_pins')) {
    /**
     * Display pins
     * 
     * @param String $pins_details Object should have each pin current status e.g '{"A":2, "B":0, "C":1}'
     * 
     * @return String html
     */
    function display_pins($pins_details, $class="") {
        $html = '<div class="pins-display-wrapper '.$class.' ">';
        $html .= '<div class="arrow-center">
                    <i>sd</i>
                </div>';
        $html .= '<div class="pins-display no-click">';

        $pin_states = json_decode($pins_details, true);
        
        $col_array = array_merge(range('A', 'Z'), ['AA', 'AB']);
        for ($i = 1; $i <= 14; $i++) {
            for ($j = 0; $j < count($col_array); $j++) {

                $pin_id = $col_array[$j] . $i;
                
                $pin_class = 'pin-box gray-pin';

                if (isset($pin_states[$pin_id])) {
                    $pin_value = $pin_states[$pin_id];    
                    if ($pin_value == 0) {
                        $pin_class = 'pin-box green-pin';
                    } elseif ($pin_value == 1) {
                        $pin_class = 'pin-box red-pin';
                    } elseif ($pin_value == 2) {
                        $pin_class = 'pin-box orange-pin';
                    } elseif ($pin_value == 3) {
                        $pin_class = 'pin-box gray-pin';
                    }
                } 
                
                $html .= '<div id="' . $pin_id . '" title="' . $pin_id . '" class="' . $pin_class . '">' 
                . $pin_id . '</div>';

                if (($j + 1) % 14 == 0 && ($j / 14) % 2 == 0) {
                    $html .= '<div class="x-axis-line"></div>';
                }
            }

            // Add y-axis line after every 8 rows
            if (($i + 1) % 8 == 0) {
                $html .= '<div class="y-axis-line"></div>';
            }
        }
        
        $html .= '</div>';
        $html .= '<div class="arrow-center">
                    <div class="front">Front</div>
                </div>';

        return $html;
    }
}
