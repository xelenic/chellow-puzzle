<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function checkAuth()
    {
        return session('admin_auth') === true;
    }

    public function loginForm()
    {
        if ($this->checkAuth()) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required']);

        $correct = env('ADMIN_PASSWORD', 'admin123');

        if ($request->password === $correct) {
            session(['admin_auth' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Incorrect password. Please try again.']);
    }

    public function logout()
    {
        session()->forget('admin_auth');
        return redirect()->route('admin.login');
    }

    public function dashboard(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $query = Player::latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('phone', 'like', "%$s%"));
        }

        if ($request->filled('result')) {
            $request->result === 'playing'
                ? $query->whereNull('result')
                : $query->where('result', $request->result);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $players = $query->paginate(15)->withQueryString();

        $stats = [
            'total'    => Player::count(),
            'wins'     => Player::where('result', 'win')->count(),
            'timeouts' => Player::where('result', 'timeout')->count(),
            'playing'  => Player::whereNull('result')->count(),
            'today'    => Player::whereDate('created_at', today())->count(),
        ];

        return view('admin.dashboard', compact('players', 'stats'));
    }
}
