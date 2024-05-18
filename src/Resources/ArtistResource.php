<?php

namespace Bramato\FilamentSpotifyManager\Resources;

use Bramato\FilamentSpotifyManager\Models\Artist;
use Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages\CreateArtist;
use Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages\EditArtist;
use Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages\ListArtists;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArtistResource extends Resource
{
    protected static ?string $model = Artist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Stripe Manager';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               TextInput::make('name')->label('Plan name')->hint('Name of plan')->columnSpanFull(),
                Select::make('monthly_quota_status')->options([
                    0 => 'No',
                    1 => 'Yes'
                ])->live(),
                TextInput::make('monthly_quota')
                ->disabled(fn (Get $get): bool => ($get('monthly_quota_status') == 0)),
                
                Select::make('annual_quota_status')->options([
                    false => 'No',
                    true => 'Yes'
                ])->live(),
                TextInput::make('annual_quota')
                    ->disabled(fn (Get $get): bool => ($get('annual_quota_status') == false))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Plan Name'),
                Tables\Columns\ToggleColumn::make('monthly_quota_status')->label('Monthly')->alignCenter(),
                Tables\Columns\ToggleColumn::make('annual_quota_status')->label('Annual')->alignCenter(),
                Tables\Columns\TextColumn::make('monthly_quota')->label('Monthly Quota')->alignCenter(),
                Tables\Columns\TextColumn::make('annual_quota')->label('Annual Quota')->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArtists::route('/'),
            'create' => CreateArtist::route('/create'),
            'edit' => EditArtist::route('/{record}/edit'),
        ];
    }
}
