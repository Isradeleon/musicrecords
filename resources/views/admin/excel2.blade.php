@extends('layouts.principal')

@section('title','(New version) Excel')

@section('content')
<section class="container">
<br><br>
	<section class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						<h4 align="center">(New version) Excel</h4>
					</div>
				</div>
				<div class="panel-body">
					<form enctype="multipart/form-data" class="horizontal" method="post" action="/excel2">
					{{csrf_field()}}
					<div>
						<fieldset class="form-group">
						<label class="btn btn-default btn-block"><strong><span class="glyphicon glyphicon-folder-open"></span> File</strong><input style=" display:none;" type="file" name="fileup" accept=".csv, .xls, .xlsx"></label>

						</fieldset>
						<fieldset class="form-group">
						<button class="btn btn-success btn-block">
						Upload</button>
						</fieldset>
					@if(Session::has('fileError'))
						<br>
						<h6 align="center" style="color:#900;">**{{Session::get('fileError')}}**</h6>
					@endif
					@if(Session::has('msgs'))
						<br>
						@foreach(Session::get('msgs') as $msg)
						<h6 align="center" style="color:#090;">
						**{{$msg}}**</h6>
						@endforeach
					@endif
					</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</section>
@endsection