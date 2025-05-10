<?php

namespace App\Helpers;

use App\Models\User;

trait ChangeAuthorShield
{
    public function change_author(User $user): bool{
        $shield_name = 'change_author_' . \Str::of(static::class)
                ->afterLast('\Policies')
                ->replace('Policy', '')
                ->snake()
                ->replace('_', '-');
        var_dump($shield_name);
        return $user->can(
            $shield_name
        );
    }
}
