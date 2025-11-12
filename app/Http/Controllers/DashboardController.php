<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now       = Carbon::now();
        $today     = $now->copy()->startOfDay();
        $weekStart = $now->copy()->startOfWeek();
        $monthStart= $now->copy()->startOfMonth();

        $name     = auth()->user()->first_name ?? auth()->user()->name ?? 'Agent';
        $hour     = (int) $now->format('H');
        $greeting = $hour < 12 ? "Good morning, {$name} 👋"
                 : ($hour < 18 ? "Good afternoon, {$name} 👋"
                               : "Good evening, {$name} 👋");

        // production totals
        $daily   = Activity::sumRange($today, $now);
        $weekly  = Activity::sumRange($weekStart, $now);
        $monthly = Activity::sumRange($monthStart, $now);

        // upcoming appointments (next 14 days)
        $appointments = Appointment::where('starts_at', '>=', $now)
            ->orderBy('starts_at')
            ->limit(5)
            ->get(['id','client_name','starts_at']);

        // insights (next 10 days)
        $inTenDays = $now->copy()->addDays(10);
        $birthdays = Client::upcomingDate('dob', $now, 10)
            ->limit(5)->get(['id','first_name','last_name','dob']);

        $anniversaries = Client::upcomingDate('anniversary_date', $now, 10)
            ->limit(5)->get(['id','first_name','last_name','anniversary_date']);

        // recently added
        $recentClients = Client::latest()->limit(5)->get(['id','first_name','last_name','created_at']);
        $recentLeads   = Lead::latest()->limit(5)->get(['id','first_name','last_name','created_at']);

        return view('dashboard', compact(
            'greeting', 'daily', 'weekly', 'monthly',
            'appointments', 'birthdays', 'anniversaries',
            'recentClients', 'recentLeads', 'now'
        ));
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->get('q'));
        if ($q === '') {
            return redirect()->route('dashboard');
        }

        // very basic search across clients & leads
        $clients = Client::whereRaw("concat_ws(' ', first_name, last_name) ILIKE ?", ["%{$q}%"])
            ->orWhere('email', 'ILIKE', "%{$q}%")
            ->orWhere('phone', 'ILIKE', "%{$q}%")
            ->limit(20)->get(['id','first_name','last_name','email','phone']);

        $leads = Lead::whereRaw("concat_ws(' ', first_name, last_name) ILIKE ?", ["%{$q}%"])
            ->orWhere('email', 'ILIKE', "%{$q}%")
            ->orWhere('phone', 'ILIKE', "%{$q}%")
            ->limit(20)->get(['id','first_name','last_name','email','phone']);

        return view('stubs.search', compact('q','clients','leads'));
    }
}
