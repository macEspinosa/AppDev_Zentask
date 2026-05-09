@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Welcome Home, {{ Auth::user()->name }}!</h4>
            </div>
            <div class="card-body">
                <p>You are successfully logged in to the Assignment Tracker System.</p>
            </div>
        </div>
    </div>
</div>
@endsection