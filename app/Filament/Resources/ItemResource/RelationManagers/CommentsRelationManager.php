<?php

namespace App\Filament\Resources\ItemResource\RelationManagers;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\CommentResource;
use Filament\Resources\RelationManagers\RelationManager;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'content';

    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Model $record): string => CommentResource::getUrl('edit', ['record' => $record]))
            ->columns([
                Tables\Columns\TextColumn::make('content')->searchable()->wrap(),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('votes_count')->counts('votes')->label(trans('table.total-votes'))->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Date'),
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc');
    }
}
