<?php

namespace App\Console\Commands;

use App\Models\Blogs;
use App\Models\Products;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $sitemap = Sitemap::create();

        // Add dynamic URLs (e.g., products)
        $products = Products::all();
        foreach ($products as $product) {
            $sitemap->add(Url::create(route('catalogDetail', $product->id))
                ->setLastModificationDate($product->updated_at)
                ->setChangeFrequency('weekly')
                ->setPriority(0.8));
        }

        // Add other dynamic URLs (e.g., blogs)
        $blogs = Blogs::all();
        foreach ($blogs as $blog) {
            $sitemap->add(Url::create(route('blogSingle', $blog->id))
                ->setLastModificationDate($blog->updated_at)
                ->setChangeFrequency('weekly')
                ->setPriority(0.6));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        
    }
}
