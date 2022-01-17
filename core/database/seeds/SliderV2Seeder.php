<?php

use App\Models\SliderV2;
use Illuminate\Database\Seeder;

class SliderV2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $main_sliders   = [
            [
                'id'                    => 1,
                'language_id'           => 169,
                'slider_category'       => 'main',
                'title'                 => "Financial Planning For Life",
                'title_font_size'       => 24,
                'bold_text'             => "Be stronger!",
                'bold_text_font_size'   => 147,
                'bold_text_color'       => null,
                'text'                  => "Trusted to help guide entrepreneurs make better financial decisions.",
                'text_font_size'        => 60,
                'button_text'           => "Learn More",
                'button_text_font_size' => 14,
                'button_url'            => "javascript:;",
                'image'                 => "defaults/v2-m-1.png",
                'side_image'            => null,
                'serial_number'         => 1,
                'another_button_text'           => null,
                'another_button_text_font_size' => null,
                'another_button_url'            => null
            ],
            [
                'id'                    => 2,
                'language_id'           => 169,
                'slider_category'       => 'main',
                'title'                 => "Financial Planning For Life",
                'title_font_size'       => 24,
                'bold_text'             => "Be stronger!",
                'bold_text_font_size'   => 147,
                'bold_text_color'       => null,
                'text'                  => "Trusted to help guide entrepreneurs make better financial decisions.",
                'text_font_size'        => 60,
                'button_text'           => "Learn More",
                'button_text_font_size' => 14,
                'button_url'            => "javascript:;",
                'image'                 => "defaults/v2-m-1.png",
                'side_image'            => null,
                'serial_number'         => 1,
                'another_button_text'           => null,
                'another_button_text_font_size' => null,
                'another_button_url'            => null
            ],
            [
                'id'                    => 3,
                'language_id'           => 169,
                'slider_category'       => 'main',
                'title'                 => "Financial Planning For Life",
                'title_font_size'       => 24,
                'bold_text'             => "Be stronger!",
                'bold_text_font_size'   => 147,
                'bold_text_color'       => null,
                'text'                  => "Trusted to help guide entrepreneurs make better financial decisions.",
                'text_font_size'        => 60,
                'button_text'           => "Learn More",
                'button_text_font_size' => 14,
                'button_url'            => "javascript:;",
                'image'                 => "defaults/v2-m-1.png",
                'side_image'            => null,
                'serial_number'         => 1,
                'another_button_text'           => null,
                'another_button_text_font_size' => null,
                'another_button_url'            => null
            ],
        ];
        $side_sliders   = collect([
            [
                'id'                    => 4,
                'language_id'           => 169,
                'slider_category'       => 'side1',
                'title'                 => "Financial Planning For Life",
                'title_font_size'       => 24,
                'bold_text'             => "Be stronger!",
                'bold_text_font_size'   => 147,
                'bold_text_color'       => null,
                'text'                  => "Trusted to help guide entrepreneurs make better financial decisions.",
                'text_font_size'        => 60,
                'button_text'           => "Learn More",
                'button_text_font_size' => 14,
                'button_url'            => "javascript:;",
                'image'                 => "defaults/v2-s-1.png",
                'side_image'            => null,
                'serial_number'         => 1,
                'another_button_text'           => null,
                'another_button_text_font_size' => null,
                'another_button_url'            => null
            ],
            [
                'id'                    => 5,
                'language_id'           => 169,
                'slider_category'       => 'side2',
                'title'                 => "Financial Planning For Life",
                'title_font_size'       => 24,
                'bold_text'             => "Be stronger!",
                'bold_text_font_size'   => 147,
                'bold_text_color'       => null,
                'text'                  => "Trusted to help guide entrepreneurs make better financial decisions.",
                'text_font_size'        => 60,
                'button_text'           => "Learn More",
                'button_text_font_size' => 14,
                'button_url'            => "javascript:;",
                'image'                 => "defaults/v2-s-2.png",
                'side_image'            => null,
                'serial_number'         => 1,
                'another_button_text'           => null,
                'another_button_text_font_size' => null,
                'another_button_url'            => null
            ],
        ]);

        foreach($main_sliders as $data)
        {
            $banner = SliderV2::firstOrCreate(['id' => $data['id']]);
            $banner->update($data);
            $banner->save();
        }

        foreach($side_sliders as $data)
        {
            $slider = SliderV2::firstOrCreate(['id' => $data['id']]);
            $slider->update($data);
            $slider->save();
        }

    }
}
