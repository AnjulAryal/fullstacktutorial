<?php
namespace App\Controllers;

use App\Models\Student;

class StudentController {
    private $studentModel;
    private $blade;
    
    public function __construct(Student $studentModel, $blade) {
        $this->studentModel = $studentModel;
        $this->blade = $blade;
    }
    
    public function index() {
        $students = $this->studentModel->all();
        return $this->blade->make('students.index', ['students' => $students]);
    }
    
    public function create() {
        return $this->blade->make('students.create');
    }
    
    public function store() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $course = $_POST['course'] ?? '';
        
        if ($this->studentModel->create($name, $email, $course)) {
            header('Location: /workshop8/public/index.php?action=index');
            exit();
        }
    }
    
    public function edit($id) {
        $student = $this->studentModel->find($id);
        return $this->blade->make('students.edit', ['student' => $student]);
    }
    
    public function update($id) {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $course = $_POST['course'] ?? '';
        
        if ($this->studentModel->update($id, $name, $email, $course)) {
            header('Location: /workshop8/public/index.php?action=index');
            exit();
        }
    }
    
    public function delete($id) {
        if ($this->studentModel->delete($id)) {
            header('Location: /workshop8/public/index.php?action=index');
            exit();
        }
    }
}
?>