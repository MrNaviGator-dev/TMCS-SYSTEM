<!DOCTYPE html>
<html>
<head>
    <title>Current Admin Profile Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .profile-test { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .profile-img { max-width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
        .error { color: red; }
        .success { color: green; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>Current Admin Profile Test</h1>
    
    <?php
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Simulate getting current admin user (first admin)
    $currentAdmin = \App\Models\User::where('role', 'admin')->first();
    
    if ($currentAdmin):
    ?>
        <div class='profile-test'>
            <h3>Current Admin: <?= $currentAdmin->name ?></h3>
            <p><strong>Email:</strong> <?= $currentAdmin->email ?></p>
            <p><strong>Profile Picture:</strong> <?= $currentAdmin->profile_picture ?: 'NULL' ?></p>
            
            <?php if ($currentAdmin->profile_picture): ?>
                <?php 
                $imageUrl = asset('uploads/profiles/' . $currentAdmin->profile_picture);
                $filePath = public_path('uploads/profiles/' . $currentAdmin->profile_picture);
                ?>
                <p><strong>Image URL:</strong> <a href='<?= $imageUrl ?>' target='_blank'><?= $imageUrl ?></a></p>
                <p><strong>File Path:</strong> <?= $filePath ?></p>
                <p><strong>File Exists:</strong> <span class="<?= file_exists($filePath) ? 'success' : 'error' ?>"><?= file_exists($filePath) ? 'YES' : 'NO' ?></span></p>
                
                <p><strong>Image Test:</strong></p>
                <img src='<?= $imageUrl ?>' class='profile-img' 
                     onerror='this.style.border="2px solid red"; this.nextSibling.innerHTML="Failed to load";' 
                     onload='this.style.border="2px solid green"; this.nextSibling.innerHTML="Loaded successfully";'>
                <span class='info'>Loading...</span>
            <?php else: ?>
                <p><span class='error'>No profile picture set</span></p>
                <p><strong>Fallback Test:</strong></p>
                <img src='<?= asset('uploads/profiles/default-avatar.svg') ?>' class='profile-img' 
                     onerror='this.nextSibling.innerHTML="Fallback failed";' 
                     onload='this.nextSibling.innerHTML="Fallback loaded successfully";'>
                <span class='info'>Loading fallback...</span>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class='profile-test'>
            <p><span class='error'>No admin user found</span></p>
        </div>
    <?php endif; ?>
    
    <div class='profile-test'>
        <h3>JavaScript Test (Simulating Dashboard)</h3>
        <p>This simulates how the dashboard loads the profile:</p>
        
        <div id="profileContent">
            <p>Loading profile...</p>
        </div>
    </div>
    
    <script>
        // Simulate the dashboard profile loading
        const currentUser = {
            id: <?= $currentAdmin->id ?>,
            name: "<?= $currentAdmin->name ?>",
            email: "<?= $currentAdmin->email ?>",
            profile_picture: <?= $currentAdmin->profile_picture ? '"' . $currentAdmin->profile_picture . '"' : 'null' ?>,
            role: "<?= $currentAdmin->role ?>",
            membership_status: "<?= $currentAdmin->membership_status ?>"
        };
        
        console.log('=== PROFILE DEBUG ===');
        console.log('User data:', currentUser);
        console.log('Profile picture path:', currentUser.profile_picture);
        console.log('Profile picture exists:', !!currentUser.profile_picture);
        
        if (currentUser.profile_picture) {
            const imageUrl = "<?= asset('uploads/profiles/') ?>" + currentUser.profile_picture;
            console.log('Full image URL:', imageUrl);
            
            // Test if image loads
            const testImg = new Image();
            testImg.onload = function() {
                console.log('Image loads successfully:', imageUrl);
            };
            testImg.onerror = function() {
                console.error('Image fails to load:', imageUrl);
            };
            testImg.src = imageUrl;
        }
        console.log('==================');
        
        // Simulate displayMyProfile function
        const profileHtml = `
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="profile-section">
                        ${currentUser.profile_picture ? 
                            `<img src="<?= asset('uploads/profiles/') ?>${currentUser.profile_picture}" class="img-fluid rounded-circle mb-3" style="max-width: 150px; height: 150px; object-fit: cover;" alt="Profile Picture" onerror="this.onerror=null; this.src='<?= asset('uploads/profiles/default-avatar.svg') ?>'; console.log('Profile image failed to load, using fallback:', this.src);">` :
                            `<div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; margin: 0 auto;">
                                <i class="bi bi-person fs-1 text-muted"></i>
                            </div>`
                        }
                        <h6 class="text-primary">TMCS-${String(currentUser.id).padStart(4, '0')}</h6>
                        <p class="text-muted small">${currentUser.name}</p>
                        <span class="badge bg-${currentUser.role === 'admin' ? 'danger' : currentUser.role === 'leader' ? 'warning' : 'primary'} badge-sm">
                            ${currentUser.role.charAt(0).toUpperCase() + currentUser.role.slice(1)}
                        </span>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('profileContent').innerHTML = profileHtml;
    </script>
</body>
</html>
