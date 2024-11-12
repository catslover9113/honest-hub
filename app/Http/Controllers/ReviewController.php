<?php
namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Product; 
use App\Models\Like; 
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
  
    public function index()
{
    $reviews = Review::with(['likes', 'product'])->latest()->get();


    foreach ($reviews as $review) {
        
        if ($review->product) {
            $review->product_name = $review->product->name;
            $review->category_id = $review->product->category_id;
        } else {
            $review->product_name = 'منتج غير موجود';
            $review->category_id = null;
        }
    }

    return view('user.index', compact('reviews'));
}
 
public function search(Request $request)
{
    $query = $request->input('query');

   
    $products = Product::where('name', 'like', "%$query%")
                       ->with('reviews') 
                       ->get();

    return view('product.search', compact('products')); 
}
 
    
    public function store(Request $request)
{
    $request->validate([
        'products_id' => 'required|exists:products,id',
        'rating' => 'required|integer|min:1|max:5',
        'review_content' => 'required|string',
        'category_id' => 'required|exists:categories,id',
    ]);

    $review = new Review();
    $review->products_id = $request->input('products_id');
    $review->user_id = auth()->id(); 
    $review->rating = $request->input('rating');
    $review->content = $request->input('review_content');
    $review->category_id = $request->input('category_id'); 
    $review->save();

    return redirect()->route('dashboard')->with('success', 'تم إضافة المراجعة بنجاح!');
}

public function like($id)
{
    $review = Review::findOrFail($id);

    if (auth()->check()) {

        $userId = auth()->id();
        $existingLike = $review->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
          
            $existingLike->delete();
        } else {

            $review->likes()->create(['user_id' => $userId]);
        }
    } else {
       
        $sessionId = session()->getId();
        $existingLike = $review->likes()->where('session_id', $sessionId)->first();

        if ($existingLike) {
           
            $existingLike->delete();
        } else {
         
            $review->likes()->create(['session_id' => $sessionId]);
        }
    }

    return back();
}


}
