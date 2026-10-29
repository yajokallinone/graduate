# ออกแบบ Database Schema — ระบบจัดการข้อมูลหลักสูตรบัณฑิตศึกษา

## เป้าหมาย

ย้ายข้อมูลหลักสูตรที่ตอนนี้ hard-code อยู่ใน `config/programs.php` (PHP array) ให้ไปอยู่ในฐานข้อมูล MySQL เพื่อให้:

- แก้ไขข้อมูลรายละเอียดสาขา/หลักสูตร/แผนการเรียนได้ผ่านหน้าแอดมิน โดยไม่ต้องแก้โค้ด
- รองรับสองภาษา (ไทย/อังกฤษ) แบบมีโครงสร้างจริง แทนการเก็บคู่ฟิลด์ `x` / `x_en`
- เชื่อมโยงกับข้อมูลที่มีอยู่แล้วในไฟล์ `public/data/*.json` (สาขา, หมวดหมู่งานวิจัย, อาจารย์, วิทยานิพนธ์) เข้าด้วยกันเป็นระบบเดียว แทนที่จะเป็นไฟล์ static แยกกัน
- เผื่อไว้สำหรับต่อกับหน้า Research ในอนาคต (ตาม STRUCTURE.md เดิมที่ระบุว่าจะเชื่อมกับฐานข้อมูล `reg` ของมหาวิทยาลัย)

โครงสร้างด้านล่างออกแบบให้ใช้กับ Laravel migration ได้ทันที (ใช้ `id` เป็น primary key แบบ `BIGINT UNSIGNED AUTO_INCREMENT` ตามธรรมเนียม Eloquent)

---

## ภาพรวมความสัมพันธ์ระหว่างตาราง

```
departments (ภาควิชา)
    └── programs (หลักสูตร)
            ├── program_translations (คำแปล TH/EN ของหลักสูตร)
            └── program_plans (แผนการเรียนของหลักสูตร)
                    ├── program_plan_fees (ค่าธรรมเนียม)
                    └── program_plan_qualifications (คุณสมบัติผู้สมัคร)

research_categories (หมวดหมู่งานวิจัย แบบ self-referencing: main/sub)
    └── theses (วิทยานิพนธ์)
            └── thesis_advisor (pivot) ── teachers (อาจารย์)
                                              └── departments

majors (สาขาวิชา จากระบบทะเบียน มช. — ใช้ map กับ teachers/programs)

users / roles (ผู้ใช้งานระบบแอดมิน + สิทธิ์แก้ไข)
```

---

## 1. กลุ่มตาราง "หลักสูตร" (Programs)

### 1.1 `departments` — ภาควิชา

เดิมข้อมูลนี้ปนอยู่ในฟิลด์ `major` / `major_en` ของแต่ละหลักสูตร แยกออกมาเป็นตารางเพื่อไม่ให้พิมพ์ชื่อภาควิชาซ้ำผิดเพี้ยนในแต่ละหลักสูตร

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `name_th` | VARCHAR(255) | ชื่อภาควิชา (ไทย) เช่น "ภาควิชาวิศวกรรมโยธา" |
| `name_en` | VARCHAR(255) | ชื่อภาควิชา (อังกฤษ) |
| `legacy_major_id` | VARCHAR(20) NULL | อ้างอิง `id` จาก `majors.json` เดิม (สำหรับ migrate ข้อมูล) |
| `created_at`, `updated_at` | TIMESTAMP | |

### 1.2 `programs` — หลักสูตร (ตารางหลัก)

ฟิลด์ที่ไม่ต้องแปลภาษา (เป็นค่าคงที่/รหัส/รูปภาพ) เก็บไว้ที่นี่

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `code` | VARCHAR(100) UNIQUE | รหัสหลักสูตร (คีย์เดิมใน config เช่น `civil_engineering_meng`) ใช้เป็น slug ใน URL `/programs/{code}` |
| `department_id` | BIGINT UNSIGNED FK → `departments.id` | |
| `degree_level` | ENUM('master','doctoral') | ระดับปริญญา (ใช้ filter ในหน้า /programs) |
| `contact_phone` | VARCHAR(50) NULL | เบอร์ติดต่อ |
| `image_path` | VARCHAR(255) NULL | path รูปโลโก้ เช่น `images/ce-logo.png` |
| `is_published` | BOOLEAN DEFAULT TRUE | เปิด/ปิดการแสดงผลหลักสูตรนี้ |
| `sort_order` | INT DEFAULT 0 | ลำดับการแสดงผล |
| `created_at`, `updated_at` | TIMESTAMP | |

> หมายเหตุ: ไม่เก็บ `degree` (ข้อความ "ปริญญาโท/ปริญญาเอก") เป็น string ตรงๆ เพราะซ้ำกับ `degree_level` — ใช้ ENUM แล้วแปลข้อความตอนแสดงผลแทน จะแก้ไขคำ ("ปริญญาโท" → "ปริญญามหาบัณฑิต") ได้จากที่เดียวในตาราง translations ของ UI ไม่ต้องไล่แก้ทุกแถว

### 1.3 `program_translations` — คำแปลของหลักสูตร

แยกฟิลด์ที่เป็นข้อความและต้องมีสองภาษาออกมาเป็นตารางแบบ EAV เบาๆ (locale-keyed) แทนการมีคอลัมน์ `_en` คู่กันเสมอ ทำให้เพิ่มภาษาที่ 3 ในอนาคตได้โดยไม่ต้อง ALTER TABLE

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `program_id` | BIGINT UNSIGNED FK → `programs.id` | |
| `locale` | VARCHAR(5) | `th` หรือ `en` |
| `title` | VARCHAR(500) | ชื่อหลักสูตรเต็ม |
| `created_at`, `updated_at` | TIMESTAMP | |

UNIQUE KEY (`program_id`, `locale`)

> ทางเลือก: ถ้าต้องการความเรียบง่ายกว่านี้และทีมไม่คุ้นกับ pattern translation table สามารถรวมกลับมาเป็นคอลัมน์คู่ `title_th` / `title_en` ในตาราง `programs` ตรงๆ ได้เช่นกัน (ดูหัวข้อ "ทางเลือกออกแบบแบบง่าย" ท้ายเอกสาร)

### 1.4 `program_plans` — แผนการเรียนของแต่ละหลักสูตร

หนึ่งหลักสูตรมีได้หลายแผน (เช่น แผน 1 แบบวิชาการ / แผน 2)

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `program_id` | BIGINT UNSIGNED FK → `programs.id` | |
| `plan_code` | VARCHAR(20) | รหัสแผน เช่น "1", "2" |
| `plan_name_th` | VARCHAR(255) | เช่น "แผน 1 แบบวิชาการ" |
| `plan_name_en` | VARCHAR(255) | |
| `study_type_th` | VARCHAR(255) | เช่น "ภาคปกติ (จ.-ศ.)" |
| `study_type_en` | VARCHAR(255) | |
| `credit_th` | VARCHAR(255) | เช่น "ปริญญานิพนธ์ 36 หน่วยกิต" (เก็บเป็นข้อความตามต้นฉบับ เพราะรูปแบบไม่คงที่) |
| `credit_en` | VARCHAR(255) | |
| `duration_th` | VARCHAR(255) | เช่น "ระยะเวลาการศึกษาตลอดหลักสูตร 2 ปี" |
| `duration_en` | VARCHAR(255) | |
| `date_study_th` | VARCHAR(255) | เช่น "จันทร์–ศุกร์" |
| `date_study_en` | VARCHAR(255) | |
| `sort_order` | INT DEFAULT 0 | |
| `created_at`, `updated_at` | TIMESTAMP | |

> เหตุผลที่ไม่แยก `credit_th`/`en`, `duration_th`/`en` ไปเป็น translation table เหมือน `programs`: ฟิลด์เหล่านี้เป็นข้อความสั้นเฉพาะของแผนเดียว ไม่คุ้มกับความซับซ้อนของ EAV — ใช้คอลัมน์คู่ตรงไปตรงมาเพียงพอ

### 1.5 `program_plan_fees` — ค่าธรรมเนียม (1-ต่อ-กลุ่ม)

ในข้อมูลเดิม `fee` เป็น array ของบรรทัดข้อความ (เช่น 2 บรรทัดต่อแผน) จึงแยกเป็นตารางลูกเพื่อรองรับจำนวนบรรทัดไม่จำกัด

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `program_plan_id` | BIGINT UNSIGNED FK → `program_plans.id` | |
| `fee_text_th` | VARCHAR(500) | เช่น "ภาคการศึกษาละ 25,000 บาท" |
| `fee_text_en` | VARCHAR(500) | |
| `sort_order` | INT DEFAULT 0 | |

### 1.6 `program_plan_qualifications` — คุณสมบัติผู้สมัคร

เช่นเดียวกับค่าธรรมเนียม `qualification` เดิมเป็น array ของข้อความ

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `program_plan_id` | BIGINT UNSIGNED FK → `program_plans.id` | |
| `qualification_text_th` | TEXT | |
| `qualification_text_en` | TEXT | |
| `sort_order` | INT DEFAULT 0 | |

---

## 2. กลุ่มตาราง "งานวิจัย / วิทยานิพนธ์" (Research)

มาจากไฟล์ `public/data/categories.json`, `theses.json`, `teachers.json`, `majors.json` — รวมเป็นระบบเดียวกันเพื่อให้หน้า `/research` (ปัจจุบันเป็น placeholder) ต่อกับฐานข้อมูลได้จริงในอนาคต

### 2.1 `majors` — สาขาวิชา (จากระบบทะเบียน มช.)

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `external_id` | VARCHAR(20) UNIQUE | รหัสสาขาเดิมจากระบบทะเบียน (ฟิลด์ `id` ใน `majors.json` เช่น "71") |
| `name_th` | VARCHAR(255) | |
| `name_en` | VARCHAR(255) NULL | (บางรายการเป็น null ในข้อมูลต้นฉบับ ต้องรองรับ) |
| `department_id` | BIGINT UNSIGNED FK → `departments.id` NULL | เผื่อ map เข้ากับภาควิชาภายหลัง |

### 2.2 `teachers` — อาจารย์

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `code` | VARCHAR(20) UNIQUE | รหัสอาจารย์เดิม เช่น "FA01" (คีย์ใน `teachers.json`) |
| `name` | VARCHAR(255) | ชื่อ-นามสกุล (ข้อมูลต้นฉบับเป็นภาษาไทยล้วน ไม่มี name_en) |
| `major_id` | BIGINT UNSIGNED FK → `majors.id` NULL | |
| `created_at`, `updated_at` | TIMESTAMP | |

### 2.3 `research_categories` — หมวดหมู่งานวิจัย (self-referencing: main + sub)

`categories.json` เดิมมีโครงสร้าง main category ที่มี `subcategories` ซ้อนอยู่ข้างใน ใช้ self-referencing FK แทนการแยกเป็น 2 ตาราง จะยืดหยุ่นกว่าถ้าอนาคตอยากมีมากกว่า 2 ระดับ

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `parent_id` | BIGINT UNSIGNED FK → `research_categories.id` NULL | NULL = หมวดหลัก (main_cat), ไม่ NULL = หมวดย่อย (sub_cat) |
| `key_slug` | VARCHAR(255) | ค่าที่ใช้ match กับ `main_cat`/`sub_cat` เดิมใน theses.json ระหว่าง migrate |
| `name_th` | VARCHAR(255) | |
| `name_en` | VARCHAR(255) | |
| `thesis_count_cache` | INT DEFAULT 0 | เก็บ count ที่คำนวณไว้ล่วงหน้า (denormalized) สำหรับแสดงผลเร็ว ไม่ต้อง COUNT() ทุกครั้ง — อัปเดตด้วย job/trigger เมื่อมีวิทยานิพนธ์เพิ่ม/ลบ |

### 2.4 `theses` — วิทยานิพนธ์

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `external_id` | VARCHAR(20) UNIQUE | รหัสวิทยานิพนธ์เดิม (รหัสนักศึกษา เช่น "570635907") |
| `title_th` | VARCHAR(1000) | |
| `title_en` | VARCHAR(1000) | |
| `main_category_id` | BIGINT UNSIGNED FK → `research_categories.id` | |
| `sub_category_id` | BIGINT UNSIGNED FK → `research_categories.id` NULL | |
| `created_at`, `updated_at` | TIMESTAMP | |

FULLTEXT INDEX บน (`title_th`, `title_en`) — เพื่อรองรับการค้นหาชื่อวิทยานิพนธ์แบบ full-text แทน LIKE '%...%'

### 2.5 `thesis_advisor` — pivot table วิทยานิพนธ์ ↔ อาจารย์ที่ปรึกษา

หนึ่งวิทยานิพนธ์มีอาจารย์ที่ปรึกษาได้มากกว่า 1 คน (จากตัวอย่างข้อมูล `advisors` เป็น array)

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `thesis_id` | BIGINT UNSIGNED FK → `theses.id` | |
| `teacher_id` | BIGINT UNSIGNED FK → `teachers.id` | |
| `role` | ENUM('main_advisor','co_advisor') DEFAULT 'main_advisor' | เผื่อแยกที่ปรึกษาหลัก/ร่วมในอนาคต |

PRIMARY KEY (`thesis_id`, `teacher_id`)

---

## 3. กลุ่มตาราง "ทุนการศึกษา" (Scholarships)

ปัจจุบันหน้า `/scholarships` เป็นเนื้อหา static ในไฟล์ blade แต่ถ้าต้องการให้แก้ไขได้ผ่านแอดมินเหมือนหลักสูตร ให้เพิ่ม:

### 3.1 `scholarships`

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `title_th` | VARCHAR(500) | |
| `title_en` | VARCHAR(500) | |
| `description_th` | TEXT | |
| `description_en` | TEXT | |
| `contact_info` | VARCHAR(255) NULL | |
| `is_published` | BOOLEAN DEFAULT TRUE | |
| `sort_order` | INT DEFAULT 0 | |
| `created_at`, `updated_at` | TIMESTAMP | |

---

## 4. กลุ่มตาราง "ผู้ใช้งานระบบแอดมิน" (Admin / Auth)

Laravel มีตาราง `users` มาให้อยู่แล้ว (`database/migrations/0001_01_01_000000_create_users_table.php`) เพิ่มสิทธิ์ตามความจำเป็น

### 4.1 `users` (ของเดิมที่มีอยู่แล้ว — เพิ่มคอลัมน์)

| คอลัมน์เพิ่มเติม | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `role` | ENUM('admin','editor') DEFAULT 'editor' | ระดับสิทธิ์ ถ้าต้องการละเอียดกว่านี้ค่อยแยกเป็นตาราง `roles`/`permissions` ภายหลัง |
| `department_id` | BIGINT UNSIGNED FK → `departments.id` NULL | จำกัดสิทธิ์ให้แก้ไขได้เฉพาะหลักสูตรของภาควิชาตนเอง (ถ้าต้องการ) |

### 4.2 `activity_logs` (แนะนำเพิ่ม — ไม่บังคับ)

เก็บประวัติการแก้ไขข้อมูล เพื่อ audit ว่าใครแก้อะไรเมื่อไหร่ (สำคัญเมื่อเปิดให้หลายคนแก้ไขข้อมูลหลักสูตรร่วมกัน)

| คอลัมน์ | ชนิดข้อมูล | อธิบาย |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | |
| `user_id` | BIGINT UNSIGNED FK → `users.id` | |
| `action` | VARCHAR(50) | create / update / delete |
| `model_type` | VARCHAR(100) | เช่น `Program`, `ProgramPlan` |
| `model_id` | BIGINT UNSIGNED | |
| `changes` | JSON | diff ของข้อมูลก่อน/หลัง |
| `created_at` | TIMESTAMP | |

---

## 5. ตัวอย่าง SQL (MySQL) — ตารางหลักของกลุ่ม Programs

```sql
CREATE TABLE departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name_th VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    legacy_major_id VARCHAR(20) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE programs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(100) NOT NULL UNIQUE,
    department_id BIGINT UNSIGNED NOT NULL,
    degree_level ENUM('master','doctoral') NOT NULL,
    contact_phone VARCHAR(50) NULL,
    image_path VARCHAR(255) NULL,
    is_published BOOLEAN NOT NULL DEFAULT TRUE,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_programs_department FOREIGN KEY (department_id) REFERENCES departments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE program_translations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    program_id BIGINT UNSIGNED NOT NULL,
    locale VARCHAR(5) NOT NULL,
    title VARCHAR(500) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uniq_program_locale (program_id, locale),
    CONSTRAINT fk_translations_program FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE program_plans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    program_id BIGINT UNSIGNED NOT NULL,
    plan_code VARCHAR(20) NOT NULL,
    plan_name_th VARCHAR(255) NOT NULL,
    plan_name_en VARCHAR(255) NOT NULL,
    study_type_th VARCHAR(255) NULL,
    study_type_en VARCHAR(255) NULL,
    credit_th VARCHAR(255) NULL,
    credit_en VARCHAR(255) NULL,
    duration_th VARCHAR(255) NULL,
    duration_en VARCHAR(255) NULL,
    date_study_th VARCHAR(255) NULL,
    date_study_en VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_plans_program FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE program_plan_fees (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    program_plan_id BIGINT UNSIGNED NOT NULL,
    fee_text_th VARCHAR(500) NOT NULL,
    fee_text_en VARCHAR(500) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_fees_plan FOREIGN KEY (program_plan_id) REFERENCES program_plans(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE program_plan_qualifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    program_plan_id BIGINT UNSIGNED NOT NULL,
    qualification_text_th TEXT NOT NULL,
    qualification_text_en TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_quals_plan FOREIGN KEY (program_plan_id) REFERENCES program_plans(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 6. ทางเลือกออกแบบแบบง่าย (ถ้าไม่อยากใช้ translation table)

ถ้าทีมมองว่าตาราง `program_translations` ซับซ้อนเกินความจำเป็น (โปรเจกต์นี้รองรับแค่ 2 ภาษาคงที่ ไม่มีแผนเพิ่มภาษาที่ 3) สามารถยุบรวมกลับเข้า `programs` ตรงๆ แบบเดียวกับที่ `program_plans` ทำอยู่แล้ว:

```sql
ALTER TABLE programs
    ADD COLUMN title_th VARCHAR(500) NOT NULL AFTER code,
    ADD COLUMN title_en VARCHAR(500) NOT NULL AFTER title_th;
-- แล้วไม่ต้องสร้างตาราง program_translations
```

วิธีนี้เขียน query ง่ายกว่า (ไม่ต้อง JOIN เพื่อดึงชื่อหลักสูตร) แลกกับความยืดหยุ่นที่ลดลงถ้าต้องเพิ่มภาษาในอนาคต — แนะนำให้เลือกวิธีนี้ถ้าต้องการความเรียบง่ายและ deploy เร็ว เพราะโครงสร้างข้อมูลเดิมทั้งระบบ (`resources/lang`, `ProgramTranslator`) ก็ออกแบบมาสำหรับ 2 ภาษาตายตัวอยู่แล้ว

---

## 7. Mapping จากไฟล์ข้อมูลเดิม → ตารางใหม่

| ไฟล์/ฟิลด์เดิม | ตาราง/คอลัมน์ใหม่ |
|---|---|
| `config/programs.php` → key ของ array (เช่น `civil_engineering_meng`) | `programs.code` |
| `config/programs.php` → `major`, `major_en` | `departments.name_th`, `departments.name_en` |
| `config/programs.php` → `title`, `title_en` | `program_translations` (หรือ `programs.title_th/en` ถ้าใช้ทางเลือกง่าย) |
| `config/programs.php` → `degree`, `degree_en` | `programs.degree_level` (ENUM) + แปลข้อความตอนแสดงผล |
| `config/programs.php` → `contact` | `programs.contact_phone` |
| `config/programs.php` → `img` | `programs.image_path` |
| `config/programs.php` → `plans[]` | `program_plans` (1 แถวต่อ 1 แผน) |
| `config/programs.php` → `plans[].fee[]` | `program_plan_fees` (1 แถวต่อ 1 บรรทัด) |
| `config/programs.php` → `plans[].qualification[]` | `program_plan_qualifications` |
| `public/data/majors.json` | `majors` |
| `public/data/teachers.json` (key เช่น "FA01") | `teachers.code` |
| `public/data/categories.json` → `subcategories[]` | `research_categories` (self-referencing) |
| `public/data/theses.json` → `advisors[]` | `thesis_advisor` (pivot) |

---

## 8. ข้อเสนอแนะเพิ่มเติม

- **Index ที่ควรมี**: `programs.department_id`, `programs.degree_level`, `theses.main_category_id`, `theses.sub_category_id`, `thesis_advisor.teacher_id` — เพราะเป็นคอลัมน์ที่หน้าเว็บใช้ filter บ่อย (ตรงกับ filter bar ในหน้า `/programs` ที่มีอยู่แล้ว: ค้นหาชื่อ, ระดับ, ภาควิชา, สาขา, วันเรียน)
- **Soft delete**: ถ้าต้องการ "ปิดการแสดงผล" หลักสูตรโดยไม่ลบข้อมูลจริง ใช้ `is_published` ที่มีอยู่แล้วในตาราง หรือเพิ่ม `deleted_at` (Laravel SoftDeletes) ถ้าต้องการเก็บประวัติแบบเต็มรูปแบบ
- **Seeder**: เขียน Laravel Seeder ที่อ่านค่าจาก `config/programs.php` และไฟล์ JSON เดิมโดยตรง เพื่อ migrate ข้อมูลเข้าตารางใหม่แบบอัตโนมัติครั้งเดียว แทนการคีย์ข้อมูลใหม่ด้วยมือ
- **Backward compatibility**: ระหว่างเปลี่ยนผ่าน อาจทำ Eloquent Accessor ในโมเดล `Program` ให้คืนค่าหน้าตาเหมือนโครงสร้าง array เดิม (`$program->title`, `$program->plans`) เพื่อไม่ต้องแก้ไฟล์ Blade view ที่มีอยู่แล้วทั้งหมดในคราวเดียว
