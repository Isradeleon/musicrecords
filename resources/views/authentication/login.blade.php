@extends('index')

@section('title', 'MusicRecords | Login')

@section('body')
<div class="jumbotron">
	<div class="container">
	<div class="row">
		<div class="col-md-6" align="center">
		</div>
		<div class="col-md-5">
		<h4>Login</h4>
		<form id="formulary" class="horizontal" method="post" action="/">
			{{ csrf_field() }}
			@if(Session::has('emailreg'))
			<fieldset class="form-group">
				<label for="email">E-Mail</label>
				<input class="form-control" placeholder="Type your email" type="email" name="email" id="email" 
				value="{{Session::get('emailreg')}}" autofocus>
			</fieldset>
			@else
			<fieldset class="form-group">
				<label for="email">E-Mail</label>
				<input class="form-control" placeholder="Type your email" type="email" name="email" id="email" value="{{old('email')}}">
			</fieldset>
			@endif
			<fieldset class="form-group">
				<label for="password">Password</label>
				<input class="form-control" placeholder="Type your password" type="password" name="password" id="password">
			</fieldset>
			<fieldset class="pull-right">
				<button id="bttn" class="btn btn-primary">Login</button>
			</fieldset>
		</form>
		<a href="/registration">Sign me up!</a>
		</div>
	</div>
	@if(Session::has('errors'))
	<br>
	<div class="row">
		<div class="col-md-6" align="center">
		</div>
		<div class="col-md-5">
		@foreach(Session::get('errors') as $error)
		<p align="center" 
		style="font-size: 16px; 
				color: #900;">*{{$error}}*</p>
		@endforeach
		</div>
	</div>
	@endif
	@if(Session::has('msg'))
	<br>
	<div class="row" align="center">
		@foreach(Session::get('msg') as $msg)
		<p align="center" 
		style="font-size: 16px; 
				color: #090;">***{{$msg}}***</p>
		@endforeach
	</div>
	@endif
	</div>
</div>
@endsection

@section('js')
<script src="/jQuery/jquery.validate.min.js"></script>
<!-- More scripts -->
@endsection