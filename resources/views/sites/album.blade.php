@extends('layouts.principal')

@section('title',$album->name.' | '.$album->artist->name)

@section('content')
<div style="padding-bottom: 0; padding-top: 0; background-color: #111; margin-bottom: 0;" align="center" class="jumbotron  hidden-xs">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="2000">
      <!-- Indicators -->
      <ol class="carousel-indicators">
      @foreach($album->images as $image)
	      @if($loop->first)
	      <li data-target="#carousel-example-generic" data-slide-to="{{$loop->index}}" class="active"></li>
	      @else
	      <li data-target="#carousel-example-generic" data-slide-to="{{$loop->index}}"></li>
	      @endif
      @endforeach
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
      @foreach($album->images as $image)
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
    @if(Auth::user()->admin)  
    <br>
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <form enctype="multipart/form-data" method="post" action="/newimage">
          <input type="hidden" name="kind" value="{{$album->kind->id}}">
          <input type="hidden" name="artist" value="{{$album->artist->id}}">
          <input type="hidden" name="album" value="{{$album->id}}">
          <input type="hidden" name="albumname" value="{{$album->name}}">
          {{csrf_field()}}
          <div class="form-group">
            <label style="border-radius: 0;" class="btn btn-default btn-block">Add a new image (.jpg) <span class="glyphicon glyphicon-folder-open"></span><input style="display:none; border-radius: 0;" type="file" name="image" accept=".jpg">
            </label>
          </div>
          <div class="form-group">
            <button style="border-radius: 0;" class="btn btn-success btn-block">Upload</button>
          </div>
        </form>
        @if(Session::has('msg'))
        <p style="color:#eee;" align="center">{{Session::get('msg')}}</p>
        @endif
      </div>
    </div>
    @endif
</div>
<div style="margin-bottom: 0; margin-top: 0; background-color: #fff; color:#666;" class="jumbotron">
  <div class="container">
  <div class="col-sm-10 col-sm-offset-1">
    @if($album->songs->count()>0)
      <h4 align="center"><span class="glyphicon glyphicon-headphones"></span> <strong>{{$album->name}}</strong> | {{$album->artist->name}}</h4>
      <hr>
      <input type="hidden" id="iduser" value="{{Auth::user()->id}}">
      <div class="table-responsive" id="tabla">
        <table class="table table-condensed">
          <thead>
            <tr align="center">
              <td><strong>Track!</strong></td>
              <td><strong>Play</strong></td>
              <td><strong>Add to <span class="glyphicon glyphicon-star"></span></strong></td>
            </tr>
          </thead>
          <tbody>
            @foreach($album->songs as $key => $song)
            <tr align="center">
              <td>{{$song->name}}</td>
              @if($song->sourceup)
              <td>
                <span class="glyphicon glyphicon-play play" name="{{'play'.$song->id}}"></span>
                <audio id="{{'play'.$song->id}}">
                  <source src="{{$song->source}}" type="audio/mpeg">
                </audio>
                <input name="{{'play'.$song->id}}" class="mdl-slider mdl-js-slider" value="0" type="range">
              </td>
                @if(!in_array($song->id, $favorites))
                <td><button id="{{$song->id}}" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored btnadd">+</button></td>
                @else
                <td><span style="font-size: 16px; margin-top: 8px;" class='glyphicon glyphicon-star'></span></td>
                @endif
              @else
              <td>
                <strong>This song is not ready yet!</strong>
              </td>
              <td>Soon! :D</td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
    <br><br>
    <h2 align="center">There're no albums from this artist!</h2>
    @endif
  </div>
  </div>
</div>
@endsection

@section('morescripts')
<script src="/js/reproduction.js"></script>
<script src="/js/reproductionB.js"></script>
@endsection