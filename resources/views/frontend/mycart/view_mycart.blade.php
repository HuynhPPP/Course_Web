@extends('frontend.master')
@section('home')

<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area section-padding img-bg-2">
    <div class="overlay"></div>
    <div class="container">
        <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
            <div class="section-heading">
                <h2 class="section__title text-white">Shopping Cart</h2>
            </div>
            <ul class="generic-list-item generic-list-item-white generic-list-item-arrow d-flex flex-wrap align-items-center">
                <li><a href="index.html">Home</a></li>
                <li>Pages</li>
                <li>Shopping Cart</li>
            </ul>
        </div><!-- end breadcrumb-content -->
    </div><!-- end container -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
       START CONTACT AREA
================================= -->
<section class="cart-area section-padding">
    <div class="container">
        <div class="table-responsive">
            <table class="table generic-table">
                <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Details</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody id="cartPage">
                
                </tbody>
            </table>
            <div class="d-flex flex-wrap align-items-center justify-content-between pt-4">

                @if(Session::has('coupon'))

                @else
                <form action="#">
                    <div class="input-group mb-2" id="couponField">
                        <input class="form-control form--control pl-3" type="text" id="coupon_name" placeholder="Coupon code">
                        <div class="input-group-append">
                            <a class="btn theme-btn" 
                                type="submit"
                                onclick="applyCoupon()"
                            >
                                Apply Code
                            </a>
                        </div>
                    </div>
                </form>
                {{-- {{ json_encode(Session::get('coupon'), JSON_PRETTY_PRINT) }} --}}
                @endif
            </div>
        </div>
        <div class="col-lg-4 ml-auto">
            <div class="bg-gray p-4 rounded-rounded mt-40px" id="couponCalField">
                
            </div>
            <a href="{{ route('checkout') }}" class="btn theme-btn w-100 mt-3">Checkout <i class="la la-arrow-right icon ml-1"></i></a>
        </div>
    </div><!-- end container -->
</section>
<!-- ================================
       END CONTACT AREA
================================= -->

<!--======================================
        START COURSE AREA
======================================-->
<section class="course-area section--padding bg-gray">
    <div class="course-wrapper">
        <div class="container">
            <div class="section-heading">
                <h2 class="section__title">You may also like</h2>
            </div><!-- end section-heading -->
            <div class="course-carousel owl-action-styled owl--action-styled mt-30px">
                <div class="card card-item">
                    <div class="card-image">
                        <a href="course-details.html" class="d-block">
                            <img class="card-img-top" src="images/img8.jpg" alt="Card image cap">
                        </a>
                        <div class="course-badge-labels">
                            <div class="course-badge">Bestseller</div>
                            <div class="course-badge blue">-39%</div>
                        </div>
                    </div><!-- end card-image -->
                    <div class="card-body">
                        <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">All Levels</h6>
                        <h5 class="card-title"><a href="course-details.html">The Complete WordPress Website Business Course</a></h5>
                        <p class="card-text"><a href="teacher-detail.html">Jose Portilla</a></p>
                        <div class="rating-wrap d-flex align-items-center py-2">
                            <div class="review-stars">
                                <span class="rating-number">4.4</span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star-o"></span>
                            </div>
                            <span class="rating-total pl-1">(20,230)</span>
                        </div><!-- end rating-wrap -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-price text-black font-weight-bold">12.99 <span class="before-price font-weight-medium">129.99</span></p>
                            <div class="icon-element icon-element-sm shadow-sm cursor-pointer" title="Add to Wishlist"><i class="la la-heart-o"></i></div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
                <div class="card card-item">
                    <div class="card-image">
                        <a href="course-details.html" class="d-block">
                            <img class="card-img-top" src="images/img9.jpg" alt="Card image cap">
                        </a>
                        <div class="course-badge-labels">
                            <div class="course-badge">Bestseller</div>
                        </div>
                    </div><!-- end card-image -->
                    <div class="card-body">
                        <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">All Levels</h6>
                        <h5 class="card-title"><a href="course-details.html">The Complete WordPress Website Business Course</a></h5>
                        <p class="card-text"><a href="teacher-detail.html">Jose Portilla</a></p>
                        <div class="rating-wrap d-flex align-items-center py-2">
                            <div class="review-stars">
                                <span class="rating-number">4.4</span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star-o"></span>
                            </div>
                            <span class="rating-total pl-1">(20,230)</span>
                        </div><!-- end rating-wrap -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-price text-black font-weight-bold">129.99</p>
                            <div class="icon-element icon-element-sm shadow-sm cursor-pointer" title="Add to Wishlist"><i class="la la-heart-o"></i></div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
                <div class="card card-item">
                    <div class="card-image">
                        <a href="course-details.html" class="d-block">
                            <img class="card-img-top" src="images/img10.jpg" alt="Card image cap">
                        </a>
                        <div class="course-badge-labels">
                            <div class="course-badge green">Free</div>
                        </div>
                    </div><!-- end card-image -->
                    <div class="card-body">
                        <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">All Levels</h6>
                        <h5 class="card-title"><a href="course-details.html">The Complete WordPress Website Business Course</a></h5>
                        <p class="card-text"><a href="teacher-detail.html">Jose Portilla</a></p>
                        <div class="rating-wrap d-flex align-items-center py-2">
                            <div class="review-stars">
                                <span class="rating-number">4.4</span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star-o"></span>
                            </div>
                            <span class="rating-total pl-1">(20,230)</span>
                        </div><!-- end rating-wrap -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-price text-black font-weight-bold">Free</p>
                            <div class="icon-element icon-element-sm shadow-sm cursor-pointer" title="Add to Wishlist"><i class="la la-heart-o"></i></div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
                <div class="card card-item">
                    <div class="card-image">
                        <a href="course-details.html" class="d-block">
                            <img class="card-img-top" src="images/img11.jpg" alt="Card image cap">
                        </a>
                    </div><!-- end card-image -->
                    <div class="card-body">
                        <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">All Levels</h6>
                        <h5 class="card-title"><a href="course-details.html">The Complete WordPress Website Business Course</a></h5>
                        <p class="card-text"><a href="teacher-detail.html">Jose Portilla</a></p>
                        <div class="rating-wrap d-flex align-items-center py-2">
                            <div class="review-stars">
                                <span class="rating-number">4.4</span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star-o"></span>
                            </div>
                            <span class="rating-total pl-1">(20,230)</span>
                        </div><!-- end rating-wrap -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-price text-black font-weight-bold">129.99</p>
                            <div class="icon-element icon-element-sm shadow-sm cursor-pointer" title="Add to Wishlist"><i class="la la-heart-o"></i></div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
                <div class="card card-item">
                    <div class="card-image">
                        <a href="course-details.html" class="d-block">
                            <img class="card-img-top" src="images/img12.jpg" alt="Card image cap">
                        </a>
                        <div class="course-badge-labels">
                            <div class="course-badge">Featured</div>
                        </div>
                    </div><!-- end card-image -->
                    <div class="card-body">
                        <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">All Levels</h6>
                        <h5 class="card-title"><a href="course-details.html">The Complete WordPress Website Business Course</a></h5>
                        <p class="card-text"><a href="teacher-detail.html">Jose Portilla</a></p>
                        <div class="rating-wrap d-flex align-items-center py-2">
                            <div class="review-stars">
                                <span class="rating-number">4.4</span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star-o"></span>
                            </div>
                            <span class="rating-total pl-1">(20,230)</span>
                        </div><!-- end rating-wrap -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-price text-black font-weight-bold">129.99</p>
                            <div class="icon-element icon-element-sm shadow-sm cursor-pointer" title="Add to Wishlist"><i class="la la-heart-o"></i></div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
                <div class="card card-item">
                    <div class="card-image">
                        <a href="course-details.html" class="d-block">
                            <img class="card-img-top" src="images/img13.jpg" alt="Card image cap">
                        </a>
                        <div class="course-badge-labels">
                            <div class="course-badge">Featured</div>
                        </div>
                    </div><!-- end card-image -->
                    <div class="card-body">
                        <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">All Levels</h6>
                        <h5 class="card-title"><a href="course-details.html">The Complete WordPress Website Business Course</a></h5>
                        <p class="card-text"><a href="teacher-detail.html">Jose Portilla</a></p>
                        <div class="rating-wrap d-flex align-items-center py-2">
                            <div class="review-stars">
                                <span class="rating-number">4.4</span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star"></span>
                                <span class="la la-star-o"></span>
                            </div>
                            <span class="rating-total pl-1">(20,230)</span>
                        </div><!-- end rating-wrap -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-price text-black font-weight-bold">129.99</p>
                            <div class="icon-element icon-element-sm shadow-sm cursor-pointer" title="Add to Wishlist"><i class="la la-heart-o"></i></div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end tab-content -->
        </div><!-- end container -->
    </div><!-- end course-wrapper -->
</section><!-- end courses-area -->
<!--======================================
        END COURSE AREA
======================================-->

@endsection