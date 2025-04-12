<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Data Siswa';
    protected static ?string $modelLabel = 'Siswa';
    protected static ?string $slug = 'Data Siswa';

    protected static ?string $label = 'Data Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nis')
                    ->label('NIS')
                    ->placeholder('Masukkan Nomor Induk Siswa')
                    ->maxLength(10)
                    ->required()
                    ->helperText('Nomor Induk Siswa maksimal 10 digit'),

                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->placeholder('Masukkan nama lengkap siswa')
                    ->required(),

                Select::make('kelas_id')
                    ->label('Pilih Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Pilih kelas siswa dari daftar'),

                TextInput::make('no_absen')
                    ->label('Nomor Absen')
                    ->placeholder('Masukkan nomor absen')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nis')->searchable()->sortable(),
                TextColumn::make('nama')->searchable()->sortable(),
                BadgeColumn::make('kelas.nama_kelas')
                    ->label('Kelas')
                    ->colors([
                        'primary',
                        'success' => fn($state) => str_contains($state, 'XII'),
                        'warning' => fn($state) => str_contains($state, 'XI'),
                        'danger' => fn($state) => str_contains($state, 'X'),
                    ]),
                TextColumn::make('no_absen')->sortable(),
            ])
            ->filters([
                SelectFilter::make('kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->label('Filter Kelas')
                    ->searchable(),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
            'show' => Pages\ViewSiswa::route('/{record}'),
        ];
    }
}
