<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class dashboard extends Controller
{
public function index(Request $request)
{

     $reviews = Review::paginate(100000); 
     
    return view('dashboard.index', ['reviews' => $reviews]);
}

}

