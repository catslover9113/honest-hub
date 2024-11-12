@extends('layouts.appdash')

@section('content')
<div class="container mt-4">
    <div class="row">
      
<div class="col-md-3">
    <div class="card shadow-sm rounded p-3 mb-4">
        <h4 class="text-center mb-3">معلومات الحساب</h4>
        <div class="text-center mb-3">
           
            <form action="{{ route('profile.updateImage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="profile-image-upload" class="cursor-pointer">
                    <img src="{{ asset('images/users/' . (auth()->user()->profile_image ?? 'default-user.jpg')) }}" alt="User Image" class="user-avatar rounded-circle" width="80">
                </label>
                <input type="file" id="profile-image-upload" name="profile_image" class="hidden" accept="image/*" onchange="this.form.submit()">
            </form>
        </div>
        <p class="text-center"><strong>{{ auth()->user()->name }}</strong></p>
        <p class="text-center">{{ auth()->user()->email }}</p>
        <hr>
        <ul class="list-unstyled text-center">
            <li><strong>المنشورات:</strong> {{ auth()->user()->reviews->count() }}</li>
           
           
        </ul>
    </div>
</div>

    
        <div class="col">
            <div class="reviews-section">
                <h2 class="text-center mb-4">آخر المراجعات</h2>
                
                <div class="row">
                    @forelse($reviews as $review)
                        <div class="col-md-6 mb-4">
                            <div class="card custom-card" dir="rtl">
                                <div class="card-body">
                                    <!-- ...... -->
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

                                    <!-- Like Button -->
                                 
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

           
            <div class="d-flex justify-content-center mt-4">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>

<div class="fixed-bottom ms-3 mb-3">
    <button class="btn btn-primary" onclick="showReviewModal()">إضافة مراجعة</button>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reviewModalLabel">إضافة مراجعة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="reviewForm" action="{{ route('review.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

           
   
<div class="mb-3">
    <label for="product_name" class="form-label">اسم المنتج</label>
    <input type="text" class="form-control" id="product_name" name="product_name" required>
</div>

    
    <div class="mb-3">
                <label for="product-image" class="form-label">صورة المنتج</label>
               <input type="file" class="form-control" id="product-image" name="product_image" accept="image/*">

            </div>
           


<div class="mb-3">
    <label for="review_content" class="form-label">محتوى المراجعة</label>
    <textarea class="form-control" id="review_content" name="review_content" rows="3" required></textarea>
</div>


<div class="mb-3">
    <label for="category_id" class="form-label">التصنيف</label>
    <select class="form-select" id="category_id" name="category_id" required>
        <option value="1">منتج عناية</option>
        <option value="2">منتج تجميل</option>
        <option value="3">إلكترونيات</option>
        <option value="4">أخرى</option>
</select>
</div>


<div class="mb-3">
    <label for="rating" class="form-label">التقييم</label>
    <select class="form-select" id="rating" name="rating" required>
        <option value="1">1 نجمة</option>
        <option value="2">2 نجمة</option>
        <option value="3">3 نجوم</option>
        <option value="4">4 نجوم</option>
        <option value="5">5 نجوم</option>
    </select>
</div>

<button type="submit" class="btn btn-primary">إضافة المراجعة</button>
        </form>
      </div>
    </div>
  </div>
</div>

        
@endsection

