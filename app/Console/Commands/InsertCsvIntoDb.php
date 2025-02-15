<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Part;
use App\Models\Offer;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Condition;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertCsvIntoDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:csv-into-db {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts rows from a suppliers/products .csv file into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if(!file_exists($filePath)) {
            $this->error('File not found: '.$filePath);
            return;
        }

        $file = fopen($filePath, 'r');
        
        if(!$file) {
            $this->error('Could not open the file: '.$filePath);
            return;
        }

        $header = fgetcsv($file);

        DB::beginTransaction();

        try {
            while($row = fgetcsv($file)) {
                $rowData = array_combine($header, $row);
                $supplier = null;
                $category = null;
                $condition = null;

                if(!empty($rowData['supplier_name'])) {
                    $supplier = Supplier::firstOrCreate([
                        'supplier_name' => $rowData['supplier_name'],
                    ]);
                }
    
                if(!empty($rowData['category'])) {
                    $category = Category::firstOrCreate([
                        'category_name' => $rowData['category'],
                    ]);
                }
    
                if(!empty($rowData['condition'])) {
                    $condition = Condition::firstOrCreate([
                        'condition_name' => $rowData['condition'],
                    ]);
                }

                $part = Part::create([
                    'part_number' => $rowData['part_number'] ?? null,
                    'part_desc' => $rowData['part_desc'],
                    'category_id' => $category->id ?? null,
                ]);

                if(!empty($rowData['days_valid']) && !empty($rowData['priority']) && !empty($rowData['quantity']) && !empty($rowData['price']) && isset($condition) && $part->id && isset($supplier)) {
                    $offer = Offer::create([
                        'days_valid' => $rowData['days_valid'],
                        'priority' => $rowData['priority'],
                        'quantity' => $rowData['quantity'],
                        'price' => $rowData['price'],
                        'condition_id' => $condition->id,
                        'part_id' => $part->id,
                        'supplier_id' => $supplier->id,
                    ]);
                }
            }

            DB::commit();
            $this->info('CSV data successfully inserted into the database.');
        }
        catch(Exception $e) {
            DB::rollBack();
            $this->error('Error inserting CSV: '.$e->getMessage());
        }

        fclose($file);
    }
}
