@extends('layouts.principal')

@section('title','Favorites')

@section('content')
<div style="padding-bottom: 0; padding-top: 0; background-color: #111;" align="center" class="jumbotron  hidden-xs">
@if(Auth::user()->favorites->count()>0)
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="2000">
      <!-- Indicators -->
      <ol class="carousel-indicators">
      @foreach($images as $image)
	      @if($loop->first)
	      <li data-target="#carousel-example-generic" data-slide-to="{{$loop->index}}" class="active"></li>
	      @else
	      <li data-target="#carousel-example-generic" data-slide-to="{{$loop->index}}"></li>
	      @endif
      @endforeach
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
      @foreach($images as $image)
      @if($loop->first)
      	<div class="item active">
          <img style="max-height: 400px; min-height: 400px;" src="{{$image->source}}" alt="...">
          <div class="carousel-caption">
          </div>
        </div>
      @else
      	<div class="item">
          <img style="max-height: 400px; min-height: 400px;" src="{{$image->source}}" alt="...">
          <div class="carousel-caption">
          </div>
        </div>
      @endif
      @endforeach
      </div>
    </div>
@else
<br>
<h3 align="center" style="color:#eee;">There's no images to show.</h3>
<h4 align="center" style="color:#eee;">Add some favorites man!</h4>
<br>
@endif
</div>

<div class="container">
<div class="col-sm-8 col-sm-offset-2">
  <h3 style="color:#333;"><span class="glyphicon glyphicon-star-empty"></span> Favorites section</h3>
  <hr>
  <div align="center" class="col-sm-4">
    <img class="img-responsive" src="/img/music.png">
  </div>
  <div style="color:#333;" class="col-sm-8">   
    <h4>User info</h4>
    <p align="justify"><strong>Name: </strong>{{Auth::user()->name.' '.Auth::user()->lastname}}</p>
    <p align="justify"><strong>E-Mail: </strong>{{Auth::user()->email}}</p>
    <p align="justify"><strong>Sex: </strong>{{Auth::user()->sex}}</p>
    <p align="justify"><strong>Favorites: </strong>{{Auth::user()->favorites->count()}}</p>
  </div>
</div>

</div>
<br><br><br>
<div style="margin-bottom: 0; background-color: #ccc;" class="jumbotron">
  @if(Auth::user()->favorites->count()>0)
    <h4 align="center"><span class="glyphicon glyphicon-headphones"></span> Listen all your favorite songs!</h4>
    <div class="table-responsive" id="tabla">
      <table class="table">
        <thead>
          <tr align="center">
            <td><strong>Track!</strong></td>
            <td><strong>Album / Kind</strong></td>
            <td><strong>Play</strong></td>
            <td><strong>Remove <span class="glyphicon glyphicon-remove"></span></strong></td>
          </tr>
        </thead>
        <tbody>
          @foreach(Auth::user()->favorites as $key => $favorite)
          <tr align="center" id="{{'tr'.$favorite->id}}">
            <td><strong>{{$favorite->song->name}}</strong> | {{$favorite->song->album->artist->name}}</td>
            <td>{{$favorite->song->album->name}} / {{$favorite->song->album->kind->name}}</td>
            <td>
              <span class="glyphicon glyphicon-play play" name="{{'play'.$favorite->song->id}}"></span>
              <audio id="{{'play'.$favorite->song->id}}">
                <source src="{{$favorite->song->source}}" type="audio/mpeg">
              </audio>
              <input name="{{'play'.$favorite->song->id}}" class="mdl-slider mdl-js-slider" value="0" type="range">
            </td>
            <td><button id="{{$favorite->id}}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored btnquit"><span class="glyphicon glyphicon-remove"></span></button></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
  <br><br>
  <h2 align="center">:(</h2>
  <h3 align="center">You have no favorite songs!</h3>
  @endif
</div>
@endsection

@section('morescripts')
<script src="/js/rep2.js"></script>
<script src="/js/reproductionB.js"></script>
@endsection
