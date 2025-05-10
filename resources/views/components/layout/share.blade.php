<div class="news-detail-body-share">
    <span>@lang('site.Share')</span>
    <div>
        <a href="https://www.facebook.com/sharer.php?u={{$route}}"
        ><img src="{{asset('/images/icons/facebook-black.svg')}}" alt=""
            /></a>
        <a href="https://twitter.com/share?url={{$route}}"
        ><img src="{{asset('/images/icons/twitter-black.svg')}}" alt=""
            /></a>
{{--        <a href=""--}}
{{--        ><img src="{{asset('/images/icons/instagram-black.svg')}}" alt=""--}}
{{--            /></a>--}}
        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{$route}}"
        ><img src="{{asset('/images/icons/linkedin-black.svg')}}" alt=""
            /></a>
    </div>
</div>
