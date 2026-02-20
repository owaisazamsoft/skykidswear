<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Lot;
use App\Models\LotItem;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class DataController extends Controller
{
    //


    public function import(){

       

    

        // $users = json_decode($jsonContent, true);

        $this->products();
        $this->lot();

        // $this->users();
        // $this->products();
        


    }


    public function lot(){
        
         Lot::query()->delete();
         LotItem::query()->delete();

        // $jsonContent = file_get_contents(public_path('products.xlsx'));
        $data = Excel::toArray([], public_path('lot.xlsx'));
        $rows = ($data[0]);
        array_shift($rows);

        // dd($rows);

        foreach ($rows as $key => $value) {

            if(!$value[0]){
                continue;
            }

            $size = Size::whereRaw('LOWER(trim(name)) = ?', [strtolower(trim($value[3]))])->first();
            if(!$size){
                $size = new Size();
                $size->name = trim($value[3]);
                $size->save();
            }
            
            $product = Product::whereRaw('LOWER(trim(code)) = ?', [strtolower(trim($value[0]))])->first();
            if(!$product){
                $product = new Product();
                $product->name = trim($value[0]);
                $product->size_id = $size->id;
                $product->save();
                // echo '<br> product not found-'.$value[0];
            }
          
            if($product){

                $lot = Lot::create([
                    'ref' => $value[1],
                    'total_quantity' => $value[2],
                    'product_id' => $product->id,
                    'date' =>  Carbon::parse($value[4]),
                ]);

                // dd($lot);
                // $lot->items()->create([
                //     'size_id' => $size->id,
                //     'color_id' => 1,
                //     'quantity' => $value[2],
                // ]);

            }
            

          

        }

    }

    public function products(){

        Product::query()->delete();
        Category::query()->delete();
        Brand::query()->delete();
        Size::query()->delete();

        // $jsonContent = file_get_contents(public_path('products.xlsx'));
        $data = Excel::toArray([], public_path('products.xlsx'));
        $rows = ($data[0]);
        array_shift($rows);

        foreach ($rows as $key => $value) {

            if(!$value[0]){
                continue;
            }
            
            $category = Category::whereRaw('LOWER(trim(name)) = ?', [strtolower(trim($value[4]))])->first();
            if(!$category){
                $category = new Category();
                $category->name = trim($value[4]);
                $category->save();
            }
            // dd($value);

            $size = Size::whereRaw('LOWER(trim(name)) = ?', [strtolower(trim($value[2]))])->first();
            if(!$size){
                $size = new Size();
                $size->name = trim($value[2]);
                $size->save();
            }

            $brand = Brand::whereRaw('LOWER(trim(name)) = ?', [strtolower(trim($value[3]))])->first();
            if(!$brand){
                $brand = new Brand();
                $brand->name = trim($value[3]);
                $brand->save();
            }

            Product::create([
                'code' => $value[0],
                'name' =>  $value[1],
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'size_id' => $size->id,
            ]);

        }

    }


    public function users(){

        Employee::query()->delete();

        $jsonContent = file_get_contents(public_path('users.json'));
        $users = json_decode($jsonContent, true);
        foreach ($users as $key => $value) {
            Employee::create([
                'id' => $value['id'],
                'name' => $value['name'],
            
            ]);
        }



    }




}
