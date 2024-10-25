<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create Post')
                ->description('Create a new post')
                ->collapsible(true)
                // ->aside()
                ->schema([
                    // Group::make()->schema([
                        TextInput::make('title')
                            ->rules('min:3|max:50')
                            // ->in('test', 'hello') 
                            ->required()
                        ,
                        TextInput::make('slug')
                            ->unique(ignoreRecord: true)
                            ->required(),                        
                    // ]),
                    
                    // Select::make('category_id')
                    //     ->options(Category::all()->pluck('name', 'id'))
                    //     ->required()
                    //     ->label('Category'),
                        
                    ColorPicker::make('color')->required(),
                    
                    MarkdownEditor::make('content')->required()
                    ->columnSpan(2)
                    ->columns(2)
                    // ->columnSpanFull()
                    ,
                ])->columnSpan(2)->columns(2),   

                Group::make()->schema([
                    Section::make("Image")
                    ->collapsible(true)
                    ->schema([
                        FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),
                    ])->columnSpan(1),
                    Section::make("Meta")->schema([
                        TagsInput::make('tags')->required(),
                        Checkbox::make('published'),
                    ])
                ]),
                     
            ])->columns(([
                'default' => 3,
                'sm' => 3,
                'md' => 3,
                'lg' => 3,
            ]));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                TextColumn::make('slug'),
                CheckboxColumn::make('published'),
                TextColumn::make('created_at')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
