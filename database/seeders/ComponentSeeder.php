<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Component;
use Illuminate\Support\Str;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $components = [
            [
                'name' => 'Hero Banner',
                'slug' => 'hero',
                'default_schema' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => [
                                [
                                    'key' => 'title',
                                    'type' => 'text',
                                    'label' => 'Judul Utama',
                                    'default_value' => 'Headline Menarik Disini',
                                    'placeholder' => 'Masukkan judul utama',
                                    'required' => true
                                ],
                                [
                                    'key' => 'subtitle',
                                    'type' => 'textarea',
                                    'label' => 'Deskripsi Singkat',
                                    'default_value' => 'Deskripsikan produk Anda disini',
                                    'placeholder' => 'Masukkan deskripsi singkat',
                                    'required' => false
                                ],
                                [
                                    'key' => 'bg_image',
                                    'type' => 'image',
                                    'label' => 'Gambar Background',
                                    'default_value' => null,
                                    'placeholder' => 'Pilih gambar background',
                                    'required' => false
                                ],
                                [
                                    'key' => 'cta_text',
                                    'type' => 'text',
                                    'label' => 'Teks Tombol',
                                    'default_value' => 'Mulai Sekarang',
                                    'placeholder' => 'Masukkan teks tombol',
                                    'required' => true
                                ],
                                [
                                    'key' => 'cta_link',
                                    'type' => 'url',
                                    'label' => 'Link Tombol',
                                    'default_value' => '#',
                                    'placeholder' => 'https://wa.me/628123456789',
                                    'required' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Features',
                'slug' => 'features',
                'default_schema' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => [
                                [
                                    'key' => 'section_title',
                                    'type' => 'text',
                                    'label' => 'Judul Section',
                                    'default_value' => 'Keunggulan Kami',
                                    'placeholder' => 'Masukkan judul section',
                                    'required' => true
                                ],
                                [
                                    'key' => 'items',
                                    'type' => 'repeater',
                                    'label' => 'Daftar Fitur',
                                    'item_label' => 'Fitur',
                                    'schema' => [
                                        [
                                            'key' => 'title',
                                            'type' => 'text',
                                            'label' => 'Judul Fitur',
                                            'default_value' => 'Fitur Baru',
                                            'placeholder' => 'Masukkan judul fitur',
                                            'required' => true
                                        ],
                                        [
                                            'key' => 'description',
                                            'type' => 'textarea',
                                            'label' => 'Penjelasan',
                                            'default_value' => 'Jelaskan keunggulan fitur ini.',
                                            'placeholder' => 'Masukkan penjelasan fitur',
                                            'required' => true
                                        ],
                                        [
                                            'key' => 'icon',
                                            'type' => 'image',
                                            'label' => 'Ikon',
                                            'default_value' => null,
                                            'placeholder' => 'Pilih ikon',
                                            'required' => false
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'About',
                'slug' => 'about',
                'default_schema' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => [
                                [
                                    'key' => 'title',
                                    'type' => 'text',
                                    'label' => 'Judul Section',
                                    'default_value' => 'Tentang Kami',
                                    'placeholder' => 'Masukkan judul section',
                                    'required' => true
                                ],
                                [
                                    'key' => 'description',
                                    'type' => 'textarea',
                                    'label' => 'Deskripsi Bisnis',
                                    'default_value' => 'Ceritakan bisnis Anda',
                                    'placeholder' => 'Masukkan deskripsi bisnis',
                                    'required' => true
                                ],
                                [
                                    'key' => 'image',
                                    'type' => 'image',
                                    'label' => 'Foto Ilustrasi',
                                    'default_value' => null,
                                    'placeholder' => 'Pilih foto ilustrasi',
                                    'required' => false
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Contact',
                'slug' => 'contact',
                'default_schema' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => [
                                [
                                    'key' => 'phone',
                                    'type' => 'text',
                                    'label' => 'Nomor Telepon',
                                    'default_value' => '62',
                                    'placeholder' => '628123456789',
                                    'required' => true
                                ],
                                [
                                    'key' => 'email',
                                    'type' => 'email',
                                    'label' => 'Alamat Email',
                                    'default_value' => 'info@example.com',
                                    'placeholder' => 'info@example.com',
                                    'required' => true
                                ],
                                [
                                    'key' => 'address',
                                    'type' => 'textarea',
                                    'label' => 'Alamat Lengkap',
                                    'default_value' => 'Jl',
                                    'placeholder' => 'Masukkan alamat lengkap',
                                    'required' => true
                                ],
                                [
                                    'key' => 'map_embed',
                                    'type' => 'textarea',
                                    'label' => 'Embed Google Maps',
                                    'default_value' => '',
                                    'placeholder' => '<iframe src="..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                                    'required' => false
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Testimonials',
                'slug' => 'testimonials',
                'default_schema' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => [
                                [
                                    'key' => 'section_title',
                                    'type' => 'text',
                                    'label' => 'Judul Section',
                                    'default_value' => 'Testimoni Pelanggan',
                                    'placeholder' => 'Masukkan judul section',
                                    'required' => true
                                ],
                                [
                                    'key' => 'items',
                                    'type' => 'repeater',
                                    'label' => 'Daftar Testimoni',
                                    'item_label' => 'Testimoni',
                                    'schema' => [
                                        [
                                            'key' => 'name',
                                            'type' => 'text',
                                            'label' => 'Nama Pelanggan',
                                            'default_value' => 'John Doe',
                                            'placeholder' => 'Masukkan nama pelanggan',
                                            'required' => true
                                        ],
                                        [
                                            'key' => 'role',
                                            'type' => 'text',
                                            'label' => 'Jabatan/Peran',
                                            'default_value' => 'CEO',
                                            'placeholder' => 'Masukkan jabatan atau peran',
                                            'required' => false
                                        ],
                                        [
                                            'key' => 'testimonial',
                                            'type' => 'textarea',
                                            'label' => 'Isi Testimoni',
                                            'default_value' => 'Produk ini sangat membantu bisnis saya.',
                                            'placeholder' => 'Masukkan isi testimoni',
                                            'required' => true
                                        ],
                                        [
                                            'key' => 'rating',
                                            'type' => 'select',
                                            'label' => 'Rating',
                                            'default_value' => '5',
                                            'options' => [
                                                '1' => '1 Bintang',
                                                '2' => '2 Bintang',
                                                '3' => '3 Bintang',
                                                '4' => '4 Bintang',
                                                '5' => '5 Bintang'
                                            ],
                                            'required' => true
                                        ],
                                        [
                                            'key' => 'photo',
                                            'type' => 'image',
                                            'label' => 'Foto Pelanggan',
                                            'default_value' => null,
                                            'placeholder' => 'Pilih foto pelanggan',
                                            'required' => false
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'default_schema' => [
                    'tabs' => [
                        [
                            'label' => 'Content',
                            'fields' => [
                                [
                                    'key' => 'section_title',
                                    'type' => 'text',
                                    'label' => 'Judul Section',
                                    'default_value' => 'Layanan Kami',
                                    'placeholder' => 'Masukkan judul section',
                                    'required' => true
                                ],
                                [
                                    'key' => 'items',
                                    'type' => 'repeater',
                                    'label' => 'Daftar Layanan',
                                    'item_label' => 'Layanan',
                                    'schema' => [
                                        [
                                            'key' => 'title',
                                            'type' => 'text',
                                            'label' => 'Judul Layanan',
                                            'default_value' => 'Konsultasi Bisnis',
                                            'placeholder' => 'Masukkan judul layanan',
                                            'required' => true
                                        ],
                                        [
                                            'key' => 'description',
                                            'type' => 'textarea',
                                            'label' => 'Deskripsi Layanan',
                                            'default_value' => 'Kami menyediakan konsultasi bisnis terbaik.',
                                            'placeholder' => 'Masukkan deskripsi layanan',
                                            'required' => true
                                        ],
                                        [
                                            'key' => 'price',
                                            'type' => 'text',
                                            'label' => 'Harga',
                                            'default_value' => 'Rp 500.000',
                                            'placeholder' => 'Masukkan harga',
                                            'required' => false
                                        ],
                                        [
                                            'key' => 'icon',
                                            'type' => 'image',
                                            'label' => 'Ikon Layanan',
                                            'default_value' => null,
                                            'placeholder' => 'Pilih ikon layanan',
                                            'required' => false
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($components as $component) {
            Component::create([
                'id' => Str::uuid(),
                'name' => $component['name'],
                'slug' => $component['slug'],
                'default_schema' => $component['default_schema']
            ]);
        }
    }
}
