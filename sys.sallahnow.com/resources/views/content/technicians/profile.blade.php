@extends('index')
@section('title')
    Technician
@endsection
@section('content')
    <h3>Profile : {{ $technician->name }}</h3>
@endsection
@section('js')
    {{-- script --}}
@endsection
