<div class="product__item card bg-light rounded ">
    <div class="product__item__pic set-bg card-header p-1"
        data-setbg="{{ $image }}">
        <div class="label new">New</div>
        <ul class="product__hover">
            <li><a href="{{ $image }}"
                    class="image-popup"><span class="arrow_expand"></span></a></li>
            <li><a href="{{ $route }}"><span><i class="fa fa-eye"></i></span></a></li>
        </ul>
    </div>
    <div class="product__item__text card-body">
        <h6><a href="{{ $route }}">{{ $name }}</a></h6>
        <div class="rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
        </div>
        <div class="product__price">IDR. {{ $price }},00</div>
    </div>
</div>
