<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TMCS - Tanzania Movement of Catholic Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            padding: 0 2rem;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .hero-image {
            position: relative;
            z-index: 2;
            width: 25%;
            max-width: 300px;
        }

        .hero-image-left {
            align-self: flex-start;
            margin-top: 10%;
            height: auto;
            max-height: 400px;
        }

        .hero-image-right {
            align-self: flex-end;
            margin-bottom: 10%;
            height: auto;
            max-height: 400px;
        }

        .side-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .side-image:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
            max-width: 800px;
            flex: 1;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out;
            white-space: nowrap;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 3rem;
            opacity: 0.8;
            line-height: 1.6;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .btn-hero {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 2px solid #667eea;
        }

        .btn-primary-hero {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .btn-primary-hero:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-outline-hero {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline-hero:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                flex-direction: column;
                justify-content: center;
                padding: 1rem;
                min-height: 100vh;
                padding-bottom: 80px; /* Add space for footer */
            }

            .hero-image {
                display: block;
                width: 80%;
                max-width: 250px;
                margin: 1rem auto;
            }

            .hero-image-left {
                align-self: center;
                margin-top: 1rem;
                order: -1;
            }

            .hero-image-right {
                align-self: center;
                margin-bottom: 1rem;
                order: 1;
                margin-top: 1rem; /* Add top margin */
            }

            .hero-content {
                max-width: 100%;
                padding: 1rem;
                order: 0;
            }

            .hero-title {
                font-size: 1.8rem;
                white-space: normal;
                line-height: 1.2;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-description {
                font-size: 1rem;
                margin-bottom: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
                gap: 0.8rem;
            }
            
            .btn-hero {
                width: 200px;
                justify-content: center;
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                padding: 0.5rem;
            }

            .hero-image {
                width: 90%;
                max-width: 200px;
            }

            .hero-title {
                font-size: 1.5rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .hero-description {
                font-size: 0.9rem;
            }
            
            .btn-hero {
                width: 180px;
                padding: 0.7rem 1.2rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 1024px) {
            .hero-image {
                width: 20%;
                max-width: 200px;
            }

            .hero-content {
                max-width: 500px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        
        <!-- Left Image (church2.jpg) -->
        <div class="hero-image hero-image-left">
            <img src="{{ asset('images/church2.jpg') }}" alt="Church Community" class="side-image">
        </div>
        
        <!-- Center Content -->
        <div class="hero-content">
            <h1 class="hero-title">
                <i class="bi bi-mortarboard-fill me-3"></i><span style="color: #FFD700;">Welcome to</span> TMCS TEKU
            </h1>
            <p class="hero-subtitle">Tanzania Movement of Catholic Students</p>
            <p class="hero-description">
                Join our vibrant community of Catholic students across Tanzania. 
                Connect, grow, and serve together in faith and fellowship.
            </p>
            <div class="action-buttons">
                <a href="/register" class="btn-hero btn-primary-hero">
                    <i class="bi bi-person-plus-fill"></i>
                    Register Now
                </a>
                <a href="/login" class="btn-hero btn-outline-hero">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </a>
            </div>
        </div>
        
        <!-- Right Image (church3.jpg) -->
        <div class="hero-image hero-image-right">
            <img src="{{ asset('images/church3.jpg') }}" alt="Church Building" class="side-image">
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p class="footer-text">TMCS-SYSTEM @ 2026 MrNaviGator DigitalHub | 
            <a href="https://web.facebook.com/watson.boniface.593507" target="_blank" class="social-icon" title="Facebook">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="https://www.instagram.com/01mr_nsembo/" target="_blank" class="social-icon" title="Instagram">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="https://twitter.com" target="_blank" class="social-icon" title="Twitter">
                <i class="bi bi-twitter"></i>
            </a>
            <a href="https://wa.me/255716294829" target="_blank" class="social-icon" title="WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </a>
        </p>
    </footer>

    <style>
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #f8f9fa;
        color: #0066cc;
        text-align: center;
        padding: 0.7rem;
        font-size: 0.95rem;
        z-index: 1000;
    }

    .footer-text {
        margin: 0;
        opacity: 0.9;
        font-weight: bold;
        font-family: 'Times New Roman', Times, serif;
        /* font-style: italic; */
        letter-spacing: 0.5px;
    }

    .social-icon {
        color: #0066cc;
        text-decoration: none;
        font-size: 1.1rem;
        margin: 0 0.3rem;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .social-icon:hover {
        color: #0056b3;
        transform: scale(1.2);
    }

    .social-icon:nth-child(1):hover { color: #1877f2; } /* Facebook */
    .social-icon:nth-child(2):hover { color: #e4405f; } /* Instagram */
    .social-icon:nth-child(3):hover { color: #1da1f2; } /* Twitter */
    .social-icon:nth-child(4):hover { color: #25d366; } /* WhatsApp */
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
