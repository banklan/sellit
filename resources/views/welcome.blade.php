@extends('layouts.app')

@section('content')
    @include('layouts.homenavbar')
    <router-view></router-view>
@endsection