<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Traits\GeneralFunction;

class CnnController extends Controller
{
    public function index(){
        return view('cnn.home');    
    }

    public function predict(){
        return view('cnn.predict');    
    }

    public function about(){
        return view('cnn.about');    
    }

    public function try_predict(Request $request){
        $request->validate([
            'file' => 'required|mimes:wav'
        ]);
        
        $sound = $request->file('file');
        
        $response = Http::attach('file', file_get_contents($sound), GeneralFunction::generate_uniq(10).'.wav')
        ->post(env('API_URL'), $request->all());
        if ($response->status() == 200) {
            $response = (object) $response->json();
            $response->data['file'] = asset('data/'. $response->data['file'].'.png');
            
            return response()->json($response, 200);
        }else {
            $response = (object) $response->json();
            return response()->json($response, 400);
        }
    }
}
