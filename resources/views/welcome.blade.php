@extends('landingPage.layout')

@section('alert')
	@include('landingPage.alerts')
@endsection

@section('topBar')
	@include('landingPage.topBar')
@endsection

@section('tabs')
	@include('landingPage.Tabs')
@endsection

@section('sideBar')
	@include('landingPage.common.sideBars.home')
@endsection

@section('content')

@endsection
