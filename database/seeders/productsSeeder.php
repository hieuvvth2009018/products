<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class productsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
           [
               'id'=>1,
               'name'=>'ao mua',
               'price'=>2000000,
               'thumbnail'=>'https://bizweb.dktcdn.net/thumb/1024x1024/100/344/834/products/fd748edb9cca7d9424db.jpg?v=1600674855640',
               'created_at'=>Carbon::now(),
               'updated_at'=>Carbon::now(),
           ],[
                'id'=>2,
                'name'=>'ao khoác',
                'price'=>3000000,
                'thumbnail'=>'https://www.chapi.vn/img/product/2020/10/3/ao-khoac-gio-nam-kpb-sport-14-new.jpg',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],[
                'id'=>3,
                'name'=>'ao bò',
                'price'=>4000000,
                'thumbnail'=>'https://salt.tikicdn.com/cache/w64/ts/product/61/72/73/fa77e2be2aef594455d042caa9f3cd9d.jpg',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],[
                'id'=>4,
                'name'=>'ao mèo',
                'price'=>5000000,
                'thumbnail'=>'https://sakurafashion.vn/upload/sanpham/large/5895-ao-hoodie-hinh-mat-meo-de-thuong-1.jpg',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],[
                'id'=>5,
                'name'=>'ao chó',
                'price'=>6000000,
                'thumbnail'=>'https://petviet.vn/wp-content/uploads/2018/09/quan-ao-cho-thu-cung-qa040101-1.jpg',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],[
                'id'=>6,
                'name'=>'ao cóc',
                'price'=>7000000,
                'thumbnail'=>'https://product.hstatic.net/200000189081/product/bst_b2638d3d40214769b77e86efdf1eca95_master.jpg',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],[
                'id'=>7,
                'name'=>'ao tâm đồ',
                'price'=>8000000,
                'thumbnail'=>'https://salt.tikicdn.com/cache/w444/ts/product/79/07/ca/759b5ad1a4942d7ef09d57c6d33c3ef3.jpg',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],[
                'id'=>8,
                'name'=>'ao gió',
                'price'=>9000000,
                'thumbnail'=>'https://salt.tikicdn.com/cache/w444/ts/product/79/07/ca/759b5ad1a4942d7ef09d57c6d33c3ef3.jpg',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],[
                'id'=>9,
                'name'=>'ao quat',
                'price'=>10000000,
                'thumbnail'=>'http://quatbaoho.com/wp-content/uploads/2019/06/quatbaoho.com-tb05-5-600x1398.png',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],[
                'id'=>10,
                'name'=>'ao thông hơi',
                'price'=>11000000,
                'thumbnail'=>'http://quatbaoho.com/wp-content/uploads/2019/06/quatbaoho.com-aobaohoganquat-bt04-3-1024x739.jpg',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]
        ]);
    }
}
