<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryItem;
use App\Models\GalleryCategory;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery photos with search, category filtering, and pagination.
     */
    public function index(Request $request)
    {
        $categories = GalleryCategory::orderBy('sort_order')->get();

        $items = GalleryItem::with('category')
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
            })
            ->when($request->category, function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.gallery.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new gallery photo.
     */
    public function create()
    {
        $categories = GalleryCategory::orderBy('sort_order')->get();
        return view('admin.gallery.create', compact('categories'));
    }

    /**
     * Store a newly created gallery photo in database and convert to WebP.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:gallery_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ], [
            'category_id.required' => 'Kategori foto wajib dipilih.',
            'category_id.exists' => 'Kategori foto tidak valid.',
            'title.required' => 'Judul/keterangan singkat foto wajib diisi.',
            'image.required' => 'File foto wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, webp, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $imagePath = $this->saveImageAndConvertToWebp($request->file('image'), 'gallery');

        GalleryItem::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto baru "' . $request->title . '" berhasil dipajang di galeri!');
    }

    /**
     * Remove the specified gallery item from database and disk.
     */
    public function destroy(string $id)
    {
        $item = GalleryItem::findOrFail($id);

        // Delete physical file
        if ($item->image_path && file_exists(public_path($item->image_path))) {
            @unlink(public_path($item->image_path));
        }

        $title = $item->title;
        $item->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Foto "' . $title . '" berhasil dilepas dari bingkai galeri.');
    }

    /**
     * Display a listing of gallery categories with creation form.
     */
    public function categoriesIndex(Request $request)
    {
        $categories = GalleryCategory::orderBy('sort_order')->get();

        return view('admin.gallery.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new gallery category.
     */
    public function categoriesCreate()
    {
        $categories = GalleryCategory::orderBy('sort_order')->get();
        return view('admin.gallery.create_category', compact('categories'));
    }

    /**
     * Create a new gallery category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:gallery_categories,name',
            'sort_order' => 'required|integer|min:0',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'sort_order.required' => 'Urutan tampil wajib diisi.',
        ]);

        GalleryCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.gallery.categories.index')
            ->with('success', 'Kategori galeri "' . $request->name . '" berhasil dibuat!');
    }

    /**
     * Delete gallery category.
     */
    public function destroyCategory(string $id)
    {
        $category = GalleryCategory::findOrFail($id);

        if ($category->items()->count() > 0) {
            return redirect()->route('admin.gallery.categories.index')
                ->with('error', 'Kategori "' . $category->name . '" tidak bisa dihapus karena masih memuat foto aktif.');
        }

        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.gallery.categories.index')
            ->with('success', 'Kategori galeri "' . $name . '" berhasil dihapus.');
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
