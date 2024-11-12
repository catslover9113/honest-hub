@extends('layouts.app')

@section('content')
 <div class="col">
   
            <div class="reviews-section">
                <h2 class="text-center mb-4">آخر المراجعات</h2>
                
                <div class="row" dir="rtl" > 
                    @forelse($reviews as $review)
                        <div class="col-md-6 mb-4 " >
                            <div class="card customm-card " dir="rtl">
                                <div class="card-body" >
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


 <div class="product-image  mb-3 mt-4">
                        @if ($review->image)
                            <img src="{{ asset($review->image) }}" alt="{{ $review->product->name }}" class="product-image img-fluid">
                        @else
                            <p class="text-muted">لا توجد صورة لهذا المنتج</p>
                        @endif
                        
                        @if ($review->product)
                            <div class="ms-3">
                                <h5 class="card-title mt-2">{{ $review->product->name }}</h5>
                                <p class="text-muted">التصنيف: {{ $review->product->category->name ?? 'غير مصنف' }}</p>
                                <p class="text-muted">{{ $review->created_at ? $review->created_at->diffForHumans() : 'تاريخ غير معروف' }}</p>
                            </div>
                        @else
                            <p class="text-muted">المنتج غير متوفر</p>
                        @endif
</div>
   



                                    <form action="{{ route('review.like', $review->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-heart{{ $review->likes && $review->likes->contains('user_id', auth()->id()) ? '-fill' : '' }}"></i>
                                            {{ $review->likes->count() > 0 ? $review->likes->count() . ' إعجاب' : 'إعجاب' }}
                                        </button>
                                    </form>
 
                                   

                                   
                            </div> 
                        </div>
                    @empty
                        <p class="text-center">لا توجد مراجعات لعرضها.</p>
                    @endforelse
                </div>
            </div>

         
        </div>
    </div>
</div>
@endsection
