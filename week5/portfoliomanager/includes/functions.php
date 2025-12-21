<?php
/**
 * Custom Functions for Student Portfolio Manager
 */

/**
 * Format name by trimming and capitalizing first letter of each word
 * @param string $name
 * @return string
 */
function formatName($name) {
    $name = trim($name);
    $name = ucwords(strtolower($name));
    return $name;
}

/**
 * Validate email address
 * @param string $email
 * @return bool
 */
function validateEmail($email) {
    $email = trim($email);
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Clean skills string by removing extra spaces and special characters
 * @param string $string
 * @return string
 */
function cleanSkills($string) {
    // Trim and remove extra spaces
    $string = trim($string);
    $string = preg_replace('/\s+/', ' ', $string);
    
    // Remove any quotes or special characters that might interfere
    $string = str_replace(['"', "'", "|"], '', $string);
    
    return $string;
}

/**
 * Save student information to file
 * @param string $name
 * @param string $email
 * @param array $skillsArray
 * @return bool
 * @throws Exception
 */
function saveStudent($name, $email, $skillsArray) {
    $filename = 'data/students.txt';
    
    // Format skills array to string
    $skillsString = implode(',', $skillsArray);
    
    // Create data line with pipe delimiter
    $data = $name . '|' . $email . '|' . $skillsString . PHP_EOL;
    
    // Attempt to write to file
    $result = file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
    
    if ($result === false) {
        throw new Exception("Failed to save student data to file.");
    }
    
    return true;
}

/**
 * Upload portfolio file with validation
 * @param array $file - $_FILES array element
 * @return array - ['success' => bool, 'message' => string, 'filename' => string]
 */
function uploadPortfolioFile($file) {
    $uploadDir = 'uploads/';
    $maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
    
    try {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            throw new Exception("No file was uploaded.");
        }
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload error occurred. Error code: " . $file['error']);
        }
        
        // Check file size
        if ($file['size'] > $maxFileSize) {
            throw new Exception("File size exceeds 2MB limit. Your file: " . round($file['size'] / 1024 / 1024, 2) . "MB");
        }
        
        // Get file extension
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        // Validate extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("Invalid file type. Only PDF, JPG, and PNG files are allowed.");
        }
        
        // Validate MIME type
        $fileMimeType = mime_content_type($file['tmp_name']);
        if (!in_array($fileMimeType, $allowedTypes)) {
            throw new Exception("Invalid file format detected.");
        }
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Failed to create uploads directory.");
            }
        }
        
        // Generate unique filename using string functions
        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
        $cleanName = strtolower($cleanName);
        $timestamp = date('Ymd_His');
        $newFilename = $cleanName . '_' . $timestamp . '.' . $fileExtension;
        $destination = $uploadDir . $newFilename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Failed to move uploaded file.");
        }
        
        return [
            'success' => true,
            'message' => "File uploaded successfully!",
            'filename' => $newFilename
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage(),
            'filename' => ''
        ];
    }
}

/**
 * Read all students from file
 * @return array
 */
function getAllStudents() {
    $filename = 'data/students.txt';
    $students = [];
    
    if (!file_exists($filename)) {
        return $students;
    }
    
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        $parts = explode('|', $line);
        
        if (count($parts) === 3) {
            $students[] = [
                'name' => $parts[0],
                'email' => $parts[1],
                'skills' => explode(',', $parts[2])
            ];
        }
    }
    
    return $students;
}
?>