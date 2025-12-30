<?php

namespace App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\Product;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductImage;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductVariant;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Brands\Database\Models\Brand;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Categories\Database\Models\Category;
use App\Modules\ECOMMERCE\Managements\ProductManagements\SubCategories\Database\Models\Subcategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ChildCategories\Database\Models\ChildCategory;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Colors\Database\Models\Color;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Flags\Database\Models\Flag;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Sizes\Database\Models\ProductSize;
use App\Modules\ECOMMERCE\Managements\ProductManagements\Products\Database\Models\ProductWarrenty;
use App\Modules\ECOMMERCE\Managements\ProductManagements\ProductAttributes\Units\Database\Models\Unit;

class GenerateDemoProducts
{
    public static function execute(Request $request)
    {
        ini_set('max_execution_time', 3600);

        $faker = Container::getInstance()->make(Generator::class);

        // Determine product type from request (1=Fashion, 2=Tech)
        $productType = $request->product_type ?? 1;

        // Define demo image paths based on product type
        if ($productType == 1) {
            // Fashion products
            $demoImageBase = 'uploads/products/demo/fashion/';
            $productNames = ['T-Shirt', 'Jeans', 'Dress', 'Shoes', 'Jacket', 'Bag', 'Watch', 'Sunglasses'];
        } else {
            // Tech products
            $demoImageBase = 'uploads/products/demo/tech/';
            $productNames = ['Smartphone', 'Laptop', 'Tablet', 'Headphones', 'Camera', 'Smartwatch', 'Speaker', 'Monitor'];
        }

        // Ensure demo image directories exist
        $publicPath = public_path($demoImageBase);
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        for ($i = 1; $i <= $request->products; $i++) {
            $randomName = $productNames[array_rand($productNames)];
            $title = $randomName . " " . $faker->words(2, true) . " #" . $i;
            $categoryId = Category::where('status', 1)->select('id')->inRandomOrder()->limit(1)->get();
            $subcategoryId = Subcategory::where('status', 1)->where('category_id', isset($categoryId[0]) ? $categoryId[0]->id : null)->select('id')->inRandomOrder()->limit(1)->get();
            $childCategoryId = ChildCategory::where('subcategory_id', isset($subcategoryId[0]) ? $subcategoryId[0]->id : null)->select('id')->inRandomOrder()->limit(1)->get();
            $brandId = Brand::where('status', 1)->select('id')->inRandomOrder()->limit(1)->get();
            $modelId = Product::where('brand_id', isset($brandId[0]) ? $brandId[0]->id : null)->select('id')->inRandomOrder()->limit(1)->get();
            $unitId = Unit::select('id')->inRandomOrder()->limit(1)->get();
            $warrentyId = ProductWarrenty::select('id')->inRandomOrder()->limit(1)->get();
            $flagId = Flag::select('id')->where('status', 1)->inRandomOrder()->limit(1)->get();
            $colorId = Color::select('id')->inRandomOrder()->limit(1)->get();
            $sizeId = ProductSize::select('id')->inRandomOrder()->limit(1)->get();
            $regionId = DB::table('country')->select('id')->inRandomOrder()->limit(1)->get();
            $simId = DB::table('sims')->select('id')->inRandomOrder()->limit(1)->get();
            $storageTypeId = DB::table('storage_types')->select('id')->inRandomOrder()->limit(1)->get();
            $conditionID = DB::table('device_conditions')->select('id')->inRandomOrder()->limit(1)->get();
            $warrentyID = DB::table('product_warrenties')->select('id')->inRandomOrder()->limit(1)->get();

            // Generate demo image filename
            $mainImage = $demoImageBase . 'product-' . $i . '.jpg';

            // Create a simple colored placeholder image
            $imgPath = public_path($mainImage);
            if (!file_exists($imgPath)) {
                $img = imagecreatetruecolor(800, 800);
                $bgColor = imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255));
                imagefill($img, 0, 0, $bgColor);
                $textColor = imagecolorallocate($img, 255, 255, 255);
                $text = $randomName . " #" . $i;
                imagestring($img, 5, 350, 390, $text, $textColor);
                imagejpeg($img, $imgPath, 90);
                imagedestroy($img);
            }

            $multipleProductArray = array();
            for ($j = 1; $j <= 4; $j++) {
                $additionalImage = $demoImageBase . 'product-' . $i . '-' . $j . '.jpg';
                $additionalImgPath = public_path($additionalImage);

                if (!file_exists($additionalImgPath)) {
                    $img = imagecreatetruecolor(800, 800);
                    $bgColor = imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255));
                    imagefill($img, 0, 0, $bgColor);
                    $textColor = imagecolorallocate($img, 255, 255, 255);
                    $text = "Image " . $j;
                    imagestring($img, 5, 370, 390, $text, $textColor);
                    imagejpeg($img, $additionalImgPath, 90);
                    imagedestroy($img);
                }

                array_push($multipleProductArray, $additionalImage);
            }

            $price = rand(100, 999);

            $id = Product::insertGetId([
                'name' => $title,
                'slug' => Str::slug($title) . "-" . time() . Str::random(5),
                'product_type' => $productType == 1 ? 'Fashion' : 'Tech',
                'short_description' => $faker->paragraph(),
                'description' => $faker->paragraph(),
                'tags' => $faker->word() . ',' . $faker->word(),
                'video_url' => 'https://www.youtube.com/watch?v=' . Str::random(11),
                'category_id' => isset($categoryId[0]) ? $categoryId[0]->id : null,
                'subcategory_id' => isset($subcategoryId[0]) ? $subcategoryId[0]->id : null,
                'childcategory_id' => isset($childCategoryId[0]) ? $childCategoryId[0]->id : null,
                'brand_id' => isset($brandId[0]) ? $brandId[0]->id : null,
                'model_id' => isset($modelId[0]) ? $modelId[0]->id : null,
                'unit_id' => isset($unitId[0]) ? $unitId[0]->id : null,
                'warrenty_id' => isset($warrentyId[0]) ? $warrentyId[0]->id : null,
                'flag_id' => isset($flagId[0]) ? $flagId[0]->id : null,
                'image' => $mainImage,
                'multiple_images' => json_encode($multipleProductArray),
                'price' => $price,
                'discount_price' => $price - rand(10, 50),
                'stock' => rand(10, 100),
                'code' => 'DEMO-' . Str::random(6),
                'meta_title' => $title,
                'meta_keywords' => $faker->word() . ',' . $faker->word(),
                'meta_description' => $faker->sentence(),
                'specification' => $faker->paragraph(),
                'status' => 1,
                'is_demo' => 1,
                'created_at' => Carbon::now()
            ]);

            if ($i % 2 != 0) {
                for ($j = 1; $j <= 4; $j++) {
                    $galleryImage = $demoImageBase . 'gallery-' . $i . '-' . $j . '.jpg';
                    $galleryImgPath = public_path($galleryImage);

                    if (!file_exists($galleryImgPath)) {
                        $img = imagecreatetruecolor(800, 800);
                        $bgColor = imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255));
                        imagefill($img, 0, 0, $bgColor);
                        $textColor = imagecolorallocate($img, 255, 255, 255);
                        $text = "Gallery " . $j;
                        imagestring($img, 5, 350, 390, $text, $textColor);
                        imagejpeg($img, $galleryImgPath, 90);
                        imagedestroy($img);
                    }

                    ProductImage::insert([
                        'product_id' => $id,
                        'image' => $galleryImage,
                        'created_at' => Carbon::now()
                    ]);
                }
            }

            if ($i % 2 == 0) {
                for ($k = 1; $k <= 3; $k++) {
                    $variantImage = $demoImageBase . 'variant-' . $i . '-' . $k . '.jpg';
                    $variantImgPath = public_path($variantImage);

                    if (!file_exists($variantImgPath)) {
                        $img = imagecreatetruecolor(800, 800);
                        $bgColor = imagecolorallocate($img, rand(100, 255), rand(100, 255), rand(100, 255));
                        imagefill($img, 0, 0, $bgColor);
                        $textColor = imagecolorallocate($img, 255, 255, 255);
                        $text = "Variant " . $k;
                        imagestring($img, 5, 350, 390, $text, $textColor);
                        imagejpeg($img, $variantImgPath, 90);
                        imagedestroy($img);
                    }

                    ProductVariant::insert([
                        'product_id' => $id,
                        'color_id' => isset($colorId[0]) ? $colorId[0]->id : null,
                        'size_id' => isset($sizeId[0]) ? $sizeId[0]->id : null,
                        'region_id' => isset($regionId[0]) ? $regionId[0]->id : null,
                        'sim_id' => isset($simId[0]) ? $simId[0]->id : null,
                        'storage_type_id' => isset($storageTypeId[0]) ? $storageTypeId[0]->id : null,
                        'device_condition_id' => isset($conditionID[0]) ? $conditionID[0]->id : null,
                        'warrenty_id' => isset($warrentyID[0]) ? $warrentyID[0]->id : null,
                        'price' => rand(100, 999),
                        'discounted_price' => rand(50, 99),
                        'stock' => rand(10, 100),
                        'image' => $variantImage,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        return [
            'status' => 'success',
            'message' => 'Demo Products Inserted'
        ];
    }
}
