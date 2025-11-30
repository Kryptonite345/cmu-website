<!DOCTYPE html>
<html>
<head>
    <title>City of Malabon University Enrollment Form</title>
    <link rel="stylesheet" href="Enrollment Form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Additional CSS for Admin Portal link */
        .admin-portal-link {
            position: relative;
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            transition: color 0.3s ease, transform 0.3s ease;
            padding: 5px;
        }
        
        .admin-portal-link .admin-logo {
            height: 24px;
            width: 24px;
            transition: transform 0.3s ease;
            filter: brightness(0) invert(1);
        }
        
        .admin-portal-link .tooltip {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background-color: rgba(0, 43, 92, 0.95);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85em;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1001;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .admin-portal-link:hover .tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(5px);
        }
        
        .admin-portal-link:hover {
            color: #ff9354;
            transform: scale(1.1);
        }
        
        .admin-portal-link:hover .admin-logo {
            transform: scale(1.1);
            filter: brightness(0) sepia(1) hue-rotate(10deg) saturate(5);
        }

        /* SVG Admin Logo */
        .admin-logo {
            display: inline-block;
            width: 24px;
            height: 24px;
        }

        /* File upload info styles */
        .file-info {
            font-size: 0.8em;
            color: #666;
            margin-top: 5px;
        }

        .file-requirements {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #002b5c;
        }

        /* Loading indicator */
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #002b5c;
            background: #f8f9fa;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="images/cmu logo.png" alt="City of Malabon University Logo">
            <div class="logo-text">
                <h4>CITY OF MALABON UNIVERSITY</h4>
                <h5>Pampano St, Maya-Maya St, Malabon, Metro Manila</h5>
            </div>
        </div>
        <div class="nav-bar">
            <a href="Home.html" target="_self" class="nav-item">
                <img src="images/home logo.png" alt="Home Icon">
                <span>HOME</span>
            </a>
            <a href="Admission.html" target="_self" class="nav-item">
                <img src="images/admission logo.png" alt="Admission Icon">
                <span>ADMISSION</span>
            </a>
            <a href="Courses.php" target="_self" class="nav-item">
                <img src="images/courses logo.png" alt="Courses Icon">
                <span>COURSES</span>
            </a>
            <a href="News.php" target="_self" class="nav-item">
                <img src="images/news logo.png" alt="News Icon">
                <span>NEWS</span>
            </a>
            <a href="Contact Us.php" target="_self" class="nav-item">
                <img src="images/mail logo.png" alt="Contact Us Icon">
                <span>CONTACT US</span>
            </a>
            <!-- Admin Portal Link - Only Logo with Fixed Tooltip -->
            <a href="Login.html" target="_self" class="admin-portal-link">
                <svg class="admin-logo" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 5.5V7H9V5.5L3 7V9L9 10.5V12H15V10.5L21 9ZM12 15C7.6 15 4 16.8 4 19V21H20V19C20 16.8 16.4 15 12 15Z" fill="currentColor"/>
                </svg>
                <div class="tooltip">Admin Portal</div>
            </a>
        </div>
    </div>

    <section class="heading">
        <h1>Enrollment Form</h1>
    </section>

    <!-- Loading Indicator -->
    <div class="loading" id="loading">
        <i class="fas fa-spinner fa-spin"></i> Submitting your enrollment...
    </div>

    <div class="form">
        <form id="contactForm" method="POST" enctype="multipart/form-data">
            
            <div>
                <label for="program">Program Applied For:</label><br>
                <select name="program_applied" id="program" required>
                    <option value="">Select Program</option>
                    <optgroup label="COLLEGE OF ARTS AND SCIENCE (CAS)">
                        <option value="Bachelor of Arts in Journalism">Bachelor of Arts in Journalism</option>
                        <option value="Bachelor of Arts in Political Science">Bachelor of Arts in Political Science</option>
                        <option value="Bachelor of Public Administration">Bachelor of Public Administration</option>
                        <option value="Bachelor of Science in Social Work">Bachelor of Science in Social Work</option>
                    </optgroup>
                    <optgroup label="COLLEGE OF CRIMINOLOGY">
                        <option value="Bachelor of Science in Criminology">Bachelor of Science in Criminology</option>
                    </optgroup>
                    <optgroup label="COLLEGE OF BUSINESS AND ACCOUNTANCY (C.B.A)">
                        <option value="B.S.B.A in Financial Management">B.S.B.A in Financial Management</option>
                        <option value="B.S.B.A in Human Resource Management">B.S.B.A in Human Resource Management</option>
                        <option value="B.S.B.A in Marketing Management">B.S.B.A in Marketing Management</option>
                        <option value="Bachelor of Science in Accountancy">Bachelor of Science in Accountancy</option>
                        <option value="Bachelor of Science in Management Accounting">Bachelor of Science in Management Accounting</option>
                    </optgroup>
                    <optgroup label="COLLEGE OF COMPUTER STUDIES (CCS)">
                        <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                    </optgroup>
                    <optgroup label="COLLEGE OF TEACHER EDUCATION (C.T.E)">
                        <option value="Bachelor in Elementary Education">Bachelor in Elementary Education</option>
                        <option value="BSE in English">BSE in English</option>
                        <option value="BSE in Mathematics">BSE in Mathematics</option>
                        <option value="BSE in Social Studies">BSE in Social Studies</option>
                        <option value="Bachelor of Early Childhood Education">Bachelor of Early Childhood Education</option>
                    </optgroup>
                    <optgroup label="SCHOOL OF GRADUATE STUDIES (S.G.S)">
                        <option value="Doctor of Educational Management">Doctor of Educational Management</option>
                        <option value="Doctor of Business Administration">Doctor of Business Administration</option>
                        <option value="Doctor of Public Administration">Doctor of Public Administration</option>
                        <option value="Master of Arts in Educational Management">Master of Arts in Educational Management</option>
                        <option value="Master in Business Administration">Master in Business Administration</option>
                        <option value="Master in Public Administration">Master in Public Administration</option>
                    </optgroup>
                    <optgroup label="SCHOOL OF PROFESSIONAL AND CERTIFICATE PROGRAM">
                        <option value="Professional Education Program">Professional Education Program</option>
                    </optgroup>
                    <optgroup label="POST BACCALAUREATE PROGRAM">
                        <option value="Certificate on Professional Education (C.P.E) 18 units">Certificate on Professional Education (C.P.E) 18 units</option>
                        <option value="Refresher Course 12-15 units">Refresher Course 12-15 units</option>
                    </optgroup>
                </select>
            </div>
    
            <br>

            <div class="bold-heading">PERSONAL INFORMATION</div>
            <div class="form-row">
    <label for="personal_name">Name:</label>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="text" name="given_name" placeholder="Given Name" required>
    <input type="text" name="middle_name" placeholder="Middle Name" required> <!-- ADDED THIS LINE -->
    <input type="text" name="ext_name" placeholder="Ext. Name">
</div>
            <div class="form-row">
                <label>Gender:</label> 
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                
                <label>Civil Status:</label> 
                <select name="civil_status" required>
                    <option value="">Select Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="widowed">Widowed</option>
                    <option value="separated">Separated</option>
                </select>
                
                <label>Date of Birth:</label> 
                <input type="date" name="birth_date" required>
            </div>
            <div class="form-row">
                <label>Place of Birth:</label> 
                <input type="text" name="birth_place" required>
                <label>Nationality:</label> 
                <input type="text" name="nationality" required>
                <label>Religion:</label> 
                <input type="text" name="religion" required>
            </div>
            <div class="form-row">
                <label>Cel/Tel No.:</label> 
                <input type="text" name="contact_no" required>
                <label>Email Address:</label> 
                <input type="email" name="email_address" required>
            </div>
            <div class="form-row">
                <label>Permanent Address:</label>
                <input type="text" name="address" placeholder="No., Street, Barangay, City, Province, Zipcode" required style="width: 70%;">
            </div>
            <div class="form-row">
                <label>Residence:</label>
                <div class="radio-group">
                    <input type="radio" name="residence" value="with_parents" id="res_parents" required>
                    <label for="res_parents">With Parents</label>
                    
                    <input type="radio" name="residence" value="with_relatives" id="res_relatives" required>
                    <label for="res_relatives">With Relatives</label>
                    
                    <input type="radio" name="residence" value="with_guardian" id="res_guardian" required>
                    <label for="res_guardian">With Guardian</label>
                    
                    <input type="radio" name="residence" value="boarding" id="res_boarding" required>
                    <label for="res_boarding">Boarding</label>
                </div>
            </div>
            <div class="form-row">
                <label>Are you a member of any indigenous group?</label>
                <div class="radio-group">
                    <input type="radio" name="indigenous_group" value="yes" id="indigenous_yes" required>
                    <label for="indigenous_yes">YES</label>
                    
                    <input type="radio" name="indigenous_group" value="no" id="indigenous_no" required>
                    <label for="indigenous_no">NO</label>
                </div>
                <span id="indigenous_specify" style="display: none;">
                    If YES, please specify: <input type="text" name="indigenous_details">
                </span>
            </div>

            <br>

            <div class="bold-heading">FAMILY BACKGROUND</div>
            <div class="form-row">
                <label for="father_name">Father's Name:</label>
                <input type="text" id="father_name" name="father_name" required>
                <div class="radio-group">
                    <input type="radio" name="father_status" value="living" id="father_living" required>
                    <label for="father_living">Living</label>
                    
                    <input type="radio" name="father_status" value="deceased" id="father_deceased" required>
                    <label for="father_deceased">Deceased</label>
                </div>
            </div>
            <div class="form-row">
                <label>Occupation:</label> 
                <input type="text" name="father_occupation" required>
                <label>Monthly Income:</label> 
                <input type="number" name="father_income" required>
                <label>Contact No:</label> 
                <input type="text" name="father_contact" required>
            </div>

            <div class="form-row">
                <label for="mother_name">Mother's Name:</label>
                <input type="text" id="mother_name" name="mother_name" required>
                <div class="radio-group">
                    <input type="radio" name="mother_status" value="living" id="mother_living" required>
                    <label for="mother_living">Living</label>
                    
                    <input type="radio" name="mother_status" value="deceased" id="mother_deceased" required>
                    <label for="mother_deceased">Deceased</label>
                </div>
            </div>
            <div class="form-row">
                <label>Occupation:</label> 
                <input type="text" name="mother_occupation" required>
                <label>Monthly Income:</label> 
                <input type="number" name="mother_income" required>
                <label>Contact No:</label> 
                <input type="text" name="mother_contact" required>
            </div>
            
            <div class="form-row">
                <label for="guardian_name">Guardian's Name:</label>
                <input type="text" id="guardian_name" name="guardian_name" required>
                <label>Relationship:</label> 
                <input type="text" name="guardian_relationship" required>
            </div>
            <div class="form-row">
                <label>Occupation:</label> 
                <input type="text" name="guardian_occupation" required>
                <label>Monthly Income:</label> 
                <input type="number" name="guardian_income" required>
                <label>Contact No:</label> 
                <input type="text" name="guardian_contact" required>
            </div>

            <br>

            <div class="bold-heading">EDUCATIONAL BACKGROUND</div>
            <div class="form-row">
                <label for="school_name">Last school attended or where you are currently completing Secondary Level Education:</label>
            </div>
            <div class="form-row">
                <label>Name of School:</label>
                <input type="text" id="school_name" name="school_name" required style="width: 60%;">
            </div>
            <div class="form-row">
                <label>Complete Address:</label>
                <input type="text" name="school_address" required style="width: 60%;">
            </div>
            <div class="form-row">
                <label>Learner's Reference No.:</label>
                <input type="text" name="lrn" required>
            </div>

            <br>

            <div class="bold-heading">OTHER INFO</div>
            <div class="form-row">
                <label>Facebook:</label>
                <input type="url" name="facebook_url" required style="width: 60%;">
            </div>

            <br>

            <div class="no-print">
                <div class="bold-heading">PROFILE // FILE // TIME SUBMITTED</div>
                
                <div class="file-requirements">
                    <strong>File Requirements:</strong>
                    <ul style="margin: 5px 0; padding-left: 20px;">
                        <li>2x2 Picture: Max 5MB, JPG/PNG format</li>
                        <li>Documents: Max 10MB each, PDF/DOCX format</li>
                    </ul>
                </div>
                
                <div class="form-row">
                    <label>Upload Your 2x2 Picture:</label>
                    <input type="file" id="profile_pic" name="profile_pic" accept=".png, .jpg, .jpeg" required>
                    <div class="file-info">Accepted formats: JPG, PNG | Max size: 5MB</div>
                </div>
                <div class="form-row">
                    <label>Upload Your Documents:</label>
                    <input type="file" name="documents" accept=".docx, .pdf" required>
                    <div class="file-info">Accepted formats: PDF, DOCX | Max size: 10MB</div>
                </div>
                <div class="form-row">
                    <label>Time Submitted:</label>
                    <input type="time" name="time_submitted" required>
                </div>
            </div>

            <br>

            <div>
                <p><i>
                    <input type="checkbox" name="check" id="check" required>
                    I hereby confirm that all the information I have provided is accurate, and any discrepancies may result in the cancellation of my admission.
                </i></p>

                <br>

                <div class="signature-section">
                    <div class="signature-box">
                        <input type="text" class="signature-input" name="signature_applicant" placeholder=" " required>
                        <span class="signature-label">Applicant</span>
                        <span class="sub-label">(Signature over Printed Name)</span>
                    </div>
                    
                    <div class="signature-box">
                        <input type="date" class="signature-input" name="signature_date" placeholder=" " required>
                        <span class="signature-label">Date</span>
                    </div>
                </div>
            </div>

            <br><br>

            <div class="btns">
                <input type="reset" name="reset" id="reset" value="RESET">
                <input type="submit" name="submit" id="submitBtn" value="SUBMIT" class="submit">
                <button type="button" id="printBtn" name="print" style="padding: 0px 28px 0px 28px; border: none; border-radius: 4px; font-size: 13px; cursor: pointer; box-shadow: 0 0 8px rgba(2, 7, 83, 0.527); transition: background-color 0.3s, transform 0.2s;">PRINT</button>
            </div>
        </form>
        
        <!-- POPUP -->
        <div class="popup" id="popup">
            <img src="images/check.png">
            <h2>Thank You!</h2>
            <p id="popupMessage">Your enrollment has been successfully submitted!</p>
            <button type="button" onclick="closePopup()">OK</button>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About CMU</h3>
                <ul>
                    <li><a href="#">Facts & History</a></li>
                    <li><a href="#">Vision and Mission</a></li>
                    <li><a href="#">Transparency Seal</a></li>
                    <li><a href="#">Careers @ CMU</a></li>
                </ul>
            </div>
    
            <div class="footer-section">
                <h3>Student Life</h3>
                <ul>
                    <li><a href="#">Programs Offerings</a></li>
                    <li><a href="#">Sports Program</a></li>
                    <li><a href="#">Become a CMU Student</a></li>
                    <li><a href="#">Downloadable Forms</a></li>
                </ul>
            </div>
    
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="#"><i class="fab fa-youtube"></i> YouTube</a>
                    <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
                </div>
            </div>
    
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:email@cmu.edu.ph">Email Us</a></li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <address>
                            Pampano cor.,<br>
                            Maya-Maya Sts., Longos<br>
                            City of Malabon
                        </address>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <img src="images/CMU_white logo.png" alt="CMU Logo" class="footer-logo">
            <p class="copyright-text">Copyright © 2024 City of Malabon University. All Rights Reserved</p>
        </div>
    </footer>
    
    <div class="preloader" id="preloader">
        <img src="images/cmu logo.png" alt="Loading Logo" id="preloader-logo">
        <div class="counter" id="preloader-counter">0%</div>
    </div>
    
    <script>
    const form = document.getElementById("contactForm");
    const popup = document.getElementById("popup");
    const loading = document.getElementById("loading");
    const submitBtn = document.getElementById("submitBtn");
    const popupMessage = document.getElementById("popupMessage");

    // File validation function
    function validateFiles() {
        const picFile = document.getElementById('profile_pic').files[0];
        const docFiles = document.querySelector('input[name="documents"]').files[0];
        
        // Validate picture
        if (picFile) {
            const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validImageTypes.includes(picFile.type)) {
                alert('Please upload a valid image file (JPG, JPEG or PNG) for your 2x2 picture.');
                return false;
            }
            
            if (picFile.size > 5000000) {
                alert('Picture file is too large. Maximum size is 5MB.');
                return false;
            }
        } else {
            alert('Please upload your 2x2 picture.');
            return false;
        }
        
        // Validate documents
        if (docFiles) {
            const validDocTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!validDocTypes.includes(docFiles.type)) {
                alert('Please upload only PDF or DOCX files for documents.');
                return false;
            }
            
            if (docFiles.size > 10000000) {
                alert('Document file is too large. Maximum size is 10MB.');
                return false;
            }
        } else {
            alert('Please upload your documents.');
            return false;
        }
        
        return true;
    }

    // Main form validation
    function validateForm() {
        const requiredFields = form.querySelectorAll('[required]');
        for (let field of requiredFields) {
            if (!field.value.trim()) {
                alert('Please fill in all required fields.');
                field.focus();
                return false;
            }
        }
        
        const checkBox = document.getElementById('check');
        if (!checkBox.checked) {
            alert('Please confirm that all information is accurate.');
            checkBox.focus();
            return false;
        }
        
        // Validate files
        if (!validateFiles()) {
            return false;
        }
        
        return true;
    }

    // EXACT SAME PATTERN AS CONTACT US WITH BETTER ERROR HANDLING
    form.addEventListener("submit", function (event) {
        event.preventDefault(); 
        
        // Validate required fields and files
        if (!validateForm()) {
            return;
        }
        
        // Show loading indicator
        loading.style.display = 'block';
        submitBtn.disabled = true;
        submitBtn.value = 'SUBMITTING...';
        
        // Create FormData object
        const formData = new FormData(form);
        
        console.log('Submitting enrollment form...');
        
        // Send AJAX request to PHP with better error handling
        fetch('save_enrollment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status, response.statusText);
            
            // First get the response as text to handle both JSON and non-JSON responses
            return response.text().then(text => {
                console.log('Raw server response:', text);
                
                // Try to parse as JSON
                try {
                    const data = JSON.parse(text);
                    return {
                        success: true,
                        data: data
                    };
                } catch (e) {
                    // If it's not JSON, return the raw text as error
                    return {
                        success: false,
                        error: 'Server returned non-JSON response. This usually means there is a PHP error. Check the response in browser console.'
                    };
                }
            });
        })
        .then(result => {
            console.log('Processed result:', result);
            
            // Hide loading indicator
            loading.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.value = 'SUBMIT';
            
            if (result.success && result.data) {
                const data = result.data;
                
                if (data.success) {
                    // Show success popup
                    popupMessage.textContent = data.message;
                    openPopup();
                    // Reset form
                    form.reset();
                    
                    // Reset dates to current values
                    setTimeout(() => {
                        const today = new Date().toISOString().split('T')[0];
                        document.querySelector('input[name="signature_date"]').value = today;
                        const now = new Date();
                        const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                                         now.getMinutes().toString().padStart(2, '0');
                        document.querySelector('input[name="time_submitted"]').value = timeString;
                    }, 100);
                } else {
                    // Show error message from PHP
                    alert('Error: ' + (data.message || 'Unknown error occurred'));
                }
            } else {
                // Show non-JSON error
                alert('Server Error: ' + result.error + '\n\nPlease check the browser console for details and contact support if the problem continues.');
            }
        })
        .catch(error => {
            console.error('Network/Fetch Error:', error);
            
            // Hide loading indicator
            loading.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.value = 'SUBMIT';
            
            alert('Network Error: Unable to connect to the server. Please check your internet connection and try again.\n\nError: ' + error.message);
        });
    });

    function openPopup() {
        popup.classList.add("open-popup");
    }

    function closePopup() {
        popup.classList.remove("open-popup");
    }

    // Show/hide indigenous group details
    document.querySelectorAll('input[name="indigenous_group"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('indigenous_specify').style.display = 
                this.value === 'yes' ? 'inline' : 'none';
        });
    });

    // Real-time file validation
    document.getElementById('profile_pic').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validImageTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, JPEG or PNG).');
                this.value = '';
            } else if (file.size > 5000000) {
                alert('File is too large. Maximum size is 5MB.');
                this.value = '';
            }
        }
    });

    document.querySelector('input[name="documents"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const validDocTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!validDocTypes.includes(file.type)) {
                alert('Please select only PDF or DOCX files.');
                this.value = '';
            } else if (file.size > 10000000) {
                alert('File is too large. Maximum size is 10MB.');
                this.value = '';
            }
        }
    });

    // PRINT FUNCTION
    document.getElementById("printBtn").addEventListener("click", function () {
        // Hide buttons and popup temporarily for clean print view
        const btns = document.querySelector(".btns");
        const popup = document.querySelector(".popup");
        const footer = document.querySelector("footer");
        const header = document.querySelector(".header");
        const noPrintElements = document.querySelectorAll(".no-print");

        btns.style.display = "none";
        if (popup) popup.style.display = "none";
        if (footer) footer.style.display = "none";
        if (header) header.style.display = "none";
        noPrintElements.forEach(el => {
            el.style.display = "none";
        });

        window.print(); // open browser print dialog

        // Restore after printing
        setTimeout(() => {
            btns.style.display = "flex";
            if (popup) popup.style.display = "block";
            if (footer) footer.style.display = "block";
            if (header) header.style.display = "flex";
            noPrintElements.forEach(el => {
                el.style.display = "block";
            });
        }, 1000);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        const counter = document.getElementById('preloader-counter');
        const logo = document.getElementById('preloader-logo');
        const links = document.querySelectorAll('a');

        // Set today's date as default for signature date
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="signature_date"]').value = today;

        // Set current time as default for submission time
        const now = new Date();
        const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                         now.getMinutes().toString().padStart(2, '0');
        document.querySelector('input[name="time_submitted"]').value = timeString;

        // Hide loading indicator initially
        loading.style.display = 'none';

        links.forEach(link => {
            link.addEventListener('click', function (e) {
                const target = this.getAttribute('target') || '_self'; 

                if (this.getAttribute('href') && this.getAttribute('href') !== '#' && !this.getAttribute('href').includes('mailto:')) {
                    e.preventDefault(); 

                    preloader.classList.add('show'); 

                    let count = 0;
                    const interval = setInterval(() => {
                        count += 1;
                        counter.textContent = `${count}%`;

                        logo.style.opacity = count / 100;
                        if (count > 80) {
                            logo.style.filter = `grayscale(${100 - count}%)`;
                        }

                        if (count >= 100) {
                            clearInterval(interval);
                            preloader.classList.remove('show');

                            if (target === '_blank') {
                                window.open(this.href, '_blank'); 
                            } else {
                                window.location.href = this.href; 
                            }
                        }
                    }, 20); 
                }
            });
        });
    });
</script>
</body>
</html>