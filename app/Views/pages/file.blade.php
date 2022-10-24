@extends('layouts.main.index')

@section('title', "Upload file")
    
@section('main')
    <form action="/demo" enctype="multipart/form-data" method="post">
        <input type="file" name="file" id="file">
        <button type="submit">Submit</button>
    </form>
@endsection
