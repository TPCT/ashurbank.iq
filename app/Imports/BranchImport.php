<?php

namespace App\Imports;

use App\Helpers\Import;
use App\Helpers\Utilities;
use App\Models\Branch;
use App\Models\City;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithLimit;
use phpDocumentor\Reflection\Types\Self_;

class BranchImport implements ToCollection, WithChunkReading, WithLimit
{
    use Import, RemembersChunkOffset;

    public function limit(): int
    {
        return 100;
    }

    private array $columns = [];
    private array $translatable = ['name', 'address'];
    private array $transforms = [
        'city' => 'city_id',
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

            if (!City::find($row['city_id'])) {
                Notification::make()
                    ->seconds(10)
                    ->title(__("Can't Save Branch"))
                    ->body(__("Check Branch With Name: ") . $row['name'][app()->getLocale()])
                    ->danger()
                    ->send();
                continue;
            }

            Branch::create($row);
        }
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
