<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\BranchesWidget;
use App\Filament\Resources\UserResource\Widgets\UsersWidget;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource implements HasShieldPermissions
{
    public static function getPermissionPrefixes(): array
    {
       return [
           'view',
           'view_any',
           'create',
           'update',
           'delete',
           'delete_any',
           'change_role',
           'ban'
       ];
    }

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    public static function getNavigationLabel(): string
    {
        return __("Users");
    }

    public static function getModelLabel(): string
    {
        return __("User");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Users");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Users");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Users Management");
    }

    public static function form(Form $form): Form
    {
        $items = [
            Forms\Components\TextInput::make('name')
                ->unique(ignoreRecord: true)
                ->maxLength(255)
                ->required(),
            Forms\Components\TextInput::make('email')
                ->unique(ignoreRecord: true)
                ->maxLength(255)
                ->email()
                ->required(),
            Forms\Components\TextInput::make('password')
                ->maxLength(255)
                ->password()
                    ->required()
                ->confirmed(),
            Forms\Components\TextInput::make('password_confirmation')
                ->maxLength(255)
                ->password()
                ->required(),
            Forms\Components\Hidden::make('last_logged_at')
                ->default(function (){
                    return Carbon::now();
                })
        ];

        $current_user = Filament::auth()->user();

        if ($current_user->can('change_role_user')){
            $items[] = Forms\Components\Select::make('roles')
                ->label(__("Roles"))
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->native(false);
        }

        if ($current_user->can('ban_user')){
            $items[] = Forms\Components\Select::make('banned')
                ->label(__("Status"))
                ->options([
                    1 => __("Banned"),
                    0 => __("Active")
                ])
                ->native(false);
        }

        return $form
            ->schema($items);
    }

    public static function table(Table $table): Table
    {
        $actions = [];
        if (Filament::auth()->user()->can('ban_user')){
            $actions[] = Tables\Actions\Action::make("Ban")
                ->action(function (User $record){
                    $record->banned = !$record->banned;
                    $record->save();
                })
                ->icon(function (User $record){
                    return $record->banned ? "iconpark-correct" : "fas-ban";
                })
                ->label(function (User $record){
                    return $record->banned ? __("Activate") : __("Ban");
                });
        }
        $actions = array_merge($actions, [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()
        ]);

        return $table
            ->query(function(){
                return User::where('id', '!=', Filament::auth()->user()->id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->label(__("Name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable()
                    ->label(__("Email"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->toggleable()
                    ->label(__('Roles'))
                ,
                Tables\Columns\TextColumn::make('ip_address')
                    ->toggleable()
                    ->label(__("IP Address"))
                    ->searchable(),
                Tables\Columns\TextColumn::make("last_logged_at")
                    ->toggleable()
                    ->label(__("Logged Since"))
                    ->since(),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable()
                    ->label("Joined since")
                    ->since()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->label('roles')
                    ->multiple()
                    ->searchable()
                    ->relationship('roles', 'name')
                    ->native(false)
                    ->preload()
            ])
            ->actions($actions)
            ->poll("5s")
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            UsersWidget::class
        ];
    }
}
