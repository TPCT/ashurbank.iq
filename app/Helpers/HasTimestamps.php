<?php

namespace App\Helpers;


use Carbon\Carbon;

trait HasTimestamps
{
    public function publishedAt(): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->published_at)->format('d M Y');
    }

    public function publishedAtForHumans(): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->published_at)->format('M jS Y');
    }

    public function publishedAtForHumans2(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->published_at)->format('M d, Y');
    }
}
