<?php
header('Content-Type: application/json');

try {
    require_once 'config.php';
    
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        throw new Exception('Invalid request method');
    }
    
    // Get all form data - match EXACTLY with your database columns
    $program_applied = $_POST['program_applied'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $given_name = $_POST['given_name'] ?? '';
    $middle_name = $_POST['middle_name'] ?? '';
    $ext_name = $_POST['ext_name'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $civil_status = $_POST['civil_status'] ?? '';
    $birth_date = $_POST['birth_date'] ?? '';
    $birth_place = $_POST['birth_place'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $religion = $_POST['religion'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';
    $email_address = $_POST['email_address'] ?? '';
    $address = $_POST['address'] ?? '';
    $residence = $_POST['residence'] ?? '';
    $indigenous_group = $_POST['indigenous_group'] ?? '';
    $indigenous_details = $_POST['indigenous_details'] ?? '';
    $father_name = $_POST['father_name'] ?? '';
    $father_status = $_POST['father_status'] ?? '';
    $father_occupation = $_POST['father_occupation'] ?? '';
    $father_income = $_POST['father_income'] ?? '';
    $father_contact = $_POST['father_contact'] ?? '';
    $mother_name = $_POST['mother_name'] ?? '';
    $mother_status = $_POST['mother_status'] ?? '';
    $mother_occupation = $_POST['mother_occupation'] ?? '';
    $mother_income = $_POST['mother_income'] ?? '';
    $mother_contact = $_POST['mother_contact'] ?? '';
    $guardian_name = $_POST['guardian_name'] ?? '';
    $guardian_relationship = $_POST['guardian_relationship'] ?? '';
    $guardian_occupation = $_POST['guardian_occupation'] ?? '';
    $guardian_income = $_POST['guardian_income'] ?? '';
    $guardian_contact = $_POST['guardian_contact'] ?? '';
    $school_name = $_POST['school_name'] ?? '';
    $school_address = $_POST['school_address'] ?? '';
    $lrn = $_POST['lrn'] ?? '';
    $facebook_url = $_POST['facebook_url'] ?? '';
    $time_submitted = $_POST['time_submitted'] ?? '';
    $signature_applicant = $_POST['signature_applicant'] ?? '';
    $signature_date = $_POST['signature_date'] ?? '';
    
    // Handle file uploads
    $profile_pic = '';
    $documents = '';
    
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
        $profile_pic = $upload_dir . uniqid() . '_' . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic);
    }
    
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] == UPLOAD_ERR_OK) {
        $documents = $upload_dir . uniqid() . '_' . basename($_FILES['documents']['name']);
        move_uploaded_file($_FILES['documents']['tmp_name'], $documents);
    }
    
    // Based on your original table structure, use this SQL:
    $sql = "INSERT INTO enrollments (
        program_applied, last_name, given_name, middle_name, ext_name, gender, civil_status, 
        birth_date, birth_place, nationality, religion, contact_no, email_address, 
        address, residence, indigenous_group, indigenous_details, father_name, 
        father_status, father_occupation, father_income, father_contact, mother_name, 
        mother_status, mother_occupation, mother_income, mother_contact, guardian_name, 
        guardian_relationship, guardian_occupation, guardian_income, guardian_contact, 
        school_name, school_address, lrn, facebook_url, profile_pic, documents, 
        time_submitted, signature_applicant, signature_date, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // 40 parameters total (without the auto-increment id and submitted_at)
    $params = [
        $program_applied, $last_name, $given_name, $middle_name, $ext_name, $gender, $civil_status,
        $birth_date, $birth_place, $nationality, $religion, $contact_no, $email_address,
        $address, $residence, $indigenous_group, $indigenous_details, $father_name,
        $father_status, $father_occupation, $father_income, $father_contact, $mother_name,
        $mother_status, $mother_occupation, $mother_income, $mother_contact, $guardian_name,
        $guardian_relationship, $guardian_occupation, $guardian_income, $guardian_contact,
        $school_name, $school_address, $lrn, $facebook_url, $profile_pic, $documents,
        $time_submitted, $signature_applicant, $signature_date, 'pending' // status
    ];
    
    error_log("Executing SQL with " . count($params) . " parameters");
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($params);
    
    if ($result) {
        echo json_encode([
            'success' => true, 
            'message' => 'Your enrollment has been submitted successfully! It will now appear in the admin panel.'
        ]);
    } else {
        throw new Exception('Failed to save to database');
    }
    
} catch (Exception $e) {
    error_log("Enrollment Error: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>