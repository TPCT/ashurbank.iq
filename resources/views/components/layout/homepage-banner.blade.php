@if ($banner)
    <div class="home-slider1">
        @foreach($banner->slides as $slide)
            <div>
                @if (@explode('/', File::mimeType(public_path(DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $slide['image'])))[0] == "image")
                    <img src="{{asset('/storage/' . $slide['image'])}}" alt="" srcset="">
                @else
                    <video id="theVideo" autoplay muted playsinline loop>
                        <source src="{{asset('/storage/' . $slide['image'])}}" />
                    </video>
                @endif
            </div>
        @endforeach
    </div>
@endif


@push('script')
    <script>
        $('.home-slider1').slick({
            autoplay: true,
            arrows: false,
            speed: 700,
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            rtl: {{$rtl}}
        }).on('beforeChange', function (event, slick, currentSlide, nextSlide){
            const slide = $(slick.$slides[nextSlide]);
            const video = slide.find("video");
            if (video[0]){
                $('.home-slider1').slick('slickPause');
                const src = video.find('source').attr('source')
                video[0].play();
                video.on('ended', function(){
                    video.find('source').attr('src', "");
                    video[0].find('source').attr('src', src)
                    video[0].load();
                    video.currentTime = 0;
                    $('.home-slider1').slick('slickPlay');
                })
            }
        }).on('afterChange', function(event, slick, currentSlide, nextSlide){
            const slide = $(slick.$slides[currentSlide]);
            const video = slide.find("video");
            if (video[0]){
                $('.home-slider1').slick('slickPause');
                video[0].play();
                video.on('ended', function(){
                    $('.home-slider1').slick('slickPlay');
                })
            }
        });
    </script>
@endpush
