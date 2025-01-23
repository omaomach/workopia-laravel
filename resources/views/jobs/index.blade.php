@extends('layout')

@section('content')
<h1>Available Jobs</h1>
<ul>
    @forelse ($jobs as $job)
    <!-- <li>{{ $loop->iteration }} {{ $job }}</li> -->
    <!-- <li>{{ $loop->index }} {{ $job }}</li> -->
    @if ($loop->first)
    <li>First: {{ $job }}</li>
    @else
    <li>{{ $job }}</li>
    @endif
    @empty
    <li>No jobs available</li>
    @endforelse
</ul>

@endsection