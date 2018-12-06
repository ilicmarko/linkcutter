@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="title m-b-md">
    LinkCutter
</div>
<form action="/" id="shorten">
    <input type="text" name="url" placeholder="Copy the url you want to cut" class="form-control" id="url">
    <div class="valid-feedback">
        Yeah, that looks like a valid URL. Thank you!
    </div>
    <div class="invalid-feedback">
        Do you think this is funny?
    </div>

    <div class="alert alert-success alert-dismissible fade show shorturl-alert" style="display: none" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
        <h4 class="alert-heading">Here is your magical link!</h4>
        <p>This should be copiable but ain't nobody got time for that</p>
        <hr>
        <input type="text" class="shortlink-input form-control" onfocus="this.select();">
    </div>

    <h4 class="trackmore-title" id="openinfo">
        <span>Want to track link analytics?</span>
        <i class="fas fa-chevron-down"></i>
    </h4>
    <div class="trackmore-info" id="info">
        <div class="trackmore-content">
            <p>Enter your email and you will be delivered a unique URL for a stylish and fancy dashboard.</p>
            <input type="email" name="url" placeholder="Enter your email" class="form-control" id="email">
        </div>
    </div>
    <button type="submit" class="btn btn-lg btn-block btn-outline-primary">Cut it  <i class="fas fa-cut"></i></button>
</form>
@endsection
