<?php

namespace App\View\Components\Layout;

use App\Helpers\Utilities;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class HeaderImage extends Component
{
    public function __construct(
        public ?Model $model=null,
        public ?string $class=null,
        public ?string $title = null,
        public ?string $image = null,
        public ?string $last_title=""
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->image = app()->getLocale() == "en" ? "/images/default_image.png" : "/image/default_image_ar.png";
        if (!$this->model?->header_image){
            $current_path = '/' . trim(Utilities::str_replace_limit(app()->getLocale(), '', request()->path(), 1), '/');
            $this->model = \App\Models\HeaderImage::wherePath($current_path)->first();
            $this->image = $this->model?->image ? '/storage/' . $this->model?->image : $this->image;
            $this->title = $this->model?->title ?: $this->title;
        }else{
            $this->image = $this->model->header_image ? '/storage/' . $this->model->header_image: $this->image;
            $this->title = $this->model->header_title ?: $this->title;
        }

        return view('components.layout.header-image');
    }
}
