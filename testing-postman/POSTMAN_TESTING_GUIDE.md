# 🧪 Postman Testing Guide - ComPro CMS API

Panduan lengkap untuk testing API backend ComPro CMS menggunakan Postman.

---

## 📥 Import ke Postman

### **1. Import Collection**
1. Buka Postman
2. Click **Import** button (kiri atas)
3. Drag & drop file `ComPro-CMS-API.postman_collection.json` 
4. Click **Import**

### **2. Import Environment**
1. Click **Environments** di sidebar kiri
2. Click **Import**
3. Drag & drop file `ComPro-CMS-Environment.postman_environment.json` 
4. Click **Import**
5. **Activate environment** dengan click pada dropdown dan pilih "ComPro CMS - Local"

---

## 🚀 Quick Start Testing Flow

### **Step 1: Start Laravel Server**
```bash
cd C:\Kuliah\CODING\P79\ComPro5
php artisan serve
```

Server akan running di: `http://127.0.0.1:8000` 

---

### **Step 2: Test Authentication Flow**

#### **2.1 Register User**
- Endpoint: `POST /api/register` 
- Request body sudah diisi dengan sample data
- Click **Send**
- ✅ Expected: Status 201, token tersimpan otomatis ke environment variable

#### **2.2 Login**
- Endpoint: `POST /api/login` 
- Click **Send**
- ✅ Expected: Status 200, token tersimpan otomatis
- 📝 Token akan otomatis digunakan untuk request selanjutnya

#### **2.3 Get Profile**
- Endpoint: `GET /api/profile` 
- Click **Send**
- ✅ Expected: Status 200, user data ditampilkan

---

### **Step 3: Test CMS - Create Landing Page**

#### **3.1 Create New Page**
- Endpoint: `POST /api/cms/pages` 
- Sample body sudah ada (Toko Kue Manis)
- Click **Send**
- ✅ Expected: Status 201, `page_id` tersimpan otomatis
- 📝 `page_id` akan digunakan untuk request selanjutnya

#### **3.2 Get Page Details**
- Endpoint: `GET /api/cms/pages/{{page_id}}` 
- Click **Send**
- ✅ Expected: Status 200, page data lengkap

---

### **Step 4: Test Components**

#### **4.1 List Available Components**
- Endpoint: `GET /api/cms/components` 
- Click **Send**
- ✅ Expected: 6 component templates (Hero, Features, About, Contact, Testimonials, Services)

#### **4.2 Add Hero Component**
- Endpoint: `POST /api/cms/pages/{{page_id}}/components` 
- Body sudah ada sample Hero section
- Click **Send**
- ✅ Expected: Status 201, component ditambahkan

#### **4.3 Add Features Component**
- Ganti `component_slug` ke `features` di body
- Update content sesuai schema Features
- Click **Send**

**Sample Features Body:**
```json
{
    "component_id": "{{component_id}}",
    "content": {
        "section_title": "Keunggulan Kami",
        "section_subtitle": "Mengapa memilih Toko Kue Manis?",
        "items": [
            {
                "icon": "check",
                "title": "Bahan Premium",
                "description": "Menggunakan bahan berkualitas tinggi"
            },
            {
                "icon": "clock",
                "title": "Pengiriman Cepat",
                "description": "Delivery ke seluruh Bandung"
            },
            {
                "icon": "heart",
                "title": "Dibuat dengan Cinta",
                "description": "Setiap kue dibuat dengan penuh perhatian"
            }
        ]
    },
    "order_index": 1
}
```

---

### **Step 5: Test Content Versioning**

#### **5.1 List Versions**
- Endpoint: `GET /api/cms/pages/{{page_id}}/versions` 
- Click **Send**
- ✅ Expected: List semua versions

#### **5.2 Restore Version**
- Copy `version_id` dari response sebelumnya
- Paste ke URL variable
- Endpoint: `POST /api/cms/pages/{{page_id}}/versions/{{version_id}}/restore` 
- Click **Send**
- ✅ Expected: Page kembali ke state version tersebut

---

### **Step 6: Test Publish Mechanism**

#### **6.1 Update Page Status to Published**
- Endpoint: `PUT /api/cms/pages/{{page_id}}` 
- Body:
```json
{
    "title": "Toko Kue Manis - Published",
    "slug": "toko-kue-manis",
    "status": "published",
    "business_profile": {
        "company_name": "Toko Kue Manis",
        "phone": "08123456789",
        "email": "info@tokokuemanis.com",
        "address": "Jl. Raya Bandung No. 123, Bandung"
    }
}
```
- Click **Send**
- ✅ Expected: Status changed to "published"

#### **6.2 View Public Page**
- Copy `slug` dari page (e.g., "toko-kue-manis")
- Endpoint: `GET /api/preview/public/toko-kue-manis` 
- Click **Send**
- ✅ Expected: Public data (tanpa auth required)

---

### **Step 7: Test Analytics**

#### **7.1 Track Visitor** (No Auth)
- Endpoint: `POST /api/analytics/track/toko-kue-manis` 
- Body: fingerprint & referrer
- Click **Send**
- ✅ Expected: Visit recorded

#### **7.2 Dashboard Stats**
- Endpoint: `GET /api/analytics/dashboard?period=30days` 
- Click **Send**
- ✅ Expected: Summary statistics

#### **7.3 Page Analytics**
- Endpoint: `GET /api/analytics/pages/{{page_id}}` 
- Click **Send**
- ✅ Expected: Detailed page stats

---

### **Step 8: Test Preview**

#### **8.1 Preview Page (Auth Required)**
- Endpoint: `GET /api/preview/pages/{{page_id}}` 
- Click **Send**
- ✅ Expected: Page preview dengan auth

#### **8.2 Get Responsive Preview**
- Endpoint: `GET /api/preview/pages/{{page_id}}/responsive` 
- Click **Send**
- ✅ Expected: Responsive preview data

#### **8.3 Get Component Schema**
- Endpoint: `GET /api/preview/components/hero/schema` 
- Click **Send**
- ✅ Expected: Hero component schema

#### **8.4 Get Component Preview**
- Endpoint: `POST /api/preview/components/hero/preview` 
- Body sample hero content
- Click **Send**
- ✅ Expected: Rendered component preview

---

## 🧩 Complete Testing Scenario

### **Scenario: Membuat Landing Page Toko Kue**

1. **Register/Login** → Get token
2. **Create Page** "Toko Kue Manis"
3. **Add Components:**
   - Hero Section (judul, subtitle, CTA)
   - Features (3 keunggulan)
   - About (tentang toko)
   - Services (menu kue)
   - Contact (alamat, phone, email)
4. **Create Version** "v1.0 - Initial Launch"
5. **Preview** di desktop/mobile
6. **Publish** page
7. **Test Public Access** via slug
8. **Track Analytics** (simulate visitor)
9. **Check Dashboard Stats**

---

## 📊 Expected Results Checklist

### **Authentication** ✅
- [ ] Register berhasil dengan token
- [ ] Login berhasil dengan token
- [ ] Get profile menampilkan user data
- [ ] Logout menghapus token

### **CMS - Pages** ✅
- [ ] List pages menampilkan user's pages
- [ ] Create page dengan business_profile
- [ ] Update page
- [ ] Get page details dengan components
- [ ] Delete page (soft delete)
- [ ] Publish/unpublish page

### **CMS - Components** ✅
- [ ] List 6 component templates
- [ ] Add component ke page
- [ ] Update component content
- [ ] Reorder components
- [ ] Toggle active/inactive
- [ ] Delete component

### **Content Versioning** ✅
- [ ] Create version dengan snapshot
- [ ] List all versions
- [ ] Restore to specific version

### **Analytics** ✅
- [ ] Dashboard statistics dengan period filter
- [ ] Page analytics detail
- [ ] Track visitor (public endpoint)

### **Preview** ✅
- [ ] Preview dengan auth (draft pages)
- [ ] Public preview (published only)
- [ ] Device-specific rendering
- [ ] Component schema & preview

---

## 🔧 Troubleshooting

### **Issue: "Unauthenticated" Error**
**Solution:**
1. Check token di Environment variables
2. Jalankan Login request lagi
3. Token akan auto-save ke `access_token` 

### **Issue: "Page not found"**
**Solution:**
1. Check `page_id` di environment variables
2. Run "Create New Page" request
3. `page_id` akan auto-save

### **Issue: "CSRF token mismatch"**
**Solution:**
- API endpoints tidak memerlukan CSRF token
- Pastikan menggunakan `/api/*` routes, bukan `/web/*` 

### **Issue: "Validation failed"**
**Solution:**
- Check request body format
- Lihat error message untuk field mana yang salah
- Sesuaikan dengan schema component

---

## 🎯 Testing Tips

### **1. Auto-Save Variables**
Request dengan pre-test scripts akan auto-save:
- `access_token` dari Register/Login
- `page_id` dari Create Page
- `component_id` dari Add Component
- Gunakan untuk request selanjutnya

### **2. Test Ordering**
Untuk full flow testing, jalankan dengan urutan:
```
1. Authentication (Register → Login)
2. CMS Pages (Create → Add Components)
3. Preview
4. Publish
5. Analytics
```

### **3. Environment Variables**
Monitor variables di Postman:
- Click mata icon di kanan atas
- Lihat current values
- Edit manual jika diperlukan

### **4. Collection Runner**
Untuk automated testing:
1. Click collection → Run
2. Select requests yang ingin ditest
3. Click "Run ComPro CMS API"
4. Lihat test results

---

## 📝 Sample Test Data

### **Business Profile Template**
```json
{
    "company_name": "Nama Bisnis Anda",
    "logo": "https://example.com/logo.png",
    "phone": "08123456789",
    "email": "info@bisnis.com",
    "address": "Alamat lengkap bisnis",
    "description": "Deskripsi singkat bisnis"
}
```

### **Component Schemas**

#### **Hero**
```json
{
    "title": "Judul Utama",
    "subtitle": "Deskripsi singkat",
    "background_image": "url",
    "cta_text": "Tombol",
    "cta_link": "https://wa.me/..."
}
```

#### **Features**
```json
{
    "section_title": "Keunggulan Kami",
    "items": [
        {
            "icon": "check",
            "title": "Judul Fitur",
            "description": "Deskripsi fitur"
        }
    ]
}
```

#### **Contact**
```json
{
    "section_title": "Hubungi Kami",
    "address": "Alamat lengkap",
    "phone": "08123456789",
    "email": "info@example.com",
    "maps_embed": "<iframe...>",
    "show_contact_form": true
}
```

---

## ✅ Success Criteria

Backend API testing dianggap **SUKSES** jika:

1. ✅ Semua authentication endpoints working
2. ✅ CRUD pages berfungsi dengan benar
3. ✅ Component management operational
4. ✅ Versioning & rollback working
5. ✅ Publish/unpublish mechanism functioning
6. ✅ Analytics tracking & reporting accurate
7. ✅ Preview system rendering correctly
8. ✅ Component schema & preview working

---

## 📞 Support

Jika ada issues:
1. Check Laravel logs: `storage/logs/laravel.log` 
2. Check database connection
3. Verify migrations: `php artisan migrate:status` 
4. Test endpoint di browser/curl dulu

---

**Happy Testing! 🚀**

Last Updated: January 6, 2026
Version: 1.0.0
