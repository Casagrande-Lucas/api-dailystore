<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ServiceCsv;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

        $sql = "INSERT INTO products (name, color, size, value, amount, created_at, updated_at) VALUES ";

        $count = 0;
        $pluck = 50;

        foreach ($data as $row) {
            $productData = array_combine($headers, explode(';', $row[0]));

            $name = $productData['name'];
            $color = $productData['color'];
            $size = $productData['size'];
            $value = $productData['value'];
            $amount = $productData['amount'];
            $createdAt = Carbon::now()->format('Y-m-d H:i:s');
            $updatedAt = Carbon::now()->format('Y-m-d H:i:s');

            $sql .= "('$name', '$color', '$size', $value, $amount, '$createdAt', '$updatedAt'), ";

            $count++;

            if ($count >= $pluck) {
                $sql = rtrim($sql, ", ");
                DB::select($sql);
                $pluck += 50;
            }
        }

        $this->info('csv import success.');
    }
}
