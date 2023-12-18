@extends('cnn.app')

@section('page-style')
<style>
    /* https://github.com/lonekorean/gist-syntax-themes */
    @import url('https://cdn.rawgit.com/lonekorean/gist-syntax-themes/d49b91b3/stylesheets/idle-fingers.css');
    
    @import url('https://fonts.googleapis.com/css?family=Open+Sans');
    body {
      font: 16px 'Open Sans', sans-serif;
    }
    body .jp-Notebook {
        margin: 0 !important;
        padding: 0 !important;
    }
    body .gist .gist-file {
      border-color: #555 #555 #444
    }
    body .gist .gist-data {
      border-color: #555
    }
    body .gist .gist-meta {
      color: #ffffff;
      background: #373737; 
    }
    body .gist .gist-meta a {
      color: #ffffff
    }
    body .gist .gist-data .pl-s .pl-s1 {
      color: #a5c261
    }
    .jp-Notebook .jp-Cell .jp-InputPrompt {
        cursor: pointer !important;
    }
    .jp-Collapser {
        flex: 0 0 0 !important;
    }
    </style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card mb-4">
            <div class="card-body">                        

                <h2>Covid Detection Using Cough Sounds</h2>
                <iframe src="https://www.kaggle.com/embed/sarabhian/optuna-hyperparameter-tunning?cellIds=1&kernelSessionId=94927984" height="300" style="margin: 0 auto; width: 100%; max-width: 950px;" frameborder="0" scrolling="auto" title="optuna hyperparameter tunning"></iframe>
                <script src="https://gist.github.com/fadilahmuh/e4ec9af732aa333b56a413f895aee769.js"></script>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
@endsection