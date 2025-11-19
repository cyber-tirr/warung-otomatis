# 🚀 Quick Start - Tailwind CSS

## Langkah Cepat Menjalankan Aplikasi

### 1️⃣ Install Dependencies
```bash
npm install
```

### 2️⃣ Build Assets
```bash
# Pilih salah satu:

# Development (dengan watch mode - auto reload)
npm run dev

# Production (optimized & minified)
npm run build
```

### 3️⃣ Jalankan Laravel
```bash
php artisan serve
```

### 4️⃣ Akses Aplikasi
- **URL**: http://localhost:8000 atau http://warung-kopi-otomatis.test
- **Login**: admin@warungkopi.com / password

---

## ⚡ Commands Penting

### Development
```bash
# Terminal 1: Jalankan Vite (auto compile CSS/JS)
npm run dev

# Terminal 2: Jalankan Laravel
php artisan serve
```

### Production Build
```bash
# Build assets untuk production
npm run build

# Clear cache
php artisan optimize:clear

# Deploy
# Upload semua file ke server
```

### Troubleshooting
```bash
# Jika CSS tidak muncul
npm run build
php artisan optimize:clear
php artisan config:clear
php artisan view:clear

# Jika error npm
rm -rf node_modules package-lock.json
npm install

# Jika error composer
composer install
php artisan key:generate
php artisan migrate --seed
```

---

## 📁 File Structure

```
warung-kopi-otomatis/
├── resources/
│   ├── css/
│   │   └── app.css              # Tailwind CSS config
│   ├── js/
│   │   └── app.js               # JavaScript entry
│   └── views/
│       ├── layouts/
│       │   ├── dashboard.blade.php   # ✅ Updated
│       │   └── app.blade.php         # ✅ Updated
│       ├── dashboard/
│       │   └── index.blade.php       # ✅ Updated
│       ├── admin/
│       │   └── products/
│       │       ├── index.blade.php   # ✅ Updated
│       │       └── create.blade.php  # ✅ Updated
│       └── auth/
│           └── login.blade.php       # ✅ Updated
├── public/
│   └── build/                   # Generated assets (auto)
├── package.json                 # NPM dependencies
├── vite.config.js              # Vite configuration
└── tailwind.config.js          # Tailwind config (optional)
```

---

## 🎨 Tailwind Classes Cheat Sheet

### Layout
```html
<!-- Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

<!-- Flex -->
<div class="flex items-center justify-between">
```

### Typography
```html
<!-- Headings -->
<h1 class="text-3xl font-bold text-gray-900">
<h2 class="text-2xl font-bold text-gray-900">
<h3 class="text-xl font-semibold text-gray-900">

<!-- Text -->
<p class="text-sm text-gray-600">
<p class="text-base text-gray-700">
```

### Colors
```html
<!-- Backgrounds -->
bg-blue-600    bg-green-500    bg-amber-500
bg-red-500     bg-gray-900     bg-white

<!-- Text -->
text-blue-600  text-green-500  text-amber-500
text-red-500   text-gray-900   text-white

<!-- Borders -->
border-blue-500  border-gray-300  border-red-500
```

### Spacing
```html
<!-- Padding -->
p-4  p-6  p-8  px-4  py-3

<!-- Margin -->
m-4  m-6  m-8  mx-auto  mb-6

<!-- Space Between -->
space-x-2  space-y-4  gap-6
```

### Buttons
```html
<!-- Primary -->
<button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">

<!-- Secondary -->
<button class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">

<!-- Danger -->
<button class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
```

### Cards
```html
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6">
        <!-- Content -->
    </div>
</div>
```

### Forms
```html
<!-- Input -->
<input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

<!-- Select -->
<select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">

<!-- Textarea -->
<textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
```

### Alerts
```html
<!-- Success -->
<div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
    <p class="text-green-800">Success message</p>
</div>

<!-- Error -->
<div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
    <p class="text-red-800">Error message</p>
</div>
```

### Responsive
```html
<!-- Mobile First -->
<div class="text-sm md:text-base lg:text-lg">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
<div class="hidden md:block">  <!-- Hidden on mobile -->
<div class="block md:hidden">  <!-- Visible only on mobile -->
```

---

## 🎯 Alpine.js Snippets

### Dropdown
```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open" @click.away="open = false">
        Dropdown content
    </div>
</div>
```

### Modal
```html
<div x-data="{ show: false }">
    <button @click="show = true">Open Modal</button>
    <div x-show="show" class="fixed inset-0 bg-black bg-opacity-50">
        <div @click.away="show = false" class="bg-white p-6 rounded-lg">
            Modal content
        </div>
    </div>
</div>
```

### Alert Dismissible
```html
<div x-data="{ show: true }" x-show="show">
    Alert message
    <button @click="show = false">×</button>
</div>
```

---

## 📱 Responsive Breakpoints

| Breakpoint | Min Width | CSS |
|------------|-----------|-----|
| sm | 640px | `sm:text-lg` |
| md | 768px | `md:grid-cols-2` |
| lg | 1024px | `lg:px-8` |
| xl | 1280px | `xl:max-w-7xl` |
| 2xl | 1536px | `2xl:text-6xl` |

---

## 🔥 Tips & Tricks

### 1. Gunakan VS Code Extensions
- **Tailwind CSS IntelliSense** - Autocomplete classes
- **Headwind** - Sort classes automatically
- **Prettier + Tailwind Plugin** - Format code

### 2. Hover & Focus States
```html
<!-- Hover -->
hover:bg-blue-700  hover:scale-105  hover:shadow-lg

<!-- Focus -->
focus:ring-2  focus:ring-blue-500  focus:outline-none

<!-- Active -->
active:scale-95  active:bg-blue-800
```

### 3. Transitions
```html
<!-- Default -->
transition duration-300

<!-- Custom -->
transition-all duration-500 ease-in-out

<!-- Transform -->
transform hover:scale-105 transition
```

### 4. Gradients
```html
<!-- Background -->
bg-gradient-to-r from-blue-500 to-blue-700
bg-gradient-to-br from-amber-500 to-amber-600

<!-- Text -->
bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent
```

### 5. Shadows
```html
shadow-sm   shadow-md   shadow-lg   shadow-xl   shadow-2xl
```

---

## 🆘 Common Issues

### Issue: CSS tidak ter-apply
**Solution:**
```bash
npm run build
php artisan view:clear
```

### Issue: Alpine.js tidak bekerja
**Solution:** Pastikan script ada di layout:
```html
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

### Issue: Vite connection error
**Solution:** Pastikan `npm run dev` berjalan di terminal terpisah

### Issue: Classes tidak autocomplete
**Solution:** Install Tailwind CSS IntelliSense extension

---

## 📚 Learning Resources

- **Tailwind Docs**: https://tailwindcss.com/docs
- **Alpine.js Docs**: https://alpinejs.dev/
- **Tailwind UI**: https://tailwindui.com/ (Premium components)
- **Tailwind Components**: https://tailwindcomponents.com/ (Free)
- **Flowbite**: https://flowbite.com/ (Free components)

---

## ✅ Checklist Deployment

- [ ] Run `npm run build`
- [ ] Run `php artisan optimize`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Test di browser
- [ ] Check responsive (mobile, tablet, desktop)
- [ ] Upload ke server

---

**Happy Coding! ☕**
