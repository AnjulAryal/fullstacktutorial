<?php
	class Student{
		private PDO $pdo;

		  // Constructor receives PDO connection
		public function __construct(PDO $pdo){
			$this->pdo = $pdo;
		}

		//GetAll Student Functions
		public function getAll(){
			$sql =  "SELECT * FROM students";
			$stmt = $this->pdo->query($sql);
			return $stmt->fetchAll();
		}

		//Get a Student by its id
		public function find($id){
		    $sql = "SELECT * FROM students WHERE id = ?";
		    $stmt = $this->pdo->prepare($sql);
		    $stmt->execute([$id]);
		    return $stmt->fetch();
		}

		// Create a Students
		public function create($name, $email, $course){
		    $sql = "INSERT INTO students (name, email, course) VALUES (?, ?, ?)";
		    $stmt = $this->pdo->prepare($sql);
		    return $stmt->execute([$name, $email, $course]);
		}

		//Edit a students
		public function update($id, $name, $email, $course){
		    $sql = "UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?";
		    $stmt = $this->pdo->prepare($sql);
		    return $stmt->execute([$name, $email, $course, $id]);
		}

		//Delete the student
		public function delete($id){
		    $sql = "DELETE FROM students WHERE id = ?";
		    $stmt = $this->pdo->prepare($sql);
		    return $stmt->execute([$id]);
		}	
	}
?>