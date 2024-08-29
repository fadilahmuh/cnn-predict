@extends('cnn.app')

@section('title', 'Home')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-gist.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
      <div class="card bg-primary text-white text-center py-5 p-3 mb-3">
        <figure class="mb-0">
          <blockquote class="blockquote">
            <h2 class="text-white">Covid Detection Using Cough Sounds</h2>
          </blockquote>
          <figcaption class="blockquote-footer mb-0 text-white">
            Trained with CNN Inception-V4
          </figcaption>
        </figure>
      </div>

        <div class="card mb-4">
            <div class="card-body">                        
              @php
                $source = asset('codes2 no image gen 2.html');
              @endphp
              <x-gist-frame :src="$source" :link="'https://gist.github.com/fadilahmuh/e4ec9af732aa333b56a413f895aee769'"></x-gist-frame>
              {{-- <x-gist-frame /> --}}
            </div>
        </div>

    </div>
</div>
@endsection

@section('page-script')
@endsection