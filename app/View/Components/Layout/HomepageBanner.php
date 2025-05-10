<?php

namespace App\View\Components\Layout;

use App\Models\Block;
use App\Models\Dropdown;
use App\Models\Slider;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HomepageBanner extends Component
{
    public ?Slider $homepage_banner;
    public const SLUG = "homepage-banner";
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->homepage_banner = Slider::active()
            ->whereCategory(Slider::HOMEPAGE_SLIDER)
            ->whereSlug('homepage-banner')
            ->active()
            ->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.homepage-banner', [
                'banner' => $this->homepage_banner
        ]);
    }
}
