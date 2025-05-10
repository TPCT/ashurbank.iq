<?php

namespace App\Models\Media;

use Awcodes\Curator\Models\Media as ModelsMedia;
use OwenIt\Auditing\Contracts\Auditable;


class Media extends ModelsMedia implements Auditable
{

    use \OwenIt\Auditing\Auditable;

}
