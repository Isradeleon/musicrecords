@extends('index')

@section('title', 'MusicRecords | Sign in')

@section('body')
<div class="jumbotron">
	<div class="container">
	<div class="row">
	<h4 class="col-sm-offset-2">Sign yourself in</h4>
		<form id="formulario" class="horizontal" method="post" 
		action="/registration">
		{{ csrf_field() }}
		<div class="row">
		<div class="col-sm-4 col-sm-offset-2">
			<fieldset class="form-group">
				<label class="label-control" for="name">Name</label>
				<input class="form-control" placeholder="Type your name" type="text" name="name" id="name" value="{{old('name')}}">
			</fieldset>
			<fieldset class="form-group">
				<label class="label-control" for="lastname">Last name</label>
				<input class="form-control" placeholder="Type your lastname" type="text" name="lastname" id="lastname" 
				value="{{old('lastname')}}">
			</fieldset>
			<fieldset class="form-group">
				<label class="label-control" for="sex">Sex</label>
				<select class="form-control" name="sex" id="sex">
				@if(old('sex')=='F')
					<option value="F" selected>Female</option>
					<option value="M">Male</option>
				@elseif(old('sex')=='M')
					<option value="M" selected>Male</option>
					<option value="F">Female</option>
				@else
					<option value="M" selected>Male</option>
					<option value="F">Female</option>
				@endif
				</select>
			</fieldset>
		</div>
		<div class="col-sm-4">
			<fieldset class="form-group">
				<label class="label-control" for="email">E-Mail</label>
				<input class="form-control" placeholder="Type your email" type="email" name="email" id="email" value="{{old('email')}}">
			</fieldset>
			<fieldset class="form-group">
				<label class="label-control" for="password">Password</label>
				<input class="form-control" placeholder="Type your password" type="password" name="password" id="password">
			</fieldset>
			<fieldset class="form-group">
				<label class="label-control" for="password2">Confirm password</label>
				<input class="form-control" placeholder="Type your pass again" type="password" name="password2" id="password2">
			</fieldset>
			<fieldset class="pull-right">
				<button id="bttn" class="btn btn-primary">Sign in</button>
			</fieldset>
		</div>
		</div>
		</form>
	</div>
	@if(Session::has('errors'))
	<br>
	<div class="row" align="center">
		@foreach(Session::get('errors') as $error)
		<p align="center" 
		style="font-size: 16px; 
				color: #900;">***{{$error}}***</p>
		@endforeach
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