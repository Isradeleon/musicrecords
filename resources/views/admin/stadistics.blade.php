@extends('layouts.principal')

@section('title','Stadistics')

@section('content')
<br><br>
<section class="container">
	<div class="row">
        <div class="col-md-8 col-md-offset-2">
		<h4>Favorites stadistics <span class="glyphicon glyphicon-align-left"></span></h4>
		<hr>
		@if($favoritescount>0)
			@foreach($kindswithf as $kind)
				<div class="panel panel-default">
	                <div class="panel-heading">
	                	<h4 align="center">{{$kind->name}} stadistics.</h4>
	                </div>
	                <div class="panel-body">
	                	<div id="container{{$kind->id}}" style="width:100%;
	                	height:400px; margin: 0 auto;"></div>
	                </div>
	            </div>
			@endforeach
		@else
		<h5>There're no favorites registered in the database.</h5>
		@endif
        </div>
    </div>
</section>
@endsection

@section('morescripts')
<script src="/Highcharts/js/highcharts.js"></script>
<script src="/js/chartajax.js"></script>
@endsection