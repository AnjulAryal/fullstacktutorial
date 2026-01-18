<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: #007bff; color: white; padding: 15px; }
        .student-list { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .student-list th, .student-list td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .student-list th { background-color: #f4f4f4; }
        .btn { padding: 8px 16px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; }
        .btn-danger { background: #dc3545; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"] { width: 100%; padding: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Student Management System</h1>
        </div>
        
        @yield('content')
    </div>
</body>
</html>