<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Avatar;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Avatar::create([
            'avatar_image' => 'avatar_images/image1.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image2.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image3.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image4.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image5.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image6.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image7.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image8.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image9.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image10.jpeg'
        ]);

        Avatar::create([
            'avatar_image' => 'avatar_images/image11.jpeg'
        ]);
    }
}
