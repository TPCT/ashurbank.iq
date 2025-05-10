<?php

namespace App\Filament\Components;

use App\Models\FileExtension;
use Closure;
use Illuminate\Contracts\Support\Arrayable;

class FileUpload extends \Filament\Forms\Components\FileUpload
{
    public function getAcceptedFileTypes(): ?array
    {
        $accepted_filetypes = FileExtension::pluck('extension')->toArray();
        $this->acceptedFileTypes = $accepted_filetypes;
        return parent::getAcceptedFileTypes();
    }
}
