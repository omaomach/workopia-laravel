@extends('layout')

@section('title')
    Create Job
@endsection

@section('content')
    <h1>Create New Job</h1>
    <form action="/jobs" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Job Title">
        <input type="text" name="description" placeholder="Job Description">
        <button type="submit">Create Job</button>
    </form>
@endsection
