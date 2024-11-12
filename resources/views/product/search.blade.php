@extends('layouts.app') 

@section('content')
<div class="row" dir="rtl">
    @forelse($products as $product)
        <div class="col-12 mb-4">
            <h4 class="mb-3">{{ $product->name }}</h4> 
            
            @forelse($product->reviews as $review)
                <div class="col-md-6 mb-4">
                    <div class="card customm-card" dir="rtl">
                        <div class="card-body">
                            @if ($review->user)
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('images/users/' . ($review->user->profile_image ?? 'default-user.jpg')) }}" class="rounded-circle me-3" width="50" height="50" alt="User Image">
                                    <h5 class="card-title">{{ $review->user->name }}</h5>
                                </div>
                            @else
                                <p class="text-muted">مستخدم غير معروف</p>
                            @endif

                            <p class="card-text mt-2">{{ Str::limit($review->content, 100) }}</p>

                            <div class="d-flex justify-content-between mt-3">
                                <span><i class="bi bi-star-fill text-warning"></i> {{ $review->rating }}/5</span>
                            </div>

                      
                            @if ($review->image)
                                <div class="product-image mt-3 mb-3">
                                    <img src="{{ asset($review->image) }}" alt="{{ $product->name }}" class="img-fluid">
                                </div>
                            @endif

                            <form action="{{ route('review.like', $review->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-heart{{ $review->likes && $review->likes->contains('user_id', auth()->id()) ? '-fill' : '' }}"></i>
                                            {{ $review->likes->count() > 0 ? $review->likes->count() . ' إعجاب' : 'إعجاب' }}
                                        </button>
                                    </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">لا توجد تقييمات لهذا المنتج.</p>
            @endforelse
        </div>
    @empty
        <p class="text-muted">لم يتم العثور على منتجات مطابقة.</p>
    @endforelse
</div>

@endsection