@extends('cnn.app')

@section('title', 'About')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card mb-4">
            <div class="card-body">                        
                <div class="card-title">
                    <h6 class="mb-4">Made by Fadilah Muhammad</h6>
                    <h4>App Ver 1.2</h4>
                </div>
<pre>
Latest Train : 21-05-2024
Method       : CNN
Architecture : Inception-V4
Datasets     : COSWARA
Data Length  : 2432 (3 Classes)
</pre>
                <h6 class="mt-4">Change Log</h6>
                <div class="demo-inline-spacing mt-3">
                    <div class="list-group">
                    <a href="javascript:void(0);" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex justify-content-between w-100">
                            <h6>1.2</h6>
                        </div>
<pre>
- Some UI update
- Fix mic input
- Image convertion update (spectrogram)
- Model Update
- Model F1-Score : 74.79%
</pre>
                    </a>
                    <a href="javascript:void(0);" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex justify-content-between w-100">
                            <h6>1.1</h6>
                        </div>

<pre>
- Model Update
- Model F1-Score : 74.55%
</pre>
                    </a>
                    <a href="javascript:void(0);" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex justify-content-between w-100">
                        <h6>1.0</h6>
                        </div>
<pre>
- First app build
- First model
- Model F1-Score : 68.98%
</pre>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')

@endsection