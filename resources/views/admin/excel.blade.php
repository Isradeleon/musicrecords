@extends('layouts.principal')

@section('title','Upload an excel')

@section('content')
<section class="container">
<br><br>
	<section class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						<h4 align="center">Select the songs file</h4>
					</div>
				</div>
				<div class="panel-body">
					<form enctype="multipart/form-data" class="horizontal" method="post" action="/excel">
					{{csrf_field()}}
					<div>
						<fieldset class="form-group">
						<label class="btn btn-primary btn-block"><span class="glyphicon glyphicon-folder-open"></span> File<input style=" display:none;" type="file" name="fileup" accept=".csv, .xls, .xlsx"></label>

						</fieldset>
						<fieldset class="form-group">
						<button class="btn btn-success btn-block">
						Upload</button>
						</fieldset>
					@if(Session::has('fileError'))
						<fieldset>
							<h5 align="center"
							style="color:#900;">
							{{Session::get('fileError')}}
							</h5>
						</fieldset>
					@endif
					@if(Session::has('msgs'))
					@foreach(Session::get('msgs') as $msg)
					<fieldset>
					<h5 align="center" style="color:#090;">
					**{{$msg}}**</h5>
					</fieldset>
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