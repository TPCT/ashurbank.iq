<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->delete('site.title');
        $this->migrator->delete('site.description');
        $this->migrator->delete('site.admin_email');
    }
};
