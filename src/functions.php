<?php

// FORMATTING FUNCTIONS
function html_escape($text): string {

    $text = $text ?? ''; // If the value passed into function is null set $text to a blank string

    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
}

function format_date(string $string): string {

    $date = date_create_from_format('Y-m-d H:i:s', $string);
    return $date->format('d / m / Y');
}

function create_filename(string $filename, string $uploads): string {
    $basename = pathinfo($filename, PATHINFO_FILENAME);          // Get basename
    $extension = pathinfo($filename, PATHINFO_EXTENSION);         // Get extension
    $filename = $basename . '_' . time() . '.' . $extension;            // New filename

    return $filename;
}

function crop_and_resize_image_gd($orig_path, $new_path, $new_width, $new_height) {
    $image_data = getimagesize($orig_path);                       // Get image data
    $orig_width = $image_data[0];                                 // Image width
    $orig_height = $image_data[1];                                 // Image height
    $media_type = $image_data['mime'];                            // Media type
    $orig_ratio = $orig_width / $orig_height;                     // Ratio of original
    $new_ratio = $new_width / $new_height;                       // Ratio of crop
    // Calculate new size
    if ($new_ratio < $orig_ratio) {                                // If new ratio < orig
        $select_width = $orig_height * $new_ratio;                // Calculate width
        $select_height = $orig_height;                             // Height stays same
        $x_offset = ($orig_width - $select_width) / 2;        // Calculate X Offset
        $y_offset = 0;                                        // Y offset = 0 (top)
    } else {                                                       // Otherwise
        $select_width = $orig_width;                              // Width stays same
        $select_height = $orig_width * $new_ratio;                 // Calculate height
        $x_offset = 0;                                        // X-offset = 0 (left)
        $y_offset = ($orig_height - $select_height) / 2;      // Calculate Y Offset
    }

    switch ($media_type) {                                          // If media type is
        case 'image/gif' :                                         // GIF
            $orig = imagecreatefromgif($orig_path);                // Open GIF
            break;                                                 // End of switch
        case 'image/jpeg' :                                        // JPEG
            $orig = imagecreatefromjpeg($orig_path);               // Open JPEG
            break;                                                 // End of switch
        case 'image/png' :                                         // PNG
            $orig = imagecreatefrompng($orig_path);                // Open PNG
            break;                                                 // End of switch
    }

    $new = imagecreatetruecolor($new_width, $new_height);     // New blank image
    imagecopyresampled($new, $orig, 0, 0, $x_offset, $y_offset, $new_width,
            $new_height, $select_width, $select_height); // Crop and resize
    // Save the image in the correct format
    switch ($media_type) {
        case 'image/gif' : $result = imagegif($new, $new_path);
            break;
        case 'image/jpeg': $result = imagejpeg($new, $new_path);
            break;
        case 'image/png' : $result = imagepng($new, $new_path);
            break;
    }
    return $result;
}
