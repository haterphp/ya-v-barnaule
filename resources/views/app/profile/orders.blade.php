@extends('app.layouts.profile')

@section('title', 'Я в Барнауле - Мои бронирования')

@section('profile-content')
    <h1 class="h2" style="margin-left: 15px">Мои бронирования</h1>    
    <div class="row mt-3">
        @foreach ($locations as $location)
            <div class="col-12 col-md-6 col-xl-4 mt-3">
                @include('app.components.outline-card', compact('location'))
            </div>
        @endforeach
        @if (!count($locations))
            <div class="wrap mt-3" style="margin-left: 15px">
                <h3 class="text-muted">Здесь пока ничего нет</h3>
                <p class="text-muted">Но вы можете перейти в <a href="{{ route('catalog') }}" class="btn-link">каталог</a> и <br>забронировать то, что вам понравилось.</p>
            </div>
        @endif
    </div>
@endsection

@if($location->pivot && $location->pivot->code)
    @once
    @push('modals')
        <div class="modal fade" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="review-modal-label">Оставить отзыв {{ $location->title }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('review.store', ['order' => $location->pivot->id]) }}" id="review-form" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="text-muted">Комментарий</label>
                                <textarea name="content" class="form-control @error('content') is-invalid @enderror" cols="30" rows="5">{{old('content')}}</textarea>
                                @error('content')
                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label class="text-muted">Оценка</label>
                                <div class="rate rate-input mt-0 mb-0">
                                    <span class="fa fa-star" onclick="setRate(5)"></span>
                                    <span class="fa fa-star" onclick="setRate(4)"></span>
                                    <span class="fa fa-star" onclick="setRate(3)"></span>
                                    <span class="fa fa-star" onclick="setRate(2)"></span>
                                    <span class="fa fa-star" onclick="setRate(1)"></span>
                                </div>
                                <input type="hidden" name="rate" class="@error('content') is-invalid @enderror" id="rate-input">
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
            const url = new URLSearchParams(location.search);
            const state = url.get('state') || null;
            if(state === 'modal') $('#review-modal').modal('show');
            $('#review-modal').on('show.bs.modal', function (e) {
                history.replaceState({state: 'modal'}, null, `?state=modal`)
            })
            $('#review-modal').on('hidden.bs.modal', function (e) {
                history.replaceState({state: null}, null, '?')

            })
        </script>
        <script>
            const rateContainer = document.querySelector('.rate-input');
            const input = document.querySelector('#rate-input');
            const setRate = (value) => {
                rateContainer.querySelectorAll('.fa').forEach(item => item.classList.remove('checked'));
                event.target.classList.add('checked');
                input.value = value;
            }
        </script>
    @endpush
    @endonce
@endif