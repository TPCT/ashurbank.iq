
<li class="nav-item dropdown">
    <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarScrollingDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
    >
        <img src="{{asset(config('app.locales_images.' . $language))}}" alt="{{config('app.locales.' . $language)}}" srcset="" />
        {{config('app.locales.' . $language)}}
    </a>
    <ul
            class="dropdown-menu dropdown-menu-small"
            aria-labelledby="navbarScrollingDropdown"
    >
        @foreach(config('app.locales') as $locale => $locale_language)
            @continue($language == $locale)

            <li>
                <a
                        class="dropdown-item d-flex justify-content-between align-items-center"
                        href="{{route($route, array_merge(request()->route()->parameters(), ['locale' => $locale], request()->query()))}}"
                ><p class="text-dark">{{$locale_language}}</p>
                    <img src="{{asset(config('app.locales_images.' . $locale))}}" alt="{{config('app.locales.' . $language)}}" srcset=""
                    /></a>
            </li>
        @endforeach
    </ul>
</li>
