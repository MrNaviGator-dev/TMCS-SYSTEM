<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Profile Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-section { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .error { color: red; }
        .success { color: green; }
        .info { color: blue; }
        .profile-img { max-width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
        .symbol-fallback { 
            width: 150px; 
            height: 150px; 
            border-radius: 50%; 
            background: #e9ecef; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 48px; 
            color: #6c757d;
        }
    </style>
</head>
<body>
    <h1>Dashboard Profile Debug</h1>
    
    <div class="debug-section">
        <h3>Current Authenticated User Check</h3>
        <p>This will test the actual authentication state in the browser.</p>
        
        <div id="authResult">
            <p>Checking authentication...</p>
        </div>
    </div>
    
    <div class="debug-section">
        <h3>Profile Image Loading Test</h3>
        <div id="profileTest">
            <p>Testing profile image...</p>
        </div>
    </div>
    
    <div class="debug-section">
        <h3>Console Output</h3>
        <p>Check the browser console (F12) for detailed debug information.</p>
    </div>

    <script>
        // Test authentication and profile loading exactly like the dashboard
        console.log('=== DASHBOARD PROFILE DEBUG ===');
        
        // Test 1: Check if we can access the current user API
        console.log('Testing current user API...');
        
        fetch('/admin/current-user', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => {
            console.log('API Response status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('API Response data:', data);
            
            if (data.success && data.user) {
                const user = data.user;
                
                // Update auth result
                document.getElementById('authResult').innerHTML = `
                    <p class="success">Authenticated User Found:</p>
                    <p><strong>Name:</strong> ${user.name}</p>
                    <p><strong>Email:</strong> ${user.email}</p>
                    <p><strong>Role:</strong> ${user.role}</p>
                    <p><strong>Profile Picture:</strong> ${user.profile_picture || 'NULL'}</p>
                    <p><strong>ID:</strong> ${user.id}</p>
                `;
                
                // Test profile image loading
                console.log('=== PROFILE IMAGE DEBUG ===');
                console.log('User data:', user);
                console.log('Profile picture path:', user.profile_picture);
                console.log('Profile picture exists:', !!user.profile_picture);
                
                if (user.profile_picture) {
                    const imageUrl = '/uploads/profiles/' + user.profile_picture;
                    console.log('Full image URL:', imageUrl);
                    
                    // Test if image loads
                    const testImg = new Image();
                    testImg.onload = function() {
                        console.log('Image loads successfully:', imageUrl);
                        document.getElementById('profileTest').innerHTML = `
                            <p class="success">Profile Image Loads Successfully:</p>
                            <img src="${imageUrl}" class="profile-img" style="border: 2px solid green;">
                            <p>URL: ${imageUrl}</p>
                        `;
                    };
                    testImg.onerror = function() {
                        console.error('Image fails to load:', imageUrl);
                        document.getElementById('profileTest').innerHTML = `
                            <p class="error">Profile Image Fails to Load:</p>
                            <p>URL: ${imageUrl}</p>
                            <p>Will show fallback symbol in dashboard</p>
                            <div class="symbol-fallback">?</div>
                        `;
                    };
                    testImg.src = imageUrl;
                } else {
                    console.log('No profile picture, will show fallback symbol');
                    document.getElementById('profileTest').innerHTML = `
                        <p class="info">No Profile Picture Set:</p>
                        <p>This explains why you see a symbol instead of an image.</p>
                        <div class="symbol-fallback">?</div>
                        <p><strong>Solution:</strong> The current admin user needs to set a profile picture.</p>
                    `;
                }
                console.log('========================');
                
            } else {
                document.getElementById('authResult').innerHTML = `
                    <p class="error">No authenticated user found</p>
                    <p>This means you're not logged in as an admin.</p>
                `;
            }
        })
        .catch(error => {
            console.error('API Error:', error);
            document.getElementById('authResult').innerHTML = `
                <p class="error">API Error: ${error.message}</p>
                <p>This could be a network issue or authentication problem.</p>
            `;
        });
        
        console.log('================================');
    </script>
</body>
</html>
