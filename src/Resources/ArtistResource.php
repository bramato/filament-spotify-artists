<?php

namespace Bramato\FilamentSpotifyManager\Resources;

use Bramato\FilamentSpotifyManager\Models\Artist;
use Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages\CreateArtist;
use Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages\EditArtist;
use Bramato\FilamentSpotifyManager\Resources\ArtistResource\Pages\ListArtists;
use Bramato\FilamentSpotifyManager\Resources\ArtistResource\RelationManagers\AlbumRelationManager;
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

    protected static ?string $navigationIcon = 'zondicon-artist';

    protected static ?string $navigationGroup = 'Spotify Manager';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('genre')->label('Genre'),
                Tables\Columns\TextColumn::make('image_url')->label('Avatar'),
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
            AlbumRelationManager::make()
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
