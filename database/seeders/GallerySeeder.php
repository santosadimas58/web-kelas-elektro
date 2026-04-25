<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Seed gallery items for demo content.
     */
    public function run(): void
    {
        $classroom = config('classroom');

        foreach ($classroom['gallery'] as $index => $item) {
            GalleryItem::query()->updateOrCreate(
                ['title' => $item['title']],
                [
                    'description' => $item['description'],
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
