<?php

namespace Database\Seeders;

use App\Models\GeneralInfo;
use App\Models\Homepage;
use App\Models\InfoCategory;
use App\Models\Language;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\ToothbrushType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run() {

        $this->call(LanguageSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ToothbrushTypeSeeder::class);
        $this->call(ProductToothbrushTypeSeeder::class);
        $this->call(ToothpasteTypeSeeder::class);
        $this->call(ProductToothpasteTypeSeeder::class);
        $this->call(ColorProductSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(InfoCategorySeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(GeneralInfoSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(HomepageSeeder::class);
        $this->call(FooterSeeder::class);
        $this->call(NewsletterSeeder::class);
        $this->call(TestimonialSeeder::class);

    }
}
