<?php

namespace App\Imports;

use App\Helpers\Import;
use App\Helpers\Utilities;
use App\Models\Account;
use App\Models\Block;
use App\Models\Branch;
use App\Models\Card;
use App\Models\City;
use App\Models\Dropdown;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithLimit;
use phpDocumentor\Reflection\Types\Self_;

class BlockImport implements ToCollection, WithChunkReading, WithLimit
{
    use Import, RemembersChunkOffset;

    public function limit(): int
    {
        return 100;
    }

    private array $columns = [];
    private array $translatable = ['title', 'second_title', 'description', 'content', 'image'];
    private array $transforms = [
    ];

    public function collection(Collection $collection){
        foreach($collection as $row){
            ++$this->row_index;
            if ($this->row_index == 1){
                $this->columns = self::transform($row);
                continue;
            }

            $row = array_slice($row->toArray(), 0, count($this->columns));
            if (!array_filter($row))
                continue;

            $row = array_combine($this->columns, $row);
            $row = $this->translate($row);
            Block::create($row);
        }
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
