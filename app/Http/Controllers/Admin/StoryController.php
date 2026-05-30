<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerStory;

class StoryController extends Controller
{
    /**
     * Display a listing of customer stories with status filters and search query.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $stories = CustomerStory::when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.stories.index', compact('stories', 'status'));
    }

    /**
     * Update the moderation status of a specific story.
     */
    public function updateStatus(Request $request, string $id)
    {
        $story = CustomerStory::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $oldStatus = $story->status;
        $newStatus = $request->status;

        $story->update([
            'status' => $newStatus,
        ]);

        $author = $story->author;
        
        $message = 'Ulasan dari "' . $author . '" berhasil ';
        if ($newStatus === 'approved') {
            $message .= 'disetujui dan kini tampil di website!';
        } elseif ($newStatus === 'rejected') {
            $message .= 'ditolak.';
        } else {
            $message .= 'dikembalikan ke status tertunda.';
        }

        return redirect()->route('admin.stories.index', ['status' => $oldStatus])
            ->with('success', $message);
    }

    /**
     * Remove the story from database and disk.
     */
    public function destroy(string $id)
    {
        $story = CustomerStory::findOrFail($id);

        // Delete physical media file if exists
        if ($story->media_path && file_exists(public_path($story->media_path))) {
            @unlink(public_path($story->media_path));
        }

        $author = $story->author;
        $oldStatus = $story->status;
        
        $story->delete();

        return redirect()->route('admin.stories.index', ['status' => $oldStatus])
            ->with('success', 'Ulasan dari "' . $author . '" berhasil dihapus secara permanen.');
    }
}
