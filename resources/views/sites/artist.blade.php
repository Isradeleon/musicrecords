@extends('layouts.principal')

@section('title',$artist->name)

@section('content')
<div style="padding-bottom: 0; padding-top: 0; background-color: #111;" align="center" class="jumbotron hidden-xs">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="2000">
      <!-- Indicators -->
      <ol class="carousel-indicators">
      @foreach($albums as $album)
  	      @if($loop->first)
  	      <li data-target="#carousel-example-generic" data-slide-to="{{$loop->index}}" class="active"></li>
  	      @else
  	      <li data-target="#carousel-example-generic" data-slide-to="{{$loop->index}}"></li>
  	      @endif
      @endforeach
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
      @foreach($albums as $album)
          @if($loop->first)
          	<div class="item active">
              <img style="max-height: 400px; min-height: 400px;" src="{{$album->images->first()->source}}" alt="...">
              <div class="carousel-caption">
              </div>
            </div>
          @else
          	<div class="item">
              <img style="max-height: 400px; min-height: 400px;" class="caru" src="{{$album->images->first()->source}}" alt="...">
              <div class="carousel-caption">
              </div>
            </div>
          @endif
      @endforeach
      </div>
    </div>
</div>
<div class="container">
<div class="col-sm-6 col-sm-offset-3">
<br>
  <h3 align="center"><span class="glyphicon glyphicon-flash"></span> {{$artist->name}}</h3>
  <p align="justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
</div>
<br><br><br>
<div style="margin-bottom: 0;  background-color: #ccc;" class="jumbotron">
<br>
<div class="container">
<div class="col-sm-8 col-sm-offset-2">
  <h4 style="color:#666;"><span class="glyphicon glyphicon-headphones"></span> {{$artist->name}} albums! <small style="color:#333;"><strong>| KindOfMusic: {{$thekind->name}}</strong></small></h4>
  <div class="table-responsive" id="tabla">
    <table class="table">
      <thead>
        <tr>
          <td><strong>Album name</strong></td>
          <td><strong>Number of songs</strong></td>
          <td><strong>Link to the album</strong></td>
          @if(Auth::user()->admin)
          <td align="center"><strong>Delete whole album <span class="glyphicon glyphicon-exclamation-sign"></span></strong></td>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($albums as $key => $album)
        <tr id="tr{{$album->id}}">
          <td>{{$album->name}}</td>
          @if($album->songs->count()>0)
          <td><strong>{{$album->songs->count()}}</strong></td>
          <td><a href="/music/{{$album->kind->name}}/{{$album->artist->name}}/{{$album->name}}">Go the album!</a></td>
          @else
          <td><strong>There're no songs :(</strong></td>
          <td><i><span class="glyphicon glyphicon-exclamation-sign"></span> No songs loaded yet.</i></td>
          @endif
          @if(Auth::user()->admin)
          <td align="center"><button style="color:#D32F2F;" id="{{$album->id}}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored btnremove"><span class="glyphicon glyphicon-remove"></span></button></td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
@endsection

@section('morescripts')
<script src="/js/albumajax.js"></script>
@endsection