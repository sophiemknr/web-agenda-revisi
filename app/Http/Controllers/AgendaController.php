<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogActivity;

class AgendaController extends Controller
{

    public function laporanPdf(Request $request)
    {
        $query = Agenda::with('user')->orderBy('date', 'desc');
        if ($request->filled('tanggal_awal')) {
            $query->where('date', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->where('date', '<=', $request->tanggal_akhir);
        }
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        $agendas = $query->get();

        // TCPDF logic
        require_once(base_path('vendor/tecnickcom/tcpdf/tcpdf.php'));
        $pdf = new \TCPDF();
        $pdf->SetCreator('webagendawalkot');
        $pdf->SetAuthor('webagendawalkot');
        $pdf->SetTitle('Laporan Agenda');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        $html = view('laporan_pdf', compact('agendas'))->render();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('laporan_agenda_' . now()->format('Ymd_His') . '.pdf', 'I');
        exit;
    }
    use LogActivity;
    use LogActivity;

    public function create()
    {
        return view('new');
    }

    public function getNationalHolidays(Request $request)
    {
        $year = $request->query('year');
        if (!$year) {
            return response()->json(['error' => 'Year parameter is required'], 400);
        }

        $url = "https://api-harilibur.vercel.app/api?year={$year}";

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            $holidays = [];
            foreach ($data as $holiday) {
                $holidays[] = [
                    'date' => $holiday['holiday_date'],
                    'name' => $holiday['holiday_name'],
                ];
            }
            return response()->json($holidays);
        } catch (\Exception $e) {
            Log::error('Error fetching holidays: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch holidays'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'jam' => 'required',
            'title' => 'required',
            'description' => 'required',
            'tempat' => 'required',
            'status' => 'required',
            'disposition' => 'required',
        ]);

        $agenda = Agenda::create([
            'date' => $request->date,
            'jam' => $request->jam,
            'title' => $request->title,
            'description' => $request->description,
            'tempat' => $request->tempat,
            'status' => $request->status,
            'disposition' => $request->disposition,
            'user_id' => Auth::id(),
        ]);

        // Mencatat aktivitas
        $this->addToLog('Menambahkan agenda baru: ' . $agenda->title);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil disimpan!');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('agenda.edit', compact('agenda'));
    }

    /**
     * Memperbarui data agenda di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'jam' => 'required',
            'title' => 'required',
            'description' => 'required',
            'tempat' => 'required',
            'status' => 'required',
            'disposition' => 'required',
        ]);

        $agenda = Agenda::findOrFail($id);
        $agenda->update($request->all());

        $this->addToLog('Memperbarui agenda: ' . $agenda->title);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Menghapus agenda.
     * Modifikasi: Mengembalikan respons JSON.
     */
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $title = $agenda->title; // Simpan judul untuk log

        $agenda->delete();

        $this->addToLog('Menghapus agenda: ' . $title);

        // PENTING: Kembalikan respons JSON, bukan redirect.
        return response()->json(['success' => 'Agenda berhasil dihapus.']);
    }

    public function getAgendaDatesForMonth(Request $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');

        if (!$year || !$month) {
            return response()->json(['error' => 'Year and month are required'], 400);
        }

        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $dates = Agenda::whereBetween('date', [$startDate, $endDate])
            ->pluck('date')
            ->unique()
            ->values();

        return response()->json($dates);
    }

    public function getAgendasByDate($date)
    {
        $agendas = Agenda::with('user')
            ->whereDate('date', $date)
            ->orderBy('jam')
            ->get();

        return response()->json($agendas);
    }

    public function showByStatus($status)
    {
        $allowedStatuses = ['draft', 'tentative', 'confirm', 'cancel'];
        if (!in_array(strtolower($status), $allowedStatuses)) {
            abort(404);
        }

        $agendas = Agenda::whereRaw("LOWER(status) = ?", [strtolower($status)])->get();

        $viewName = $status === 'confirm' ? 'confirm' : $status;
        return view("agenda.$viewName", compact('agendas', 'status'));
    }

    public function index()
    {
        $agendas = Agenda::all();
        return view('agenda.index', compact('agendas'));
    }

    public function draft()
    {
        $agendas = Agenda::where('status', 'draft')->get();
        return view('agenda.draft', compact('agendas'));
    }

    public function tentative()
    {
        $agendas = Agenda::where('status', 'tentative')->get();
        return view('agenda.tentative', compact('agendas'));
    }

    public function showRescheduleForm($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('reschedule', compact('agenda'));
    }

    public function reschedule(Request $request)
    {

        $request->validate([
            'tanggal_reschedule' => 'required|date',
            'status' => 'required',
        ]);

        $agendaId = $request->input('agenda_id');
        $agenda = Agenda::findOrFail($agendaId);
        $agenda->update([
            'date' => $request->tanggal_reschedule,
            'status' => 'reschedule',
        ]);;

        // Mencatat aktivitas
        $this->addToLog('Merubah jadwal agenda: ' . $agenda->title);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil di-reschedule!');
    }

    public function confirm()
    {
        $agendas = Agenda::where('status', 'confirm')->get();
        return view('agenda.confirm', compact('agendas'));
    }

    public function cancel()
    {
        $agendas = Agenda::where('status', 'cancel')->get();
        return view('agenda.cancel', compact('agendas'));
    }

    public function dashboard()
    {
        $startDate = \Carbon\Carbon::now()->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();

        $draftCount = Agenda::where('status', "draft")->whereBetween('date', [$startDate, $endDate])->count();
        $tentativeCount = Agenda::where('status', "tentative")->whereBetween('date', [$startDate, $endDate])->count();
        $cancelCount = Agenda::where('status', "cancel")->whereBetween('date', [$startDate, $endDate])->count();
        $confirmCount = Agenda::where('status', "confirm")->whereBetween('date', [$startDate, $endDate])->count();
        $rescheduleCount = Agenda::where('status', 'reschedule')->whereBetween('date', [$startDate, $endDate])->count();

        // Log Activity: Pagination, Search, Show Entries
        $show = (int) request()->input('log_show', 10);
        $search = request()->input('log_search', '');
        $logQuery = \App\Models\LogActivity::with('user')->latest();
        if ($search) {
            $logQuery->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%$search%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    });
            });
        }
        $logs = $logQuery->paginate($show)->appends(['log_search' => $search, 'log_show' => $show]);

        return view('dashboard', compact(
            'draftCount',
            'tentativeCount',
            'cancelCount',
            'confirmCount',
            'rescheduleCount',
            'logs',
            'show',
            'search'
        ));
    }

    public function laporan(Request $request)
    {
        $query = Agenda::with('user')->orderBy('date', 'desc');

        // Search
        $search = $request->input('log_search', '');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('tempat', 'like', "%$search%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%$search%");
                    });
            });
        }

        // Show entries per page
        $show = (int) $request->input('log_show', 10);
        if (!in_array($show, [5, 10, 25, 50, 100])) $show = 10;

        if ($request->filled('tanggal_awal')) {
            $query->where('date', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->where('date', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $agendas = $query->paginate($show)->appends($request->except('page'));

        return view('laporan', compact('agendas', 'show', 'search'));
    }

    public function getAgendasForMonth(Request $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');

        if (!$year || !$month) {
            return response()->json(['error' => 'Parameter tahun dan bulan dibutuhkan'], 400);
        }

        $agendas = Agenda::with('user')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->orderBy('jam', 'asc')
            ->get();

        return response()->json($agendas);
    }
}
