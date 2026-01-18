<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../db.php';

use App\Models\Student;
use App\Controllers\StudentController;
use Jenssegers\Blade\Blade;

$views = __DIR__ . '/../app/views';
$cache = __DIR__ . '/../cache/views';
$blade = new Blade($views, $cache);

// Create model and controller instances
$studentModel = new Student($pdo);
$controller = new StudentController($studentModel, $blade);

// Simple routing
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'index':
        echo $controller->index();
        break;
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        } else {
            echo $controller->create();
        }
        break;
    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update($id);
        } else {
            echo $controller->edit($id);
        }
        break;
    case 'delete':
        $controller->delete($id);
        break;
    default:
        echo $controller->index();
}
?>