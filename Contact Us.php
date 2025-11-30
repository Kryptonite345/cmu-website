<!DOCTYPE html>
<html>
<head>
    <title>CONTACT US</title>
    <link rel="stylesheet" href="Contact Us.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body data-page="contact us">
    
    <!-- HEADER -->
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
            <a href="http://localhost/cmu-website/Courses.php" target="_self" class="nav-item">
                <img src="images/courses logo.png" alt="Courses Icon">
                <span>COURSES</span>
            </a>
            <a href="http://localhost/cmu-website/News.php" target="_self" class="nav-item">
                <img src="images/news logo.png" alt="News Icon">
                <span>NEWS</span>
            </a>
            <a href="http://localhost/cmu-website/Contact Us.php" target="_self" class="nav-item">
                <img src="images/mail logo.png" alt="Contact Us Icon">
                <span>CONTACT US</span>
            </a>
            <!-- Admin Portal Link - Only Logo with Fixed Tooltip -->
            <a href="http://localhost/cmu-website/Login.php" target="_self" class="admin-portal-link">
                <svg class="admin-logo" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 5.5V7H9V5.5L3 7V9L9 10.5V12H15V10.5L21 9ZM12 15C7.6 15 4 16.8 4 19V21H20V19C20 16.8 16.4 15 12 15Z" fill="currentColor"/>
                </svg>
                <div class="tooltip">Admin Portal</div>
            </a>
        </div>
    </div>

    <!-- CONTACT SECTION -->
    <section class="heading">
        <h1>Contact Us</h1>
    </section> 
    
    <section class="ftco-section" style="box-shadow: 0 0 12px rgb(2, 7, 83);">
        <div class="container">
            <h2 class="heading-section" style="box-shadow: 0 0 12px rgb(2, 7, 83);"></h2>

            <!-- Loading Indicator -->
            <div class="loading" id="loading">
                <i class="fas fa-spinner fa-spin"></i> Sending your message...
            </div>

            <div class="contact-container" style="box-shadow: 0 0 12px rgb(2, 7, 83);">
                <!-- LEFT BLUE PANEL -->
                <div class="info-wrap">
                    <h3>Let's get in touch</h3>
                    <p style="font-size: 23px;">We're open for any inquiry or suggestion.</p>

                    <div class="dbox">
                        <div class="icon"><span class="fa fa-map-marker"></span></div>
                        <div class="text">
                            <p style="font-size: 22px;"><span style="font-size: 20px;">Address:</span> Pampano cor., Maya-Maya Sts., Longos City of Malabon</p>
                        </div>
                    </div>

                    <div class="dbox">
                        <div class="icon"><span class="fa fa-phone"></span></div>
                        <div class="text">
                            <p style="font-size: 20px;"><span style="font-size: 20px;">Phone:</span> <a href="tel://1234567920">09468293580</a></p>
                        </div>
                    </div>

                    <div class="dbox">
                        <div class="icon"><span class="fa fa-paper-plane"></span></div>
                        <div class="text">
                            <p style="font-size: 20px;"><span style="font-size: 20px;">Email:</span> <a href="mailto:info@yoursite.com">ro@cityofmalabonuniversity.edu.ph</a></p>
                        </div>
                    </div>

                    <div class="dbox">
                        <div class="icon"><span class="fa fa-globe"></span></div>
                        <div class="text">
                            <p style="font-size: 20px;"><span style="font-size: 20px;">Website:</span> <a href="#">https://cityofmalabonuniversity.edu.ph/</a></p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT WHITE PANEL -->
                <div class="contact-wrap" style="box-shadow: 0 0 12px rgb(2, 7, 83);">
                    <h3>Get in touch</h3>
                    <form id="contactForm" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Message" required></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary" id="submitBtn">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- POPUP -->
        <div class="popup" id="popup">
            <img src="images/check.png">
            <h2>Thank You!</h2>
            <p id="popupMessage">Your details have been successfully submitted. Thanks!</p>
            <button type="button" onclick="closePopup()">OK</button>
        </div>
    </section>

    <!-- PRELOADER -->
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

        form.addEventListener("submit", function (event) {
            event.preventDefault(); 
            
            // Show loading indicator
            loading.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.value = 'Sending...';
            
            // Create FormData object
            const formData = new FormData(form);
            
            // Send AJAX request to PHP
            fetch('process_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading indicator
                loading.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.value = 'Send Message';
                
                if (data.success) {
                    // Show success popup
                    popupMessage.textContent = data.message;
                    openPopup();
                    // Reset form
                    form.reset();
                } else {
                    // Show error message
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                // Hide loading indicator
                loading.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.value = 'Send Message';
                
                console.error('Error:', error);
                alert('Sorry, there was an error sending your message. Please try again.');
            });
        });

        function openPopup() {
            popup.classList.add("open-popup");
        }

        function closePopup() {
            popup.classList.remove("open-popup");
        }

        const currentPage = document.body.getAttribute('data-page');
        const navItems = document.querySelectorAll('.nav-bar .nav-item');
    
        navItems.forEach(navItem => {
            const href = navItem.getAttribute('href').toLowerCase().replace('.php', '').replace('.html', '');
            if (currentPage === href) {
                navItem.classList.add('active'); 
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const preloader = document.getElementById('preloader');
            const counter = document.getElementById('preloader-counter');
            const logo = document.getElementById('preloader-logo');
            const links = document.querySelectorAll('a');

            // Hide preloader after page loads
            setTimeout(() => {
                preloader.classList.remove('show');
            }, 1000);

            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    const target = this.getAttribute('target') || '_self'; 

                    if (this.getAttribute('href') && this.getAttribute('href') !== '#') {
                        e.preventDefault(); 
                        preloader.classList.add('show'); 

                        let count = 0;
                        const interval = setInterval(() => {
                            count += 1;
                            counter.textContent = `${count}%`;
                            logo.style.opacity = count / 100;
                            if (count > 80) logo.style.filter = `grayscale(${100 - count}%)`;
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