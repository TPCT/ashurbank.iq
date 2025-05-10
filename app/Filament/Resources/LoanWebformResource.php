<?php

namespace App\Filament\Resources;

use App\Helpers\BaseExport;
use App\Helpers\HasForm;
use App\Models\LoanWebform;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class LoanWebformResource extends Resource implements HasShieldPermissions
{
    use HasForm, Translatable;

    protected static ?string $model = LoanWebform::class;

    protected static ?string $navigationIcon = 'eos-format-list-bulleted';


    public static function getNavigationLabel(): string
    {
        return __("Applications");
    }

    public static function getModelLabel(): string
    {
        return __("Application");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Applications");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Applications");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Loans");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function (){
                return self::$model::orderBy('created_at', 'desc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('loan.title')
                    ->toggleable()
                    ->label(__("Loan")),
                Tables\Columns\TextColumn::make('name_' . app()->getLocale())
                    ->toggleable()
                    ->label(__("Name")),
                Tables\Columns\TextColumn::make("email")
                    ->toggleable()
                    ->label(__("Email")),
                Tables\Columns\TextColumn::make("phone_number")
                    ->toggleable()
                    ->label(__("Phone")),
                Tables\Columns\TextColumn::make("created_at")
                    ->toggleable()
                    ->label(__("Since"))
                    ->since()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('loan')
                    ->relationship('loan', 'title->' . app()->getLocale())
                    ->searchable()
                    ->preload()
                    ->label(__("Loan")),
                Tables\Filters\Filter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label(__("Name")),
                        Forms\Components\TextInput::make('email')
                            ->label(__("Email")),
                        Forms\Components\TextInput::make('phone_number')
                            ->label(__("Phone"))
                    ])
                    ->query(function (Builder $query, array $data){
                        $query->when(
                            $data['name'],
                            fn (Builder $builder, $name) => $query->where('name_en', 'like', '%' . $name . '%')->orWhere('name_ar', 'like', '%' . $name . '%'));
                        $query->when(
                            $data['email'],
                            fn (Builder $builder, $email) => $query->where('email', 'like', '%' . $email . '%'));
                        $query->when(
                            $data['phone_number'],
                            fn (Builder $builder, $phone) => $query->where('phone_number', 'like', '%' . $phone . '%'));
                    })
            ])
            ->poll('30s')
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label(__("View"))
                    ->modalHeading(function($record){
                        return "{$record->name} " . __("Information");
                    })
                    ->modalContent(function ($record){
                        return view('filament.Loans.WebformView', ['record' => $record]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
                Tables\Actions\DeleteAction::make()

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        BaseExport::make()->fromModel()
                    ]),
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
            'index' => \App\Filament\Resources\LoanWebformResource\Pages\ListLoanWebforms::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return False;
    }

    public static function canEdit(Model $record): bool
    {
        return False;
    }
}
