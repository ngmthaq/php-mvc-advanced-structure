@extends('layouts.main')

@push('css')
@endpush

@section('title', 'PHP')

@section('main')
    <p>Hello {{ $title }}</p>
@endsection

@push('js')
    <script>
        console.log(trans("_404"));
    </script>
@endpush
