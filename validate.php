<?php
/**
 * PHP National ID Validator
 * 
 * This script validates Iranian national ID numbers based on official checksum rules.
 * 
 * Author: YoozNet
 * GitHub Repository: https://github.com/shanaqisaeed/PHP-National-ID-Validator
 * License: MIT License (See LICENSE file)
 * 
 * Permission is granted to use this software, provided that proper attribution is given.
 */
function validateNationalID($nationalID) {
    $output = [
        'input' => $nationalID,
        'status' => 'Invalid',
        'steps' => []
    ];
    
    if (!preg_match('/^\d{10}$/', $nationalID)) {
        $output['steps'][] = 'کد ملی باید 10 رقم باشد';
        return $output;
    }
    
    $digits = str_split($nationalID);
    $controlDigit = (int) array_pop($digits); 
    
    $weights = range(10, 2);
    
    $sum = 0;
    foreach ($digits as $index => $digit) {
        $sum += (int)$digit * $weights[$index];
    }
    
    $remainder = $sum % 11;
    
    $expectedControl = ($remainder < 2) ? $remainder : (11 - $remainder);
    
    if ($controlDigit === $expectedControl) {
        $output['status'] = 'Valid';
        $output['steps'][] = 'کد ملی معتبر است';
    } else {
        $output['steps'][] = 'کد ملی نامعتبر است';
    }
    
    return $output;
}

// نمونه تست
$testID = '1234567890';
$result = validateNationalID($testID);
print_r($result);
?>
