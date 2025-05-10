<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.headquarter_longitude');
        $this->migrator->add('site.headquarter_latitude');
    }
};
