<?php
// PART 4 — View Students Page (students.php)
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Read students from file
$students = getAllStudents();
?>

<h2>Registered Students</h2>

<?php if (empty($students)): ?>
    <div class="message" style="background: #fff3cd; color: #856404; border: 1px solid #ffeeba;">
        No students registered yet. <a href="add_student.php" style="color: #856404; text-decoration: underline;">Add your first student</a>
    </div>
<?php else: ?>
    <p style="margin-bottom: 20px; color: #666;">
        Total Students: <strong><?php echo count($students); ?></strong>
    </p>
    
    <?php foreach ($students as $index => $student): ?>
        <div class="student-card">
            <h3>👤 <?php echo htmlspecialchars($student['name']); ?></h3>
            
            <p style="margin: 10px 0;">
                <strong>Email:</strong> 
                <a href="mailto:<?php echo htmlspecialchars($student['email']); ?>" style="color: #007bff; text-decoration: none;">
                    <?php echo htmlspecialchars($student['email']); ?>
                </a>
            </p>
            
            <div class="skills">
                <strong>Skills:</strong>
                <div style="margin-top: 8px;">
                    <?php foreach ($student['skills'] as $skill): ?>
                        <span class="skill-tag"><?php echo htmlspecialchars(trim($skill)); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #dee2e6;">
    <a href="add_student.php" style="display: inline-block; padding: 12px 25px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">
        ➕ Add New Student
    </a>
    <a href="index.php" style="display: inline-block; padding: 12px 25px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;">
        🏠 Back to Home
    </a>
</div>

<?php
include 'includes/footer.php';
?>