<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
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

        $apiKey = env('CALENDARIFIC_API_KEY');
        $country = 'ID';
        $url = "https://calendarific.com/api/v2/holidays?api_key={$apiKey}&country={$country}&year={$year}";

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            $translationMap = [
                "New Year's Day" => "Tahun Baru Masehi",
                "Good Friday" => "Wafat Yesus Kristus",
                "International Workers' Day" => "Hari Buruh Internasional",
                "Ascension Day of Jesus Christ" => "Kenaikan Yesus Kristus",
                "Joint Holiday after Ascension Day" => "Cuti Bersama Kenaikan Yesus Kristus",
                "Vesak Day" => "Hari Raya Waisak",
                "Pancasila Day" => "Hari Lahir Pancasila",
                "Idul Adha" => "Hari Raya Idul Adha",
                "Joint Holiday for Idul Adha" => "Cuti Bersama Hari Raya Idul Adha",
                "Ascension of the Prophet Muhammad" => "Isra Mi'raj Nabi Muhammad SAW",
                "Chinese New Year Joint Holiday" => "Cuti Bersama Tahun Baru Imlek",
                "Chinese New Year's Day" => "Tahun Baru Imlek",
                "Ramadan Start" => "Awal Bulan Ramadhan",
                "Joint Holiday for Bali's Day of Silence and Hindu New Year (Nyepi)" => "Cuti Bersama Hari Suci Nyepi (Tahun Baru Saka)",
                "Bali's Day of Silence and Hindu New Year (Nyepi)" => "Hari Suci Nyepi (Tahun Baru Saka)",
                "Idul Fitri" => "Hari Raya IdulFitri",
                "Idul Fitri Holiday" => "Hari Raya IdulFitri",
                "Idul Fitri Joint Holiday" => "Cuti Bersama Hari Raya IdulFitri",
                "Easter Sunday" => "Hari Paskah",
                "International Labor Day" => "Hari Buruh Internasional",
                "Waisak Day (Buddha's Anniversary)" => "Hari Raya Waisak",
                "Joint Holiday for Waisak Day" => "Cuti Bersama Hari Raya Waisak",
                "Muharram / Islamic New Year" => "Satu Muharram/Tahun Baru Hijriah",
                "Indonesian Independence Day" => "Hari Proklamasi Kemerdekaan Republik Indonesia",
                "Maulid Nabi Muhammad (The Prophet Muhammad's Birthday)" => "Maulid Nabi Muhammad SAW",
                "Christmas Eve" => "Malam Natal",
                "Christmas Day" => "Hari Raya Natal",
                "Boxing Day" => "Cuti Bersama Natal",
                "New Year's Eve" => "Malam Tahun Baru",
            ];

            if (isset($data['response']['holidays'])) {
                $holidays = [];
                foreach ($data['response']['holidays'] as $holiday) {
                    $hinduHolidays = ["Maha Shivaratri", "Holi", "Raksha Bandhan", "Janmashtami", "Ganesh Chaturthi", "Navaratri", "Dussehra", "Diwali"];
                    if (in_array($holiday['name'], $hinduHolidays)) {
                        continue;
                    }
                    $name = $holiday['name'];
                    if (isset($translationMap[$name])) {
                        $name = $translationMap[$name];
                    }
                    $holidays[] = [
                        'date' => $holiday['date']['iso'],
                        'name' => $name,
                    ];
                }
                return response()->json($holidays);
            } else {
                return response()->json(['error' => 'No holidays found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching holidays: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch holidays'], 500);
        }
    }

    // public function getNationalHolidays(Request $request)
    // {
    //     $year = $request->query('year');
    //     if (!$year) {
    //         return response()->json(['error' => 'Year parameter is required'], 400);
    //     }

    //     $apiKey = env('KALENDERINDONESIA_API_KEY');
    //     $url = "https://kalenderindonesia.com/api/{$apiKey}/libur/masehi/{$year}";

    //     try {
    //         $client = new \GuzzleHttp\Client();
    //         $response = $client->get($url);
    //         $data = json_decode($response->getBody(), true);

    //         if (isset($data['data']) && is_array($data['data'])) {
    //             $holidays = [];

    //             foreach ($data['data'] as $holiday) {
    //                 $holidays[] = [
    //                     'date' => $holiday['tanggal'],
    //                     'name' => $holiday['keterangan'],
    //                 ];
    //             }

    //             return response()->json($holidays);
    //         } else {
    //             return response()->json(['error' => 'No holidays found'], 404);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching holidays: ' . $e->getMessage());
    //         return response()->json(['error' => 'Failed to fetch holidays'], 500);
    //     }
    // }

    // public function getNationalHolidays(Request $request)
    // {
    //     $year = $request->query('year');
    //     if (!$year) {
    //         return response()->json(['error' => 'Year parameter is required'], 400);
    //     }

    //     $apiKey = env('KALENDERINDONESIA_API_KEY');
    //     $url = "https://kalenderindonesia.com/api/{$apiKey}/libur/masehi/{$year}";

    //     try {
    //         $client = new \GuzzleHttp\Client();
    //         $response = $client->get($url);
    //         $data = json_decode($response->getBody(), true);

    //         if (isset($data['data']) && is_array($data['data'])) {
    //             $holidays = [];

    //             foreach ($data['data'] as $holiday) {
    //                 $holidays[] = [
    //                     'date' => $holiday['tanggal'],
    //                     'name' => $holiday['keterangan'],
    //                 ];
    //             }

    //             return response()->json($holidays);
    //         } else {
    //             return response()->json(['error' => 'No holidays found'], 404);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching holidays from KalenderIndonesia: ' . $e->getMessage());
    //         return response()->json(['error' => 'Failed to fetch holidays'], 500);
    //     }
    // }


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

        Agenda::create([
            'date' => $request->date,
            'jam' => $request->jam,
            'title' => $request->title,
            'description' => $request->description,
            'tempat' => $request->tempat,
            'status' => $request->status,
            'disposition' => $request->disposition,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('new')->with('success', 'Agenda berhasil disimpan!');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->back()->with('success', 'Agenda berhasil dihapus.');
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
        $allowedStatuses = ['draft', 'tentative', 'confirmed', 'cancel'];
        if (!in_array(strtolower($status), $allowedStatuses)) {
            abort(404);
        }

        $agendas = Agenda::whereRaw("LOWER(status) = ?", [strtolower($status)])->get();

        $viewName = $status === 'confirmed' ? 'confirm' : $status;
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
        \Log::info('Reschedule Request Data:', $request->all());

        $request->validate([
            'tanggal_reschedule' => 'required|date',
            'status' => 'required',
            'jam' => 'required',
            'kegiatan' => 'required',
            'keterangan' => 'required',
            'tempat' => 'required',
        ]);

        $agendaId = $request->input('agenda_id');
        $agenda = Agenda::findOrFail($agendaId);
        $agenda->update([
            'date' => $request->tanggal_reschedule,
            'status' => 'reschedule',
        ]);;

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil di-reschedule!');
    }

    public function confirm()
    {
        $agendas = Agenda::where('status', 'confirmed')->get();
        return view('agenda.confirm', compact('agendas'));
    }

    public function cancel()
    {
        $agendas = Agenda::where('status', 'cancel')->get();
        return view('agenda.cancel', compact('agendas'));
    }

    // app/Http/Controllers/AgendaController.php

    public function dashboard()
    {
        // Tentukan rentang waktu satu bulan (dari awal hingga akhir bulan ini)
        $startDate = \Carbon\Carbon::now()->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();

        // Hitung jumlah agenda untuk setiap status dalam rentang waktu tersebut
        $draftCount = Agenda::where('status', "draft")->whereBetween('date', [$startDate, $endDate])->count();
        $tentativeCount = Agenda::where('status', "tentative")->whereBetween('date', [$startDate, $endDate])->count();
        $cancelCount = Agenda::where('status', "cancel")->whereBetween('date', [$startDate, $endDate])->count();
        $confirmCount = Agenda::where('status', "confirmed")->whereBetween('date', [$startDate, $endDate])->count();
        $rescheduleCount = Agenda::where('status', 'reschedule')->whereBetween('date', [$startDate, $endDate])->count();

        $logs = [];
        if (class_exists(\App\Models\LogActivity::class)) {
            $logs = \App\Models\LogActivity::latest()->limit(10)->get();
        }

        return view('dashboard', compact(
            'draftCount',
            'tentativeCount',
            'cancelCount',
            'confirmCount',
            'rescheduleCount',
            'logs'
        ));
    }
}
