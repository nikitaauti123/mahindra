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