<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Include config - FIXED PATH
    require_once 'Config.php';
    
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        throw new Exception('Invalid request method. Only POST allowed.');
    }
    
    // Get all POST data
    $data = [
        'program_applied' => $_POST['program_applied'] ?? '',
        'last_name' => $_POST['last_name'] ?? '',
        'given_name' => $_POST['given_name'] ?? '',
        'middle_name' => $_POST['middle_name'] ?? '', // ADDED THIS FIELD
        'ext_name' => $_POST['ext_name'] ?? '',
        'gender' => $_POST['gender'] ?? '',
        'civil_status' => $_POST['civil_status'] ?? '',
        'birth_date' => $_POST['birth_date'] ?? '',
        'birth_place' => $_POST['birth_place'] ?? '',
        'nationality' => $_POST['nationality'] ?? '',
        'religion' => $_POST['religion'] ?? '',
        'contact_no' => $_POST['contact_no'] ?? '',
        'email_address' => $_POST['email_address'] ?? '',
        'address' => $_POST['address'] ?? '',
        'residence' => $_POST['residence'] ?? '',
        'indigenous_group' => $_POST['indigenous_group'] ?? '',
        'indigenous_details' => $_POST['indigenous_details'] ?? '',
        'father_name' => $_POST['father_name'] ?? '',
        'father_status' => $_POST['father_status'] ?? '',
        'father_occupation' => $_POST['father_occupation'] ?? '',
        'father_income' => floatval($_POST['father_income'] ?? 0),
        'father_contact' => $_POST['father_contact'] ?? '',
        'mother_name' => $_POST['mother_name'] ?? '',
        'mother_status' => $_POST['mother_status'] ?? '',
        'mother_occupation' => $_POST['mother_occupation'] ?? '',
        'mother_income' => floatval($_POST['mother_income'] ?? 0),
        'mother_contact' => $_POST['mother_contact'] ?? '',
        'guardian_name' => $_POST['guardian_name'] ?? '',
        'guardian_relationship' => $_POST['guardian_relationship'] ?? '',
        'guardian_occupation' => $_POST['guardian_occupation'] ?? '',
        'guardian_income' => floatval($_POST['guardian_income'] ?? 0),
        'guardian_contact' => $_POST['guardian_contact'] ?? '',
        'school_name' => $_POST['school_name'] ?? '',
        'school_address' => $_POST['school_address'] ?? '',
        'lrn' => $_POST['lrn'] ?? '',
        'facebook_url' => $_POST['facebook_url'] ?? '',
        'time_submitted' => $_POST['time_submitted'] ?? '',
        'signature_applicant' => $_POST['signature_applicant'] ?? '',
        'signature_date' => $_POST['signature_date'] ?? '',
        'status' => 'pending'
    ];
    
    // Validate required fields
    $required_fields = [
        'program_applied', 'last_name', 'given_name', 'middle_name', 'gender', 
        'civil_status', 'birth_date', 'birth_place', 'nationality', 'religion', 
        'contact_no', 'email_address', 'address', 'residence', 'indigenous_group', 
        'father_name', 'father_status', 'father_occupation', 'father_income', 
        'father_contact', 'mother_name', 'mother_status', 'mother_occupation', 
        'mother_income', 'mother_contact', 'guardian_name', 'guardian_relationship', 
        'guardian_occupation', 'guardian_income', 'guardian_contact', 'school_name', 
        'school_address', 'lrn', 'facebook_url', 'time_submitted', 'signature_applicant', 
        'signature_date'
    ];
    
    $missing_fields = [];
    foreach ($required_fields as $field) {
        if (empty(trim($data[$field]))) {
            $missing_fields[] = $field;
        }
    }
    
    if (!empty($missing_fields)) {
        throw new Exception("Missing required fields: " . implode(', ', $missing_fields));
    }
    
    // Handle file uploads
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            throw new Exception('Failed to create upload directory');
        }
    }
    
    // Profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
        $profile_pic_name = uniqid() . '_' . basename($_FILES['profile_pic']['name']);
        $data['profile_pic'] = $upload_dir . $profile_pic_name;
        
        if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $data['profile_pic'])) {
            throw new Exception('Failed to upload profile picture');
        }
    } else {
        throw new Exception('Profile picture is required');
    }
    
    // Documents upload
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] == UPLOAD_ERR_OK) {
        $documents_name = uniqid() . '_' . basename($_FILES['documents']['name']);
        $data['documents'] = $upload_dir . $documents_name;
        
        if (!move_uploaded_file($_FILES['documents']['tmp_name'], $data['documents'])) {
            // Clean up profile pic if documents fail
            if (file_exists($data['profile_pic'])) {
                unlink($data['profile_pic']);
            }
            throw new Exception('Failed to upload documents');
        }
    } else {
        // Clean up profile pic if documents are missing
        if (file_exists($data['profile_pic'])) {
            unlink($data['profile_pic']);
        }
        throw new Exception('Documents are required');
    }
    
    // Prepare SQL with all fields including middle_name
    $columns = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    
    $sql = "INSERT INTO enrollments ($columns) VALUES ($placeholders)";
    
    // Log for debugging
    error_log("Enrollment SQL: $sql");
    
    $stmt = $pdo->prepare($sql);
    
    // Bind all parameters
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    
    $result = $stmt->execute();
    
    if ($result && $stmt->rowCount() > 0) {
        $enrollment_id = $pdo->lastInsertId();
        
        echo json_encode([
            'success' => true, 
            'message' => 'Your enrollment has been submitted successfully! Enrollment ID: #' . $enrollment_id,
            'enrollment_id' => $enrollment_id
        ]);
    } else {
        throw new Exception('Failed to save enrollment to database. No rows affected.');
    }
    
} catch (Exception $e) {
    // Log detailed error
    error_log("ENROLLMENT ERROR: " . $e->getMessage());
    error_log("POST Data: " . print_r($_POST, true));
    error_log("FILES Data: " . print_r($_FILES, true));
    
    echo json_encode([
        'success' => false, 
        'message' => 'Submission Error: ' . $e->getMessage()
    ]);
}
?>