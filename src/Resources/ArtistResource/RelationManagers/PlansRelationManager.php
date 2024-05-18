<?php

namespace Bramato\FilamentStripeManager\Resources\StripeProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlansRelationManager extends RelationManager
{
    protected static string $relationship = 'plans';
    protected static ?string $title = 'Stripe Plans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('interval')
            ->columns([
                Tables\Columns\TextColumn::make('interval'),
                Tables\Columns\TextColumn::make('active'),
                Tables\Columns\TextColumn::make('amount_currency')->label('Amount')->default(fn($record)=>$record->currency. ' '.$record->amount),
            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }
}
