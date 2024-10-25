<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\AuthorsRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 7;


    protected static ?string $modelLabel = 'Post';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Create New Post')->tabs([
                    Tab::make('Details')
                    ->icon('heroicon-o-pencil')
                    ->schema([
                        TextInput::make('title')
                        ->rules('min:3|max:50')
                        // ->in('test', 'hello')
                        ->required()
                    ,
                    TextInput::make('slug')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Select::make('category_id')
                        ->options(Category::all()->pluck('name', 'id'))
                        ->required()
                        ->label('Category'),

                    ColorPicker::make('color')->required(),
                    ]),

                    Tab::make('Content')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        MarkdownEditor::make('content')->required()->columnSpanFull()
                    ]),

                    Tab::make('Meta')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Group::make()->schema([
                            Section::make("Image")
                            ->collapsible(true)
                            ->schema([
                                FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),
                            ])->columnSpan(1),
                            Section::make("Meta")->schema([
                                TagsInput::make('tags')->required(),
                                Checkbox::make('published'),
                            ]),
                            Section::make('Authors')->schema([
                                Select::make('authors')
                                    ->relationship('authors', 'name')
                                    ->multiple(true)
                                    ->searchable()
                            ])
                        ]),
                    ]),
                ])->columnSpanFull()->persistTabInQueryString(),

                // Section::make('Create Post')
                // ->description('Create a new post')
                // ->collapsible(true)
                // ->aside()
                // ->schema([
                    // Group::make()->schema([
                    //     TextInput::make('title')
                    //         ->rules('min:3|max:50')
                    //         // ->in('test', 'hello')
                    //         ->required()
                    //     ,
                    //     TextInput::make('slug')
                    //         ->unique(ignoreRecord: true)
                    //         ->required(),
                    // // ]),

                    // Select::make('category_id')
                    //     ->options(Category::all()->pluck('name', 'id'))
                    //     ->required()
                    //     ->label('Category'),

                    // ColorPicker::make('color')->required(),

                    // MarkdownEditor::make('content')->required()
                    // ->columnSpan(2)
                    // ->columns(2)
                    // ->columnSpanFull()                    ,
                // ])->columnSpan(2)->columns(2),

                // Group::make()->schema([
                //     Section::make("Image")
                //     ->collapsible(true)
                //     ->schema([
                //         FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),
                //     ])->columnSpan(1),
                //     Section::make("Meta")->schema([
                //         TagsInput::make('tags')->required(),
                //         Checkbox::make('published'),
                //     ]),
                //     Section::make('Authors')->schema([
                //         Select::make('authors')
                //             ->relationship('authors', 'name')
                //             ->multiple(true)
                //             ->searchable()
                //     ])
                // ]),

            ])
            ->columns(1)
            // ->columns([
            //     'default' => 3,
            //     'sm' => 3,
            //     'md' => 3,
            //     'lg' => 3,
            // ])
            ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->sortable()
                ->searchable()
                ->toggleable(true),
                ImageColumn::make('thumbnail'),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                TextColumn::make('slug')
                    ->toggleable(true),
                // TextColumn::make('category_id'),
                TextColumn::make('category.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                ColorColumn::make('color'),
                TextColumn::make('tags')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                CheckboxColumn::make('published')
                    ->sortable()
                    ->searchable()
                    ->toggleable(true),
                TextColumn::make('created_at')
                    ->label('Published On')
                    ->date()
                    ->searchable()
                    ->toggleable(true),
            ])
            ->filters([
                // Filter::make('Published Posts')->query(
                //     function ($query) {
                //         return $query->where('published', true);
                //     }
                // ),

                TernaryFilter::make('Published'),

                SelectFilter::make('category_id')
                    ->label('Category')
                    // ->options(Category::all()->pluck('name', 'id')
                    ->relationship('category', 'name') // App/Models/Post -> Category
                    ->multiple()
                    ->searchable()
                    ->preload()
                ,
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make(),
                DeleteAction::make()
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
            AuthorsRelationManager::class,
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
