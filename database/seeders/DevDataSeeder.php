<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Blog;
use App\Models\BlogBlogCategories;
use App\Models\BlogBlogImages;
use App\Models\BlogImages;
use App\Models\Comments;
use App\Models\Contacts;
use App\Models\MpesaPayment;
use App\Models\Order_Items;
use App\Models\Orders;
use App\Models\Prices;
use App\Models\ProductCategories;
use App\Models\ProductImages;
use App\Models\ProductMaterials;
use App\Models\ProductColors;
use App\Models\ProductSizes;
use App\Models\ProductProductCategories;
use App\Models\ProductProductColors;
use App\Models\ProductProductMaterials;
use App\Models\ProductProductSizes;
use App\Models\ProductProductTypes;
use App\Models\Products;
use App\Models\ProductTypes;
use App\Models\PromoCodes;
use App\Models\PromoCodeUsage;
use App\Models\Ratings;
use App\Models\Review;
use App\Models\ReviewToken;
use App\Models\User;
use App\Models\VisitorData;
use App\Models\VisitorJourney;
use App\Models\WishList;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DevDataSeeder extends Seeder
{
    private array $adminPassword = ['devpw-2026'];
    private string $userPassword = 'password';

    public function run(): void
    {
        $this->createUsersAndAdmins();
        if (Products::count() >= 12) {
            $this->command->info('DevDataSeeder: products already present, skipping product creation.');
        } else {
            $this->createProducts();
        }
        if (Blog::count() >= 6) {
            $this->command->info('DevDataSeeder: blogs already present, skipping.');
        } else {
            $this->createBlogs();
        }
        $this->createPromoCodes();
        if (Orders::count() === 0) {
            $this->createOrders();
        }
        if (Review::count() === 0) {
            $this->createEngagement();
        }
        if (VisitorJourney::count() < 200) {
            $this->createVisitorAnalytics();
        }
        $this->createMpesaPayments();

        $this->command->info('DevDataSeeder: done. Admin password: devpw-2026, user password: password');
    }

    private function createUsersAndAdmins(): void
    {
        $users = [
            ['first_name' => 'Grace', 'last_name' => 'Wanjiru', 'gender' => 'Female', 'phone' => '0711000001', 'town' => 'Nairobi', 'location' => 'Kilimani'],
            ['first_name' => 'Brian', 'last_name' => 'Otieno', 'gender' => 'Male', 'phone' => '0711000002', 'town' => 'Mombasa', 'location' => 'Nyali'],
            ['first_name' => 'Wanjiru', 'last_name' => 'Kamau', 'gender' => 'Female', 'phone' => '0711000003', 'town' => 'Kisumu', 'location' => 'Milimani'],
            ['first_name' => 'Peter', 'last_name' => 'Mwangi', 'gender' => 'Male', 'phone' => '0711000004', 'town' => 'Nakuru', 'location' => 'Milimani'],
            ['first_name' => 'Faith', 'last_name' => 'Chebet', 'gender' => 'Female', 'phone' => '0711000005', 'town' => 'Eldoret', 'location' => 'Kimumu'],
            ['first_name' => 'Samuel', 'last_name' => 'Njoroge', 'gender' => 'Male', 'phone' => '0711000006', 'town' => 'Thika', 'location' => 'Town Centre'],
            ['first_name' => 'Lilian', 'last_name' => 'Achieng', 'gender' => 'Female', 'phone' => '0711000007', 'town' => 'Nyeri', 'location' => 'Kimathi'],
            ['first_name' => 'David', 'last_name' => 'Kiplagat', 'gender' => 'Male', 'phone' => '0711000008', 'town' => 'Kericho', 'location' => 'Town'],
            ['first_name' => 'Winnie', 'last_name' => 'Mutiso', 'gender' => 'Female', 'phone' => '0711000009', 'town' => 'Machakos', 'location' => 'Machakos Town'],
            ['first_name' => 'James', 'last_name' => 'Karanja', 'gender' => 'Male', 'phone' => '0711000010', 'town' => 'Nairobi', 'location' => 'Westlands'],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => Str::slug($user['first_name'] . '.' . $user['last_name']) . '@example.test'],
                [
                    'uuid' => (string) Str::uuid(),
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'gender' => $user['gender'],
                    'phone' => $user['phone'],
                    'town' => $user['town'],
                    'location' => $user['location'],
                    'password' => Hash::make($this->userPassword),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Unverified user, to test the email-verification flow
        User::firstOrCreate(
            ['email' => 'unverified@example.test'],
            ['uuid' => (string) Str::uuid(), 'first_name' => 'Upendo', 'last_name' => 'Otieno', 'gender' => 'Male', 'phone' => '0711000011', 'town' => 'Nairobi', 'location' => 'Rongai', 'password' => Hash::make($this->userPassword), 'email_verified_at' => null]
        );

        $adminPassword = Hash::make($this->adminPassword[0]);

        $devAdmin = Admin::firstOrCreate(['email' => 'devadmin@example.test'], ['name' => 'Dev Admin', 'username' => 'devadmin', 'uuid' => (string) Str::uuid(), 'password' => $adminPassword, 'is_admin' => 1, 'is_staff' => 0]);
        $devStaff = Admin::firstOrCreate(['email' => 'devstaff@example.test'], ['name' => 'Dev Staff', 'username' => 'devstaff', 'uuid' => (string) Str::uuid(), 'password' => $adminPassword, 'is_admin' => 1, 'is_staff' => 1]);
        $devSupport = Admin::firstOrCreate(['email' => 'devsupport@example.test'], ['name' => 'Dev Support', 'username' => 'devsupport', 'uuid' => (string) Str::uuid(), 'password' => $adminPassword, 'is_admin' => 1, 'is_staff' => 1]);

        $devAdmin->syncRoles(['SuperAdmin']);
        $devStaff->syncRoles(['Staff']);
        $devSupport->syncRoles(['Support']);
    }

    private function createProducts(): void
    {
        $productImages = ['blue-fire-2023-02-02-63dc23a9396d3.jpg', 'good-leader-2023-02-02-63dc24fadf6dc.jpg', 'legends-2023-02-02-63dc14ca434a3.jpg', 'never-give-up-praying-2023-02-02-63dc1db9bfd5d.jpg', 'relationship-goals-2023-02-02-63dc21f933e32.jpg', 'you-matter-2023-02-02-63dc20b492e36.jpg', 'bad-choices-make-good-stories-2023-02-10-63e652057504f.jpg'];

        Storage::disk('public')->makeDirectory('img/products');
        foreach ($productImages as $index => $file) {
            $source = public_path('assets/img/products/' . $file);
            if (file_exists($source)) {
                copy($source, storage_path('app/public/img/products/dev-' . ($index + 1) . '.jpg'));
            }
        }

        $types = ProductTypes::orderBy('id')->get();
        $categories = ProductCategories::inRandomOrder()->get();
        $colors = ProductColors::all();
        $sizes = ProductSizes::all();
        $materials = ProductMaterials::all();
        $imagePool = ['dev-1.jpg', 'dev-2.jpg', 'dev-3.jpg', 'dev-4.jpg', 'dev-5.jpg', 'dev-6.jpg', 'dev-7.jpg'];

        $products = [
            ['name' => 'Classic Round Neck T-Shirt', 'base' => 1],
            ['name' => 'V-Neck Essential Tee', 'base' => 2],
            ['name' => 'Pocketed Sweatshirt', 'base' => 3],
            ['name' => 'Everyday Sweatshirt', 'base' => 4],
            ['name' => 'Pocketed Sweatpants', 'base' => 5],
            ['name' => 'Everyday Sweatpants', 'base' => 6],
            ['name' => 'Pocketed Hoodie', 'base' => 7],
            ['name' => 'Classic Hoodie', 'base' => 8],
            ['name' => 'Zipped Hoodie', 'base' => 9],
            ['name' => 'Signature Cap', 'base' => 10],
            ['name' => 'Polo Tee', 'base' => 11],
            ['name' => 'Kids Round Neck Tee', 'base' => 1],
        ];

        foreach ($products as $index => $row) {
            $type = $types->firstWhere('id', $row['base']) ?? $types->first();
            $price = Prices::where('type_id', $type->id)->value('price') ?? 1000;
            $color = $colors->random();
            $size = $sizes->random();
            $material = $materials->random();
            $category = $categories[$index % $categories->count()];

            $product = Products::create([
                'categories_id' => $category->id,
                'colors_id' => $color->id,
                'sizes_id' => $size->id,
                'materials_id' => $material->id,
                'type_id' => $type->id,
                'name' => $row['name'],
                'description' => 'DEV DATA — ' . $row['name'] . ': premium combed cotton, pre-shrunk, printed to order at PrintShopEld. Available in multiple colors and sizes.',
                'price' => $price,
                'meta_title' => $row['name'] . ' | PrintShopEld',
                'meta_description' => 'Buy ' . $row['name'] . ' online in Kenya — quality print, fast delivery, M-Pesa checkout.',
                'meta_keywords' => strtolower(str_replace(' ', ',', $row['name'])) . ',kenya,printshopeld',
                'meta_image' => 'assets/img/products/' . $imagePool[$index % count($imagePool)],
                'whatsapp' => 1,
                'telegram' => 0,
                'website' => 1,
                'promotion' => $index % 4 === 0 ? 1 : 0,
            ]);

            ProductProductCategories::create(['products_id' => $product->id, 'product_categories_id' => $category->id]);
            ProductProductColors::create(['products_id' => $product->id, 'product_colors_id' => $color->id]);
            ProductProductMaterials::create(['products_id' => $product->id, 'product_materials_id' => $material->id]);
            ProductProductTypes::create(['products_id' => $product->id, 'product_types_id' => $type->id]);
            ProductProductSizes::create(['products_id' => $product->id, 'product_sizes_id' => $size->id]);

            $image = ProductImages::create(['thumbnail' => $imagePool[$index % count($imagePool)], 'full' => $imagePool[$index % count($imagePool)], 'products_id' => $product->id]);
            DB::table('product_product_images')->insert(['products_id' => $product->id, 'product_images_id' => $image->id]);

            if ($index % 3 === 0 && count($sizes) > 1) {
                $size2 = $sizes->where('id', '!=', $size->id)->random();
                DB::table('product_product_sizes')->insertOrIgnore(['products_id' => $product->id, 'product_sizes_id' => $size2->id]);
            }
        }
    }

    private function createBlogs(): void
    {
        $blogImages = ['Embroidery-Services-2-1.jpg', 'how-to-make-embroidery.jpg', 'istockphoto-1185540944-612x612.jpg', 'istockphoto-1305793711-612x612.jpg', 'post-1.jpg', 'top_custom_embroidery_tips_for_your_embroidery_business.png'];
        Storage::disk('public')->makeDirectory('img/blogs');
        $sourceBlogsDir = public_path('assets/img/blogs');
        foreach (glob($sourceBlogsDir . '/*.{jpg,png,jpeg}', GLOB_BRACE) ?: [] as $file) {
            copy($file, storage_path('app/public/img/blogs/' . basename($file)));
        }

        $categories = DB::table('blog_categories')->get();
        $posts = [
            'Why embroidery beats print for uniforms',
            'How to choose the right t-shirt fabric',
            'Caring for your printed merch',
            '5 ways to brand your events with caps',
            'Our favourite embroidery finishes this season',
            'Bulk ordering? Here is how to save',
        ];

        foreach ($posts as $index => $title) {
            $category = $categories[$index % max(1, $categories->count())];
            $blog = Blog::create([
                'blog_categories_id' => $category->id ?? null,
                'title' => $title,
                'sub_title' => 'From the PrintShopEld studio',
                'body' => "<p>Placeholder body for \"{$title}\".\n\nDEV DATA — replace with the real article. Topics covered include fabric choice, print durability, care instructions and local supplier tips for Kenyan clients ordering in bulk.</p><p>Have questions? Reach us on WhatsApp.</p>",
                'meta_title' => $title . ' | PrintShopEld Blog',
                'meta_description' => 'Read: ' . $title,
                'meta_keywords' => 'print, embroidery, merch, kenya',
                'meta_image' => 'img/blogs/' . basename($blogImages[$index % count($blogImages)]),
            ]);

            if ($category) {
                BlogBlogCategories::create(['blogs_id' => $blog->id, 'blog_categories_id' => $category->id]);
            }

            $image = BlogImages::create(['thumbnail' => basename($blogImages[$index % count($blogImages)]), 'full' => basename($blogImages[$index % count($blogImages)]), 'blogs_id' => $blog->id]);
            BlogBlogImages::create(['blogs_id' => $blog->id, 'blog_images_id' => $image->id]);
        }
    }

    private function createPromoCodes(): void
    {
        PromoCodes::firstOrCreate(['code' => 'SAVE10'], ['discount_percentage' => 10, 'max_uses' => 100, 'times_used' => 3, 'user_limit' => 2, 'expires_at' => now()->addDays(30)]);
        PromoCodes::firstOrCreate(['code' => 'WELCOME15'], ['discount_percentage' => 15, 'max_uses' => 20, 'times_used' => 18, 'user_limit' => 1, 'expires_at' => now()->addDays(7)]);
        PromoCodes::firstOrCreate(['code' => 'FLASH25'], ['discount_percentage' => 25, 'max_uses' => 5, 'times_used' => 5, 'user_limit' => 1, 'expires_at' => now()->addDays(3)]);
        PromoCodes::firstOrCreate(['code' => 'EXPIRED30'], ['discount_percentage' => 30, 'max_uses' => 50, 'times_used' => 12, 'user_limit' => 1, 'expires_at' => now()->subDays(10)]);

        $save10 = PromoCodes::where('code', 'SAVE10')->first();
        $users = User::whereNotNull('email_verified_at')->limit(3)->get();
        foreach ($users as $user) {
            PromoCodeUsage::firstOrCreate(['promo_code_id' => $save10->id, 'user_id' => $user->id]);
        }
    }

    private function createOrders(): void
    {
        $users = User::whereNotNull('email_verified_at')->get();
        $products = Products::with('ProductImage')->get();
        $promo = PromoCodes::where('code', 'SAVE10')->first();
        $index = 0;

        foreach ($users->take(8) as $user) {
            if ($index >= $products->count()) {
                break;
            }

            $isComplete = $index % 3 !== 2;
            $createdAt = $index < 3 ? now()->subDays(10 + $index) : now()->subDays($index);

            $order = new Orders();
            $order->user_id = $user->id;
            $order->promo_code_id = $index % 4 === 0 ? $promo->id : null;
            $order->reference = $user->first_name;
            $order->tracking_No = 'DEV-' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT);
            $order->price = 0;
            $order->complete = $isComplete ? 1 : 0;
            $order->created_at = $createdAt;
            $order->updated_at = $createdAt;
            $order->save();

            $total = 0;
            $lineProducts = $products->slice($index, 2);
            foreach ($lineProducts as $product) {
                $price = (float) $product->price;
                $qty = 1 + ($index % 2);
                $item = new Order_Items();
                $item->order_id = $order->id;
                $item->product_id = $product->id;
                $item->color_id = $product->colors_id;
                $item->size_id = $product->sizes_id;
                $item->price = $price;
                $item->quantity = $qty;
                $item->created_at = $createdAt;
                $item->updated_at = $createdAt;
                $item->save();
                $total += $price * $qty;
            }

            $order->price = $total;
            $order->save();
            $index++;
        }
    }

    private function createEngagement(): void
    {
        $users = User::whereNotNull('email_verified_at')->get();
        $products = Products::all();
        $blogs = Blog::all();

        foreach ($products as $product) {
            foreach ($users->take(4) as $offset => $user) {
                Ratings::firstOrCreate(
                    ['products_id' => $product->id, 'user_id' => $user->id],
                    ['rating' => 3 + (($offset + $product->id) % 3), 'created_at' => now()->subDays($offset)]
                );
            }
        }

        foreach ($blogs as $blog) {
            foreach ($users->take(2) as $offset => $user) {
                Comments::firstOrCreate(
                    ['blog_id' => $blog->id, 'user_id' => $user->id],
                    ['content' => 'DEV DATA — great write-up, thanks for sharing!']
                );
            }
        }

        foreach ($users->take(6) as $user) {
            $wished = $products->random(2);
            foreach ($wished as $product) {
                WishList::firstOrCreate(['user_id' => $user->id, 'product_id' => $product->id]);
            }
        }

        $contacts = [
            ['name' => 'Mary Njeri', 'email' => 'mary@example.test', 'subject' => 'Bulk order enquiry', 'message' => 'DEV DATA — We need 200 branded hoodies for a company event; please send a quote.'],
            ['name' => 'Tom Oloo', 'email' => 'tom@example.test', 'subject' => 'Delivery question', 'message' => 'DEV DATA — How long does delivery to Mombasa take?'],
            ['name' => 'Lucy Wambui', 'email' => 'lucy@example.test', 'subject' => 'Sizing help', 'message' => 'DEV DATA — Please share the size guide for the hoodie.'],
            ['name' => 'Kevin Mutua', 'email' => 'kevin@example.test', 'subject' => 'Design service', 'message' => 'DEV DATA — Can you help design our logo tee?'],
            ['name' => 'Ann Atieno', 'email' => 'ann@example.test', 'subject' => 'Refund request', 'message' => 'DEV DATA — My order arrived with the wrong size; requesting exchange.'],
        ];

        foreach ($contacts as $offset => $contact) {
            Contacts::firstOrCreate(
                ['email' => $contact['email'], 'subject' => $contact['subject']],
                ['name' => $contact['name'], 'message' => $contact['message']]
            );
        }

        $reviewUsers = User::whereNotNull('email_verified_at')->take(3)->get();
        foreach ($reviewUsers as $index => $user) {
            $token = (string) Str::uuid();
            ReviewToken::create(['token' => $token, 'url' => url('/review/create?token=' . $token . '&name=' . urlencode($user->first_name)), 'user_id' => $user->id, 'is_used' => $index === 0, 'expires_at' => now()->addMonths(6)]);
            Review::create(['token' => $token, 'user_id' => $user->id, 'review' => 'DEV DATA — Fantastic quality and fast delivery. Will order again.', 'rating' => 5, 'guest_name' => $user->first_name . ' ' . $user->last_name]);
        }
    }

    private function createVisitorAnalytics(): void
    {
        $paths = ['/', '/catalog', '/catalog/classic-tee', '/blog', '/cart', '/checkout'];
        $mediums = ['organic', 'referral', 'paid', 'social', 'direct'];

        for ($day = 59; $day >= 0; $day--) {
            $date = now()->subDays($day);
            $visitorsToday = rand(4, 28);

            for ($v = 0; $v < $visitorsToday; $v++) {
                $medium = $mediums[array_rand($mediums)];
                $data = VisitorData::create([
                    'ip_address' => '154.160.' . rand(1, 254) . '.' . rand(1, 254),
                    'country' => 'Kenya',
                    'region' => ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Uasin Gishu'][rand(0, 4)],
                    'city' => ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret'][rand(0, 4)],
                    'referrer' => $medium === 'organic' ? 'https://www.google.com/' : ($medium === 'referral' ? 'https://www.instagram.com/' : 'https://t.co/dev'),
                    'user_agent' => 'Mozilla/5.0 (Linux; Android 13) Chrome/124.0 Mobile',
                    'utm_source' => $medium === 'paid' ? 'meta' : null,
                    'utm_medium' => $medium,
                    'utm_campaign' => $medium === 'paid' ? 'dev-campaign' : null,
                ]);
                DB::table('visitor_data')->where('id', $data->id)->update(['created_at' => $date->copy()->subMinutes(rand(0, 1439)), 'updated_at' => $date]);

                $pageVisits = rand(1, 5);
                for ($p = 0; $p < $pageVisits; $p++) {
                    DB::table('visitor_journeys')->insert([
                        'visitor_data_id' => $data->id,
                        'event_type' => 'page_visit',
                        'page_url' => $paths[array_rand($paths)],
                        'created_at' => $date->copy()->subMinutes(rand(0, 1439)),
                        'updated_at' => $date,
                    ]);
                }

                if (rand(1, 100) <= 12) {
                    DB::table('visitor_journeys')->insert([
                        'visitor_data_id' => $data->id,
                        'event_type' => 'button_click',
                        'page_url' => '/checkout',
                        'button_clicked' => 'checkout-button',
                        'created_at' => $date->copy()->subMinutes(rand(0, 1439)),
                        'updated_at' => $date,
                    ]);
                }
            }
        }
    }

    private function createMpesaPayments(): void
    {
        $orders = Orders::where('complete', 1)->take(3)->get();

        foreach ($orders as $order) {
            MpesaPayment::firstOrCreate(
                ['order_id' => $order->id],
                ['merchant_request_id' => 'DEV-' . Str::upper(Str::random(8)), 'checkout_request_id' => 'DEV-' . Str::upper(Str::random(12)), 'result_code' => 0, 'result_desc' => 'The service request is processed successfully.', 'amount' => $order->price, 'mpesa_receipt_number' => 'DEV' . Str::upper(Str::random(8)), 'transaction_date' => now()->subDays(2), 'phone_number' => '0711000001', 'status' => 'Success']
            );
        }
    }
}
