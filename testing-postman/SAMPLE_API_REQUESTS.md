# 📝 Sample API Requests - ComPro CMS

Collection of sample request bodies untuk semua API endpoints.

---

## 1. Authentication

### Register
```json
{
    "name": "Budi Santoso",
    "email": "budi@tokobakso.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Login
```json
{
    "email": "budi@tokobakso.com",
    "password": "password123"
}
```

---

## 2. Pages

### Create Page - Toko Bakso
```json
{
    "title": "Bakso Pak Budi - Bakso Enak Bandung",
    "slug": "bakso-pak-budi",
    "status": "draft",
    "business_profile": {
        "company_name": "Bakso Pak Budi",
        "logo": "https://example.com/logo-bakso.png",
        "phone": "08122334455",
        "email": "info@baksopakbudi.com",
        "address": "Jl. Merdeka No. 45, Bandung",
        "description": "Bakso dengan daging sapi pilihan sejak 1995"
    },
    "metadata": {
        "meta_title": "Bakso Pak Budi - Bakso Enak Sejak 1995",
        "meta_description": "Nikmati bakso daging sapi pilihan dengan kuah gurih. Delivery gratis untuk pemesanan di atas 50rb.",
        "og_image": "https://example.com/bakso-og.jpg"
    }
}
```

### Create Page - Salon Kecantikan
```json
{
    "title": "Salon Cantik Beauty & Spa",
    "slug": "salon-cantik",
    "status": "draft",
    "business_profile": {
        "company_name": "Salon Cantik",
        "logo": "https://example.com/logo-salon.png",
        "phone": "08199887766",
        "email": "booking@saloncantik.com",
        "address": "Jl. Sudirman No. 123, Bandung",
        "description": "Salon dan spa dengan perawatan profesional"
    },
    "metadata": {
        "meta_title": "Salon Cantik - Beauty & Spa Bandung",
        "meta_description": "Perawatan rambut, facial, spa, dan kecantikan profesional. Book appointment sekarang!",
        "og_image": "https://example.com/salon-og.jpg"
    }
}
```

### Update Page
```json
{
    "title": "Bakso Pak Budi - Updated Title",
    "business_profile": {
        "company_name": "Bakso Pak Budi",
        "logo": "https://example.com/logo-bakso-new.png",
        "phone": "08122334455",
        "email": "contact@baksopakbudi.com",
        "address": "Jl. Merdeka No. 45, Bandung, Jawa Barat",
        "description": "Bakso dengan daging sapi pilihan sejak 1995. Kini hadir dengan varian baru!"
    }
}
```

---

## 3. Components

### Hero Section - Bakso
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "title": "Bakso Daging Sapi Pilihan",
        "subtitle": "Sejak 1995 - Rasa yang Tak Terlupakan",
        "background_image": "https://example.com/hero-bakso.jpg",
        "cta_text": "Pesan Sekarang",
        "cta_link": "https://wa.me/628122334455?text=Halo,%20saya%20mau%20pesan%20bakso"
    },
    "order_index": 0
}
```

### Hero Section - Salon
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "title": "Tampil Cantik & Percaya Diri",
        "subtitle": "Perawatan Profesional untuk Kecantikan Anda",
        "background_image": "https://example.com/hero-salon.jpg",
        "cta_text": "Book Appointment",
        "cta_link": "https://wa.me/628199887766"
    },
    "order_index": 0
}
```

### Features - Bakso
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "section_title": "Mengapa Pilih Bakso Pak Budi?",
        "section_subtitle": "Kualitas terjamin dengan bahan pilihan",
        "items": [
            {
                "icon": "check-circle",
                "title": "Daging Sapi Murni",
                "description": "100% daging sapi tanpa campuran bahan lain"
            },
            {
                "icon": "clock",
                "title": "Delivery Cepat",
                "description": "Pesanan diantar dalam 30 menit area Bandung"
            },
            {
                "icon": "heart",
                "title": "Resep Turun Temurun",
                "description": "Menggunakan resep rahasia keluarga sejak 1995"
            },
            {
                "icon": "award",
                "title": "Higienis & Halal",
                "description": "Proses pembuatan higienis dan bersertifikat halal"
            }
        ]
    },
    "order_index": 1
}
```

### Features - Salon
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "section_title": "Layanan Kami",
        "section_subtitle": "Perawatan lengkap untuk kecantikan Anda",
        "items": [
            {
                "icon": "scissors",
                "title": "Hair Treatment",
                "description": "Perawatan rambut dengan produk berkualitas"
            },
            {
                "icon": "sparkles",
                "title": "Facial & Spa",
                "description": "Facial treatment dan spa menenangkan"
            },
            {
                "icon": "brush",
                "title": "Make Up",
                "description": "Make up profesional untuk berbagai acara"
            }
        ]
    },
    "order_index": 1
}
```

### About - Bakso
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "title": "Tentang Bakso Pak Budi",
        "description": "<p>Bakso Pak Budi didirikan pada tahun 1995 oleh Bapak Budi Santoso. Dengan pengalaman lebih dari 25 tahun, kami berkomitmen menyajikan bakso berkualitas dengan daging sapi murni.</p><p>Setiap hari kami memproduksi bakso segar dengan resep turun temurun yang telah terbukti kelezatannya. Kini telah melayani ribuan pelanggan setia di Bandung.</p>",
        "image": "https://example.com/about-bakso.jpg",
        "stats": [
            {
                "number": "25+",
                "label": "Tahun Pengalaman"
            },
            {
                "number": "10K+",
                "label": "Pelanggan Setia"
            },
            {
                "number": "500+",
                "label": "Porsi per Hari"
            }
        ]
    },
    "order_index": 2
}
```

### Services - Bakso
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "section_title": "Menu Kami",
        "section_subtitle": "Berbagai pilihan bakso yang menggugah selera",
        "items": [
            {
                "image": "https://example.com/bakso-reguler.jpg",
                "title": "Bakso Reguler",
                "description": "Bakso klasik dengan daging sapi pilihan",
                "price": "Rp 15.000"
            },
            {
                "image": "https://example.com/bakso-urat.jpg",
                "title": "Bakso Urat",
                "description": "Bakso dengan urat sapi yang kenyal",
                "price": "Rp 20.000"
            },
            {
                "image": "https://example.com/bakso-jumbo.jpg",
                "title": "Bakso Jumbo",
                "description": "Bakso berukuran extra besar, super kenyang!",
                "price": "Rp 25.000"
            },
            {
                "image": "https://example.com/bakso-beranak.jpg",
                "title": "Bakso Beranak",
                "description": "Bakso besar dengan bakso kecil di dalamnya",
                "price": "Rp 30.000"
            }
        ]
    },
    "order_index": 3
}
```

### Services - Salon
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "section_title": "Paket Perawatan",
        "section_subtitle": "Pilih paket yang sesuai kebutuhan Anda",
        "items": [
            {
                "image": "https://example.com/creambath.jpg",
                "title": "Creambath & Hair Spa",
                "description": "Perawatan rambut intensif untuk rambut sehat berkilau",
                "price": "Mulai dari Rp 75.000"
            },
            {
                "image": "https://example.com/facial.jpg",
                "title": "Facial Treatment",
                "description": "Pembersihan wajah mendalam dengan produk premium",
                "price": "Mulai dari Rp 150.000"
            },
            {
                "image": "https://example.com/makeup.jpg",
                "title": "Make Up",
                "description": "Make up untuk wisuda, wedding, atau acara spesial",
                "price": "Mulai dari Rp 200.000"
            }
        ]
    },
    "order_index": 3
}
```

### Testimonials
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "section_title": "Apa Kata Pelanggan Kami",
        "items": [
            {
                "photo": "https://example.com/customer1.jpg",
                "name": "Dewi Kusuma",
                "role": "Ibu Rumah Tangga",
                "quote": "Bakso Pak Budi adalah bakso terenak yang pernah saya coba! Anak-anak saya sangat suka. Delivery juga cepat!",
                "rating": 5
            },
            {
                "photo": "https://example.com/customer2.jpg",
                "name": "Andi Wijaya",
                "role": "Karyawan Swasta",
                "quote": "Sudah langganan sejak 2015. Kualitas selalu konsisten, harga terjangkau. Recommended!",
                "rating": 5
            },
            {
                "photo": "https://example.com/customer3.jpg",
                "name": "Siti Nurhaliza",
                "role": "Mahasiswa",
                "quote": "Baksonya enak banget! Kuahnya gurih dan baksonya padat. Jadi langganan kalau kangen bakso.",
                "rating": 5
            }
        ]
    },
    "order_index": 4
}
```

### Contact - Bakso
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "section_title": "Hubungi Kami",
        "address": "Jl. Merdeka No. 45, Bandung, Jawa Barat 40111",
        "phone": "08122334455",
        "email": "info@baksopakbudi.com",
        "maps_embed": "<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7995678901234!2d107.6191!3d-6.9175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMDMuMCJTIDEwN8KwMzcnMDguOCJF!5e0!3m2!1sen!2sid!4v1234567890\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>",
        "show_contact_form": true
    },
    "order_index": 5
}
```

### Gallery - Bakso
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "section_title": "Galeri Kami",
        "items": [
            {
                "image": "https://example.com/gallery1.jpg",
                "title": "Bakso Reguler",
                "description": "Bakso klasik favorit pelanggan"
            },
            {
                "image": "https://example.com/gallery2.jpg",
                "title": "Proses Pembuatan",
                "description": "Dibuat dengan higienis"
            },
            {
                "image": "https://example.com/gallery3.jpg",
                "title": "Suasana Kedai",
                "description": "Tempat nyaman untuk makan"
            },
            {
                "image": "https://example.com/gallery4.jpg",
                "title": "Bakso Jumbo",
                "description": "Porsi extra besar"
            }
        ]
    },
    "order_index": 6
}
```

### Call to Action
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "title": "Lapar? Pesan Sekarang!",
        "description": "Delivery gratis untuk pesanan di atas Rp 50.000 area Bandung",
        "button_text": "Pesan via WhatsApp",
        "button_link": "https://wa.me/628122334455?text=Halo%20Pak%20Budi%2C%20saya%20mau%20pesan%20bakso",
        "background_color": "#ef4444"
    },
    "order_index": 7
}
```

---

## 4. Update Component Content

### Update Hero Component
```json
{
    "content": {
        "title": "Bakso Pak Budi - The Best in Town",
        "subtitle": "25 Tahun Pengalaman Membuat Bakso Terenak",
        "background_image": "https://example.com/hero-bakso-new.jpg",
        "cta_text": "Order Sekarang",
        "cta_link": "https://wa.me/628122334455?text=Halo%20Pak%20Budi%2C%20saya%20mau%20pesan%20bakso"
    },
    "order_index": 0,
    "is_active": true
}
```

---

## 5. Analytics Tracking

### Track Visitor
```json
{
    "fingerprint": "fp_8a7b9c1d2e3f4g5h",
    "referrer": "https://www.google.com/search?q=bakso+bandung"
}
```

```json
{
    "fingerprint": "fp_unique_browser_123",
    "referrer": "https://www.instagram.com"
}
```

---

## 6. Component Preview

### Hero Component Preview
```json
{
    "title": "Preview Hero Component",
    "subtitle": "This is a preview subtitle",
    "background_image": "https://example.com/preview-bg.jpg",
    "cta_text": "Click Me",
    "cta_link": "#"
}
```

### Features Component Preview
```json
{
    "section_title": "Preview Features",
    "section_subtitle": "Preview subtitle for features",
    "items": [
        {
            "icon": "star",
            "title": "Preview Feature 1",
            "description": "This is a preview description"
        },
        {
            "icon": "heart",
            "title": "Preview Feature 2",
            "description": "Another preview description"
        }
    ]
}
```

---

## 7. Complete Page Example - Coffee Shop

```json
{
    "title": "Kopi Nusantara - Kopi Asli Indonesia",
    "slug": "kopi-nusantara",
    "status": "draft",
    "business_profile": {
        "company_name": "Kopi Nusantara",
        "logo": "https://example.com/logo-kopi.png",
        "phone": "08155667788",
        "email": "hello@kopinusantara.com",
        "address": "Jl. Braga No. 89, Bandung",
        "description": "Specialty coffee dari berbagai daerah di Indonesia"
    },
    "metadata": {
        "meta_title": "Kopi Nusantara - Specialty Coffee Indonesia",
        "meta_description": "Nikmati kopi specialty dari Aceh, Toraja, Papua, dan daerah lainnya. Roasted fresh setiap hari.",
        "og_image": "https://example.com/kopi-og.jpg"
    }
}
```

---

## 📝 Notes

- Replace `https://example.com/*` dengan actual image URLs
- Phone numbers harus format Indonesia (08xxx atau +62xxx)
- Slug harus unique dan URL-friendly (lowercase, no spaces)
- Semua JSON harus valid (check di JSONLint jika error)
- UUID values akan di-generate otomatis oleh system
- `{{component_id}}` akan di-replace dengan actual component ID dari response

---

## 🎯 Testing Tips

1. **Copy-paste** request bodies ini langsung ke Postman
2. **Edit** sesuai business Anda (nama, alamat, dll)
3. **Test** berbagai component combinations
4. **Save** response IDs untuk request berikutnya
5. **Use** environment variables untuk dynamic values

---

**Last Updated:** January 6, 2026
