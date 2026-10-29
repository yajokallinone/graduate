# โครงสร้างเว็บไซต์ Graduate Studies - Faculty of Engineering CMU

## 📋 ภาพรวม
เว็บไซต์ข้อมูลการศึกษาต่อระดับบัณฑิตศึกษา สำหรับคณะวิศวกรรมศาสตร์ มหาวิทยาลัยเชียงใหม่

**Framework:** Laravel 11  
**Language:** PHP 8.2+  
**Database:** MySQL (10.10.12.77, db: `reg`)  
**Frontend:** Bootstrap 5.3.2 + Bootstrap Icons  
**Localization:** Thai (th) & English (en)

---

## 🗂️ โครงสร้างไฟล์

```
D:\grad/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php           ← หน้าแรก
│   │   │   ├── ProgramController.php        ← หลักสูตร (list + detail)
│   │   │   ├── ScholarshipController.php    ← ทุนการศึกษา
│   │   │   └── ResearchController.php       ← งานวิจัย (placeholder)
│   │   └── Middleware/
│   │       └── SetLocale.php                ← สลับภาษา TH/EN
│   └── Support/
│       └── ProgramTranslator.php            ← แปลข้อมูลหลักสูตร
│
├── config/
│   └── programs.php                         ← ข้อมูล 21 หลักสูตร
│
├── resources/
│   ├── lang/
│   │   ├── th/
│   │   │   └── site.php                     ← ข้อความ Thai
│   │   └── en/
│   │       └── site.php                     ← ข้อความ English
│   │
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                ← Master layout
│       │
│       ├── partials/
│       │   ├── navbar.blade.php             ← Navigation bar
│       │   └── footer.blade.php             ← Footer
│       │
│       ├── home/
│       │   └── index.blade.php              ← หน้าแรก (hero + menu grid)
│       │
│       ├── programs/
│       │   ├── index.blade.php              ← รายชื่อหลักสูตร + filter
│       │   ├── show.blade.php               ← รายละเอียดหลักสูตร
│       │   └── not-found.blade.php          ← หลักสูตรไม่พบ
│       │
│       ├── scholarships/
│       │   └── index.blade.php              ← ทุนการศึกษา
│       │
│       └── research/
│           └── index.blade.php              ← งานวิจัย (coming soon)
│
├── routes/
│   └── web.php                              ← Routes
│
├── public/
│   ├── images/                              ← โลโก้หลักสูตร
│   │   ├── ce-logo.png                      ← Civil Engineering
│   │   ├── cpe-logo.png                     ← Computer Engineering
│   │   ├── dsc-logo.png                     ← Data Science
│   │   ├── ee-logo.png                      ← Electrical Engineering
│   │   ├── env-logo.png                     ← Environmental Engineering
│   │   ├── ie-logo.png                      ← Industrial Engineering
│   │   ├── me-logo.png                      ← Mechanical Engineering
│   │   ├── mn-logo.png                      ← Mining Engineering
│   │   ├── interdis-logo.png                ← Interdisciplinary
│   │   ├── eng-banner.jpg                   ← Banner
│   │   └── lord.png                         ← Additional image
│   │
│   └── index.php                            ← Laravel entry point
│
├── bootstrap/
│   └── app.php                              ← Middleware registration
│
├── .env                                     ← Environment variables
├── .env.example                             ← Example config
├── composer.json                            ← PHP dependencies
├── artisan                                  ← Laravel CLI
│
└── _legacy-reference/                       ← Backup ของไฟล์เดิม (PHP)
    ├── index.php
    ├── navbar.php
    ├── footer.php
    ├── programs.php
    ├── programs-list.php
    ├── details.php
    ├── scholarships.php
    ├── research.php
    └── db.php
```

---

## 🛣️ Routes

| Method | URL | Controller | View | Description |
|--------|-----|-----------|------|-------------|
| GET | `/` | HomeController@index | home.index | หน้าแรก |
| GET | `/programs` | ProgramController@index | programs.index | รายชื่อหลักสูตร |
| GET | `/programs/{code}` | ProgramController@show | programs.show | รายละเอียดหลักสูตร |
| GET | `/scholarships` | ScholarshipController@index | scholarships.index | ทุนการศึกษา |
| GET | `/research` | ResearchController@index | research.index | งานวิจัย (placeholder) |

**Query Parameters:**
- `?lang=th` – ตั้งค่าภาษาเป็นไทย
- `?lang=en` – ตั้งค่าภาษาเป็นอังกฤษ

---

## 🎨 หน้าเว็บไซต์

### 1. **หน้าแรก** (`/`)
- **Hero section** – ชื่อเอกสารและชื่อสถาบัน
- **Menu Grid** – 4 เมนู:
  - 📚 Programs – ดูหลักสูตร
  - 💡 Research – ดูงานวิจัย
  - 🏆 Scholarships – ดูทุน
  - 📢 News – ข่าวประชาสัมพันธ์

### 2. **หลักสูตรทั้งหมด** (`/programs`)
- **Filter Bar:**
  - ค้นหาชื่อ (text search)
  - กรองตามระดับ (ปริญญาโท/เอก)
  - กรองตามภาควิชา
  - กรองตามสาขา
  - กรองตามวันเรียน
- **Program Cards:**
  - รูปโลโก้
  - ชื่อหลักสูตร
  - ภาควิชา
  - ระดับปริญญา
  - เครดิตและวันเรียน
  - ปุ่ม "View Details"
- **Client-side JavaScript** – Filter แบบ real-time

### 3. **รายละเอียดหลักสูตร** (`/programs/{code}`)
- ชื่อหลักสูตร + โลโก้
- ข้อมูลติดต่อ
- **Study Plans (แผนการเรียน):**
  - ชื่อแผน
  - ประเภทการเรียน (ภาคปกติ/พิเศษ)
  - จำนวนเครดิต
  - ระยะเวลา
  - วันเรียน
  - ค่าธรรมเนียม
  - คุณสมบัติผู้สมัคร

### 4. **ทุนการศึกษา** (`/scholarships`)
- ข้อมูลทุนวิจัย
- ช่องติดต่อสอบถาม
- เบอร์โทรศัพท์

### 5. **งานวิจัย** (`/research`)
- **Placeholder**: "Under Development / อยู่ระหว่างพัฒนา"
- *(อนาคต: จะต่อ MySQL database `reg` ค้นหาวิทยานิพนธ์)*

---

## 📊 ข้อมูล

### หลักสูตร (21 รายการ)
ข้อมูลเก็บใน `config/programs.php` โครงสร้าง:

```php
[
    "program_key" => [
        "major" => "ภาควิชา (TH)",
        "major_en" => "Department (EN)",
        "title" => "ชื่อหลักสูตร (TH)",
        "title_en" => "Program Name (EN)",
        "degree" => "ปริญญาโท/เอก (TH)",
        "degree_en" => "Master's/Doctoral (EN)",
        "contact" => "หมายเลขโทรศัพท์",
        "img" => "images/logo.png",
        "plans" => [
            [
                "plan_name" => "แผน X",
                "plan_name_en" => "Plan X",
                "study_type" => "ภาคปกติ/พิเศษ",
                "study_type_en" => "Regular/Special",
                "credit" => "36 หน่วยกิต / ปริญญานิพนธ์",
                "credit_en" => "36 credits (Thesis)",
                "duration" => "2 ปี",
                "duration_en" => "2 years",
                "date_study" => "จันทร์–ศุกร์",
                "date_study_en" => "Monday-Friday",
                "fee" => ["...", "..."],
                "fee_en" => ["...", "..."],
                "qualification" => ["...", "..."],
                "qualification_en" => ["...", "..."]
            ]
        ]
    ]
]
```

### หลักสูตรที่รวมอยู่:
1. Construction Engineering (M.Eng) – 3 plans
2. Civil Engineering (M.Eng) – 2 plans
3. Civil Engineering (Ph.D) – 1 plan
4. Data Science (M.Sc) – 3 plans
5. Data Science (Ph.D) – 1 plan
6. Mining & Georesources Engineering (M.Eng) – 1 plan
7. Electrical Engineering (M.Eng) – 1 plan
8. Electrical Engineering (Ph.D) – 1 plan
9. Industrial Engineering (M.Eng) – 1 plan
10. Industrial Engineering (Ph.D) – 1 plan
11. Logistics & Supply Chain Engineering (M.Eng) – 1 plan
12. Industrial Management (M.Sc) – 1 plan
13. Mechanical Engineering (M.Eng) – 1 plan
14. Mechanical Engineering (Ph.D) – 1 plan
15. Energy Engineering (M.Eng) – 1 plan
16. Energy Engineering (Ph.D) – 1 plan
17. Agricultural Engineering (M.Eng) – 1 plan
18. Advanced Computational Engineering & Design (M.Eng) – 1 plan
19. Computer Engineering (M.Eng) – 1 plan
20. Plasma Technology & MEMS Engineering (M.Eng) – 1 plan
21. Plasma Technology & MEMS Engineering (Ph.D) – 1 plan

---

## 🌐 ระบบสลับภาษา

### วิธีการทำงาน:
1. ผู้ใช้คลิกปุ่ม "TH" หรือ "EN" บน navbar
2. Middleware `SetLocale` อ่านค่า `?lang=` จาก query string
3. เขียนค่าลงใน `session('locale')`
4. เรียก `App::setLocale()` เพื่ออัปเดตภาษา
5. Blade views ใช้ `__('site.key')` เพื่อแสดงข้อความตามภาษา
6. ข้อมูลหลักสูตรใช้ `ProgramTranslator::translate()` เพื่ออ่าน field `title` หรือ `title_en`

### Language Files:
- `resources/lang/th/site.php` – ข้อความภาษาไทย
- `resources/lang/en/site.php` – ข้อความภาษาอังกฤษ

---

## 🔧 Configuration

### `.env` ตัวแปรสำคัญ:
```env
APP_NAME="Graduate Studies"
APP_LOCALE=th                    # ภาษาเริ่มต้น
APP_FALLBACK_LOCALE=en           # ภาษาสำรอง

DB_CONNECTION=mysql              # ใช้ MySQL
DB_HOST=10.10.12.77
DB_PORT=3306
DB_DATABASE=reg                  # Database ของมหาวิทยาลัย
DB_USERNAME=tcas68
DB_PASSWORD=ed06engr

SESSION_DRIVER=file              # เก็บ session เป็นไฟล์
CACHE_STORE=array                # ไม่ต้อง database
QUEUE_CONNECTION=sync            # ไม่ต้อง queue
```

---

## 🚀 การรัน

### เปิด Development Server:
```bash
php artisan serve --host=127.0.0.1 --port=8000
```

### เข้าเว็บไซต์:
```
http://127.0.0.1:8000
```

### สลับภาษา:
- `http://127.0.0.1:8000/?lang=th` – ไทย
- `http://127.0.0.1:8000/?lang=en` – อังกฤษ

---

## 📌 Features

✅ **Bilingual Support** – Thai & English  
✅ **Responsive Design** – Bootstrap 5.3.2  
✅ **Client-side Filtering** – Real-time search & filter  
✅ **Clean URLs** – `/programs` แทน `?program=xxx`  
✅ **Program Data Management** – Centralized in config  
✅ **Professional Layout** – Navbar + Footer + Hero sections  
✅ **Mobile Friendly** – Grid layout adapts to screen size  

---

## 🔮 อนาคต (Future Enhancement)

- [ ] Connect `/research` ไปยัง MySQL database `reg` เพื่อแสดงวิทยานิพนธ์
- [ ] Admin Panel สำหรับแก้ไขข้อมูลหลักสูตร
- [ ] Search optimization (Elasticsearch)
- [ ] PDF export สำหรับข้อมูลหลักสูตร
- [ ] Integration with university portal
- [ ] Email notifications

---

## 📞 Database Connection Reference

**Original Database (Legacy PHP):**
```php
$localhost = '10.10.12.77';
$username = 'tcas68';
$password = 'ed06engr';
$dbname = 'reg';
```

**Tables in `reg` database:**
- `project` – วิทยานิพนธ์/ปริญญานิพนธ์
- `all_teacher` – ข้อมูลอาจารย์
- `major` – ข้อมูลสาขา

---

## 📝 Notes

- ไฟล์เดิมทั้งหมด (PHP) สำรองไว้ใน `_legacy-reference/`
- ข้อมูลหลักสูตร 21 รายการถูกย้ายจาก `programs.php` → `config/programs.php`
- รูปภาพโลโก้อยู่ใน `public/images/`
- Localization ใช้ Laravel built-in system แทน custom `t()` function

---

**Created:** 2024  
**Framework:** Laravel 11  
**Status:** ✅ Development Ready
