@php
    $reverseCounts = [
        1 => "5",
        2 => "4",
        3 => "3",
        4 => "2",
        5 => "1",
    ];
@endphp


<div class="card catalog-card outline-card" style="border: none;">
    <div class="card-image">
        <div class="backdrop">
            <div class="wrap d-flex flex-column">
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
                @if($location->pivot && $location->pivot->status == 1)
                    <button class="btn btn-light mt-2" data-toggle="modal" data-target="#review-modal">Оставить отзыв</button>
                @endif
            </div>
        </div>
        <img src="{{ $location->photos(0) }}" alt="image">
    </div>
    <div class="card-body d-flex align-items-start justify-content-between pr-0 pl-0">
        <div class="wrap">
            <p class="card-title mb-0">{{ $location->title }}</p>
            <div class="rate small mt-1">
                @for($i = 1; $i <=5; $i++)
                    <span class="fa fa-star @if($reverseCounts[$i] == $location->rate()) checked @endif"></span>
                @endfor
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