@extends('layout')

@section('content')
<h2>Edit Student</h2>
<form method="POST" action="/students/update/{{ $student->id }}">
@csrf
<input type="text" name="name" value="{{ $student->name }}"><br>
<input type="number" name="age" value="{{ $student->age }}"><br>
<input type="text" name="address" value="{{ $student->address }}"><br>
<input type="email" name="email" value="{{ $student->email }}"><br>
<input type="text" name="status" value="{{ $student->status }}"><br>
<button type="submit">Update</button>
</form>
@endsection