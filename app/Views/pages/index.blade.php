@extends('layouts.main')

@push('css')
@endpush

@section('title', 'PHP')

@section('main')
    <p>Hello World</p>

    @if (flash("success"))
        <p>{{ flash("success") }}</p>
    @endif
@endsection

@push('js')
@endpush
