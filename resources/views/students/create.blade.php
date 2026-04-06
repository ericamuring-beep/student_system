@extends('layout')

@section('content')
<h2>Add Student</h2>
<form method="POST" action="/students/store">
@csrf
<input type="text" name="name" placeholder="Name"><br>
<input type="number" name="age" placeholder="Age"><br>
<input type="text" name="address" placeholder="Address"><br>
<input type="email" name="email" placeholder="Email"><br>
<input type="text" name="status" placeholder="active/inactive"><br>
<button type="submit">Save</button>
</form>
@endsection