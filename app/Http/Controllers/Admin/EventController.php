<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of all events.
     */
    public function index()
    {
        $events = Event::orderBy('event_date', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category'         => 'required|in:nobar,live_music,special_event,promo,tournament,lainnya',
            'description'      => 'nullable|string',
            'event_date'       => 'required|date',
            'event_time_start' => 'required',
            'event_time_end'   => 'nullable',
            'location'         => 'required|string|max:255',
            'poster_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_featured'      => 'boolean',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
        ], [
            'title.required'            => 'Judul event wajib diisi.',
            'category.required'         => 'Kategori event wajib dipilih.',
            'event_date.required'       => 'Tanggal event wajib diisi.',
            'event_time_start.required' => 'Jam mulai event wajib diisi.',
            'location.required'         => 'Lokasi event wajib diisi.',
            'poster_image.image'        => 'File harus berupa gambar.',
            'poster_image.mimes'        => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'poster_image.max'          => 'Ukuran gambar maksimal 5MB.',
            'status.required'           => 'Status event wajib dipilih.',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster_image')) {
            $posterPath = $this->saveImageAsWebp($request->file('poster_image'), 'events');
        }

        Event::create([
            'title'            => $request->title,
            'slug'             => Str::slug($request->title) . '-' . time(),
            'category'         => $request->category,
            'description'      => $request->description,
            'event_date'       => $request->event_date,
            'event_time_start' => $request->event_time_start,
            'event_time_end'   => $request->event_time_end,
            'location'         => $request->location,
            'poster_image'     => $posterPath,
            'is_featured'      => $request->boolean('is_featured'),
            'status'           => $request->status,
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event "' . $request->title . '" berhasil ditambahkan ke agenda!');
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.create', compact('event'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title'            => 'required|string|max:255',
            'category'         => 'required|in:nobar,live_music,special_event,promo,tournament,lainnya',
            'description'      => 'nullable|string',
            'event_date'       => 'required|date',
            'event_time_start' => 'required',
            'event_time_end'   => 'nullable',
            'location'         => 'required|string|max:255',
            'poster_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_featured'      => 'boolean',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $posterPath = $event->poster_image;

        if ($request->hasFile('poster_image')) {
            // Delete old poster
            if ($posterPath && file_exists(public_path($posterPath))) {
                @unlink(public_path($posterPath));
            }
            $posterPath = $this->saveImageAsWebp($request->file('poster_image'), 'events');
        }

        $event->update([
            'title'            => $request->title,
            'slug'             => Str::slug($request->title) . '-' . $event->id,
            'category'         => $request->category,
            'description'      => $request->description,
            'event_date'       => $request->event_date,
            'event_time_start' => $request->event_time_start,
            'event_time_end'   => $request->event_time_end,
            'location'         => $request->location,
            'poster_image'     => $posterPath,
            'is_featured'      => $request->boolean('is_featured'),
            'status'           => $request->status,
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event "' . $request->title . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified event and its poster from disk.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        if ($event->poster_image && file_exists(public_path($event->poster_image))) {
            @unlink(public_path($event->poster_image));
        }

        $title = $event->title;
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event "' . $title . '" berhasil dihapus dari agenda.');
    }

    /**
     * Compress and convert uploaded image to WebP using GD.
     */
    private function saveImageAsWebp($file, string $subDir): string
    {
        $directory = public_path('uploads/' . $subDir);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename  = time() . '_' . uniqid() . '.webp';
        $targetPath = $directory . '/' . $filename;

        $image = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($file->getRealPath()),
            'png'         => @imagecreatefrompng($file->getRealPath()),
            'webp'        => @imagecreatefromwebp($file->getRealPath()),
            default       => false,
        };

        if ($image !== false) {
            imagewebp($image, $targetPath, 82);
            imagedestroy($image);
            return 'uploads/' . $subDir . '/' . $filename;
        }

        // Fallback: save raw
        $rawName = time() . '_' . uniqid() . '.' . $extension;
        $file->move($directory, $rawName);
        return 'uploads/' . $subDir . '/' . $rawName;
    }
}
