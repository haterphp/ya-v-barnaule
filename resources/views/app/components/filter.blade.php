@push('js')
    <script src="{{ asset('assets/js/bootstrap-slider.min.js') }}"></script>
    <script>
        const components = {};

        function initRange({ id, $form }){

            function checkRangeChange($value){
                return $value === document.querySelector(`#${id}`).value;
            }

            console.log(id, $form);
            const slider = new Slider(`#${id}`, {});
            jQuery(`#${id}`).change(function(){
                setTimeout(() => {
                    if(checkRangeChange(document.querySelector(`#${id}`).value))
                        $($form).submit();
                }, 300);
            })
        }
    </script>
@endpush

<div class="filter-container">
    <form class="filter-form">
        <div class="filter card">
            <a href="#filter-price-collapse" class="card-header collapse-dropdown-toggle dropdown-toggle" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="filter-price-collapse">
                <h6 class="mb-0">Цена</h6>
            </a>
            <div class="collapse show" id="filter-price-collapse">
                <div class="card card-body">
                    @include('app.components.range', [
                        'id' => 'filter-price-range',
                        'name' => 'price',
                        'form' => '.filter-form',
                        'min' => 1000,
                        'max' => 10000,
                        'step' => 100,
                        'current' => $filters['price']
                    ])
                </div>
            </div>
        </div>
        {{-- <div class="filter card">
            <a href="#filter-time-collapse" class="card-header collapse-dropdown-toggle dropdown-toggle" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="filter-time-collapse">
                <h6 class="mb-0">Время бронирования</h6>
            </a>
            <div class="collapse show" id="filter-time-collapse">
                <div class="card card-body">
                    @include('app.components.range', [
                        'id' => 'filter-time-range',
                        'name' => 'time',
                        'form' => '.filter-form',
                        'min' => 8,
                        'max' => 23,
                        'current' => $filters['time']
                    ])
                </div>
            </div>
        </div> --}}
        <div class="filter card">
            <a href="#filter-payment_method-collapse" class="card-header collapse-dropdown-toggle dropdown-toggle" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="filter-payment_method-collapse">
                <h6 class="mb-0">Вид оплаты</h6>
            </a>
            <div class="collapse show" id="filter-payment_method-collapse">
                <div class="card card-body">
                    <div class="form-group form-checkbox">
                        <input type="checkbox" name="payment_method[]" onchange="document.querySelector('.filter-form').submit()" value="cash" @if(collect($filters['payment_method'])->contains('cash'))checked @endif id="payment-method-cash">
                        <label class="form-checkbox-label" for="payment-method-cash">
                            <span>
                                <i class="fa fa-money-bill-wave fa-lg mr-2 text-success"></i> Наличный расчет
                            </span>
                        </label>
                    </div>
                    <div class="form-group form-checkbox">
                        <input type="checkbox" name="payment_method[]" onchange="document.querySelector('.filter-form').submit()" value="non-cash" id="payment-method-non-cash" @if(collect($filters['payment_method'])->contains('non-cash'))checked @endif>
                        <label class="form-checkbox-label" for="payment-method-non-cash">
                            <span>
                                <i class="fa fa-credit-card fa-lg mr-2 text-dark"></i> Безналичный расчет
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter card">
            <a href="#filter-persons-collapse" class="card-header collapse-dropdown-toggle dropdown-toggle" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="filter-persons-collapse">
                <h6 class="mb-0">Кол-во людей</h6>
            </a>
            <div class="collapse show" id="filter-persons-collapse">
                <div class="card-body">
                    <input type="number" onchange="document.querySelector('.filter-form').submit()" value="{{ $filters['person_count'] }}" placeholder="Кол-во людей" class="form-control" name="person_count">
                </div>
            </div>
        </div>
        <div class="filter card">
            <a href="#filter-catagories-collapse" class="card-header collapse-dropdown-toggle dropdown-toggle" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="filter-catagories-collapse">
                <h6 class="mb-0">Категории</h6>
            </a>
            <div class="collapse show" id="filter-catagories-collapse">
                <div class="card-body">
                    <div class="wrap d-flex flex-wrap form-categories-wrap">
                        @foreach($categories as $category)
                            <div class="multiple-checkbox-custom">
                                <input type="checkbox" name="categories[]" onchange="document.querySelector('.filter-form').submit()" id="category-checkbox-{{$category->id}}" value="{{ $category->id }}" @if(collect($filters['categories'])->contains($category->id))checked @endif>
                                <label for="category-checkbox-{{$category->id}}" class="btn btn-outline-primary">{{ $category->title }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-slider.css') }}">
    <style>

        .filter-container{
            position: sticky;
            top: 35px;
        }

        .filter-container .collapse-dropdown-toggle[aria-expanded="true"]::after{
            transform: rotate(180deg);
        }

        .collapse-dropdown-toggle{
            text-decoration: none !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .collapse-dropdown-toggle::after{
            transition: transform .15s ease;
        }

        .filter:not(:first-of-type){
            margin-top: 10px;
        }

        .slider{
            width: auto !important;
        }

        .slider.slider-horizontal .slider-tick, 
        .slider.slider-horizontal .slider-handle {
            margin-left: -7px;
        }

        .slider-handle{
            width: 15px;
            border-radius: .5rem;
            background: #fff;
            border: solid 1px #D0D0D0;
        }

        .tooltip-inner{
            background: #3F3D56 !important;
            color: #fff !important;
        }

        .arrow.arrow::before{
            border-top-color: #8e8d96 !important;
        }

        .slider-track-low, .slider-track-high{
            background: #fff !important;
            border: solid 1px #D0D0D0 !important;
        }

        .slider-selection{
            background: #3F3D56;
        }
    </style>
@endpush
