<?php

namespace App\Console\Commands;

use App\Product;
use Carbon\Carbon;
use App\ProductImage;
use Illuminate\Http\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Facades\Storage;

class ImportProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:product-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import images for products added via CSV files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products           = Product::where('pending_images_download', '!=', '')
        //->where('created_at', '>', Carbon::now()->subHours(1))->get();
        ->where('created_at', '>', Carbon::now()->subDays(1))->get();

        $this->info("found a total of ".count($products)." products...");
        $this->comment('');
        $bar    = $this->output->createProgressBar(count($products));
        $bar->start();


        $this->info("app path = ".app_path());
        $this->info("base path = ".base_path());
        // $this->info("app path = ".app_path());
        // $this->info("app path = ".app_path());
        // $this->info("app path = ".app_path());
        // exit();

        if ($products->count() >= 1) {
            //delete old images
           $featured_images_dir= Storage::disk('baze')->allFiles('front/img/product/featured/');
           $slider_images_dir  = Storage::disk('baze')->allFiles('front/img/product/sliders/');

            // Delete Files
           Storage::disk('baze')->delete($featured_images_dir);
           Storage::disk('baze')->delete($slider_images_dir);
        }

        $counter    = 0;

        foreach ($products as $product)
        {
            // //only allow 25 proucts at a time
             if($counter >= 25 ) continue;
             $counter++;


            //$this->line(json_encode($product));
            $this->comment('');
            $bar->advance();
            $sliders        = [];
            $featured_image = uniqid() .'.'.'png';
            $image_links    = explode(',', $product->pending_images_download );

            $this->info("dumping images");
            $this->line(json_encode($image_links));


            try
            {
                // $context    = stream_context_create(
                //     array(
                //         "http"          => array(
                //             "header"    => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36",
                //             'method'    => "GET",
                //         )
                //     )
                // );
                // Storage::disk('baze')->put( 'front/img/product/featured/' . $featured_image, file_get_contents($this->parse_google_drive(trim($image_links[ 0 ])), false, $context ) );
                // Storage::disk('baze')->put('front/img/product/featured/'.$featured_image, file_get_contents($this->parse_google_drive($image_links[0])));
                // Storage::disk('baze')->put('front/img/product/featured/'.$featured_image, $this->get_curl($this->parse_google_drive($image_links[0])));
                Storage::disk('baze')->put('front/img/product/featured/'.$featured_image, $this->get_curl($this->parse_google_drive($image_links[0])));


                $this->comment("data-before = ".$product->feature_image);
                $product->feature_image = $featured_image;
                $product->save();
                $this->info("data-after = ".$product->feature_image);
                $this->info("downloaded featured image for '$product->title' in assets/front/img/product/featured/$featured_image'");
            }
            catch (\Exception $e)
            {
                $this ->error("ERROR ENCOUNTERED...");
                $this->error($e->getMessage());
            }

            $this->line("data-after = ".$product->feature_image);

            if(isset($image_links[0])) unset($image_links[0]); //prevent using main image in banner too
            $slider_array   = $image_links;
            foreach( $slider_array as $image )
            {
                try
                {
                    // $context    = stream_context_create(
                    //     array(
                    //         "http"          => array(
                    //             "header"    => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                    //         )
                    //     )
                    // );
                    $slider_name            = uniqid() .'.'.'png';
                    // $store_sliders = Storage::disk('baze')->put( 'front/img/product/sliders/' . $slider_name, file_get_contents( $this->parse_google_drive(trim($image)), false, $context ) );
                    $store_sliders = Storage::disk('baze')->put( 'front/img/product/sliders/' . $slider_name, $this->get_curl( $this->parse_google_drive(trim($image)) ) );
                    if($store_sliders)
                    {
                        array_push($sliders, $slider_name);
                        $this->line("downloaded slider image for '$product->title' in 'front/img/product/sliders/$slider_name'");
                    }
                }
                catch ( \Exception $e )
                {
                    $this->error("ERROR ENCOUNTERED (sliders)...");
                    $this->error($e->getMessage());
                 }
            }

            foreach ($product->product_images as $imp)
            {
                $imp->delete();
            }

            foreach ($sliders as $slider)
            {
                $pi             = new ProductImage;
                $pi->product_id = $product->id;
                $pi->image      = trim($slider);
                $pi->save();
            }

            $product->feature_image             = $featured_image;
            $product->pending_images_download   = NULL;
            $product->save();

            // $this->line(json_encode($product));

        }
        $bar->finish();

    }

    public function parse_google_drive($link)
    {
        //parse Url
        $url    = parse_url($link);

        try
        {
            ///parse Url
            $url    = parse_url($link);

            if($url['host'] == "drive.google.com")
            {
                //process google link
                $url_array  = explode("/", $url['path']);
                $file_id    = trim($url_array[3]);

                return "https://drive.google.com/uc?id=$file_id&export=download";
            }
            return $link;
        }catch(\Exception $e){}
        return $link;
    }

    public function get_curl(String $url)
    {
        $ch = curl_init();
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_URL            => 'http://api.local/all'
        ];

        curl_setopt_array($ch, $options);

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}

