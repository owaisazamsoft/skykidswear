<?php

namespace App\Filament\Resources\Transactions;

use App\Filament\Resources\Transactions\Pages\ManageTransactions;
use App\Models\Transaction;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('date')
                    ->required(),
                Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->required(),
                Select::make('type')
                    ->options(['debit' => 'Debit', 'credit' => 'Credit'])
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->required()
                    ->default(0),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')->label('ID'),
                TextEntry::make('date')->dateTime(),
                TextEntry::make('employee.name')->label('Employee'),
                TextEntry::make('type')->badge(),
                TextEntry::make('amount')->numeric(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')->dateTime()->placeholder('-'),
                TextEntry::make('updated_at')->dateTime()->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('date')->dateTime(),
                TextColumn::make('employee.name'),
                TextColumn::make('type')->badge(),
                TextColumn::make('description'),
                TextColumn::make('amount')->numeric(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                
                Filter::make('description')
                ->schema([TextInput::make('description')->label('Description'),])
                ->query(function ($query, array $data) {
                    return $query->when(
                        $data['description'],
                        fn ($q, $value) => $q->where('description', 'like', "%{$value}%")
                    );
                }),

                Filter::make('date_from')
                ->schema([DatePicker::make('from')->label('Date From')])
                ->query(function($query,$data){
                    return $query->when($data['from'],function($q, $date){
                        return $q->whereDate('date', '>=', $date);
                    });
                }),

                Filter::make('date_to')
                ->schema([DatePicker::make('to')->label('Date To')])
                ->query(function($query,$data){
                    return $query->when($data['to'],function($q, $date){
                        return $q->whereDate('date', '<=', $date);
                    });
                }),

                SelectFilter::make('product_id')
                ->label('Employee')
                ->searchable(['id','name'])
                ->preload()
                ->relationship('employee','id')
                 ->getOptionLabelFromRecordUsing(function ($record) {
                    return $record->id.'-'.$record->name.'-'.$record->father_name;
                })
                ->columns(1),

                SelectFilter::make('type')
                ->label('Type')
                ->preload()
                ->options([
                    'debit' => 'Debit',   // 'key' => 'Label'
                    'credit' => 'Credit',
                ])
                ->columns(1),
                


            ],FiltersLayout::AboveContent)
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->recordUrl(null)
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTransactions::route('/'),
        ];
    }
}
