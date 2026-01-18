@extends('layouts.master')

@section('content')
    <div style="margin: 20px 0;">
        <a href="?action=create" class="btn">Add New Student</a>
    </div>

    <table class="student-list">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student['id'] }}</td>
                <td>{{ $student['name'] }}</td>
                <td>{{ $student['email'] }}</td>
                <td>{{ $student['course'] }}</td>
                <td>
                    <a href="?action=edit&id={{ $student['id'] }}" class="btn">Edit</a>
                    <a href="?action=delete&id={{ $student['id'] }}" class="btn btn-danger" 
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection