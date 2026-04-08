<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - TMCS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Cache Control Headers -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #4a69bd 0%, #6c5ce7 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-toggle {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .profile-toggle:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
        }

        .profile-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .dashboard-container {
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
            min-height: 50vh;
        }

        .welcome-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #4a69bd, #6c5ce7, #a29bfe);
        }

        .welcome-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #636e72;
            font-size: 1rem;
        }

        .sidebar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            position: sticky;
            top: 20px;
        }

        .sidebar-header {
            background: linear-gradient(135deg, #4a69bd 0%, #6c5ce7 100%);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 15px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.15);
        }

        /* Standardized Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
            font-weight: 500;
            line-height: 1.5;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a69bd 0%, #6c5ce7 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            min-height: 40px;
            min-width: 120px;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            min-height: 40px;
            min-width: 120px;
        }

        .btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .btn-light {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            min-height: 36px;
            min-width: 100px;
        }

        .btn-light:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-primary {
            border: 2px solid #6c5ce7;
            color: #6c5ce7;
            background: transparent;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            min-height: 36px;
            min-width: 100px;
        }

        .btn-outline-primary:hover {
            background: #6c5ce7;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(108, 92, 231, 0.3);
        }

        .btn-outline-danger {
            border: 2px solid #dc3545;
            color: #dc3545;
            background: transparent;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            min-height: 36px;
            min-width: 100px;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(220, 53, 69, 0.3);
        }

        .btn-close {
            background: none;
            border: none;
            opacity: 0.7;
            font-size: 16px;
            padding: 6px;
            border-radius: 4px;
            min-height: 28px;
            min-width: 28px;
            transition: all 0.2s ease;
        }

        .btn-close:hover {
            opacity: 1;
            background: rgba(0, 0, 0, 0.1);
        }

        /* Ensure all buttons in flex containers have equal height */
        .d-flex .btn {
            flex: 1;
        }

        .list-group-item {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }

        
        .payment-form-section {
            display: none;
        }

        .information-form-section {
            display: none;
        }

        .my-profile-section {
            display: none;
        }

        .payment-form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .payment-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid;
        }

        .payment-card.success {
            border-left-color: #28a745;
        }

        .payment-card.pending {
            border-left-color: #ffc107;
        }

        .payment-card.failed {
            border-left-color: #dc3545;
        }

        .status-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
            border-radius: 15px;
            font-weight: 600;
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            padding: 1rem;
            text-align: center;
            border: 2px solid #4a69bd;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(74, 105, 189, 0.15);
            border-color: #2d3436;
        }

        .stats-card h5 {
            color: #2d3436;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stats-card p {
            color: #636e72;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .stats-card small {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .stats-card i {
            color: #4a69bd;
            opacity: 0.7;
        }

        .filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .year-filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            border: 1px solid #e9ecef;
        }

        .year-group {
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }

        .year-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            font-weight: 600;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .year-stats {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
        }

        .year-payments {
            padding: 1rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 1rem;
        }

        .chart-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 1rem;
            text-align: center;
        }

        .attachment-preview {
            max-width: 150px !important;
            max-height: 150px !important;
            width: auto !important;
            height: auto !important;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }

        .attachment-preview-pdf {
            max-width: 150px !important;
            max-height: 150px !important;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            background: #f8f9fa;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }

        #attachmentPreview {
            max-width: 170px;
            margin-top: 5px !important;
        }

        #attachmentPreview .card {
            border: 1px solid #e9ecef;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }

        #attachmentPreview .card-body {
            padding: 5px !important;
        }

        #attachmentPreview .card-header {
            padding: 4px 8px !important;
            background: #f8f9fa !important;
            border-bottom: 1px solid #e9ecef;
        }

        #attachmentPreview .card-header h6 {
            font-size: 0.8rem !important;
        }

        #attachmentPreview .btn {
            padding: 2px 6px !important;
            font-size: 0.7rem !important;
        }

        /* Responsive Design for All Devices */
        @media (max-width: 1200px) {
            .dashboard-container {
                padding: 0.8rem;
            }
            
            .stats-card {
                padding: 0.8rem;
            }
            
            .stats-card h5 {
                font-size: 1.1rem;
            }
            
            .stats-card p {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 992px) {
            .dashboard-container {
                padding: 0.6rem;
            }
            
            .welcome-card {
                padding: 1.2rem;
            }
            
            .welcome-title {
                font-size: 1.3rem;
            }
            
            .payment-form-card {
                padding: 1.5rem;
            }
            
            .btn-primary, .btn-secondary {
                padding: 8px 16px;
                font-size: 13px;
                min-height: 36px;
                min-width: 100px;
            }
            
            .btn-light, .btn-outline-primary, .btn-outline-danger {
                padding: 6px 12px;
                font-size: 12px;
                min-height: 32px;
                min-width: 80px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 0.4rem;
            }
            
            .welcome-card {
                padding: 1rem;
            }
            
            .welcome-title {
                font-size: 1.2rem;
            }
            
            .sidebar {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .payment-form-card {
                padding: 1rem;
            }
            
            .stats-card {
                padding: 0.6rem;
                margin-bottom: 0.5rem;
                text-align: left;
                display: flex;
                align-items: center;
                gap: 12px;
            }
            
            .stats-card h5 {
                font-size: 1.1rem;
                margin-bottom: 0.2rem;
            }
            
            .stats-card p {
                font-size: 0.85rem;
                margin-bottom: 0.1rem;
            }
            
            .stats-card small {
                font-size: 0.75rem;
            }
            
            .stats-card i {
                font-size: 1.5rem;
                opacity: 0.8;
                margin-left: auto;
            }
            
            .d-flex.gap-2 {
                flex-direction: column;
            }
            
            .d-flex.gap-2 .btn {
                width: 100%;
            }
            
            .year-header {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
            
            .year-stats {
                flex-direction: column;
                gap: 0.5rem;
                font-size: 0.8rem;
            }
            
            .payment-card {
                padding: 0.8rem;
                margin-bottom: 0.8rem;
            }
            
            .payment-card .row {
                font-size: 0.85rem;
            }
            
            .payment-card h6 {
                font-size: 0.9rem;
            }
            
            .payment-card small {
                font-size: 0.75rem;
            }
            
            .status-badge {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
            }
            
            .btn-sm {
                padding: 6px 10px;
                font-size: 11px;
                min-height: 30px;
                min-width: 70px;
            }
        }

        @media (max-width: 576px) {
            .dashboard-container {
                padding: 0.3rem;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .profile-toggle {
                padding: 0.3rem 0.6rem;
                font-size: 0.85rem;
            }
            
            .profile-img {
                width: 28px;
                height: 28px;
            }
            
            .welcome-card {
                padding: 0.8rem;
            }
            
            .welcome-title {
                font-size: 1.1rem;
            }
            
            .welcome-subtitle {
                font-size: 0.85rem;
            }
            
            .sidebar {
                padding: 0.8rem;
                margin-bottom: 1rem;
            }
            
            .sidebar-header {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
            
            .list-group-item {
                padding: 0.6rem 0.8rem;
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }
            
            .payment-form-card {
                padding: 0.75rem !important;
            }
            
            .payment-form-card h4 {
                font-size: 1.1rem !important;
            }
            
            .announcements-section {
                padding: 0.75rem !important;
            }
            
            .announcements-section h4 {
                font-size: 1.1rem !important;
            }
            
            .announcement-header {
                margin-bottom: 0.5rem !important;
            }
            
            .announcement-title-row {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                margin-bottom: 0.25rem !important;
                flex-wrap: nowrap !important;
                gap: 0.5rem !important;
            }
            
            .announcement-title-row .announcement-title {
                flex: 1 !important;
                min-width: 0 !important;
                margin-bottom: 0 !important;
                font-size: 0.9rem !important;
                font-weight: 600 !important;
                color: #2c3e50 !important;
                line-height: 1.2 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }
            
            .announcement-title-row .priority-badge {
                flex-shrink: 0 !important;
                font-size: 0.7rem !important;
                padding: 0.2rem 0.4rem !important;
                border-radius: 0.25rem !important;
            }
            
            .announcement-meta {
                font-size: 0.7rem !important;
                color: #7f8c8d !important;
                line-height: 1.2 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                display: flex !important;
                flex-wrap: nowrap !important;
                gap: 0.5rem !important;
            }
            
            .announcement-meta i {
                flex-shrink: 0 !important;
            }
            
            .payment-form-section .btn-sm {
                font-size: 0.75rem !important;
                padding: 0.3rem 0.5rem !important;
                min-height: 32px !important;
            }
            
            .payment-form-section .form-label {
                font-size: 0.75rem !important;
                margin-bottom: 0.3rem !important;
                font-weight: 600 !important;
            }
            
            .payment-form-section .form-control,
            .payment-form-section .form-select {
                font-size: 0.8rem !important;
                padding: 0.4rem 0.5rem !important;
                min-height: 36px !important;
                border-radius: 0.375rem !important;
            }
            
            .payment-form-section .form-control::placeholder {
                font-size: 0.75rem !important;
            }
            
            .payment-form-section textarea.form-control {
                min-height: 80px !important;
                font-size: 0.8rem !important;
                padding: 0.4rem 0.5rem !important;
                line-height: 1.2 !important;
            }
            
            .payment-form-section .btn {
                font-size: 0.8rem !important;
                padding: 0.5rem 0.8rem !important;
                min-height: 36px !important;
                border-radius: 0.375rem !important;
            }
            
            .payment-form-section .btn-primary {
                font-size: 0.85rem !important;
                padding: 0.6rem 1rem !important;
                min-height: 40px !important;
                font-weight: 600 !important;
            }
            
            .payment-form-section .btn-secondary {
                font-size: 0.8rem !important;
                padding: 0.5rem 0.8rem !important;
                min-height: 36px !important;
            }
            
                min-height: 32px !important;
            }
            
            .payment-form-section .alert {
                font-size: 0.8rem !important;
                padding: 0.5rem 0.75rem !important;
            }
            
            .payment-form-section .alert h6 {
                font-size: 0.85rem !important;
            }
            
            .payment-form-section .card {
                margin-bottom: 0.75rem !important;
            }
            
            .payment-form-section .card-header {
                padding: 0.5rem 0.75rem !important;
            }
            
            .payment-form-section .card-header h6 {
                font-size: 0.8rem !important;
            }
            
            .payment-form-section .card-body {
                padding: 0.5rem !important;
            }
            
            .payment-form-section .row.g-3 > * {
                padding-top: 0.5rem !important;
                padding-bottom: 0 !important;
            }
            
            .payment-form-section input[type="file"] {
                font-size: 0.75rem !important;
                padding: 0.3rem !important;
            }
            
            .payment-form-section .attachment-preview {
                margin-top: 0.5rem !important;
            }
            
            .payment-form-section .attachment-preview .card {
                border-radius: 0.375rem !important;
            }
            
            .payment-form-section .attachment-preview img {
                max-height: 120px !important;
            }
            
            .payment-form-section .attachment-preview .btn {
                font-size: 0.7rem !important;
                padding: 0.25rem 0.5rem !important;
                min-height: 28px !important;
            }
            
            .form-control, .form-select {
                padding: 6px 10px;
                font-size: 0.8rem;
            }
            
            .stats-card {
                padding: 0.5rem;
                margin-bottom: 0.6rem;
            }
            
            .stats-card h5 {
                font-size: 0.9rem;
            }
            
            .stats-card p {
                font-size: 0.75rem;
            }
            
            .stats-card i {
                font-size: 1rem;
            }
            
            .btn-primary, .btn-secondary {
                padding: 12px 16px;
                font-size: 12px;
                min-height: 44px;
                min-width: 100%;
                margin-bottom: 0.5rem;
                border-radius: 6px;
            }
            
            .btn-light, .btn-outline-primary, .btn-outline-danger {
                padding: 10px 12px;
                font-size: 11px;
                min-height: 40px;
                min-width: 100%;
                margin-bottom: 0.3rem;
                border-radius: 6px;
            }
            
            .btn-close {
                font-size: 14px;
                padding: 4px;
                min-height: 24px;
                min-width: 24px;
            }
            
            .year-filter-section {
                padding: 0.8rem;
            }
            
            .year-filter-section .row {
                gap: 0.5rem;
            }
            
            .year-filter-section .col-md-6 {
                margin-bottom: 0.5rem;
            }
            
            .year-header {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
            
            .year-stats {
                font-size: 0.75rem;
                flex-wrap: wrap;
            }
            
            .payment-card {
                padding: 0.6rem;
                margin-bottom: 0.6rem;
            }
            
            .payment-card .row {
                font-size: 0.8rem;
                gap: 0.3rem;
            }
            
            .payment-card .col-md-2,
            .payment-card .col-md-4 {
                margin-bottom: 0.5rem;
            }
            
            .payment-card h6 {
                font-size: 0.85rem;
                margin-bottom: 0.2rem;
            }
            
            .payment-card small {
                font-size: 0.7rem;
            }
        }

        /* Modern Payment Cards */
        .payment-card-modern {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 16px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .payment-card-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            border-color: #007bff;
        }

        .payment-card-modern.success {
            border-left: 4px solid #28a745;
        }

        .payment-card-modern.pending {
            border-left: 4px solid #ffc107;
        }

        .payment-card-modern.failed {
            border-left: 4px solid #dc3545;
        }

        .payment-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .payment-id-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .payment-id {
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .payment-id i {
            color: #007bff;
            font-size: 18px;
        }

        .payment-status .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .payment-card-body {
            padding: 20px;
        }

        .payment-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .payment-detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 500;
            color: #212529;
            display: flex;
            align-items: center;
        }

        .amount-value {
            font-size: 16px;
            font-weight: 700;
            color: #28a745;
        }

        .payment-user-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid #e9ecef;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 20px;
        }

        .user-details .user-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 2px;
        }

        .user-details small {
            font-size: 12px;
        }

        .action-btn {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,123,255,0.3);
        }

        /* Responsive Design for Modern Cards */
        @media (max-width: 768px) {
            .payment-details-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            
            .payment-user-section {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            
            .payment-card-header {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
            
            .payment-id-section {
                width: 100%;
                justify-content: space-between;
            }
            
            .user-info {
                width: 100%;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Extra Small Screens */
        @media (max-width: 576px) {
            .dashboard-container {
                padding: 0.2rem;
            }
            
            .payment-card-modern {
                margin-bottom: 12px;
                border-radius: 8px;
            }
            
            .payment-card-header {
                padding: 12px 16px;
            }
            
            .payment-card-body {
                padding: 16px;
            }
            
            .payment-details-grid {
                gap: 8px;
            }
            
            .payment-detail-item {
                margin-bottom: 8px;
            }
            
            .detail-label {
                font-size: 10px;
                margin-bottom: 2px;
            }
            
            .detail-value {
                font-size: 13px;
            }
            
            .amount-value {
                font-size: 14px;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 18px;
            }
            
            .user-details .user-name {
                font-size: 14px;
            }
            
            .user-details small {
                font-size: 11px;
            }
            
            .action-btn {
                padding: 10px 16px;
                font-size: 13px;
            }
            
            .payment-id {
                font-size: 14px;
            }
            
            .payment-id i {
                font-size: 16px;
            }
            
            .status-badge {
                font-size: 11px;
                padding: 4px 8px;
            }
        }

        /* Ultra Small Screens */
        @media (max-width: 480px) {
            .payment-card-modern {
                border-radius: 6px;
                margin-bottom: 10px;
            }
            
            .payment-card-header {
                padding: 10px 12px;
            }
            
            .payment-card-body {
                padding: 12px;
            }
            
            .payment-details-grid {
                gap: 6px;
            }
            
            .detail-label {
                font-size: 9px;
            }
            
            .detail-value {
                font-size: 12px;
            }
            
            .amount-value {
                font-size: 13px;
            }
            
            .user-avatar {
                width: 30px;
                height: 30px;
                font-size: 16px;
            }
            
            .user-details .user-name {
                font-size: 13px;
            }
            
            .user-details small {
                font-size: 10px;
            }
            
            .action-btn {
                padding: 8px 12px;
                font-size: 12px;
            }
            
            .payment-id {
                font-size: 13px;
            }
            
            .payment-id i {
                font-size: 14px;
            }
            
            .status-badge {
                font-size: 10px;
                padding: 3px 6px;
            }
        }
                font-size: 1rem;
            }
            
            .empty-state p {
                font-size: 0.8rem;
            }
            
            .empty-state i {
                font-size: 2rem;
            }
            
            .chart-container {
                height: 250px;
            }
            
            .chart-title {
                font-size: 0.9rem;
            }
            
            .attachment-preview {
                max-height: 120px;
            }
            
            .attachment-preview-pdf {
                height: 120px;
            }
        }

        /* Touch-friendly adjustments for mobile */
        @media (hover: none) and (pointer: coarse) {
            .btn {
                min-height: 44px;
                min-width: 44px;
            }
            
            .btn-sm {
                min-height: 40px;
                min-width: 40px;
            }
            
            .list-group-item {
                padding: 12px 16px;
                margin-bottom: 8px;
            }
            
            .form-control, .form-select {
                min-height: 44px;
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .stats-card {
                padding: 12px;
                margin-bottom: 12px;
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .stats-card i,
            .payment-card i,
            .form-label i {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
        }
        
        /* Announcements Styles */
        .announcement-card {
            border-left: 4px solid #6c5ce7;
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }
        
        .announcement-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .announcement-card.urgent {
            border-left-color: #e74c3c;
        }
        
        .announcement-card.important {
            border-left-color: #f39c12;
        }
        
        .announcement-card.normal {
            border-left-color: #6c5ce7;
        }
        
        .announcement-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .announcement-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .announcement-meta {
            font-size: 0.85rem;
            color: #7f8c8d;
        }
        
        .announcement-message {
            color: #34495e;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .announcement-image-container {
            margin-top: 15px;
            text-align: center;
        }
        
        .announcement-image-display {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            object-fit: contain;
            background: #f8f9fa;
            padding: 10px;
        }
        
        .priority-badge {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
        }
        
        .priority-urgent {
            background: #e74c3c;
            color: white;
        }
        
        .priority-important {
            background: #f39c12;
            color: white;
        }
        
        .priority-normal {
            background: #6c5ce7;
            color: white;
        }
        
        /* Mobile Payment Form Styles */
        @media (max-width: 576px) {
            .payment-form-card {
                padding: 1rem !important;
                margin: 0.5rem !important;
            }
            
            .payment-form-card h4 {
                font-size: 1.25rem !important;
                margin-bottom: 1rem !important;
            }
            
            .payment-form-card .form-label {
                font-size: 0.875rem !important;
                margin-bottom: 0.5rem !important;
            }
            
            .payment-form-card .form-control,
            .payment-form-card .form-select {
                font-size: 16px !important; /* Prevent zoom on iOS */
                padding: 0.75rem !important;
                min-height: 44px !important; /* Touch-friendly */
            }
            
            .payment-form-card .btn {
                min-height: 44px !important; /* Touch-friendly */
                font-size: 0.875rem !important;
            }
            
            .payment-form-card .alert {
                font-size: 0.875rem !important;
                padding: 0.75rem !important;
            }
            
            .payment-form-card .card {
                margin-bottom: 1rem !important;
            }
            
            .payment-form-card .card-header {
                padding: 0.75rem !important;
            }
            
            .payment-form-card .card-body {
                padding: 0.75rem !important;
            }
            
            .payment-form-card .btn-close {
                font-size: 1.25rem !important;
            }
        }
        
        @media (min-width: 577px) and (max-width: 768px) {
            .payment-form-card {
                padding: 1.5rem !important;
            }
            
            .payment-form-card .form-control,
            .payment-form-card .form-select {
                font-size: 14px !important;
                padding: 0.625rem !important;
            }
        }
        
        /* Touch-friendly targets for mobile */
        @media (pointer: coarse) {
            .payment-form-card .form-control,
            .payment-form-card .form-select,
            .payment-form-card .btn,
            .payment-form-card .btn-close {
                min-height: 44px;
                min-width: 44px;
            }
        }
        
        /* Improve file input on mobile */
        @media (max-width: 768px) {
            .payment-form-card input[type="file"] {
                font-size: 16px !important;
                padding: 0.75rem !important;
            }
        }
        
        /* Mobile Payment History Styles */
        @media (max-width: 576px) {
            .payment-form-card h4 {
                font-size: 1.25rem !important;
            }
            
            .stats-card {
                padding: 1rem !important;
                margin-bottom: 1rem !important;
            }
            
            .stats-card h5 {
                font-size: 1.5rem !important;
            }
            
            .stats-card p {
                font-size: 0.875rem !important;
            }
            
            .stats-card small {
                font-size: 0.75rem !important;
            }
            
            .stats-card .bi {
                font-size: 1.5rem !important;
            }
            
            .year-filter-section .form-label {
                font-size: 0.875rem !important;
                margin-bottom: 0.5rem !important;
            }
            
            .year-filter-section .form-select {
                font-size: 16px !important; /* Prevent zoom on iOS */
                padding: 0.75rem !important;
                min-height: 44px !important; /* Touch-friendly */
            }
            
            .empty-state {
                padding: 2rem 1rem !important;
                text-align: center !important;
            }
            
            .empty-state .bi {
                font-size: 3rem !important;
                margin-bottom: 1rem !important;
            }
            
            .empty-state h5 {
                font-size: 1.25rem !important;
                margin-bottom: 0.75rem !important;
            }
            
            .empty-state p {
                font-size: 0.875rem !important;
                margin-bottom: 1.5rem !important;
            }
            
            .empty-state .btn {
                min-height: 44px !important;
                font-size: 0.875rem !important;
                padding: 0.75rem 1.5rem !important;
            }
        }
        
        @media (min-width: 577px) and (max-width: 768px) {
            .stats-card {
                padding: 1.25rem !important;
            }
            
            .stats-card h5 {
                font-size: 1.75rem !important;
            }
            
            .year-filter-section .form-select {
                font-size: 14px !important;
                padding: 0.625rem !important;
            }
        }
        
        /* Payment History List Mobile Styles */
        @media (max-width: 768px) {
            .payment-item {
                margin-bottom: 1rem !important;
                padding: 1rem !important;
            }
            
            .payment-item .d-flex {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            
            .payment-item .badge {
                margin-top: 0.5rem !important;
                font-size: 0.75rem !important;
            }
            
            .payment-item .small {
                font-size: 0.75rem !important;
                line-height: 1.4 !important;
            }
        }
        
        /* Member Information Cards Styles */
        .member-info-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .member-info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        
        .member-info-card .icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        .member-info-card h6 {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .member-info-card p {
            font-size: 0.875rem;
            margin: 0;
            word-break: break-word;
        }
        
        .member-info-card .small {
            font-size: 0.75rem;
        }
        
        /* Mobile Member Info Cards */
        @media (max-width: 576px) {
            .member-info-card {
                padding: 0.75rem !important;
                margin-bottom: 0.75rem !important;
            }
            
            .member-info-card .icon-wrapper {
                width: 40px !important;
                height: 40px !important;
                font-size: 1rem !important;
            }
            
            .member-info-card h6 {
                font-size: 0.7rem !important;
            }
            
            .member-info-card p {
                font-size: 0.8rem !important;
            }
            
            .member-info-card .ms-3 {
                margin-left: 0.75rem !important;
            }
        }
        
        @media (min-width: 577px) and (max-width: 768px) {
            .member-info-card {
                padding: 0.875rem !important;
            }
            
            .member-info-card .icon-wrapper {
                width: 44px !important;
                height: 44px !important;
                font-size: 1.125rem !important;
            }
        }
        
        /* Payment Summary Cards Styles */
        .payment-summary-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .payment-summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #007bff, #6f42c1, #20c997);
            border-radius: 12px 12px 0 0;
        }
        
        .payment-summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }
        
        .payment-summary-card .icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .payment-summary-card h6 {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem !important;
        }
        
        .payment-summary-card p {
            font-size: 1rem;
            margin: 0;
            font-weight: 700;
            color: #2c3e50;
        }
        
        .payment-summary-card .small {
            font-size: 0.8rem;
        }
        
        /* Mobile Payment Summary Cards */
        @media (max-width: 576px) {
            .payment-summary-card {
                padding: 0.875rem !important;
                margin-bottom: 0.875rem !important;
            }
            
            .payment-summary-card .icon-wrapper {
                width: 42px !important;
                height: 42px !important;
                font-size: 1.25rem !important;
            }
            
            .payment-summary-card h6 {
                font-size: 0.7rem !important;
            }
            
            .payment-summary-card p {
                font-size: 0.9rem !important;
            }
            
            .payment-summary-card .ms-3 {
                margin-left: 0.875rem !important;
            }
        }
        
        @media (min-width: 577px) and (max-width: 768px) {
            .payment-summary-card {
                padding: 0.9375rem !important;
            }
            
            .payment-summary-card .icon-wrapper {
                width: 46px !important;
                height: 46px !important;
                font-size: 1.375rem !important;
            }
        }
        
        /* Mobile Sidebar Styles */
        @media (max-width: 767px) {
            #memberSidebarMenu {
                position: fixed;
                top: 56px;
                left: 0;
                width: 100%;
                max-width: 280px;
                height: calc(100vh - 56px);
                background: white;
                z-index: 1000;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            #memberSidebarMenu.show {
                transform: translateX(0);
            }
            
            #memberSidebarMenu.collapse:not(.show) {
                display: block;
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            
            .sidebar {
                border-radius: 0 !important;
                height: 100% !important;
                margin: 0 !important;
            }
            
            .container-fluid {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .row {
                margin: 0 !important;
            }
            
            .col-lg-4.col-md-5 {
                padding: 0 !important;
                position: fixed;
                z-index: 1000;
            }
            
            .col-lg-8.col-md-7 {
                padding: 0 !important;
                width: 100% !important;
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }
        }
        
        @media (min-width: 768px) {
            #memberSidebarMenu.collapse {
                display: block !important;
                height: auto !important;
                overflow: visible !important;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <!-- Hamburger Menu Button on LEFT -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#memberSidebarMenu" aria-controls="memberSidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <a class="navbar-brand" href="/member/dashboard">
                <i class="bi bi-mortarboard-fill me-2"></i>TMCS Member
            </a>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Profile Dropdown on RIGHT -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown profile-dropdown">
                        <a class="nav-link profile-toggle dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->profile_picture)
                                <img src="/uploads/profiles/{{ auth()->user()->profile_picture }}" 
                                     alt="Profile" class="profile-img"
                                     onerror="console.log('Image failed to load: /uploads/profiles/{{ auth()->user()->profile_picture }}'); this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiNmOGY5ZmEiLz4KPHBhdGggZD0iTTIwIDIwQzIyLjIwOTEgMjAgMjQgMTcuMjA5MSAyNCAxNUMyNCAxMi43OTA5IDIyLjIwOTEgMTAgMjAgMTBDMTcuNzA5MSAxMCAxNiAxMi43OTA5IDE2IDE1QzE2IDE3LjIwOTEgMTcuNzA5MSAyMCAyMCAyMFoiIGZpbGw9IiM2YzVjZTciLz4KPGNpcmNsZSBjeD0iMjAiIGN5PSIzMCIgcj0iOCIgZmlsbD0iIzZjNWNlNyIvPgo8L3N2Zz4K';">
                            @else
                                <div class="profile-img d-flex align-items-center justify-content-center bg-white text-primary">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            @endif
                            <span>{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/member/profile">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-4 col-md-5">
                <div class="sidebar collapse" id="memberSidebarMenu">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action" onclick="showDashboard()">
                            <i class="bi bi-house-door me-2"></i>Dashboard
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showMyProfile()">
                            <i class="bi bi-person me-2"></i>Personal Informations
                        </a>
                        <a href="/member/profile" class="list-group-item list-group-item-action">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showPaymentForm()">
                            <i class="bi bi-plus-circle me-2"></i>Make Payment
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showPaymentHistory()">
                            <i class="bi bi-clock-history me-2"></i>Payment History
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showPdfReports()">
                            <i class="bi bi-file-pdf me-2"></i>My Reports
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showAnnouncements()">
                            <i class="bi bi-megaphone me-2"></i>Announcements
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="list-group-item list-group-item-action text-danger w-100 text-start border-0 bg-transparent">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-8 col-md-7 main-content">
                <!-- Payment Form Section (Initially Hidden) -->
                <div id="paymentFormSection" class="payment-form-section">
                    <div class="payment-form-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">
                                <i class="bi bi-credit-card me-2"></i>Make Payment
                            </h4>
                            <button type="button" class="btn-close" onclick="hidePaymentForm()"></button>
                        </div>
                        
                                                
                        <form id="paymentForm" enctype="multipart/form-data">
                            <div class="row g-3 g-md-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label for="paymentType" class="form-label">
                                        <i class="bi bi-list-task me-1"></i>Payment Type
                                    </label>
                                    <select class="form-select form-select-sm" id="paymentType" name="payment_type" required onchange="handlePaymentTypeChange()">
                                        <option value="">Select Payment Type...</option>
                                        <option value="membership">Membership Fee - TZS 2,000</option>
                                        <option value="certificate">Certificate Fee - TZS 4,000</option>
                                        <option value="zaka">Zaka - TZS 2,000</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label for="paymentYear" class="form-label">
                                        <i class="bi bi-calendar me-1"></i>Payment Year
                                    </label>
                                    <select class="form-select form-select-sm" id="paymentYear" name="payment_year" required onchange="handleYearChange()">
                                        <option value="">Select Year...</option>
                                        <option value="new_year">New Year (Enter Custom Year)</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4" id="customYearDiv" style="display: none;">
                                    <label for="customYear" class="form-label">
                                        <i class="bi bi-calendar-plus me-1"></i>Enter Year
                                    </label>
                                    <input type="number" class="form-control form-control-sm" id="customYear" name="custom_year" min="2020" max="2050" placeholder="e.g., 2030">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label for="amount" class="form-label">Amount (TZS)</label>
                                    <input type="number" class="form-control form-control-sm" id="amount" name="amount" placeholder="0.00" step="0.01" required>
                                </div>
                            </div>
                            
                            <!-- Installment Options (Initially Hidden) -->
                            <div class="row g-3 g-md-4" id="installmentOptions" style="display: none;">
                                <div class="col-12">
                                    <label for="installmentType" class="form-label">
                                        <i class="bi bi-calendar-split me-1"></i>Payment Option
                                    </label>
                                    <select class="form-select form-select-sm" id="installmentType" name="installment_type" onchange="handleInstallmentChange()">
                                        <option value="">Select Payment Option...</option>
                                        <option value="full">Full Payment</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Installment Info Display -->
                            <div class="row g-3 g-md-4" id="installmentInfo" style="display: none;">
                                <div class="col-12">
                                    <div class="alert alert-info d-flex align-items-center">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <div id="installmentInfoText"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 g-md-4">
                                <div class="col-12">
                                    <label for="description" class="form-label">
                                        <i class="bi bi-text-paragraph me-1"></i> 
                                        
                                        Description
                                    </label>
                                    <textarea class="form-control form-control-sm" id="description" name="description" rows="3" placeholder="Enter payment details..." required></textarea>
                                </div>
                            </div>
                            
                            <div class="row g-3 g-md-4">
                                <div class="col-12 col-md-6">
                                    <label for="paymentMethod" class="form-label">
                                        <i class="bi bi-credit-card me-1"></i>Payment Method
                                    </label>
                                    <select class="form-select form-select-sm" id="paymentMethod" name="payment_method" required onchange="showPaymentDetails()">
                                        <option value="">Select Payment Method...</option>
                                        <!-- Payment accounts will be loaded here dynamically -->
                                    </select>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <label for="senderName" class="form-label">
                                        <i class="bi bi-person me-1"></i>Sender Name
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="senderName" name="sender_name" placeholder="Enter your full name" required>
                                </div>
                            </div>
                            
                            <!-- Payment Details Section (Initially Hidden) -->
                            <div class="row g-3 g-md-4" id="paymentDetailsSection" style="display: none;">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">
                                            <i class="bi bi-info-circle me-2"></i>Maelekezo ya Malipo
                                        </h6>
                                        <div id="paymentInstructions"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 g-md-4">
                                <div class="col-12">
                                    <label for="attachment" class="form-label">
                                        <i class="bi bi-paperclip me-1"></i>Attachment (Receipt/Proof) <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" id="attachment" name="attachment" accept="image/*,.pdf" onchange="previewAttachment(this)" required>
                                    <div id="attachmentPreview" class="mt-2" style="display: none;">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i class="bi bi-eye me-2"></i>Preview
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAttachment()">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </div>
                                            <div class="card-body text-center p-2 p-md-3">
                                                <div id="attachmentPreviewContent"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 g-md-4 mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between justify-content-md-end gap-2 flex-wrap">
                                        <button type="button" class="btn btn-outline-secondary" onclick="resetPaymentForm()">
                                            <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                        </button>
                                        <button type="submit" class="btn btn-success px-4 py-2">
                                            <i class="bi bi-check-circle me-2"></i>Submit Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                          
                        </form>
                    </div>
                </div>
                
                <!-- Member Information Section (Initially Hidden) -->
                <div id="informationFormSection" class="information-form-section">
                    <div class="payment-form-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">
                                <i class="bi bi-person-badge me-2"></i>My Information
                            </h4>
                            <button type="button" class="btn-close" onclick="hideMemberInformation()"></button>
                        </div>
                        
                        <div id="memberDetailsContent">
                            <!-- Member details will be loaded here -->
                        </div>
                    </div>
                </div>
                
                <!-- My Profile Section (Initially Hidden) -->
                <div id="myProfileSection" class="my-profile-section">
                    <div class="payment-form-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">
                                <i class="bi bi-person me-2"></i>My Profile
                            </h4>
                            <button type="button" class="btn-close" onclick="hideMyProfile()"></button>
                        </div>
                        
                        <div id="myProfileContent">
                            <!-- Profile data will be loaded here -->
                        </div>
                    </div>
                </div>
                
                <!-- Announcements Section (Initially Hidden) -->
                <div id="announcementsSection" class="payment-form-section">
                    <div class="payment-form-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">
                                <i class="bi bi-megaphone-fill me-2"></i>Announcements
                            </h4>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="loadAnnouncements()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                                </button>
                                <button type="button" class="btn-close" onclick="hideAnnouncements()"></button>
                            </div>
                        </div>
                        
                        <div id="announcementsList">
                            <!-- Announcements will be loaded here -->
                        </div>
                    </div>
                </div>
                
                <!-- PDF Reports Section (Initially Hidden) -->
                <div id="pdfReportsSection" class="payment-form-section">
                    <div class="payment-form-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">
                                <i class="bi bi-file-pdf-fill me-2"></i>PDF Reports
                            </h4>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="loadPdfReports()">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                                </button>
                                <button type="button" class="btn-close" onclick="hidePdfReports()"></button>
                            </div>
                        </div>
                        
                        <div id="pdfReportsContent">
                            <!-- PDF reports will be loaded here -->
                        </div>
                    </div>
                </div>
                
                <!-- Welcome Section -->
                <div id="welcomeSection" class="welcome-card">
                    <h1 class="welcome-title">
                        Welcome back, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="welcome-subtitle">
                        Here's what's happening with your TMCS account today.
                    </p>
                    
                    <!-- Member Information Summary Cards -->
                    <div class="row g-3 g-md-4 mt-3">
                        <!-- Profile Information Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="member-info-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-primary bg-opacity-10">
                                        <i class="bi bi-person-circle text-primary"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Full Name</h6>
                                        <p class="mb-0 fw-bold">{{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Email Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="member-info-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-success bg-opacity-10">
                                        <i class="bi bi-envelope text-success"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Email</h6>
                                        <p class="mb-0 fw-bold small">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Phone Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="member-info-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-info bg-opacity-10">
                                        <i class="bi bi-telephone text-info"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Phone</h6>
                                        <p class="mb-0 fw-bold">{{ auth()->user()->phone_number ?? 'Not Set' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Membership Status Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="member-info-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-warning bg-opacity-10">
                                        <i class="bi bi-shield-check text-warning"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Status</h6>
                                        <p class="mb-0 fw-bold">
                                            <span class="badge bg-{{ auth()->user()->membership_status === 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst(auth()->user()->membership_status ?? 'Unknown') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Information Row -->
                    <div class="row g-3 g-md-4 mt-2">
                        <!-- Registration Number Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="member-info-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-secondary bg-opacity-10">
                                        <i class="bi bi-card-text text-secondary"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Reg. Number</h6>
                                        <p class="mb-0 fw-bold">{{ auth()->user()->registration_number ?? 'Not Set' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Home Diocese Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="member-info-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-danger bg-opacity-10">
                                        <i class="bi bi-geo-alt text-danger"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Home Diocese</h6>
                                        <p class="mb-0 fw-bold small">{{ auth()->user()->home_diocese ?? 'Not Set' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Year of Study Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="member-info-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-purple bg-opacity-10">
                                        <i class="bi bi-book text-purple" style="color: #6f42c1 !important;"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Year of Study</h6>
                                        <p class="mb-0 fw-bold">{{ auth()->user()->year_of_study ?? 'Not Set' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Registration Date Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="member-info-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-teal bg-opacity-10">
                                        <i class="bi bi-calendar-check text-teal" style="color: #20c997 !important;"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Member Since</h6>
                                        <p class="mb-0 fw-bold small">{{ auth()->user()->created_at ? \Carbon\Carbon::parse(auth()->user()->created_at)->format('M j, Y') : 'Unknown' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Information Summary -->
                    <div class="row g-3 g-md-4 mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="bi bi-credit-card me-2"></i>Payment Summary
                            </h5>
                        </div>
                        
                        <!-- Approved Payments Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="payment-summary-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-success bg-opacity-10">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Approved</h6>
                                        <p class="mb-0 fw-bold" id="summaryApprovedAmount">TZS 0</p>
                                        <small class="text-muted" id="summaryApprovedCount">0 payments</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pending Payments Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="payment-summary-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-warning bg-opacity-10">
                                        <i class="bi bi-clock text-warning"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Pending</h6>
                                        <p class="mb-0 fw-bold" id="summaryPendingAmount">TZS 0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Rejected Payments Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="payment-summary-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-danger bg-opacity-10">
                                        <i class="bi bi-x-circle text-danger"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Rejected</h6>
                                        <p class="mb-0 fw-bold" id="summaryRejectedAmount">TZS 0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Total Amount Card -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="payment-summary-card">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper bg-primary bg-opacity-10">
                                        <i class="bi bi-wallet2 text-primary"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-muted">Total Amount</h6>
                                        <p class="mb-0 fw-bold" id="summaryTotalAmount">TZS 0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment History Section (Initially Hidden) -->
                <div id="paymentHistorySection" class="payment-form-section">
                    <div class="payment-form-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">
                                <i class="bi bi-clock-history me-2"></i>Historia ya Malipo
                            </h4>
                            <button type="button" class="btn-close" onclick="hidePaymentHistory()"></button>
                        </div>
                        
                        <!-- Statistics -->
                        <div class="row g-3 g-md-4 mb-4">
                            <!-- Completed Payments Card -->
                            <div class="col-12 col-md-4">
                                <div class="stats-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0" id="completedPayments">0</h5>
                                            <p class="mb-0">Malipo Yaliyoidhinishwa</p>
                                            <small class="text-success fw-bold" id="totalCompletedAmount">TZS 0</small>
                                        </div>
                                        <i class="bi bi-check-circle fs-4 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pending Payments Card -->
                            <div class="col-12 col-md-4">
                                <div class="stats-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0" id="pendingPayments">0</h5>
                                            <p class="mb-0">Malipo Yanayosubiri</p>
                                            <small class="text-warning fw-bold" id="totalPendingAmount">TZS 0</small>
                                        </div>
                                        <i class="bi bi-clock fs-4 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Rejected Payments Card -->
                            <div class="col-12 col-md-4">
                                <div class="stats-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0" id="rejectedPayments">0</h5>
                                            <p class="mb-0">Maombi Yaliyokataliwa</p>
                                            <small class="text-danger fw-bold" id="totalRejectedAmount">TZS 0</small>
                                        </div>
                                        <i class="bi bi-x-circle fs-4 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Year Filter Section -->
                        <div class="year-filter-section mb-4">
                            <div class="row g-3 g-md-4">
                                <div class="col-12 col-md-6">
                                    <label for="yearFilter" class="form-label">
                                        <i class="bi bi-calendar me-1"></i>Chagua Mwaka
                                    </label>
                                    <select class="form-select form-select-sm" id="yearFilter" onchange="filterByYear()">
                                        <option value="">Miaka Yote</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="paymentTypeFilter" class="form-label">
                                        <i class="bi bi-list-task me-1"></i>Aina ya Malipo
                                    </label>
                                    <select class="form-select form-select-sm" id="paymentTypeFilter" onchange="filterByYear()">
                                        <option value="">Aina Zote</option>
                                        <option value="membership">Ada ya Uanachama</option>
                                        <option value="certificate">Ada ya Cheti</option>
                                        <option value="zaka">Zaka</option>
                                        <option value="donation">Mchango</option>
                                        <option value="event">Usajili wa Tukio</option>
                                        <option value="other">Nyingine</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Payment History List -->
                        <div id="paymentHistoryList">
                            <!-- Payment items will be loaded here -->
                            <div class="empty-state">
                                <i class="bi bi-receipt"></i>
                                <h5>Hakuna Malipo Bado</h5>
                                <p class="text-muted">Bado hujafanya malipo yoyote. Anza kufanya malipo kuona historia hapa.</p>
                                <button type="button" class="btn btn-primary mt-3" onclick="showPaymentForm()">
                                    <i class="bi bi-plus-circle me-2"></i>Fanya Malipo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Form (Hidden) -->
    <form id="logout-form" action="/logout" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Session Validation - Check if user is authenticated
        function checkSession() {
            fetch('/member/check-session', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.authenticated) {
                    // User is not authenticated, redirect to login
                    window.location.href = '/login?error=Session expired. Please login again.';
                }
            })
            .catch(error => {
                console.error('Session check failed:', error);
                // If session check fails, redirect to login for safety
                window.location.href = '/login?error=Authentication error. Please login again.';
            });
        }

        // Check session immediately when page loads
        checkSession();

        // Check session periodically (every 30 seconds)
        setInterval(checkSession, 30000);

        // Check session when user interacts with the page
        document.addEventListener('click', function(event) {
            // Only check for clicks on dashboard elements, not external links
            if (event.target.closest('a')?.href?.includes('/logout')) {
                return; // Allow logout
            }
            checkSession();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const paymentForm = document.getElementById('paymentForm');
            
            // Load payment accounts from database
            loadPaymentAccounts();
            
            // Populate year options
            populateYearOptions();
            
            // Load payment summary data
            loadPaymentSummary();
            
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const paymentType = formData.get('payment_type');
                const amount = formData.get('amount');
                const description = formData.get('description');
                const paymentMethod = formData.get('payment_method');
                const senderName = formData.get('sender_name');
                const attachment = formData.get('attachment');
                let paymentYear = formData.get('payment_year');
                
                // Handle custom year
                if (paymentYear === 'new_year') {
                    paymentYear = formData.get('custom_year');
                    if (!paymentYear) {
                        alert('Please enter a custom year');
                        return;
                    }
                    
                    // Save custom year to localStorage for future use
                    const customYears = JSON.parse(localStorage.getItem('customPaymentYears') || '[]');
                    if (!customYears.includes(paymentYear)) {
                        customYears.push(paymentYear);
                        localStorage.setItem('customPaymentYears', JSON.stringify(customYears));
                    }
                }
                
                // Validation
                if (!paymentType || !amount || !description || !paymentMethod || !senderName || !paymentYear) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                // Attachment validation - MANDATORY
                if (!attachment || attachment.size === 0) {
                    alert('Attachment (Receipt/Proof) is required! Please upload a receipt or proof of payment.');
                    return;
                }
                
                // Special validation for membership fee - no installments required
                if (paymentType === 'membership' && amount != '2000') {
                    alert('Membership fee must be TZS 2,000');
                    return;
                }
                
                if (paymentType === 'certificate' && amount != '4000') {
                    alert('Certificate fee must be TZS 4,000 for second year students and above');
                    return;
                }
                
                if (paymentType === 'zaka' && amount != '2000') {
                    alert('Zaka payment must be TZS 2,000 per year');
                    return;
                }
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
                submitBtn.disabled = true;
                
                // Prepare payment details
                let paymentDetails = `Payment of TZS ${amount} for ${paymentType} (${paymentYear})`;
                if (paymentType === 'certificate') {
                    paymentDetails += ` (Certificate fee for second year students and above)`;
                } else if (paymentType === 'zaka') {
                    paymentDetails += ` (Annual zaka payment)`;
                }
                
                // Submit to backend
                formData.set('payment_year', paymentYear); // Ensure correct year is sent
                fetch('/member/payments/store', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Payment of TZS ${amount} for ${paymentType} (${paymentYear}) submitted successfully!`);
                        
                        // Show success notification
                        showSuccessNotification(`Payment of TZS ${amount} for ${paymentType} (${paymentYear}) has been recorded successfully!`);
                        
                        // Reset form and hide
                        this.reset();
                        hidePaymentForm();
                        
                        // Reset amount field
                        document.getElementById('amount').readOnly = false;
                        
                        // Reset payment details
                        document.getElementById('paymentDetailsSection').style.display = 'none';
                        
                        // Reset attachment
                        removeAttachment();
                        
                        // Refresh payment history if it's visible
                        if (document.getElementById('paymentHistorySection').style.display !== 'none') {
                            loadPaymentHistory();
                        }
                        
                        // Auto-refresh payment history after successful payment
                        setTimeout(() => {
                            loadPaymentHistory();
                        }, 1000);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error submitting payment. Please try again.');
                })
                .finally(() => {
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        });
        
        // Load Payment Summary Data
        function loadPaymentSummary() {
            fetch('/member/payment-summary')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updatePaymentSummaryCards(data.summary);
                    } else {
                        console.error('Failed to load payment summary');
                    }
                })
                .catch(error => {
                    console.error('Error loading payment summary:', error);
                });
        }
        
        // Update Payment Summary Cards
        function updatePaymentSummaryCards(summary) {
            // Update approved amount and count
            const approvedAmountElement = document.getElementById('summaryApprovedAmount');
            const approvedCountElement = document.getElementById('summaryApprovedCount');
            if (approvedAmountElement) {
                approvedAmountElement.textContent = `TZS ${formatNumber(summary.approved_amount || 0)}`;
            }
            if (approvedCountElement) {
                const count = summary.approved_count || 0;
                approvedCountElement.textContent = `${count} ${count === 1 ? 'payment' : 'payments'}`;
            }
            
            // Update pending amount
            const pendingAmountElement = document.getElementById('summaryPendingAmount');
            if (pendingAmountElement) {
                pendingAmountElement.textContent = `TZS ${formatNumber(summary.pending_amount || 0)}`;
            }
            
            // Update rejected amount
            const rejectedAmountElement = document.getElementById('summaryRejectedAmount');
            if (rejectedAmountElement) {
                rejectedAmountElement.textContent = `TZS ${formatNumber(summary.rejected_amount || 0)}`;
            }
            
            // Update total amount
            const totalAmountElement = document.getElementById('summaryTotalAmount');
            if (totalAmountElement) {
                totalAmountElement.textContent = `TZS ${formatNumber(summary.total_amount || 0)}`;
            }
        }
        
        // Format number with commas
        function formatNumber(num) {
            return parseInt(num).toLocaleString();
        }
        
        function populateYearOptions() {
            const yearSelect = document.getElementById('paymentYear');
            const currentYear = new Date().getFullYear();
            
            // Clear existing options first
            yearSelect.innerHTML = '<option value="">Select Year...</option>';
            
            // Add current year and next 2 years
            for (let i = 0; i <= 2; i++) {
                const year = currentYear + i;
                const option = document.createElement('option');
                option.value = year;
                option.textContent = `${year}`;
                yearSelect.appendChild(option);
            }
            
            // Add custom years from localStorage if any
            const customYears = JSON.parse(localStorage.getItem('customPaymentYears') || '[]');
            customYears.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            });
            
            // Add "New Year" option at the end
            const newYearOption = document.createElement('option');
            newYearOption.value = 'new_year';
            newYearOption.textContent = 'New Year (Enter Custom Year)';
            yearSelect.appendChild(newYearOption);
        }
        
        function handleYearChange() {
            const yearSelect = document.getElementById('paymentYear');
            const customYearDiv = document.getElementById('customYearDiv');
            
            if (yearSelect.value === 'new_year') {
                customYearDiv.style.display = 'block';
                document.getElementById('customYear').focus();
            } else {
                customYearDiv.style.display = 'none';
                document.getElementById('customYear').value = '';
            }
        }
        
        // Load Payment Accounts from Database
        function loadPaymentAccounts() {
            fetch('/member/payment-accounts')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        populatePaymentMethods(data.mobile_money, data.bank_accounts);
                    } else {
                        console.error('Failed to load payment accounts');
                    }
                })
                .catch(error => {
                    console.error('Error loading payment accounts:', error);
                });
        }

        // Populate Payment Methods Dropdown
        function populatePaymentMethods(mobileMoneyAccounts, bankAccounts) {
            const paymentMethodSelect = document.getElementById('paymentMethod');
            
            if (!paymentMethodSelect) {
                console.error('paymentMethodSelect element not found');
                return;
            }
            
            // Clear existing options except the first one
            paymentMethodSelect.innerHTML = '<option value="">Select Payment Method...</option>';
            
            // Add mobile money accounts
            if (mobileMoneyAccounts.length > 0) {
                const mobileMoneyGroup = document.createElement('optgroup');
                mobileMoneyGroup.label = '📱 Mobile Money';
                
                mobileMoneyAccounts.forEach(account => {
                    const option = document.createElement('option');
                    option.value = `mobile_${account.id}`;
                    option.textContent = `${account.account_name} - ${account.account_number}`;
                    option.dataset.type = 'mobile';
                    option.dataset.number = account.account_number;
                    option.dataset.name = account.account_name;
                    option.dataset.description = account.description || '';
                    mobileMoneyGroup.appendChild(option);
                });
                
                paymentMethodSelect.appendChild(mobileMoneyGroup);
            }
            
            // Add bank accounts
            if (bankAccounts.length > 0) {
                const bankGroup = document.createElement('optgroup');
                bankGroup.label = '🏦 Bank Accounts';
                
                bankAccounts.forEach(account => {
                    const option = document.createElement('option');
                    option.value = `bank_${account.id}`;
                    option.textContent = `${account.account_name} - ${account.account_number}`;
                    option.dataset.type = 'bank';
                    option.dataset.number = account.account_number;
                    option.dataset.name = account.account_name;
                    option.dataset.description = account.description || '';
                    bankGroup.appendChild(option);
                });
                
                paymentMethodSelect.appendChild(bankGroup);
            }
        }
        
        function handlePaymentTypeChange() {
            const paymentType = document.getElementById('paymentType').value;
            const installmentOptions = document.getElementById('installmentOptions');
            const installmentInfo = document.getElementById('installmentInfo');
            const amountInput = document.getElementById('amount');
            
            if (paymentType === 'membership') {
                installmentOptions.style.display = 'block';
                installmentInfo.style.display = 'block';
                document.getElementById('installmentInfoText').innerHTML = 
                    '<strong>Membership Fee:</strong> TZS 2,000 per year. Full payment required.';
                amountInput.value = '2000';
                amountInput.readOnly = true;
            } else if (paymentType === 'certificate') {
                installmentOptions.style.display = 'block';
                installmentInfo.style.display = 'block';
                document.getElementById('installmentInfoText').innerHTML = 
                    '<strong>Certificate Fee:</strong> TZS 4,000 for students in second year and above preparing for graduation. Full payment required.';
                amountInput.value = '4000';
                amountInput.readOnly = true;
            } else if (paymentType === 'zaka') {
                installmentOptions.style.display = 'block';
                installmentInfo.style.display = 'block';
                document.getElementById('installmentInfoText').innerHTML = 
                    '<strong>Zaka:</strong> TZS 2,000 voluntary contribution. Full payment required.';
                amountInput.value = '2000';
                amountInput.readOnly = true;
            } else {
                installmentOptions.style.display = 'none';
                installmentInfo.style.display = 'none';
                amountInput.readOnly = false;
                amountInput.value = '';
            }
        }
        
        function handleInstallmentChange() {
            const installmentType = document.getElementById('installmentType').value;
            const amountInput = document.getElementById('amount');
            
            // All payments are now full payment only
            if (installmentType === 'full') {
                const paymentType = document.getElementById('paymentType').value;
                if (paymentType === 'membership') {
                    amountInput.value = '2000';
                } else if (paymentType === 'certificate') {
                    amountInput.value = '4000';
                } else if (paymentType === 'zaka') {
                    amountInput.value = '2000';
                }
                amountInput.readOnly = true;
            } else {
                amountInput.readOnly = false;
            }
            
            switch(installmentType) {
                case 'full':
                    // Get the current amount from the input field (already set correctly above)
                    amount = parseInt(amountInput.value);
                    const paymentType = document.getElementById('paymentType').value;
                    if (paymentType === 'membership') {
                        infoText = '<strong>Full Payment:</strong> Paying the complete membership fee of TZS 2,000. No further payments required.';
                        description = 'Full membership fee payment - TZS 2,000';
                    } else if (paymentType === 'certificate') {
                        infoText = '<strong>Full Payment:</strong> Paying the complete certificate fee of TZS 4,000. No further payments required.';
                        description = 'Full certificate fee payment - TZS 4,000';
                    } else if (paymentType === 'zaka') {
                        infoText = '<strong>Full Payment:</strong> Paying the complete zaka of TZS 2,000. No further payments required.';
                        description = 'Full zaka payment - TZS 2,000';
                    }
                    break;
                case 'installment1':
                    amount = 1000;
                    infoText = '<strong>1st Installment:</strong> Paying TZS 1,000 out of TZS 2,000. Remaining balance: TZS 1,000. You can pay the remaining balance in full or continue with the second installment.';
                    description = '1st installment of membership fee - TZS 1,000 out of TZS 2,000, remaining balance TZS 1,000';
                    break;
                case 'installment2':
                    amount = 1000;
                    infoText = '<strong>2nd Installment:</strong> Paying TZS 1,000 out of TZS 2,000. This completes your membership fee payment for the year.';
                    description = '2nd installment of membership fee - TZS 1,000 out of TZS 2,000, final payment';
                    break;
            }
            
            amountInput.value = amount;
            installmentInfoText.innerHTML = infoText;
            installmentInfo.style.display = 'block';
            descriptionInput.value = description;
        }
        
        // Auto-fill description for other payment types
        function autoFillDescription() {
            const paymentType = document.getElementById('paymentType').value;
            const descriptionInput = document.getElementById('description');
            const amount = document.getElementById('amount').value;
            
            if (!paymentType || !amount) {
                return;
            }
            
            let description = '';
            
            switch(paymentType) {
                case 'certificate':
                    description = `Certificate fee payment for second year students and above - TZS ${amount}`;
                    break;
                case 'zaka':
                    description = `Zaka payment - TZS ${amount} per year`;
                    break;
                case 'membership':
                    // Description is handled by handleInstallmentChange
                    break;
                default:
                    description = `Payment for ${paymentType} - TZS ${amount}`;
                    break;
            }
            
            if (descriptionInput && !descriptionInput.value) {
                descriptionInput.value = description;
            }
        }
        
        function showPaymentDetails() {
            const paymentMethodSelect = document.getElementById('paymentMethod');
            const selectedOption = paymentMethodSelect.options[paymentMethodSelect.selectedIndex];
            const paymentDetailsSection = document.getElementById('paymentDetailsSection');
            const paymentInstructions = document.getElementById('paymentInstructions');
            
            if (!paymentMethodSelect.value) {
                paymentDetailsSection.style.display = 'none';
                return;
            }
            
            const accountType = selectedOption.dataset.type;
            const accountNumber = selectedOption.dataset.number;
            const accountName = selectedOption.dataset.name;
            const accountDescription = selectedOption.dataset.description;
            const amount = document.getElementById('amount').value;
            
            let instructions = '';
            
            if (accountType === 'mobile') {
                // Get USSD code based on account name
                let ussdCode = '';
                let networkName = accountName.toLowerCase();
                
                if (networkName.includes('m-pesa') || networkName.includes('mpesa')) {
                    ussdCode = '*150*00#';
                } else if (networkName.includes('tigo pesa') || networkName.includes('tigopesa')) {
                    ussdCode = '*150*01#';
                } else if (networkName.includes('airtel money') || networkName.includes('airtel')) {
                    ussdCode = '*150*60#';
                } else if (networkName.includes('halotel') || networkName.includes('halopesa')) {
                    ussdCode = '*150*88#';
                } else {
                    ussdCode = 'USSD code ya mtandao wako';
                }
                
                instructions = `
                    <div class="payment-steps">
                        <div class="alert alert-primary d-flex align-items-center mb-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>
                                <strong>Maelekezo ya Malipo:</strong> Tafadhali fuata hatua hizi kwa umakini kuhakikisha malipo yako yanafika kwa usalama.
                            </div>
                        </div>
                        
                        <h6 class="text-primary"><strong><i class="bi bi-phone me-2"></i>${accountName}</strong></h6>
                        <div class="card bg-light border-primary mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong><i class="bi bi-hash me-1"></i>Namba ya Lipa:</strong></p>
                                        <p class="text-primary fw-bold fs-5">${accountNumber}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong><i class="bi bi-building me-1"></i>Jina la Akaunti:</strong></p>
                                        <p class="text-primary fw-bold">${accountName}</p>
                                    </div>
                                </div>
                                ${accountDescription ? `
                                <div class="mt-3">
                                    <p class="mb-2"><strong><i class="bi bi-chat-text me-1"></i>Maelezo ya Ziada:</strong></p>
                                    <p class="text-info">${accountDescription}</p>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                        
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><strong><i class="bi bi-list-ol me-2"></i>Hatua za Malipo (${accountName})</strong></h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number">1</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Bonyesa "${ussdCode}"</strong> kwenye simu yako ya ${accountName}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number">2</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Chagua "Lipa ${accountName}"</strong> kisha <strong>"Ingiza Namba ya Biashara"</strong></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number">3</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Ingiza namba ya Lipa ya TMCS:</strong> <span class="text-primary fw-bold">${accountNumber}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number">4</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Ingiza kiasi:</strong> <span class="text-success fw-bold">TZS ${amount}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number">5</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Ingiza PIN yako</strong> kuthibitisha muamala</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number">6</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Hifadhi ujumbe wa uthibitisho</strong> wa muamala kama proof</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Muhimu:</strong> 
                            <ul class="mb-0 mt-2">
                                <li>Tumia namba ya Lipa <strong>${accountNumber}</strong> kwa malipo yote ya TMCS</li>
                                <li>Hakikisha kiasi unachoingiza ni <strong>TZS ${amount}</strong></li>
                                <li>Hifadhi ujumbe wa uthibitisho kama evidence ya malipo</li>
                                <li>Ikiwa utakumbana na changamoto, wasiliana nasi kwa msaada</li>
                            </ul>
                        </div>
                    </div>
                    
                    <style>
                        .step-number {
                            background: linear-gradient(135deg, #007bff, #0056b3);
                            color: white;
                            width: 30px;
                            height: 30px;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-weight: bold;
                            margin: 0 auto;
                        }
                    </style>
                `;
            } else if (accountType === 'bank') {
                instructions = `
                    <div class="payment-steps">
                        <div class="alert alert-primary d-flex align-items-center mb-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>
                                <strong>Maelekezo ya Malipo:</strong> Tafadhali fuata hatua hizi kwa umakini kuhakikisha malipo yako yanafika kwa usalama.
                            </div>
                        </div>
                        
                        <h6 class="text-info"><strong><i class="bi bi-bank me-2"></i>${accountName}</strong></h6>
                        <div class="card bg-light border-info mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong><i class="bi bi-building me-1"></i>Jina la Akaunti:</strong></p>
                                        <p class="text-info fw-bold fs-5">${accountName}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong><i class="bi bi-hash me-1"></i>Namba ya Akaunti:</strong></p>
                                        <p class="text-info fw-bold fs-5">${accountNumber}</p>
                                    </div>
                                </div>
                                ${accountDescription ? `
                                <div class="mt-3">
                                    <p class="mb-2"><strong><i class="bi bi-chat-text me-1"></i>Maelezo ya Ziada:</strong></p>
                                    <p class="text-info">${accountDescription}</p>
                                </div>
                                ` : ''}
                                <div class="mt-3">
                                    <p class="mb-2"><strong><i class="bi bi-geo-alt me-1"></i>Tawi:</strong></p>
                                    <p class="text-success">Unaweza kulipia ukiwa sehemu yoyote nchini Tanzania</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><strong><i class="bi bi-list-ol me-2"></i>Hatua za Malipo (Benki)</strong></h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number-bank">1</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Fika tawi lolote la benki lako</strong> (NMB, CRDB, NBC, au benki nyingine yoyote)</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number-bank">2</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Chagua "Uhamisho wa Pesa"</strong> au <strong>"Transfer"</strong> kwenye ATM au teller</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number-bank">3</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Ingiza jina la akaunti:</strong> <span class="text-info fw-bold">${accountName}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number-bank">4</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Ingiza namba ya akaunti:</strong> <span class="text-info fw-bold">${accountNumber}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number-bank">5</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Ingiza kiasi:</strong> <span class="text-success fw-bold">TZS ${amount}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number-bank">6</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Jumlishhe jina lako kama rejeresho:</strong> <span class="text-warning fw-bold">"${document.getElementById('senderName').value}"</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        <div class="step-number-bank">7</div>
                                    </div>
                                    <div class="col-md-11">
                                        <p class="mb-3"><strong>Hifadhi slip ya benki</strong> au uthibitisho wa muamala</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Muhimu:</strong> 
                            <ul class="mb-0 mt-2">
                                <li>Hakikisha unatumia pesa kwenye akaunti <strong>${accountName}</strong></li>
                                <li>Ingiza kiasi sahihi cha <strong>TZS ${amount}</strong></li>
                                <li>Jumlishhe jina lako kama rejeresho kwa urahisi wa kutambua malipo</li>
                                <li>Hifadhi slip ya benki kama evidence ya malipo</li>
                                <li>Ikiwa utakumbana na changamoto, wasiliana nasi kwa msaada</li>
                            </ul>
                        </div>
                    </div>
                    
                    <style>
                        .step-number-bank {
                            background: linear-gradient(135deg, #17a2b8, #138496);
                            color: white;
                            width: 30px;
                            height: 30px;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-weight: bold;
                            margin: 0 auto;
                        }
                    </style>
                `;
            }
            
            paymentInstructions.innerHTML = instructions;
            paymentDetailsSection.style.display = 'block';
        }
        
        // Notification Functions
        function showSuccessNotification(message) {
            // Create success notification
            const notification = document.createElement('div');
            notification.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';
            notification.innerHTML = `
                <i class="bi bi-check-circle-fill me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 5000);
        }
        
        function showErrorNotification(message) {
            // Create error notification
            const notification = document.createElement('div');
            notification.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';
            notification.innerHTML = `
                <i class="bi bi-exclamation-triangle-fill me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 5000);
        }
        
        function hideAllSections() {
            document.getElementById('paymentFormSection').style.display = 'none';
            document.getElementById('informationFormSection').style.display = 'none';
            document.getElementById('myProfileSection').style.display = 'none';
            document.getElementById('paymentHistorySection').style.display = 'none';
            document.getElementById('announcementsSection').style.display = 'none';
            document.getElementById('pdfReportsSection').style.display = 'none';
            document.getElementById('welcomeSection').style.display = 'none';
        }
        
        function showPaymentForm() {
            hideAllSections();
            document.getElementById('paymentFormSection').style.display = 'block';
            
            // Close mobile sidebar if open
            const sidebar = document.getElementById('memberSidebarMenu');
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
            
            // Scroll to top of form
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        function showPaymentHistory() {
            hideAllSections();
            document.getElementById('paymentHistorySection').style.display = 'block';
            
            // Close mobile sidebar if open
            const sidebar = document.getElementById('memberSidebarMenu');
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
            
            // Load payment history data
            loadPaymentHistory();
        }
        
        function hidePaymentHistory() {
            document.getElementById('paymentHistorySection').style.display = 'none';
            document.getElementById('welcomeSection').style.display = 'block';
        }
        
        function showAnnouncements() {
            hideAllSections();
            document.getElementById('announcementsSection').style.display = 'block';
            
            // Close mobile sidebar if open
            const sidebar = document.getElementById('memberSidebarMenu');
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
            
            loadAnnouncements();
        }
        
        function showPdfReports() {
            hideAllSections();
            document.getElementById('pdfReportsSection').style.display = 'block';
            
            // Close mobile sidebar if open
            const sidebar = document.getElementById('memberSidebarMenu');
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
            
            loadPdfReports();
        }
        
        function hidePdfReports() {
            document.getElementById('pdfReportsSection').style.display = 'none';
            document.getElementById('welcomeSection').style.display = 'block';
        }
        
        function loadPdfReports() {
            // Load available PDF reports for the member
            fetch('/member/pdf-reports')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayPdfReports(data.reports);
                    } else {
                        console.error('Failed to load PDF reports:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading PDF reports:', error);
                });
        }
        
        function displayPdfReports(reports) {
            const container = document.getElementById('pdfReportsContent');
            
            if (!reports || reports.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-file-pdf fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No PDF Reports Available</h5>
                        <p class="text-muted">No reports have been generated yet.</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            reports.forEach(report => {
                html += `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-file-pdf fs-1 text-danger mb-3"></i>
                                <h6 class="card-title">${report.title}</h6>
                                <p class="card-text small text-muted">${report.description}</p>
                                <p class="card-text small text-muted">Generated: ${new Date(report.created_at).toLocaleDateString()}</p>
                                <button class="btn btn-sm btn-primary" onclick="downloadPdfReport('${report.id}', '${report.filename}')">
                                    <i class="bi bi-download me-1"></i>Download
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = `<div class="row">${html}</div>`;
        }
        
        function downloadPdfReport(reportId, filename) {
            // Show loading state
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Generating...';
            button.disabled = true;
            
            fetch(`/member/download-pdf-report/${reportId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Create download link
                        const link = document.createElement('a');
                        link.href = data.report_url;
                        link.download = data.filename;
                        link.style.display = 'none';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        
                        // Show success message
                        showSuccessToast('PDF generated and downloaded successfully!');
                    } else {
                        showErrorToast('Error generating PDF: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error downloading PDF:', error);
                    showErrorToast('Error downloading PDF report');
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }
        
        function showSuccessToast(message) {
            // Create toast notification
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-white bg-success border-0';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Show toast
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                document.body.removeChild(toast);
            });
        }
        
        function showErrorToast(message) {
            // Create error toast notification
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-white bg-danger border-0';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Show toast
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                document.body.removeChild(toast);
            });
        }
        
        function hideAnnouncements() {
            document.getElementById('announcementsSection').style.display = 'none';
            document.getElementById('welcomeSection').style.display = 'block';
        }
        
        function loadAnnouncements() {
            fetch('/member/announcements')
                .then(response => response.json())
                .then(data => {
                    console.log('Announcements data:', data); // Debug log
                    if (data.success) {
                        displayAnnouncements(data.announcements);
                    } else {
                        console.error('Failed to load announcements:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading announcements:', error);
                });
        }
        
        function displayAnnouncements(announcements) {
            const container = document.getElementById('announcementsList');
            
            if (!announcements || announcements.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-megaphone display-1 text-muted mb-3"></i>
                        <h5>No Announcements</h5>
                        <p class="text-muted">There are no announcements at the moment.</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            announcements.forEach(announcement => {
                const priorityClass = announcement.priority === 'urgent' ? 'urgent' : 
                                     announcement.priority === 'important' ? 'important' : 'normal';
                const priorityBadge = announcement.priority === 'urgent' ? 'Urgent' : 
                                     announcement.priority === 'important' ? 'Important' : 'Normal';
                
                html += `
                    <div class="announcement-card ${priorityClass}">
                        <div class="announcement-header">
                            <div class="announcement-title-row">
                                <h6 class="announcement-title">
                                    <i class="bi bi-megaphone-fill me-2"></i>${announcement.title}
                                </h6>
                                <span class="priority-badge priority-${priorityClass}">${priorityBadge}</span>
                            </div>
                            <div class="announcement-meta">
                                <i class="bi bi-person me-1"></i>${announcement.created_by}
                                <i class="bi bi-calendar ms-3 me-1"></i>${formatDate(announcement.created_at)}
                                ${announcement.expiry_date ? `<i class="bi bi-clock ms-3 me-1"></i>Expires: ${formatDate(announcement.expiry_date)}` : ''}
                            </div>
                        </div>
                        <div class="announcement-message">${announcement.message}</div>
                        ${announcement.image ? `
                            <div class="announcement-image-container position-relative">
                                <img src="${announcement.image}" alt="Announcement Image" class="announcement-image-display" 
                                     onerror="console.error('Image failed to load:', '${announcement.image}'); this.style.display='none';" 
                                     onload="console.log('Image loaded successfully:', '${announcement.image}');">
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <button type="button" class="btn btn-primary btn-sm rounded-circle shadow-lg" onclick="viewAnnouncementImage('${announcement.image}', '${announcement.title}')" style="opacity: 0.9;">
                                        <i class="bi bi-zoom-in"></i>
                                    </button>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }
        
        // View Announcement Image Modal
        function viewAnnouncementImage(imageSrc, title) {
            // Remove existing modal if present
            const existingModal = document.getElementById('announcementImageModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Create modal HTML
            const modalHtml = `
                <div class="modal fade" id="announcementImageModal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">
                                    <i class="bi bi-image me-2"></i>${title}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center p-3">
                                <img src="${imageSrc}" alt="${title}" class="img-fluid rounded" style="max-height: 70vh;">
                            </div>
                            <div class="modal-footer">
                                <a href="${imageSrc}" download="announcement-${title.replace(/[^a-z0-9]/gi, '_').toLowerCase()}.jpg" class="btn btn-success">
                                    <i class="bi bi-download me-1"></i>Download
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Add modal to page
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('announcementImageModal'));
            modal.show();
            
            // Remove modal from DOM after it's hidden
            document.getElementById('announcementImageModal').addEventListener('hidden.bs.modal', function () {
                this.remove();
            });
        }
        
        function loadPaymentHistory() {
            console.log('loadPaymentHistory function called');
            
            // Load payment data from backend
            fetch('/member/payments/history', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Payment history response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Payment history data received:', data);
                console.log('Raw payments from API:', data.payments);
                
                if (data.success) {
                    const payments = data.payments.map(payment => ({
                        id: payment.id,
                        payment_type: payment.payment_type,
                        amount: payment.amount,
                        description: payment.description,
                        payment_method: payment.payment_method,
                        sender_name: payment.sender_name,
                        installment_type: payment.installment_type,
                        payment_year: payment.payment_year,
                        status: payment.status,
                        created_at: payment.created_at,
                        attachment: payment.attachment,
                        user_id: payment.user_id,
                        user_name: payment.user ? payment.user.name : 'Unknown',
                        user_role: data.user_role
                    }));
                    
                    console.log('Processed payments:', payments);
                    console.log('Sample payment user_id:', payments[0]?.user_id);
                    console.log('Sample payment user_name:', payments[0]?.user_name);
                    
                    // Store payments globally for filtering
                    window.allPayments = payments;
                    
                    populateYearFilter(payments);
                    
                    // Display all payments initially
                    displayPaymentHistoryByYear(payments, data.user_role);
                    updatePaymentStatistics(payments, data.user_role);
                } else {
                    console.error('Error loading payment history:', data.message);
                    // Show empty state on error
                    displayPaymentHistoryByYear([], 'member');
                    updatePaymentStatistics([], 'member');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show empty state on error
                displayPaymentHistoryByYear([], 'member');
                updatePaymentStatistics([], 'member');
            });
        }

        function populateYearFilter(payments) {
            const yearSelect = document.getElementById('yearFilter');
            const years = [...new Set(payments.map(p => parseInt(p.payment_year)))].sort((a, b) => b - a);
            
            console.log('Populating year filter with years:', years);
            
            // Clear existing options except first
            yearSelect.innerHTML = '<option value="">Miaka Yote</option>';
            
            // Add year options
            years.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            });
        }

        function filterByYear() {
            const yearFilter = document.getElementById('yearFilter').value;
            const typeFilter = document.getElementById('paymentTypeFilter').value;
            
            console.log('filterByYear called - Year:', yearFilter, 'Type:', typeFilter);
            
            let filteredPayments = window.allPayments;
            
            // Apply year filter
            if (yearFilter) {
                filteredPayments = filteredPayments.filter(p => p.payment_year == yearFilter);
            }
            
            // Filter by type
            if (typeFilter) {
                filteredPayments = filteredPayments.filter(p => {
                    console.log(`Checking payment type: ${p.payment_type} === ${typeFilter}`, p.payment_type === typeFilter);
                    return p.payment_type === typeFilter;
                });
                console.log('After type filter:', filteredPayments);
            }
            
            console.log('Final filtered payments:', filteredPayments);
            
            // Display filtered results
            displayPaymentHistoryByYear(filteredPayments);
            
            // Update statistics based on filtered results
            updatePaymentStatistics(filteredPayments, 'member');
        }

        function updateStatisticsForYear(selectedYear) {
            // This function is no longer needed - using updatePaymentStatistics instead
            console.log('updateStatisticsForYear is deprecated, use updatePaymentStatistics');
        }

        function displayPaymentHistoryByYear(payments, userRole) {
            const paymentHistoryList = document.getElementById('paymentHistoryList');
            
            if (payments.length === 0) {
                paymentHistoryList.innerHTML = `
                    <div class="empty-state">
                        <i class="bi bi-receipt"></i>
                        <h5>Hakuna Malipo Bado</h5>
                        <p class="text-muted">Bado hujafanya malipo yoyote. Anza kufanya malipo kuona historia hapa.</p>
                        <button type="button" class="btn btn-primary mt-3" onclick="showPaymentForm()">
                            <i class="bi bi-plus-circle me-2"></i>Fanya Malipo
                        </button>
                    </div>
                `;
                return;
            }

            // Check if filters are applied
            const yearFilter = document.getElementById('yearFilter').value;
            const typeFilter = document.getElementById('paymentTypeFilter').value;
            
            console.log('displayPaymentHistoryByYear - Filters:', { yearFilter, typeFilter });
            console.log('displayPaymentHistoryByYear - Payments:', payments);
            
            // Always display the filtered payments directly, don't re-group
            let html = '';
            
            if (payments.length > 0) {
                const totalAmount = payments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
                const completedCount = payments.filter(p => p.status === 'success').length;
                
                html += `
                    <div class="year-group">
                        <div class="year-header">
                            <div>
                                <i class="bi bi-calendar3 me-2"></i>
                                ${yearFilter ? yearFilter : 'All Years'} - 
                                ${typeFilter ? getPaymentTypeLabel(typeFilter) : 'All Types'}
                                ${userRole === 'leader' ? '<span class="badge bg-warning ms-2">Leader</span>' : '<span class="badge bg-info ms-2">Member</span>'}
                            </div>
                            <div class="year-stats">
                                <span><i class="bi bi-cash-stack me-1"></i>TZS ${totalAmount.toLocaleString()}</span>
                                <span><i class="bi bi-check-circle me-1"></i>${completedCount}/${payments.length}</span>
                            </div>
                        </div>
                        <div class="year-payments">
                            ${displayPaymentsForYear(payments, userRole)}
                        </div>
                    </div>
                `;
            }

            paymentHistoryList.innerHTML = html;
        }

        function displaySpecificYearTypeDetails(payments, year, type) {
            const paymentHistoryList = document.getElementById('paymentHistoryList');
            
            // Filter payments for specific year and type
            const filteredPayments = payments.filter(p => 
                p.payment_year == year && p.payment_type === type
            );
            
            const totalAmount = filteredPayments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
            const completedCount = filteredPayments.filter(p => p.status === 'success').length;
            
            const typeLabel = getPaymentTypeLabel(type);
            
            let html = `
                <div class="year-group">
                    <div class="year-header">
                        <div>
                            <i class="bi bi-calendar3 me-2"></i>${year} - ${typeLabel}
                        </div>
                        <div class="year-stats">
                            <span><i class="bi bi-cash-stack me-1"></i>TZS ${totalAmount.toLocaleString()}</span>
                            <span><i class="bi bi-check-circle me-1"></i>${completedCount}/${filteredPayments.length}</span>
                            ${type === 'membership' ? `
                                <button class="btn btn-sm btn-light" onclick="showTopUpForm(${year})">
                                    <i class="bi bi-plus-circle me-1"></i>Top Up
                                </button>
                            ` : ''}
                        </div>
                    </div>
                    
                    <!-- Payment Analysis Chart -->
                    <div class="chart-card">
                        <h6 class="chart-title">
                            <i class="bi bi-pie-chart me-2"></i>Payment Analysis - ${year}
                        </h6>
                        <div class="chart-container">
                            <canvas id="chart-${year}-${type}"></canvas>
                        </div>
                    </div>
                    
                    <div class="year-payments">
                        ${displayPaymentsForYear(filteredPayments)}
                    </div>
                </div>
            `;
            
            paymentHistoryList.innerHTML = html;
            
            // Create pie charts for each year
            setTimeout(() => {
                createPieChartsForYear(year, filteredPayments);
            }, 100);
        }

        function displayPaymentsForYear(payments, userRole) {
            let html = '';
            
            payments.forEach(payment => {
                const statusClass = payment.status === 'completed' ? 'success' : 
                                  payment.status === 'pending' ? 'pending' : 'failed';
                const statusBadge = payment.status === 'completed' ? 'Imekamilika' : 
                                   payment.status === 'pending' ? 'Inasubiri' : 'Imeshindwa';
                const statusColor = payment.status === 'completed' ? 'success' : 
                                   payment.status === 'pending' ? 'warning' : 'danger';
                const statusIcon = payment.status === 'completed' ? 'check-circle-fill' : 
                                  payment.status === 'pending' ? 'clock-fill' : 'x-circle-fill';

                html += `
                    <div class="payment-card-modern ${statusClass}">
                        <div class="payment-card-header">
                            <div class="payment-id-section">
                                <div class="payment-id">
                                    <i class="bi bi-receipt"></i>
                                    TMCS-${String(payment.user_id || '0000').padStart(4, '0')}
                                </div>
                                <span class="badge ${userRole === 'leader' ? 'bg-warning' : 'bg-info'}">
                                    ${userRole === 'leader' ? 'Leader' : 'Member'}
                                </span>
                            </div>
                            <div class="payment-status">
                                <span class="status-badge bg-${statusColor}">
                                    <i class="bi bi-${statusIcon} me-1"></i>${statusBadge}
                                </span>
                            </div>
                        </div>
                        
                        <div class="payment-card-body">
                            <div class="payment-details-grid">
                                <div class="payment-detail-item">
                                    <label class="detail-label">Aina ya Malipo</label>
                                    <div class="detail-value">
                                        <i class="bi bi-tag-fill text-primary me-1"></i>
                                        ${getPaymentTypeLabel(payment.payment_type)}
                                    </div>
                                </div>
                                
                                <div class="payment-detail-item">
                                    <label class="detail-label">Kiasi</label>
                                    <div class="detail-value amount-value">
                                        <i class="bi bi-cash-stack text-success me-1"></i>
                                        TZS ${parseInt(payment.amount).toLocaleString()}
                                    </div>
                                </div>
                                
                                <div class="payment-detail-item">
                                    <label class="detail-label">Tarehe</label>
                                    <div class="detail-value">
                                        <i class="bi bi-calendar3 text-info me-1"></i>
                                        ${formatDate(payment.created_at)}
                                    </div>
                                </div>
                                
                                <div class="payment-detail-item">
                                    <label class="detail-label">Njia ya Malipo</label>
                                    <div class="detail-value">
                                        <i class="bi bi-phone text-secondary me-1"></i>
                                        ${getPaymentMethodLabel(payment.payment_method)}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="payment-user-section">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">TMCS - ${payment.user_name}</div>
                                        <small class="text-muted">Member</small>
                                    </div>
                                </div>
                                
                                <i class="bi bi-eye text-primary" onclick="viewPaymentDetails('${payment.id}')" title="Ona Maelezo" style="cursor: pointer; font-size: 1rem;"></i>
                            </div>
                        </div>
                    </div>
                `;
            });

            return html;
        }

        function showTopUpForm(year) {
            // Set the year in payment form
            document.getElementById('paymentYear').value = year;
            document.getElementById('paymentType').value = 'membership';
            
            // Show payment form
            showPaymentForm();
            
            // Scroll to form
            document.getElementById('paymentFormSection').scrollIntoView({ behavior: 'smooth' });
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        function getPaymentTypeLabel(type) {
            const labels = {
                'membership': 'Ada ya Uanachama',
                'certificate': 'Ada ya Cheti',
                'zaka': 'Zaka',
                'donation': 'Mchango',
                'event': 'Usajili wa Tukio',
                'other': 'Nyingine'
            };
            return labels[type] || type;
        }

        function getPaymentMethodLabel(method) {
            const labels = {
                'mpesa': 'M-Pesa',
                'bank': 'Benki'
            };
            return labels[method] || method;
        }

        function displayPaymentHistory(paymentsToShow) {
            const paymentHistoryList = document.getElementById('paymentHistoryList');
            
            if (paymentsToShow.length === 0) {
                paymentHistoryList.innerHTML = `
                    <div class="empty-state">
                        <i class="bi bi-receipt"></i>
                        <h5>Hakuna Malipo Bado</h5>
                        <p class="text-muted">Bado hujafanya malipo yoyote. Anza kufanya malipo kuona historia hapa.</p>
                        <button type="button" class="btn btn-primary mt-3" onclick="showPaymentForm()">
                            <i class="bi bi-plus-circle me-2"></i>Fanya Malipo
                        </button>
                    </div>
                `;
                return;
            }

            let html = '';
            paymentsToShow.forEach(payment => {
                const statusClass = payment.status === 'success' ? 'success' : 
                                  payment.status === 'pending' ? 'pending' : 'failed';
                const statusBadge = payment.status === 'success' ? 'Imekamilika' : 
                                   payment.status === 'pending' ? 'Inasubiri' : 'Imeshindwa';
                const statusColor = payment.status === 'success' ? 'success' : 
                                   payment.status === 'pending' ? 'warning' : 'danger';

                html += `
                    <div class="payment-card ${statusClass}">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <h6 class="mb-1">${payment.user_id}</h6>
                                <small class="text-muted">${payment.user_name}</small>
                            </div>
                            <div class="col-md-2">
                                <h6 class="mb-1">${payment.type}</h6>
                                <small class="text-muted">${payment.date}</small>
                            </div>
                            <div class="col-md-2">
                                <h6 class="mb-1">TZS ${payment.amount}</h6>
                                <small class="text-muted">${payment.method}</small>
                            </div>
                            <div class="col-md-2">
                                <span class="status-badge bg-${statusColor}">${statusBadge}</span>
                            </div>
                            <div class="col-md-4 text-end">
                                <i class="bi bi-eye text-primary" onclick="viewPaymentDetails('${payment.id}')" title="Ona Maelezo" style="cursor: pointer; font-size: 1rem;"></i>
                            </div>
                        </div>
                    </div>
                `;
            });

            paymentHistoryList.innerHTML = html;
        }

        function updatePaymentStatistics(payments, userRole) {
            const totalPayments = payments.length;
            
            // Calculate payments by status
            const completedPayments = payments.filter(p => p.status === 'completed');
            const pendingPayments = payments.filter(p => p.status === 'pending');
            const rejectedPayments = payments.filter(p => p.status === 'rejected');
            
            // Calculate total amounts
            const totalCompletedAmount = completedPayments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
            const totalPendingAmount = pendingPayments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
            const totalRejectedAmount = rejectedPayments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
            const totalAmount = totalCompletedAmount + totalPendingAmount + totalRejectedAmount;
            
            console.log('Completed payments:', completedPayments.length);
            console.log('Pending payments:', pendingPayments.length);
            console.log('Rejected payments:', rejectedPayments.length);
            console.log('Total completed amount:', totalCompletedAmount);
            console.log('Total pending amount:', totalPendingAmount);
            console.log('Total rejected amount:', totalRejectedAmount);

            // Update the 3 sections with counts and amounts
            document.getElementById('completedPayments').textContent = completedPayments.length;
            document.getElementById('totalCompletedAmount').textContent = `TZS ${totalCompletedAmount.toLocaleString()}`;
            
            document.getElementById('pendingPayments').textContent = pendingPayments.length;
            document.getElementById('totalPendingAmount').textContent = `TZS ${totalPendingAmount.toLocaleString()}`;
            
            document.getElementById('rejectedPayments').textContent = rejectedPayments.length;
            document.getElementById('totalRejectedAmount').textContent = `TZS ${totalRejectedAmount.toLocaleString()}`;
        }

        function viewPaymentDetails(paymentId) {
            // Find the payment from all payments
            const payment = window.allPayments.find(p => p.id == paymentId);
            if (!payment) {
                alert('Payment not found');
                return;
            }
            
            // Create modal HTML
            const modalHtml = `
                <div class="modal fade" id="paymentDetailsModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">
                                    <i class="bi bi-receipt me-2"></i>Maelezo ya Malipo
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary">Maelezo ya Malipo</h6>
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td><strong>Payment ID:</strong></td>
                                                <td>${payment.id}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Aina ya Malipo:</strong></td>
                                                <td>${getPaymentTypeLabel(payment.payment_type)}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kiasi:</strong></td>
                                                <td><strong class="text-success">TZS ${parseInt(payment.amount).toLocaleString()}</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Hali:</strong></td>
                                                <td><span class="badge bg-${payment.status === 'completed' ? 'success' : payment.status === 'pending' ? 'warning' : 'danger'}">${payment.status}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tarehe:</strong></td>
                                                <td>${formatDate(payment.created_at)}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mwaka:</strong></td>
                                                <td>${payment.payment_year || 'N/A'}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Njia ya Malipo:</strong></td>
                                                <td>${payment.payment_method || 'N/A'}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>${payment.sender_name || 'N/A'}</strong></td>
                                                <td>${payment.sender_name || 'Hakuna jina'}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Maelezo:</strong></td>
                                                <td>${payment.description || 'Hakuna maelezo'}</td>
                                            </tr>
                                        </table>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Funga</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('paymentDetailsModal');
            if (existingModal) existingModal.remove();
            
            // Add modal to body and show
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modal = new bootstrap.Modal(document.getElementById('paymentDetailsModal'));
            modal.show();
        }
        
        function previewAttachment(input) {
            const file = input.files[0];
            const preview = document.getElementById('attachmentPreview');
            const previewContent = document.getElementById('attachmentPreviewContent');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const fileType = file.type;
                    
                    if (fileType.startsWith('image/')) {
                        // Show image preview
                        preview.style.display = 'block';
                        previewContent.innerHTML = `
                            <img src="${e.target.result}" class="attachment-preview" alt="Attachment Preview">
                            <div class="mt-2">
                                <small class="text-muted">File: ${file.name}</small>
                            </div>
                        `;
                    } else if (fileType === 'application/pdf') {
                        // Show PDF preview
                        preview.style.display = 'block';
                        previewContent.innerHTML = `
                            <div class="attachment-preview-pdf d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <i class="bi bi-file-earmark-pdf display-1 text-muted mb-2"></i>
                                    <h6 class="text-muted">PDF Document</h6>
                                    <p class="mb-0 text-muted">${file.name}</p>
                                    <i class="bi bi-file-earmark display-1 text-muted mb-2"></i>
                                    <h6 class="text-muted">Document</h6>
                                    <p class="mb-0"><small>${file.name}</small></p>
                                    <p class="text-muted">File type: ${fileType}</p>
                                </div>
                            </div>
                        `;
                        
                        // Also show in bottom section
                        preview.style.display = 'block';
                        previewContent.innerHTML = `
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <i class="bi bi-file-earmark display-1 text-muted mb-2"></i>
                                    <h6 class="text-muted">Document</h6>
                                    <p class="mb-0"><small>${file.name}</small></p>
                                    <p class="text-muted">File type: ${fileType}</p>
                                </div>
                            </div>
                        `;
                    }
                };
                
                reader.readAsDataURL(file);
            } else {
                // Hide preview
                preview.style.display = 'none';
                previewContent.innerHTML = '';
            }
        }
        
        function removeAttachment() {
            const input = document.getElementById('attachment');
            const preview = document.getElementById('attachmentPreview');
            const previewContent = document.getElementById('attachmentPreviewContent');
            
            // Clear the file input
            input.value = '';
            
            // Hide preview
            preview.style.display = 'none';
            previewContent.innerHTML = '';
        }
        
        function hidePaymentForm() {
            document.getElementById('paymentFormSection').style.display = 'none';
            document.getElementById('welcomeSection').style.display = 'block';
            
            // Reset installment sections
            document.getElementById('installmentOptions').style.display = 'none';
            document.getElementById('installmentInfo').style.display = 'none';
            document.getElementById('amount').readOnly = false;
            
            // Reset payment details
            document.getElementById('paymentDetailsSection').style.display = 'none';
            
            // Reset custom year
            document.getElementById('customYearDiv').style.display = 'none';
            document.getElementById('customYear').value = '';
            
            // Reset attachment
            removeAttachment();
        }
        
        function showMemberInformation() {
            hideAllSections();
            document.getElementById('informationFormSection').style.display = 'block';
            
            // Close mobile sidebar if open
            const sidebar = document.getElementById('memberSidebarMenu');
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
            
            // Fetch fresh user data from database
            fetch('/member/current-user')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayMemberInformation(data.user);
                    } else {
                        alert('Failed to load user information');
                    }
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                    alert('Error loading user information');
                });
        }
        
        function hideMemberInformation() {
            document.getElementById('informationFormSection').style.display = 'none';
            document.getElementById('welcomeSection').style.display = 'block';
        }
        
        function showDashboard() {
            console.log('showDashboard function called');
            hideAllSections();
            document.getElementById('welcomeSection').style.display = 'block';
            
            // Close mobile sidebar if open
            const sidebar = document.getElementById('memberSidebarMenu');
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
            
            // Refresh payment summary data when returning to dashboard
            loadPaymentSummary();
        }
        
        function showMyProfile() {
            console.log('showMyProfile function called');
            hideAllSections();
            document.getElementById('myProfileSection').style.display = 'block';
            
            // Close mobile sidebar if open
            const sidebar = document.getElementById('memberSidebarMenu');
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
            
            loadUserProfile();
            
            // Fetch fresh user data from database
            fetch('/member/current-user')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayMyProfile(data.user);
                    } else {
                        alert('Failed to load profile information');
                    }
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                    alert('Error loading profile information');
                });
        }
        
        function hideMyProfile() {
            document.getElementById('myProfileSection').style.display = 'none';
            document.getElementById('welcomeSection').style.display = 'block';
        }
        
        function loadUserProfile() {
            // Fetch fresh user data from database
            fetch('/member/current-user')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayMyProfile(data.user);
                    } else {
                        console.error('Failed to load profile information:', data.message);
                        // Show error message in profile section
                        document.getElementById('myProfileContent').innerHTML = `
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Failed to load profile information. Please try again.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                    // Show error message in profile section
                    document.getElementById('myProfileContent').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Error loading profile information. Please check your connection.
                        </div>
                    `;
                });
        }
        
        function displayMyProfile(user) {
            const profileHtml = `
                <div class="row">
                    <!-- Profile Picture Section -->
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <div class="profile-upload-area position-relative">
                                <div class="profile-image-container">
                                    ${user.profile_picture ? 
                                        `<img src="/uploads/profiles/${user.profile_picture}" class="img-fluid rounded-circle shadow-lg" style="max-width: 150px; height: 150px; object-fit: cover; border: 4px solid #6c5ce7;" alt="Profile Picture">` :
                                        `<div class="bg-gradient rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 150px; height: 150px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="bi bi-person fs-1 text-white"></i>
                                        </div>`
                                    }
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                        <i class="bi bi-patch-check me-1"></i>${user.role || 'Member'}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/member/profile" class="btn btn-gradient btn-sm px-4 py-2 shadow-sm">
                                <i class="bi bi-pencil-square me-1"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                    
                    <!-- Complete Database Profile Information Section -->
                    <div class="col-md-8">
                        <div class="card border-0 bg-gradient shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title text-primary mb-1 fw-bold">
                                            <i class="bi bi-person-badge me-2"></i>Complete Database Profile
                                        </h5>
                                        <p class="text-muted mb-0 small">All your profile information from the database</p>
                                    </div>
                                    <div class="status-badge">
                                        <span class="badge bg-success pulse-animation">
                                            <i class="bi bi-check-circle me-1"></i>Active
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Basic Information -->
                                <div class="info-section mb-4">
                                    <h6 class="section-title text-secondary mb-3">
                                        <i class="bi bi-info-circle me-2"></i>Basic Information
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">🏷️ Member ID</label>
                                                <div class="info-value">TMCS-${String(user.id || '0000').padStart(4, '0')}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">👤 Full Name</label>
                                                <div class="info-value">${user.name || 'Not provided'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Contact Information -->
                                <div class="info-section mb-4">
                                    <h6 class="section-title text-secondary mb-3">
                                        <i class="bi bi-telephone me-2"></i>Contact Information
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">📧 Email Address</label>
                                                <div class="info-value">${user.email || 'Not provided'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">📞 Phone Number</label>
                                                <div class="info-value">${user.phone_number || 'Not provided'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Academic Information -->
                                <div class="info-section mb-4">
                                    <h6 class="section-title text-secondary mb-3">
                                        <i class="bi bi-book me-2"></i>Academic Information
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">📚 Year of Study</label>
                                                <div class="info-value">${user.year_of_study || 'Not provided'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">⚧️ Gender</label>
                                                <div class="info-value">${user.gender || 'Not specified'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Registration Information -->
                                <div class="info-section mb-4">
                                    <h6 class="section-title text-secondary mb-3">
                                        <i class="bi bi-calendar-check me-2"></i>Registration Information
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">📅 Registration Date</label>
                                                <div class="info-value">${user.registration_date ? new Date(user.registration_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Not provided'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">🛡️ Membership Status</label>
                                                <div class="info-value">
                                                    <span class="badge bg-success">${user.membership_status || 'Active'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Church Information -->
                                <div class="info-section mb-4">
                                    <h6 class="section-title text-secondary mb-3">
                                        <i class="bi bi-house me-2"></i>Church Information
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">🏠 Home Diocese</label>
                                                <div class="info-value">${user.home_diocese || 'Not provided'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">📋 Registration Number</label>
                                                <div class="info-value">${user.registration_number || 'Not provided'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- System Information -->
                                <div class="info-section">
                                    <h6 class="section-title text-secondary mb-3">
                                        <i class="bi bi-gear me-2"></i>System Information
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">🏆 Role</label>
                                                <div class="info-value">
                                                    <span class="badge bg-primary">${user.role || 'Member'}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">✉️ Email Verified</label>
                                                <div class="info-value">
                                                    ${user.email_verified_at ? 
                                                        `<span class="badge bg-success">Verified</span>` : 
                                                        (user.membership_status === 'Active' ? 
                                                            `<span class="badge bg-success">Verified</span>` : 
                                                            `<span class="badge bg-warning">Not verified</span>`
                                                        )
                                                    }
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">🕐 Account Created</label>
                                                <div class="info-value">${user.created_at ? new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Not provided'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="info-label">🕐 Last Updated</label>
                                                <div class="info-value">${user.updated_at ? new Date(user.updated_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Not provided'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <style>
                    .profile-image-container {
                        position: relative;
                        display: inline-block;
                    }
                    
                    .btn-gradient {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        border: none;
                        color: white;
                        border-radius: 25px;
                        transition: all 0.3s ease;
                    }
                    
                    .btn-gradient:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
                        color: white;
                    }
                    
                    .info-section {
                        background: white;
                        border-radius: 12px;
                        padding: 20px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                        border-left: 4px solid #6c5ce7;
                    }
                    
                    .section-title {
                        font-weight: 600;
                        font-size: 0.9rem;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }
                    
                    .info-item {
                        background: #f8f9fa;
                        padding: 12px 15px;
                        border-radius: 8px;
                        border: 1px solid #e9ecef;
                        transition: all 0.3s ease;
                    }
                    
                    .info-item:hover {
                        background: #e9ecef;
                        transform: translateY(-1px);
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    }
                    
                    .info-label {
                        font-size: 0.75rem;
                        font-weight: 600;
                        color: #6c757d;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        display: block;
                        margin-bottom: 4px;
                    }
                    
                    .info-value {
                        font-size: 0.9rem;
                        font-weight: 500;
                        color: #2d3436;
                    }
                    
                    .pulse-animation {
                        animation: pulse 2s infinite;
                    }
                    
                    @keyframes pulse {
                        0% { transform: scale(1); }
                        50% { transform: scale(1.05); }
                        100% { transform: scale(1); }
                    }
                    
                    .status-badge {
                        animation: fadeIn 0.5s ease-in;
                    }
                    
                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(-10px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                </style>
            `;
            
            document.getElementById('myProfileContent').innerHTML = profileHtml;
        }
        
        function displayMemberInformation(user) {
            const informationHtml = `
                <div class="row">
                    <!-- Profile Picture Section -->
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            <div class="profile-upload-area">
                                ${user.profile_picture ? 
                                    `<img src="/uploads/profiles/${user.profile_picture}" class="img-fluid rounded-circle" style="max-width: 150px; height: 150px; object-fit: cover;" alt="Profile Picture">` :
                                    `<div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; margin: 0 auto;">
                                        <i class="bi bi-person fs-1 text-muted"></i>
                                    </div>`
                                }
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/member/profile" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil me-1"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                    
                    <!-- Profile Information Section -->
                    <div class="col-md-8">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-4">
                                    <i class="bi bi-person-badge me-2"></i>Personal Information
                                </h5>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-person me-2"></i>Full Name:</strong>
                                        <span class="ms-2">${user.name || 'Not provided'}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-envelope me-2"></i>Email:</strong>
                                        <span class="ms-2">${user.email || 'Not provided'}</span>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-telephone me-2"></i>Phone:</strong>
                                        <span class="ms-2">${user.phone_number || 'Not provided'}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-geo-alt me-2"></i>Address:</strong>
                                        <span class="ms-2">${user.address || 'Not provided'}</span>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-calendar me-2"></i>Date of Birth:</strong>
                                        <span class="ms-2">${user.date_of_birth ? new Date(user.date_of_birth).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Not provided'}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-gender me-2"></i>Gender:</strong>
                                        <span class="ms-2">${user.gender || 'Not specified'}</span>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-calendar-check me-2"></i>Registration Date:</strong>
                                        <span class="ms-2">${user.registration_date ? new Date(user.registration_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'Not provided'}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-card-text me-2"></i>Registration Number:</strong>
                                        <span class="ms-2">${user.registration_number || 'Not provided'}</span>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-church me-2"></i>Home Diocese:</strong>
                                        <span class="ms-2">${user.home_diocese || 'Not provided'}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-shield-check me-2"></i>Membership Status:</strong>
                                        <span class="ms-2">
                                            <span class="badge bg-success">${user.membership_status || 'Active'}</span>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-card me-2"></i>Member ID:</strong>
                                        <span class="ms-2">TMCS-${String(user.id || '0000').padStart(4, '0')}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-book me-2"></i>Year of Study:</strong>
                                        <span class="ms-2">${user.year_of_study || 'Not provided'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            
            document.getElementById('memberDetailsContent').innerHTML = informationHtml;
        }
        
        function createPieChartsForYear(year, payments) {
            // Calculate membership fee progress for the year
            const totalMembershipFee = 2000;
            const completedPayments = payments.filter(p => p.status === 'completed' && p.payment_type === 'membership');
            const paidAmount = completedPayments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
            const remainingAmount = totalMembershipFee - paidAmount;
            
            // Prepare data for pie chart
            const chartData = [];
            const chartLabels = [];
            const chartColors = [];
            
            // Add paid amount if > 0
            if (paidAmount > 0) {
                chartData.push(paidAmount);
                chartLabels.push(`Imelipwa (${((paidAmount / totalMembershipFee) * 100).toFixed(1)}%)`);
                chartColors.push('#28a745'); // Green for paid
            }
            
            // Add remaining amount if > 0
            if (remainingAmount > 0) {
                chartData.push(remainingAmount);
                chartLabels.push(`Imebaki (${((remainingAmount / totalMembershipFee) * 100).toFixed(1)}%)`);
                chartColors.push('#dc3545'); // Red for remaining
            }
            
            // Create pie chart
            const ctx = document.getElementById(`chart-${year}-${payments[0]?.payment_type || 'membership'}`);
            if (ctx) {
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            data: chartData,
                            backgroundColor: chartColors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const percentage = ((value / totalMembershipFee) * 100).toFixed(1);
                                        return `${label}: TZS ${value.toLocaleString()}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
        
        // Reset Payment Form Function
        function resetPaymentForm() {
            // Reset the form
            const paymentForm = document.getElementById('paymentForm');
            if (paymentForm) {
                paymentForm.reset();
                
                // Reset payment type to default
                const paymentType = document.getElementById('paymentType');
                if (paymentType) {
                    paymentType.value = '';
                }
                
                // Reset year to default
                const paymentYear = document.getElementById('paymentYear');
                if (paymentYear) {
                    paymentYear.value = '';
                }
                
                // Hide custom year input
                const customYearDiv = document.getElementById('customYearDiv');
                if (customYearDiv) {
                    customYearDiv.style.display = 'none';
                }
                
                // Reset amount
                const amount = document.getElementById('amount');
                if (amount) {
                    amount.value = '';
                }
                
                // Clear attachment preview
                const attachmentPreviewContent = document.getElementById('attachmentPreviewContent');
                if (attachmentPreviewContent) {
                    attachmentPreviewContent.innerHTML = '';
                }
                
                // Reset file input
                const fileInput = document.getElementById('paymentAttachment');
                if (fileInput) {
                    fileInput.value = '';
                }
                
                // Show success message
                alert('Payment form has been reset successfully!');
            }
        }
    </script>
</body>
</html>
