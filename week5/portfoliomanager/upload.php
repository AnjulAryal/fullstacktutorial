<?php
// PART 3 — Upload Portfolio File (upload.php)
require_once 'includes/functions.php';
require_once 'includes/header.php';

$message = '';
$messageType = '';
$uploadedFilename = '';

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['portfolio_file'])) {
        $result = uploadPortfolioFile($_FILES['portfolio_file']);
        
        if ($result['success']) {
            $message = $result['message'];
            $messageType = 'success';
            $uploadedFilename = $result['filename'];
        } else {
            $message = $result['message'];
            $messageType = 'error';
        }
    } else {
        $message = "No file was selected for upload.";
        $messageType = 'error';
    }
}
?>

<h2>Upload Portfolio File</h2>

<?php if (!empty($message)): ?>
    <div class="message <?php echo $messageType; ?>">
        <?php echo htmlspecialchars($message); ?>
        <?php if ($messageType === 'success' && !empty($uploadedFilename)): ?>
            <br><strong>Saved as:</strong> <?php echo htmlspecialchars($uploadedFilename); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div style="background: #e9ecef; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
    <h3 style="margin-bottom: 10px;">Upload Requirements:</h3>
    <ul style="line-height: 2; margin-left: 20px;">
        <li>✅ Accepted formats: <strong>PDF, JPG, PNG</strong></li>
        <li>✅ Maximum file size: <strong>2MB</strong></li>
        <li>✅ Files will be automatically renamed and stored securely</li>
    </ul>
</div>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="portfolio_file">Select Portfolio File: *</label>
        <input 
            type="file" 
            id="portfolio_file" 
            name="portfolio_file" 
            accept=".pdf,.jpg,.jpeg,.png"
            required
        >
        <small style="color: #666; display: block; margin-top: 5px;">
            Choose a PDF, JPG, or PNG file (max 2MB)
        </small>
    </div>
    
    <button type="submit">Upload File</button>
</form>

<?php
// Display uploaded files if directory exists
$uploadDir = 'uploads/';
if (file_exists($uploadDir) && is_dir($uploadDir)) {
    $files = array_diff(scandir($uploadDir), ['.', '..']);
    
    if (!empty($files)) {
        echo '<div style="margin-top: 40px;">';
        echo '<h3>Recently Uploaded Files:</h3>';
        echo '<ul style="line-height: 2; margin-left: 20px;">';
        
        // Show only last 5 files
        $files = array_reverse(array_values($files));
        $count = 0;
        
        foreach ($files as $file) {
            if ($count >= 5) break;
            
            $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $icon = '📄';
            
            if ($fileExtension === 'pdf') {
                $icon = '📕';
            } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                $icon = '🖼️';
            }
            
            echo '<li>' . $icon . ' ' . htmlspecialchars($file) . '</li>';
            $count++;
        }
        
        echo '</ul>';
        echo '</div>';
    }
}
?>

<div style="margin-top: 20px;">
    <a href="index.php" style="color: #007bff; text-decoration: none;">← Back to Home</a>
</div>

<?php
include 'includes/footer.php';
?>