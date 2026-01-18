@extends('layouts.master')

@section('content')
    <h2>Add New Student</h2>
    
    <form method="POST" action="?action=create">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>Course:</label>
            <input type="text" name="course" required>
        </div>
        
        <button type="submit" class="btn">Add Student</button>
        <a href="?action=index" class="btn" style="background: #6c757d;">Cancel</a>
    </form>
@endsection