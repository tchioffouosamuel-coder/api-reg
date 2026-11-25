<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Inscriptions';

    protected static ?string $modelLabel = 'inscription';

    protected static ?string $pluralModelLabel = 'inscriptions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options([
                        'event' => 'Événement',
                        'formation' => 'Formation',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('reference_slug')
                    ->label('Référence (slug)')
                    ->required(),
                Forms\Components\TextInput::make('reference_label')
                    ->label('Intitulé')
                    ->required(),
                Forms\Components\TextInput::make('nom')
                    ->label('Nom complet')
                    ->required(),
                Forms\Components\TextInput::make('telephone')
                    ->label('Téléphone')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Forms\Components\TextInput::make('participant_type')
                    ->label('Type de participant'),
                Forms\Components\TextInput::make('amount_label')
                    ->label('Tarif'),
                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'checked_in' => 'Présent (check-in)',
                        'cancelled' => 'Annulée',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->label('Nom')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reference_label')
                    ->label('Événement / Formation')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'event',
                        'success' => 'formation',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'event' => 'Événement',
                        'formation' => 'Formation',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('participant_type')
                    ->label('Tarif')
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'confirmed',
                        'success' => 'checked_in',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'checked_in' => 'Présent',
                        'cancelled' => 'Annulée',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Inscrit le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'event' => 'Événement',
                        'formation' => 'Formation',
                    ]),
                Tables\Filters\SelectFilter::make('reference_slug')
                    ->label('Événement / Formation')
                    ->options(fn () => Registration::query()
                        ->distinct()
                        ->pluck('reference_label', 'reference_slug')
                        ->toArray()),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'checked_in' => 'Présent',
                        'cancelled' => 'Annulée',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('checkIn')
                    ->label('Check-in')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Registration $record) => $record->status !== 'checked_in')
                    ->action(function (Registration $record) {
                        $record->update(['status' => 'checked_in', 'checked_in_at' => now()]);
                        Notification::make()
                            ->title('Participant marqué présent')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('badge')
                    ->label('Badge')
                    ->icon('heroicon-o-identification')
                    ->color('info')
                    ->url(fn (Registration $record) => route('registrations.badge', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('attestation')
                    ->label('Attestation')
                    ->icon('heroicon-o-document-check')
                    ->color('warning')
                    ->url(fn (Registration $record) => route('registrations.attestation', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRegistrations::route('/'),
        ];
    }
}
