# Migrasi ke Tailwind CSS

Aplikasi Warung Kopi Otomatis telah diubah dari Bootstrap 5 ke Tailwind CSS v4 untuk tampilan yang lebih modern dan customizable.

## Perubahan yang Dilakukan

### 1. **Setup Tailwind CSS**
- ✅ Tailwind CSS v4 sudah terinstall di `package.json`
- ✅ Konfigurasi Vite sudah include `@tailwindcss/vite` plugin
- ✅ File `resources/css/app.css` sudah dikonfigurasi dengan Tailwind

### 2. **Layout Dashboard** (`resources/views/layouts/dashboard.blade.php`)
- ✅ Navbar modern dengan dropdown menggunakan Alpine.js
- ✅ Mobile responsive dengan hamburger menu
- ✅ Alert notifications dengan animasi
- ✅ Real-time Pusher notifications dengan styling Tailwind

### 3. **Dashboard Index** (`resources/views/dashboard/index.blade.php`)
- ✅ Stats cards dengan gradient background
- ✅ Hover effects dan transitions
- ✅ Quick menu dengan icon cards

### 4. **Products Pages**
- ✅ **Index**: Modern table dengan hover effects
- ✅ **Create**: Form dengan file upload dropzone
- ✅ **Edit**: (Perlu diupdate - lihat contoh create)

### 5. **Dependencies**
- Alpine.js v3 (untuk interaktivity)
- Tailwind CSS v4
- Bootstrap Icons (tetap digunakan untuk icons)

## Cara Menjalankan

### 1. Install Dependencies
```bash
npm install
```

### 2. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 3. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000` atau `http://warung-kopi-otomatis.test`

## Fitur Tailwind yang Digunakan

### Color Palette
- **Primary**: Blue (600-700)
- **Success**: Green (500-600)
- **Warning**: Amber (500-600)
- **Danger**: Red (500-600)
- **Dark**: Gray (800-900)

### Components
- **Cards**: `rounded-xl shadow-md`
- **Buttons**: `rounded-lg shadow-md transition duration-300`
- **Forms**: `rounded-lg focus:ring-2 focus:ring-blue-500`
- **Tables**: `divide-y divide-gray-200`

### Responsive Breakpoints
- **sm**: 640px
- **md**: 768px
- **lg**: 1024px
- **xl**: 1280px

## View yang Sudah Diupdate

- ✅ `layouts/dashboard.blade.php`
- ✅ `dashboard/index.blade.php`
- ✅ `admin/products/index.blade.php`
- ✅ `admin/products/create.blade.php`

## View yang Perlu Diupdate

Untuk konsistensi, update view berikut dengan pattern yang sama:

- [ ] `admin/products/edit.blade.php`
- [ ] `admin/categories/index.blade.php`
- [ ] `admin/categories/create.blade.php`
- [ ] `admin/categories/edit.blade.php`
- [ ] `admin/users/index.blade.php`
- [ ] `admin/users/create.blade.php`
- [ ] `admin/users/edit.blade.php`
- [ ] `admin/orders/index.blade.php`
- [ ] `admin/orders/show.blade.php`
- [ ] `admin/reports/index.blade.php`
- [ ] `auth/login.blade.php`
- [ ] `home.blade.php`
- [ ] `payment.blade.php`

## Pattern untuk Update View Lainnya

### Header Section
```blade
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
        <i class="bi bi-icon-name text-color mr-3"></i>
        Page Title
    </h1>
</div>
```

### Button Primary
```blade
<a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300 flex items-center space-x-2">
    <i class="bi bi-icon"></i>
    <span>Button Text</span>
</a>
```

### Card
```blade
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6">
        <!-- Content -->
    </div>
</div>
```

### Table
```blade
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Header</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Data</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

### Form Input
```blade
<div class="mb-6">
    <label for="field" class="block text-sm font-medium text-gray-700 mb-2">
        Label <span class="text-red-500">*</span>
    </label>
    <input type="text" id="field" name="field" required
           class="w-full px-4 py-2 border @error('field') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
           placeholder="Placeholder">
    @error('field')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
```

## Alpine.js Directives

### Dropdown
```blade
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open" @click.away="open = false">
        Dropdown content
    </div>
</div>
```

### Alert Dismissible
```blade
<div x-data="{ show: true }" x-show="show">
    <button @click="show = false">Close</button>
</div>
```

## Tips

1. **Gunakan Tailwind IntelliSense** extension di VS Code untuk autocomplete
2. **Konsisten dengan spacing**: gunakan `mb-6` untuk margin bottom antar section
3. **Hover effects**: tambahkan `hover:` prefix untuk interactive elements
4. **Transitions**: gunakan `transition duration-300` untuk smooth animations
5. **Responsive**: gunakan `md:` prefix untuk desktop layout

## Troubleshooting

### CSS tidak muncul
```bash
npm run build
php artisan optimize:clear
```

### Alpine.js tidak bekerja
Pastikan script Alpine.js ada di layout:
```html
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

### Tailwind classes tidak ter-apply
Pastikan file ada di `@source` di `app.css`:
```css
@source '../**/*.blade.php';
```

## Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
