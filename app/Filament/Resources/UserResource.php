<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Users Management';

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_suspended', 1)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()

                ->schema([

                    Forms\Components\Section::make('User Details')

                    ->schema([

                        Forms\Components\TextInput::make('name')
                        ->disabled(),
                        Forms\Components\TextInput::make('email')
                        ->disabled(),
                        Forms\Components\Select::make('role')
                            ->options([
                                'admin' => 'admin',
                                'agent' => 'agent',
                                'user' => 'user',
                            ])
                            ->default('user'),
                        Forms\Components\Select::make('organization_id')
                            ->relationship('organizations', 'nickname')
                            ->disabled(),
                    ])

                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('organizations.nickname')
                    ->label('Organization')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'success',
                        'user' => 'gray',
                        'agent' => 'warning',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reputation')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bio')
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                ->options([
                    'admin' => 'Admin',
                    'agent' => 'Agent',
                    'user' => 'User',
                ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('reset_reputation')
                        ->label('Reset Reputation')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->action(function(User $user){
                            $user->total_reputation += $user->reputation;
                            $user->reputation = 0;
                            $user->save();
                            Notification::make()
                                ->title('Reputation Reset Success!')
                                ->body('Selected users&rsquo; reputations have been reset.')
                                ->icon('heroicon-o-arrow-path')
                                ->color('success')
                                ->send();
                        }),
                        Tables\Actions\Action::make('Suspend User')
                        ->label('Suspend/Unsuspend User')
                        ->icon('heroicon-o-eye-slash')
                        ->color('info')
                        ->action(function(User $user){
                            if ($user->is_suspended == false) {
                                $user->is_suspended = true;
                                $user->save();
                                Notification::make()
                                    ->title('Suspended Successfully!')
                                    ->body('Selected user have been suspended.')
                                    ->icon('heroicon-o-eye-slash')
                                    ->color('info')
                                    ->send();
                            } else {
                                $user->is_suspended = false;
                                $user->save();
                                Notification::make()
                                    ->title('Approval Removed Successfully!')
                                    ->body('Selected user have been un-suspended.')
                                    ->icon('heroicon-o-eye-slash')
                                    ->color('success')
                                    ->send();
                            }
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('reset_reputation')
                        ->label('Reset Reputation')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            $records->each(function ($record){
                                $record->total_reputation += $record->reputation;
                                $record->reputation = 0;
                                $record->save();
                                Notification::make()
                                    ->title(__('Reset Successfully!'))
                                    ->body(__('Selected users reputation have been reset.'))
                                    ->icon('heroicon-s-check')
                                    ->color('success')
                                    ->send();
                            });
                        }),
                        Tables\Actions\BulkAction::make('Suspend Users')
                        ->label('Suspend Users')
                        ->icon('heroicon-o-eye-slash')
                        ->color('danger')
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            $records->each(function ($record){
                                $record->is_suspended = !$record->is_suspended;
                                $record->save();
                                if ($record->is_suspended) {
                                    Notification::make()
                                        ->title(__('Users Suspended!'))
                                        ->body(__('Selected users have been suspended.'))
                                        ->icon('heroicon-o-eye-slash')
                                        ->color('info')
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title(__('Suspension Removed Successfully!'))
                                        ->body(__('Selected posts suspension has been lifted.'))
                                        ->icon('heroicon-o-eye')
                                        ->color('success')
                                        ->send();
                                }
                            });
                        }),
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
            // 'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()->role == 'admin';
    }
    public static function canCreate(): bool
    {
        return false; // Disables the "New User" button
    }
}
