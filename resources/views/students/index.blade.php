@extends('layout')

@section('content')
<a href="/students/create">Add Student</a>

<h2>All Students</h2>
<table border="1">
<tr>
<th>Name</th><th>Age</th><th>Address</th><th>Email</th><th>Status</th><th>Actions</th>
</tr>
@foreach($students as $student)
<tr>
<td>{{ $student->name }}</td>
<td>{{ $student->age }}</td>
<td>{{ $student->address }}</td>
<td>{{ $student->email }}</td>
<td>{{ $student->status }}</td>
<td>
<a href="/students/edit/{{ $student->id }}">Edit</a>
<form action="/students/delete/{{ $student->id }}" method="POST" style="display:inline;">
@csrf
<button type="submit">Delete</button>
</form>
</td>
</tr>
@endforeach
</table>

<h2>Active Students</h2>
<ul>
@foreach($active as $a)
<li>{{ $a->name }}</li>
@endforeach
</ul>
@endsection