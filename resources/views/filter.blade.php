@extends('layouts.main')

@section('title', $keyword ?: __('site.FILTER_PLACEHOLDER'))
@section('id', '')

@section('content')
    <form
            class="mb-3 container search-form-container"
            method="post"
            action="{{route('site.filter')}}"
    >
        @csrf
        <input
                type="text"
                class="form-control"
                placeholder="@lang('site.Search')"
                value="{{request('search')}}"
                name="search"
        />
        <button type="submit" class="main-btn">@lang('site.Search')</button>
    </form>

    <div class="container searchPageContainer">
        <div class="row flex-column-reverse flex-md-row">
            <div class=" ">
                <div class="search-container m-5">
                    @forelse($search_results as $model_name => $results)
                        @continue(!count($results))
                        <div class="product" id="{{$model_name}}-container">
                            <h4>@lang('site.' . Str::plural($model_name))</h4>
                            <div id="{{$model_name}}">
                                @foreach($results as $result)
                                    <div class="search-product__card">
                                        <h3>
                                            <a href="{{$result->getSearchUrl()}}"> {{$result->title}} </a>
                                        </h3>
                                        {!! $result->description !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="search-read-more">
                            <div class="col-lg-12 col-md-12">
                                <div class="add--read_more">
                                    <a class="load-more"
                                       data-model-id="{{$model_name}}"
                                       data-page-id="0"
                                       data-csrf-token="{{csrf_token()}}"
                                    >
                                        <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="#ed742d"
                                                stroke="#ed742d"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-plus"
                                        >
                                            <path d="M5 12h14" />
                                            <path d="M12 5v14" />
                                        </svg>
                                        @lang('site.Load more')
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="d-flex justify-content-center w-100">
                            <h2 class="text-danger">@lang('site.NO SEARCHES FOUND')</h2>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function(){
            $(".load-more").on('click', function(e){
                e.preventDefault();
                const self = $(this);
                const section_id = "#" + $(this).data('model-id');
                $(this).data('page-id', $(this).data('page-id') +1)
                $(section_id + "-container").append($('<div>').load('{{route('site.filter')}}?page=' + ($(this).data('page-id')) + ' ' + section_id, {
                    model: $(this).data('model-id'),
                    _token: $(this).data('csrf-token')
                }, function(responseText){
                    if (!$(responseText).find(section_id).length)
                        self.remove();
                }));
            })
        })
    </script>
@endpush