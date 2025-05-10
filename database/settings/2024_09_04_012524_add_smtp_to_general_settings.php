<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.smtp_host', 'smtp.gmail.com');
        $this->migrator->add('general.smtp_port', '587');
        $this->migrator->add('general.smtp_user', 'smtp.gmail.com');
        $this->migrator->add('general.smtp_pass', 'smtp.gmail.com');
    }
};
