<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Review;
use App\Models\Category;
use App\Models\like;

class ProductController extends Controller
{
    
    
  
    public function dashboardIndex()
{
    
    $reviews = Review::with(['likes'])->latest()->paginate(100000);

    
    foreach ($reviews as $review) {
        $product = Product::find($review->product_id);
        $review->product_name = $product ? $product->name : 'منتج غير موجود';
    }

    
    $products = Product::all();

    return view('dashboard.index', compact('reviews', 'products'));
}

    
public function search(Request $request)
{
    $query = $request->input('query');

   
    $products = Product::where('name', 'like', "%$query%")
                       ->with('reviews') 
                       ->get();

    return view('product.search', compact('products')); 
}
public function showReviews()
{
    
    $reviews = Review::with('user', 'product', 'product.category')->paginate(10);

    return view('dashboard', compact('reviews'));
}
public function store(Request $request)
{
 
    $validated = $request->validate([
        'product_name' => 'required|string',
        'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id' => 'required|exists:categories,id',
        'review_content' => 'required|string',
        'rating' => 'required|integer|between:1,5',
    ]);

    $imagePath = null;

    if ($request->hasFile('product_image')) {
        $file = $request->file('product_image');
        
        $filename = time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('images/products'), $filename);
        
        $imagePath = 'images/products/' . $filename;
    }

    $product = Product::create([
        'name' => $request->product_name,
        'category_id' => $request->category_id,
    ]);

    $review = new Review();
    $review->products_id = $product->id;
    $review->content = $request->review_content;
    $review->rating = $request->rating;
    $review->user_id = auth()->id();
    $review->image = $imagePath; 
    
    try {
        $review->save();
    } catch (\Exception $e) {
        \Log::error('Error saving review: ' . $e->getMessage());
        return back()->with('error', 'حدث خطأ أثناء إضافة المراجعة.');
    }

    return redirect()->route('dashboard')->with('success', 'تم إضافة المراجعة بنجاح');
}


 }