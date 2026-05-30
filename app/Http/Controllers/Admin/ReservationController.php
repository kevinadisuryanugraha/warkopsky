<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    /**
     * Display a listing of bookings (reservations) with paginated filters or export streams.
     */
    public function index(Request $request)
    {
        // Check if user requested a CSV download
        if ($request->get('export') === 'csv') {
            return $this->exportToCsv($request);
        }

        $status = $request->get('status');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');

        $reservations = Reservation::when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when($startDate, function ($query) use ($startDate) {
            $query->whereDate('reservation_date', '>=', $startDate);
        })
        ->when($endDate, function ($query) use ($endDate) {
            $query->whereDate('reservation_date', '<=', $endDate);
        })
        ->orderBy('reservation_date', 'desc')
        ->orderBy('reservation_time', 'desc')
        ->get();

        return view('admin.reservations.index', compact('reservations', 'status', 'startDate', 'endDate'));
    }

    /**
     * Update reservation status (approve or cancel).
     */
    public function updateStatus(Request $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $oldStatus = $reservation->status;
        $newStatus = $request->status;

        $reservation->update([
            'status' => $newStatus,
        ]);

        $message = 'Status reservasi Kak "' . $reservation->name . '" berhasil ';
        if ($newStatus === 'confirmed') {
            $message .= 'disetujui (CONFIRMED)!';
        } elseif ($newStatus === 'cancelled') {
            $message .= 'dibatalkan (CANCELLED).';
        } else {
            $message .= 'dikembalikan ke status TERTUNDA.';
        }

        return redirect()->route('admin.reservations.index', ['status' => $oldStatus])
            ->with('success', $message);
    }

    /**
     * Delete reservation record permanently.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $name = $reservation->name;
        $oldStatus = $reservation->status;
        
        $reservation->delete();

        return redirect()->route('admin.reservations.index', ['status' => $oldStatus])
            ->with('success', 'Reservasi Kak "' . $name . '" berhasil dihapus dari arsip.');
    }

    /**
     * Export dynamic CSV stream matching current applied filters.
     */
    private function exportToCsv(Request $request)
    {
        $status = $request->get('status');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $search = $request->get('search');

        $query = Reservation::when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when($startDate, function ($query) use ($startDate) {
            $query->whereDate('reservation_date', '>=', $startDate);
        })
        ->when($endDate, function ($query) use ($endDate) {
            $query->whereDate('reservation_date', '<=', $endDate);
        })
        ->when($search, function ($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('reservation_date', 'desc')
        ->orderBy('reservation_time', 'desc');

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reservasi-warkopsky-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($query) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM injection for Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Header Row
            fputcsv($file, [
                'ID', 'Nama Tamu', 'Nomor WA', 'Cabang', 'Pax', 
                'Tanggal Reservasi', 'Jam Reservasi', 'Catatan Tambahan', 
                'Status', 'Waktu Masuk'
            ]);

            // Memory-safe chunked execution
            $query->chunk(100, function($reservations) use ($file) {
                foreach ($reservations as $res) {
                    fputcsv($file, [
                        $res->id,
                        $res->name,
                        $res->phone,
                        $res->branch,
                        $res->pax,
                        $res->reservation_date,
                        $res->reservation_time,
                        $res->note ?? '-',
                        strtoupper($res->status),
                        $res->created_at->format('Y-m-d H:i')
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
