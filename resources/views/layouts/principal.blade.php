@extends('index')

@section('css')
@if(Auth::user()->admin)
  <style type="text/css">
  .mdl-layout__header{
    background-color: #009688;
  }
  </style>
@else
  <style type="text/css">
  .mdl-layout__header{
    background-color: #01579B;
  }
  </style>
@endif
@endsection

@section('body')
<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title"><span class="glyphicon glyphicon-flash"></span> 
      @if(Auth::user()->admin)
      Administrator: {{Auth::user()->name." ".Auth::user()->lastname}}
      @else
      {{Auth::user()->name." ".Auth::user()->lastname}}
      @endif
      </span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="/logout"><span class="glyphicon glyphicon-user"></span> Logout</a>
      </nav>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <span class="mdl-layout-title"><span class="glyphicon glyphicon-flash"></span> KindsOfMusic!</span>
    <nav class="mdl-navigation">
    @if(Auth::user()->admin)
    <a class="mdl-navigation__link event" href="#" name="ss"><span class="glyphicon glyphicon-headphones"></span> Songs  <span class="caret"></span></a>
    <ul class="mdl-navigation submenu" id="ss">
      <li class="mdl-navigation__link"><a href="/excel2"><span class="glyphicon glyphicon-list-alt"></span> Excel (new)</a></li>
      <li class="mdl-navigation__link"><a href="/songs"><span class="glyphicon glyphicon-th"></span> Song files</a></li>
    </ul>

    <a class="mdl-navigation__link event" href="#" name="aa"><span class="glyphicon glyphicon-music"></span> Artists and Kinds <span class="caret"></span></a>
    <ul class="mdl-navigation submenu" id="aa">
      <li class="mdl-navigation__link"><a href="/music"><span class="glyphicon glyphicon-ok"></span> Create new</a></li>
      <li class="mdl-navigation__link"><a href="/deleteak"><span class="glyphicon glyphicon-remove"></span> Delete</a></li>
    </ul>

    <a class="mdl-navigation__link" href="/stadistics"><span class="glyphicon glyphicon-align-left"></span> Stadistics</a>
    
    
    <!-- <a class="mdl-navigation__link" href="/excel"><span class="glyphicon glyphicon-th-list"></span> Excel (old version)</a> -->
    <hr>
    @endif
    @foreach($kinds as $kind)
    <a class="mdl-navigation__link event" name="{{$kind->id}}" href="#">{{$kind->name}} <span class="glyphicon glyphicon-menu-down"></span></a>
    @if($kind->numberOfAlbums>0)
      <ul class="mdl-navigation submenu" id="{{$kind->id}}">
      @foreach($kind->artists as $artist)
        <li class="mdl-navigation__link"><a href="/music/{{$kind->name}}/{{$artist->name}}">{{$artist->name}}</a></li>
      @endforeach
      </ul>
    @else
      <ul class="mdl-navigation submenu" id="{{$kind->id}}">
        <p style="color:#E91E63;">No artists yet :c</p>
      </ul>
    @endif
    @endforeach
    <hr>
    <a class="mdl-navigation__link event" href="/favorites"><span class="glyphicon glyphicon-star-empty"></span> Favorites</a>
    </nav>
  </div>
  <main class="mdl-layout__content">
    <div class="page-content">
      @yield("content")
    </div>
  </main>
</div>
@endsection

@section('js')
<script src="/js/changablemenu.js"></script>
@yield('morescripts')
@endsection