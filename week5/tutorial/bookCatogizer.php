<?php
// First we declare the function to determine book category based on length
function categorizeBook($pages) {
if ($pages < 100) {
return "Light Read";
} elseif ($pages < 300) {
return "Standard Novel";
} else {
return "Epic Saga";
}
}
// Then we call that function to categorize a particular book
$harryPotterPages = 600;
$category = categorizeBook($harryPotterPages);
echo "Harry Potter is considered " . $category;
?>