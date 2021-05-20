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
                        <button class="btn btn-light ml-2 d-flex align-items-center justify-content-center btn-wish">
                            @if (auth()->user() && auth()->user()->wishList->pluck('id')->contains($location->id))
                                <i class="fa fa-heart wish-list-icon active"></i>
                            @else
                                <i class="far fa-heart wish-list-icon"></i>
                            @endif
                        </button>
                    </form>
                </div>
                @if($location->pivot && $location->pivot->status == 1)
                    <button class="btn btn-light mt-2" data-toggle="modal" data-target-id="{{ $location->pivot->id }}" data-target="#review-modal">Оставить отзыв</button>
                @endif
            </div>
        </div>
        <img src="{{ $location->photos(0) }}" alt="image">
    </div>
    <div class="card-body d-flex align-items-start justify-content-between pr-0 pl-0">
        <div class="wrap">
            <p class="card-title mb-0">{{ $location->title }}</p>
            <div class="rate small mt-1 mb-0">
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

@if($location->pivot && $location->pivot->code)
@once
    @push('modals')
        <div class="modal fade" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="review-modal-label">Оставить отзыв</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('review.store', ['order' => $location->pivot->id]) }}" id="review-form" method="post">
                            @csrf
                            <input type="hidden" name="_id" value="{{ old('_id') }}">
                            <div class="form-group">
                                <label class="text-muted">Комментарий</label>
                                <textarea name="content" class="form-control @error('content') is-invalid @enderror" cols="30" rows="5">{{old('content')}}</textarea>
                                @error('content')
                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label class="text-muted">Оценка</label>
                                <div class="rate rate-input-stars mt-0 mb-0">
                                    <span class="fa fa-star" onclick="modal.setRate(5)"></span>
                                    <span class="fa fa-star" onclick="modal.setRate(4)"></span>
                                    <span class="fa fa-star" onclick="modal.setRate(3)"></span>
                                    <span class="fa fa-star" onclick="modal.setRate(2)"></span>
                                    <span class="fa fa-star" onclick="modal.setRate(1)"></span>
                                </div>
                                <input type="hidden" name="rate" class="rate-input @error('content') is-invalid @enderror">
                                @error('rate')
                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <button @guest() disabled @endguest type="button" class="btn btn-primary"
                                onclick="document.querySelector('#review-form').submit()">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('js')
        
        <script>
            function changeOrder(id){
                console.log(id);
                const form = document.querySelector('#review-form');
                let route = "{{ route('review.store', ['order' => ':id']) }}";
                route = route.replace(/:id/gi, id);
                form.setAttribute('action', route);
                form.querySelector('input[name="_id"]').value = id;
            }

            function setRate(rate){
                const rateContainer = this.container.querySelector('.rate-input-stars');
                const input = document.querySelector('.rate-input');

                rateContainer.querySelectorAll('.fa').forEach(item => item.classList.remove('checked'));
                event.target.classList.add('checked');
                input.value = rate;
            }

            function ReviewModal(props){
                this.container = props.container;
            }

            ReviewModal.prototype.changeOrder = changeOrder;
            ReviewModal.prototype.setRate = setRate;
        </script>
        <script>
            const container = document.querySelector('#review-modal');
            const modal = new ReviewModal({container}); 
        </script>
        <script>
            const url = new URLSearchParams(location.search);
            const state = url.get('state') || null; 
            if(state === 'modal') {
                const id = history.state 
                            ? history.state.id 
                            : modal.container.querySelector('input[name="_id"]').value;
                modal.changeOrder(id);
                $('#review-modal').modal('show');
            }
            $('#review-modal').on('show.bs.modal', function (e) {
                const id = $(e.relatedTarget).data('target-id');
                modal.changeOrder(id);
                history.replaceState({id}, null, `?state=modal`)
            })
            $('#review-modal').on('hidden.bs.modal', function (e) {
                history.replaceState({id: null}, null, '?')
            })
        </script>
    @endpush
@endonce
@endif
