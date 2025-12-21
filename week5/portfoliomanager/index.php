<?php
// PART 1 — Homepage (index.php)
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'includes/header.php';
?>

<h2>Welcome to Student Portfolio Manager</h2>
<p>This application helps you manage student information and their portfolio files.</p>

<div style="margin-top: 30px;">
    <h3>Features:</h3>
    <ul style="line-height: 2; margin-left: 20px;">
        <li>📝 Add student information with name, email, and skills</li>
        <li>📤 Upload portfolio files (PDF, JPG, PNG)</li>
        <li>👥 View all registered students</li>
        <li>✅ Validated input with error handling</li>
    </ul>
</div>

<div style="margin-top: 40px; padding: 20px; background: #e9ecef; border-radius: 5px;">
    <h3>Quick Actions:</h3>
    <div style="margin-top: 15px;">
        <a href="add_student.php" style="display: inline-block; padding: 15px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">
            Add Student Info
        </a>
        <a href="upload.php" style="display: inline-block; padding: 15px 30px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">
            Upload Portfolio File
        </a>
        <a href="students.php" style="display: inline-block; padding: 15px 30px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;">
            View Students
        </a>
    </div>
</div>

<?php
include 'includes/footer.php';
?>