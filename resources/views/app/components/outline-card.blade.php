<div class="card catalog-card" style="border: none;">
    <div class="card-image">
        <div class="backdrop">
            <div class="wrap d-flex">
                <a href="{{ route('catalog.show', ['location' => $location]) }}" class="btn btn-primary">Подробнее</a>
                <form action="{{ route('wish.store', ['location' => $location]) }}" method="post">
                    @csrf
                    <button class="btn btn-light ml-2 d-flex align-items-center justify-content-center">
                        @if (auth()->user() && auth()->user()->wishList->pluck('id')->contains($location->id)) 
                            <i class="fa fa-heart wish-list-icon active"></i>
                        @else 
                            <i class="far fa-heart wish-list-icon"></i>
                        @endif
                    </button>
                </form>
            </div>
        </div>
        <img src="{{ $location->photos(0) }}" alt="image">
    </div>
    <div class="card-body d-flex align-items-start justify-content-between pr-0 pl-0">
        <div class="wrap">
            <p class="card-title mb-0">{{ $location->title }}</p>
            <div class="rate">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
            </div>
            @if ($location->pivot && $location->pivot->started_at)
                <p class="text-info mb-0 mt-2">
                    <i class="fa text-info fa-shopping-cart mr-2"></i>
                    {{ $location->pivot->code }}
                </p>
                <p class="text-muted mb-2 mt-2">
                    <i class="fa text-muted fa-clock mr-2"></i>
                    с {{ dateFormat($location->pivot->started_at, 'm/d H:i') }} 
                    до {{ dateFormat($location->pivot->finished_at, 'm/d H:i') }}
                </p>
                {!! orderStatus($location->pivot->status) !!}
            @endif
        </div>
        <p class="mb-0 price">{{ $location->price }} ₽ / час</p>
    </div>
</div>