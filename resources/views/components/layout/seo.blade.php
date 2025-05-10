<meta http-equiv="content-language" content="{{app()->getLocale()}}">
<meta http-equiv="Content-Type" content="text/html" charset=utf-8"/>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

@if ($model?->keywords)
    <meta name="keywords" content="{{implode(', ', $model->keywords)}}" />
@endif

@if ($model?->author)
    <meta name="author" content="{{$model->author ?: app(\App\Settings\General::class)->site_title[$language] ?? config('app.name')}}" />
    <meta name="publisher" content="{{$model->author ?: app(\App\Settings\General::class)->site_title[$language] ?? config('app.name')}}" />
    <meta name="copyright" content="{{app(\App\Settings\General::class)->site_title[$language] ?? config('app.name')}}" />
@endif

@if ($model?->title)
    <meta property="og:title" content="{{$model->title}}" />
@endif

@if ($model?->description)
    <meta name="description" content="{{$model->description}}">
    <meta name="twitter:description" content="{{$model->description}}">
@else
    <meta name="description" content="{{app(\App\Settings\General::class)->site_description[$language] ?? config('app.name')}}"/>
    <meta name="twitter:description" content="{{app(\App\Settings\General::class)->site_description[$language] ?? config('app.name')}}"/>
@endif

@if ($model?->image)
    <meta property="og:image" content="{{asset('/storage/' . array_values($model->image)[0])}}" />
    <meta name="twitter:image" content="{{asset('/storage/' . array_values($model->image)[0])}}" />
@endif

@if ($model?->robots)
    <meta name="robots" content="{{implode(', ', $model->robots)}}" />
@endif
