<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportsResource\Pages;
use App\Filament\Resources\ReportsResource\RelationManagers;
use App\Models\Reports;
use App\Models\User;
use App\Models\Post;
use App\Notifications\WarningNotif;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;


class ReportsResource extends Resource
{
    protected static ?string $model = Reports::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Users Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        // dd($form->model());
        return $form->schema([
            Forms\Components\Select::make('reporter_id')
            ->relationship('reporter', 'name')
            ->disabled(),
            Forms\Components\TextInput::make('reportable_id')
            ->label('Reported Name/Title')
            ->disabled()
            ->afterStateHydrated(function ($component, $state) {
                $record = $component->getRecord(); // Get the record the form is editing

                // Access the reportable_type and reportable_id attributes
                $reportableType = $record->reportable_type;
                $reportableId = $record->reportable_id;

                if ($reportableType && $reportableId) {
                    // Check if the related model is an instance of User
                    if ($reportableType === \App\Models\User::class) {
                        $user = \App\Models\User::find($reportableId);
                        $component->state($user ? $user->name : 'No Reported Name');
                    }

                    // Check if the related model is an instance of Post
                    if ($reportableType === \App\Models\Post::class) {
                        $post = \App\Models\Post::find($reportableId);
                        $component->state($post ? Str::limit($post->title, 30) : 'No Reported Title');
                    }
                } else {
                    $component->state('No Reported Name');
                }
            })
            ,
            Forms\Components\Textarea::make('reason')
            ->disabled()
            ->columnSpanFull(),
        ]);

    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reportable.name')
                    ->label('Reported Name/Title')
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        if ($record->reportable) {
                            if ($record->reportable instanceof User) {
                                return $record->reportable->name;
                            }
                            if ($record->reportable instanceof Post) {
                                return Str::limit($record->reportable->title, 30);
                            }
                        }
                        return 'No Reported Name';
                    }),
                Tables\Columns\TextColumn::make('reportedAuthor.name')
                ->label('Reported Author')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('reporter.name')
                ->numeric()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('reportedAuthor.warnings')
                ->label('Warning Level')
                ->numeric(),
                Tables\Columns\TextColumn::make('reason')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')->label('Date Reported')
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Suspend')
                ->label('Suspend User')
                ->icon('heroicon-s-wrench-screwdriver')
                ->color('danger')
                ->action(function ($record) {
                    $user = $record->reportedAuthor;  // Get the user related to the report
                    switch ($user->warnings) {
                        case 0:
                            $user->update([
                                'is_suspended' => true,
                                'suspended_until' => now()->addDays(3)
                            ]);
                            $user->increment('warnings');
                            $user->save();
                            $message = "Warning issued.";
                            break;

                        case 1:
                            $user->update([
                                'is_suspended' => true,
                                'suspended_until' => now()->addDays(30)
                            ]);
                            $user->reputation = 0;
                            $user->increment('warnings');
                            $user->save();
                            $message = "Warning issued. User has been suspended for 1 month.";
                            break;

                        case 2:
                            $user->update([
                                'is_suspended' => true,
                                'suspended_until' => now()->addMonths(6)
                            ]);
                            $user->reputation = 0;
                            $user->total_reputation = 0;
                            $user->warnings = 0;
                            $user->save();
                            $message = "User has been suspended for a semester.";
                            break;

                        default:
                            $message = "No action taken.";
                            break;
                    }

                    // Increment warnings on the User model


                    $user->notify(new WarningNotif());
                    // Notify the admin
                    Notification::make()
                        ->title('Suspension Applied')
                        ->body($message)
                        ->success()
                        ->send();
                }),

            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ])
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReports::route('/create'),
            'edit' => Pages\EditReports::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;  // Disable editing for this resource
    }

}
