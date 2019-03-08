@extends('layouts.app')

@section('content')
    @if(\Request::is('/'))
        <div class="home_banner">
            @include('layouts.navbar')
            <div class="home_caption">
                <h1 class="text-center">Buy and sell anything, whenever, wherever you are</h1>
                <div class="search-form">
                    <form class="form-horizontal" method="POST" action="">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1" >
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control" name="query" placeholder="What are you looking for?">
                                    <span class="input-group-btn" style="width:0px"></span>
                                    <select class="form-control" style="margin-left: -1px">
                                        <option value="" class="faw"> &#xf041 </option>
                                        <option value="">Lagos</option>
                                        <option value="">Abuja</option>
                                        <option value="">Warri</option>
                                        <option value="">PHC</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <root-compo></root-compo>
            </div>
        </div>
    @else
        <div class="not_welcome">
            @include('layouts.homenavbar')
            <div class="">
                <root-compo></root-compo>
            </div>
        </div>
    @endif
@endsection