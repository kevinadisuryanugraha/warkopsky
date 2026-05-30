<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\MenuCategory;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Display a listing of menu items with pagination, search, and category filters.
     */
    public function index(Request $request)
    {
        $categories = MenuCategory::orderBy('sort_order')->get();

        $items = MenuItem::with('category')
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->get();

        return view('admin.menu.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        $categories = MenuCategory::orderBy('sort_order')->get();
        return view('admin.menu.create', compact('categories'));
    }

    /**
     * Store a newly created menu item in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
            'sort_order' => 'required|integer|min:0',
        ], [
            'category_id.required' => 'Kategori menu wajib dipilih.',
            'category_id.exists' => 'Kategori menu tidak valid.',
            'name.required' => 'Nama menu wajib diisi.',
            'price.required' => 'Harga menu wajib diisi.',
            'price.numeric' => 'Harga menu harus berupa angka.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, webp, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 3MB.',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->saveImageAndConvertToWebp($request->file('image'), 'menu');
        }

        MenuItem::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
            'is_available' => $request->has('is_available'),
            'is_favorite' => $request->has('is_favorite'),
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu baru "' . $request->name . '" berhasil ditambahkan ke kabin kuliner!');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(string $id)
    {
        $item = MenuItem::findOrFail($id);
        $categories = MenuCategory::orderBy('sort_order')->get();
        return view('admin.menu.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified menu item in database.
     */
    public function update(Request $request, string $id)
    {
        $item = MenuItem::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:3072',
            'sort_order' => 'required|integer|min:0',
        ], [
            'category_id.required' => 'Kategori menu wajib dipilih.',
            'name.required' => 'Nama menu wajib diisi.',
            'price.required' => 'Harga menu wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 3MB.',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
        ]);

        $imagePath = $item->image_path;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image_path && file_exists(public_path($item->image_path))) {
                @unlink(public_path($item->image_path));
            }
            $imagePath = $this->saveImageAndConvertToWebp($request->file('image'), 'menu');
        }

        $item->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
            'is_available' => $request->has('is_available'),
            'is_favorite' => $request->has('is_favorite'),
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu "' . $request->name . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified menu item from database and disk.
     */
    public function destroy(string $id)
    {
        $item = MenuItem::findOrFail($id);

        // Delete physical file
        if ($item->image_path && file_exists(public_path($item->image_path))) {
            @unlink(public_path($item->image_path));
        }

        $itemName = $item->name;
        $item->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu "' . $itemName . '" berhasil dihapus dari piring saji.');
    }

    /**
     * Display a listing of menu categories with creation form.
     */
    public function categoriesIndex(Request $request)
    {
        $categories = MenuCategory::orderBy('sort_order')->get();

        return view('admin.menu.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new menu category.
     */
    public function categoriesCreate()
    {
        $categories = MenuCategory::orderBy('sort_order')->get();
        return view('admin.menu.create_category', compact('categories'));
    }

    /**
     * Create a new category from menu list view.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:menu_categories,name',
            'column_position' => 'required|in:left,right',
            'sort_order' => 'required|integer|min:0',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah terdaftar.',
            'column_position.required' => 'Posisi kolom wajib dipilih.',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
        ]);

        MenuCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'column_position' => $request->column_position,
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.menu.categories.index')
            ->with('success', 'Kategori "' . $request->name . '" berhasil ditambahkan!');
    }

    /**
     * Remove menu category.
     */
    public function destroyCategory(string $id)
    {
        $category = MenuCategory::findOrFail($id);

        if ($category->items()->count() > 0) {
            return redirect()->route('admin.menu.categories.index')
                ->with('error', 'Kategori "' . $category->name . '" tidak bisa dihapus karena masih memiliki item menu aktif.');
        }

        $catName = $category->name;
        $category->delete();

        return redirect()->route('admin.menu.categories.index')
            ->with('success', 'Kategori "' . $catName . '" berhasil disingkirkan.');
    }

    /**
     * Private helper to compress and convert images to WebP via GD.
     */
    private function saveImageAndConvertToWebp($file, $subDir)
    {
        $directory = public_path('uploads/' . $subDir);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = time() . '_' . uniqid() . '.webp';
        $targetPath = $directory . '/' . $filename;

        // Load original image based on its type
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image = @imagecreatefromjpeg($file->getRealPath());
                break;
            case 'png':
                $image = @imagecreatefrompng($file->getRealPath());
                break;
            case 'webp':
                $image = @imagecreatefromwebp($file->getRealPath());
                break;
            case 'gif':
                $image = @imagecreatefromgif($file->getRealPath());
                break;
            default:
                $image = false;
                break;
        }

        if ($image !== false) {
            // Output as optimized WebP with quality 80
            imagewebp($image, $targetPath, 80);
            imagedestroy($image);
            return 'uploads/' . $subDir . '/' . $filename;
        }

        // Failsafe fallback: just save the raw file
        $rawFilename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $rawFilename);
        return 'uploads/' . $subDir . '/' . $rawFilename;
    }
}
