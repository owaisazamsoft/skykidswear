<?php

namespace App\Filament\Resources\Stitchings\Pages;

use App\Filament\Resources\Stitchings\StitchingResource;
use App\Models\Department;
use App\Models\Employee;
use App\Models\StitchingItem;
use Filament\Actions\DeleteAction as ActionsDeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Actions\CreateAction;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;


class ManageStitchingItems extends Page implements HasTable
{
  
    // 2. MUST use InteractsWithTable
    use InteractsWithTable;
    use InteractsWithRecord;

    protected static string $resource = StitchingResource::class;

    protected string $view = 'filament.resources.stitchings.pages.manage-stitching-items';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function table(Table $table): Table
    {

        return $table
            // Direct DB Query for this specific lot
            ->query(StitchingItem::where('stitching_id', $this->record->id))
            ->paginated(false)
            ->columns([
                TextColumn::make('index')->label('#')->rowIndex(),
                TextColumn::make('lotItem.lot.ref') ->label('Lot'),
                TextColumn::make('lotItem.product.name')->label('Product'),
                TextColumn::make('lotItem.size.name')->label('Size'),
                TextColumn::make('lotItem.color.name')->label('Color'),
                TextColumn::make('department.name'),
                TextColumn::make('employee.name'),
                TextColumn::make('quantity'),
                TextColumn::make('price')->numeric(),
                TextColumn::make('total')->numeric(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->model(StitchingItem::class)
                    ->schema($this->getStitchingItemFormSchema())
                    ->using(function (array $data) {
                        return $this->record->items()->create($data);
                    })
                    ->after(function () {
                        // Refresh parent totals or send notifications
                        $this->record->refresh(); 
                    })
            ])
            ->recordUrl(null)
            ->recordActions([
                EditAction::make()
                ->model(StitchingItem::class)
                ->schema($this->getStitchingItemFormSchema()),
                ActionsDeleteAction::make(),
            ]);
            
    }



    /**
     * Define the form once to use for both Create and Edit
     */
    protected function getStitchingItemFormSchema(): array
    {
        return [
            Section::make('Item Details')
                ->schema([
                            Select::make('lot_item_id')
                                ->relationship('lotItem', 'id')
                                ->getOptionLabelFromRecordUsing(function ($record) {
                                    $ref = $record->lot->ref;
                                    $product = $record->product->name;
                                    $color = $record->color->name;
                                    $size = $record->size->name;
                                    return $ref.'-'.$product.'-'.$color.'-'.$size;
                                })
                                ->searchable()
                                ->preload()
                                ->required(),

                            Select::make('employee_id')
                                ->relationship('employee', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Select::make('department_id')
                                ->relationship('department', 'name')
                                ->required(),
       
                            TextInput::make('quantity')
                                ->required()
                                ->numeric()
                                ->live()
                                ->default(0)
                                ->afterStateUpdated(function ($get, $set) {
                                    $q = (float) ($get('quantity') ?? 0);
                                    $p = (float) ($get('price') ?? 0);
                                    $set('total', $q * $p);
                                }),

                            TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->live()
                                ->afterStateUpdated(function ($get, $set) {
                                    $q = (float) ($get('quantity') ?? 0);
                                    $p = (float) ($get('price') ?? 0);
                                    $set('total', $q * $p);
                                }),

                            TextInput::make('total')
                                ->required()
                                ->numeric()
                                ->live()
                                ->dehydrated()
                                ->default(0),

                            Textarea::make('description')
                                ->default(null)
                                ->columnSpan(3),
            ])->columns(3)
        ];
    }


 
    
}
