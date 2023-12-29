<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ServiceCsv;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportListProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:import-list-products {--f|file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected string $file = 'list-products.csv';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->file = $this->option('file') ? $this->option('file') : $this->file;
        $path = database_path('/seeders/Stock/Products/' . $this->file);

        $data = array_map('str_getcsv', file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

        $headers = explode(';', array_shift($data)[0]);

        foreach ($data as $row) {
            $productData = array_combine($headers, explode(';', $row));


            $decodeUnicode = function ($value) {
                return json_decode('"' . $value . '"');
            };

            Product::create([
                'id' => Str::orderedUuid(),
                'name' => $decodeUnicode($productData['Nome']),
                'color' => $decodeUnicode($productData['Cor']),
                'size' => $decodeUnicode($productData['Tamanho']),
                'value' => $productData['Preco'],
                'amount' => $decodeUnicode($productData['Estoque']),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $this->info('csv import success.');
    }
}
