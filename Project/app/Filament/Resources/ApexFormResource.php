<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApexFormResource\Pages;
use App\Filament\Resources\ApexFormResource\RelationManagers;
use App\Models\ApexForm;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ApexFormResource extends Resource
{
    protected static ?string $model = ApexForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('financial_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('advanced_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('department_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('faculty_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('faculty_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('requirements')
                    ->required(),
                Forms\Components\TextInput::make('expected_outcome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('submitted_by')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('due_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable(),
                Tables\Columns\TextColumn::make('financial_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('advanced_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('faculty_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('faculty_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expected_outcome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitted_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->getStateUsing(function (Model $record) {
                        // If status is 0, return 'Rejected'
                        if ($record->status == 0) {
                            return 'Apex Rejected';
                        }
                        
                        // If status is 7, return 'Accepted'
                        if ($record->status == 7) {
                            return 'Apex Accepted';
                        }
                
                        // If status matches a role_id in the Roles table, return the role name
                        $role = \App\Models\Roles::find($record->status - 1);
                        if ($role) {
                            return $role->name." Accepted";
                        }
                
                        // Default fallback
                        return 'Not Submitted';
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('accept')
                ->label('Accept')
                ->color('success')
                ->icon('heroicon-o-check')
                ->action(function (ApexForm $record) {
                    // Increment the status value by 1
                    $record->update(['status' => $record->status + 1]);

                    Notification::make()
                     ->success()
                     ->title('Status Accepted');
                })
                ->requiresConfirmation()
                ->visible(fn (ApexForm $record) => $record->status > 1 && $record->status < 7),

            // Reject Action
            Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->action(function (ApexForm $record) {
                    // Set the status value to 0
                    $record->update(['status' => 0]);

                    // Optionally, show a notification
                    Notification::make()
                     ->danger()
                     ->title('Status Rejected');
                })
                ->requiresConfirmation()
                ->visible(fn (ApexForm $record) => $record->status > 1 && $record->status < 7),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $userRoleId = Auth::user()->role_id;
        return parent::getEloquentQuery()->where(function ($query) use ($userRoleId) {
            $query->where('status', $userRoleId)
                  ->orWhere('status', 0)
                  ->orWhere('status', 7);
        });
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
            'index' => Pages\ListApexForms::route('/'),
            'create' => Pages\CreateApexForm::route('/create'),
        ];
    }
}
