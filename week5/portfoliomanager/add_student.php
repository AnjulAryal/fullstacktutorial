<?php
// PART 2 — Add Student Info Page (add_student.php)
require_once 'includes/functions.php';
require_once 'includes/header.php';

$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $skills = $_POST['skills'] ?? '';
        
        // Validate name
        if (empty($name)) {
            throw new Exception("Name is required.");
        }
        
        // Format and validate name
        $name = formatName($name);
        
        if (strlen($name) < 2) {
            throw new Exception("Name must be at least 2 characters long.");
        }
        
        // Validate email
        if (empty($email)) {
            throw new Exception("Email is required.");
        }
        
        if (!validateEmail($email)) {
            throw new Exception("Invalid email address format.");
        }
        
        // Validate and process skills
        if (empty($skills)) {
            throw new Exception("Skills are required.");
        }
        
        // Clean skills string
        $skills = cleanSkills($skills);
        
        // Convert skills string into an array using explode()
        $skillsArray = explode(',', $skills);
        
        // Trim each skill and filter empty values
        $skillsArray = array_map('trim', $skillsArray);
        $skillsArray = array_filter($skillsArray, function($skill) {
            return !empty($skill);
        });
        
        if (empty($skillsArray)) {
            throw new Exception("Please provide at least one valid skill.");
        }
        
        // Save student info into students.txt
        saveStudent($name, $email, $skillsArray);
        
        $message = "Student information saved successfully!";
        $messageType = 'success';
        
        // Clear form data on success
        $_POST = [];
        
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = 'error';
    }
}
?>

<h2>Add Student Information</h2>

<?php if (!empty($message)): ?>
    <div class="message <?php echo $messageType; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="name">Full Name: *</label>
        <input 
            type="text" 
            id="name" 
            name="name" 
            value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
            placeholder="Enter student's full name"
            required
        >
    </div>
    
    <div class="form-group">
        <label for="email">Email Address: *</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
            placeholder="student@example.com"
            required
        >
    </div>
    
    <div class="form-group">
        <label for="skills">Skills (comma-separated): *</label>
        <input 
            type="text" 
            id="skills" 
            name="skills" 
            value="<?php echo isset($_POST['skills']) ? htmlspecialchars($_POST['skills']) : ''; ?>"
            placeholder="PHP, JavaScript, MySQL, HTML, CSS"
            required
        >
        <small style="color: #666; display: block; margin-top: 5px;">
            Enter skills separated by commas (e.g., PHP, JavaScript, MySQL)
        </small>
    </div>
    
    <button type="submit">Save Student</button>
</form>

<div style="margin-top: 20px;">
    <a href="students.php" style="color: #007bff; text-decoration: none;">View All Students →</a>
</div>

<?php
include 'includes/footer.php';
?>