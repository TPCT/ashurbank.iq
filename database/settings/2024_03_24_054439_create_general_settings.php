<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_title');
        $this->migrator->add('general.site_description');
        $this->migrator->add('general.site_admin_email');
        $this->migrator->add('general.site_country');
        $this->migrator->add('general.site_timezone');
    }
};
