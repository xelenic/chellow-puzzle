<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard — Chellow Puzzle</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{background:#f0f9ff;font-family:'Inter',sans-serif;color:#0c4a6e;min-height:100vh;}

/* ── Navbar ── */
.navbar{
    background:#fff;border-bottom:1px solid rgba(14,165,233,.15);
    height:68px;display:flex;align-items:center;justify-content:space-between;
    padding:0 36px;position:sticky;top:0;z-index:100;
    box-shadow:0 2px 12px rgba(14,165,233,.08);
}
.nav-brand{display:flex;align-items:center;gap:14px;}
.nav-brand img{height:42px;object-fit:contain;}
.nav-brand-text{font-size:18px;font-weight:700;color:#0c4a6e;}
.nav-brand-text span{color:#0ea5e9;}
.nav-right{display:flex;align-items:center;gap:16px;}
.nav-badge{
    background:rgba(14,165,233,.1);color:#0369a1;
    padding:5px 14px;border-radius:20px;font-size:13px;font-weight:600;
    border:1px solid rgba(14,165,233,.2);
}
.btn-logout{
    height:38px;padding:0 18px;border-radius:10px;border:1.5px solid rgba(239,68,68,.25);
    background:rgba(239,68,68,.06);color:#dc2626;font-size:13px;font-weight:600;
    cursor:pointer;transition:all .15s;display:flex;align-items:center;gap:7px;
}
.btn-logout:hover{background:rgba(239,68,68,.12);border-color:rgba(239,68,68,.4);}

/* ── Page ── */
.page{max-width:1400px;margin:0 auto;padding:32px 36px;}

/* ── Stats cards ── */
.stats-grid{
    display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:32px;
}
.stat-card{
    background:#fff;border-radius:18px;padding:22px 24px;
    border:1px solid rgba(14,165,233,.12);
    box-shadow:0 2px 12px rgba(14,165,233,.06);
    display:flex;align-items:center;gap:16px;
}
.stat-icon{
    width:52px;height:52px;border-radius:14px;
    display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;
}
.stat-info{}
.stat-val{font-size:32px;font-weight:800;line-height:1;}
.stat-lbl{font-size:13px;color:#64748b;margin-top:3px;font-weight:500;}

.icon-total   {background:rgba(14,165,233,.1);color:#0ea5e9;}
.icon-win     {background:rgba(34,197,94,.1);color:#16a34a;}
.icon-timeout {background:rgba(239,68,68,.1);color:#dc2626;}
.icon-playing {background:rgba(245,158,11,.1);color:#d97706;}
.icon-today   {background:rgba(139,92,246,.1);color:#7c3aed;}

.val-total   {color:#0ea5e9;}
.val-win     {color:#16a34a;}
.val-timeout {color:#dc2626;}
.val-playing {color:#d97706;}
.val-today   {color:#7c3aed;}

/* ── Filters ── */
.filters-bar{
    background:#fff;border-radius:16px;padding:18px 24px;margin-bottom:24px;
    border:1px solid rgba(14,165,233,.12);
    box-shadow:0 2px 8px rgba(14,165,233,.05);
    display:flex;align-items:center;gap:14px;flex-wrap:wrap;
}
.filter-label{font-size:13px;font-weight:600;color:#64748b;white-space:nowrap;}

.search-box{
    flex:1;min-width:200px;position:relative;
}
.search-box i{
    position:absolute;left:14px;top:50%;transform:translateY(-50%);
    color:#94a3b8;font-size:15px;
}
.search-box input{
    width:100%;height:40px;padding:0 14px 0 40px;
    border:1.5px solid rgba(14,165,233,.2);border-radius:10px;
    font-size:14px;color:#0c4a6e;outline:none;
    transition:border-color .2s,box-shadow .2s;
}
.search-box input:focus{border-color:#0ea5e9;box-shadow:0 0 0 3px rgba(14,165,233,.1);}

.filter-select{
    height:40px;padding:0 12px;
    border:1.5px solid rgba(14,165,233,.2);border-radius:10px;
    font-size:14px;color:#0c4a6e;outline:none;background:#fff;cursor:pointer;
    transition:border-color .2s;
}
.filter-select:focus{border-color:#0ea5e9;}

.btn-filter{
    height:40px;padding:0 20px;border:none;border-radius:10px;
    background:linear-gradient(135deg,#0ea5e9,#0284c7);
    color:#fff;font-size:14px;font-weight:600;cursor:pointer;
    transition:filter .15s;display:flex;align-items:center;gap:7px;
    white-space:nowrap;
}
.btn-filter:hover{filter:brightness(1.1);}
.btn-clear{
    height:40px;padding:0 16px;border:1.5px solid rgba(14,165,233,.2);border-radius:10px;
    background:#fff;color:#64748b;font-size:14px;cursor:pointer;transition:all .15s;
    display:flex;align-items:center;gap:7px;white-space:nowrap;
}
.btn-clear:hover{border-color:#0ea5e9;color:#0369a1;}

/* ── Table ── */
.table-card{
    background:#fff;border-radius:18px;overflow:hidden;
    border:1px solid rgba(14,165,233,.12);
    box-shadow:0 2px 12px rgba(14,165,233,.06);
}
.table-header{
    padding:18px 24px;border-bottom:1px solid rgba(14,165,233,.1);
    display:flex;align-items:center;justify-content:space-between;
}
.table-title{font-size:16px;font-weight:700;color:#0c4a6e;display:flex;align-items:center;gap:9px;}
.table-count{font-size:13px;color:#64748b;}

table{width:100%;border-collapse:collapse;}
thead th{
    padding:13px 18px;text-align:left;
    font-size:12px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;
    color:#64748b;background:#f8fafc;
    border-bottom:1px solid rgba(14,165,233,.1);
}
tbody tr{border-bottom:1px solid rgba(14,165,233,.07);transition:background .12s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#f0f9ff;}
tbody td{padding:14px 18px;font-size:14px;color:#334155;}
td.td-id{color:#94a3b8;font-weight:600;width:60px;}
td.td-name{font-weight:600;color:#0c4a6e;}
td.td-phone{color:#0369a1;}
td.td-num{font-variant-numeric:tabular-nums;}

/* ── Badges ── */
.badge{
    display:inline-flex;align-items:center;gap:5px;
    padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;
}
.badge-win    {background:rgba(34,197,94,.1);color:#16a34a;border:1px solid rgba(34,197,94,.2);}
.badge-timeout{background:rgba(239,68,68,.1);color:#dc2626;border:1px solid rgba(239,68,68,.2);}
.badge-playing{background:rgba(245,158,11,.1);color:#d97706;border:1px solid rgba(245,158,11,.2);}
.badge-3{background:rgba(34,197,94,.08);color:#15803d;}
.badge-4{background:rgba(245,158,11,.08);color:#b45309;}
.badge-5{background:rgba(239,68,68,.08);color:#b91c1c;}

/* ── Pagination ── */
.pagination-wrap{padding:18px 24px;border-top:1px solid rgba(14,165,233,.1);display:flex;align-items:center;justify-content:space-between;}
.page-info{font-size:13px;color:#64748b;}
.page-links{display:flex;gap:6px;}
.page-links a, .page-links span{
    display:inline-flex;align-items:center;justify-content:center;
    width:36px;height:36px;border-radius:8px;font-size:14px;font-weight:500;
    border:1.5px solid rgba(14,165,233,.2);color:#0369a1;text-decoration:none;
    transition:all .15s;
}
.page-links a:hover{background:#e0f2fe;border-color:#0ea5e9;}
.page-links span.active{background:#0ea5e9;border-color:#0ea5e9;color:#fff;}
.page-links span.disabled{color:#cbd5e1;border-color:#e2e8f0;pointer-events:none;}

/* ── Empty state ── */
.empty{padding:60px 24px;text-align:center;}
.empty i{font-size:48px;color:#cbd5e1;margin-bottom:16px;display:block;}
.empty p{font-size:16px;color:#94a3b8;}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="nav-brand">
        <img src="{{ asset('logo.png') }}" alt="Chellow">
        <div class="nav-brand-text">Admin <span>Panel</span></div>
    </div>
    <div class="nav-right">
        <div class="nav-badge"><i class="fa-solid fa-shield-halved" style="margin-right:6px;"></i>Administrator</div>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</nav>

<div class="page">

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-total"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-val val-total">{{ $stats['total'] }}</div>
                <div class="stat-lbl">Total Players</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-win"><i class="fa-solid fa-trophy"></i></div>
            <div class="stat-info">
                <div class="stat-val val-win">{{ $stats['wins'] }}</div>
                <div class="stat-lbl">Wins</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-timeout"><i class="fa-regular fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-val val-timeout">{{ $stats['timeouts'] }}</div>
                <div class="stat-lbl">Timeouts</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-playing"><i class="fa-solid fa-gamepad"></i></div>
            <div class="stat-info">
                <div class="stat-val val-playing">{{ $stats['playing'] }}</div>
                <div class="stat-lbl">In Progress</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-today"><i class="fa-solid fa-calendar-day"></i></div>
            <div class="stat-info">
                <div class="stat-val val-today">{{ $stats['today'] }}</div>
                <div class="stat-lbl">Today</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.dashboard') }}">
        <div class="filters-bar">
            <span class="filter-label"><i class="fa-solid fa-filter"></i> Filter</span>

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or phone…">
            </div>

            <select name="result" class="filter-select">
                <option value="">All Results</option>
                <option value="win"     {{ request('result') === 'win'     ? 'selected' : '' }}>Win</option>
                <option value="timeout" {{ request('result') === 'timeout' ? 'selected' : '' }}>Timeout</option>
                <option value="playing" {{ request('result') === 'playing' ? 'selected' : '' }}>In Progress</option>
            </select>

            <select name="difficulty" class="filter-select">
                <option value="">All Difficulties</option>
                <option value="3" {{ request('difficulty') == '3' ? 'selected' : '' }}>3 × 3 Easy</option>
                <option value="4" {{ request('difficulty') == '4' ? 'selected' : '' }}>4 × 4 Medium</option>
                <option value="5" {{ request('difficulty') == '5' ? 'selected' : '' }}>5 × 5 Hard</option>
            </select>

            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>
            @if(request()->hasAny(['search','result','difficulty']))
            <a href="{{ route('admin.dashboard') }}" class="btn-clear">
                <i class="fa-solid fa-xmark"></i> Clear
            </a>
            @endif
        </div>
    </form>

    <!-- Table -->
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fa-solid fa-list" style="color:#0ea5e9;"></i> Player Records
            </div>
            <div class="table-count">{{ $players->total() }} {{ Str::plural('record', $players->total()) }}</div>
        </div>

        @if($players->count())
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Difficulty</th>
                    <th>Result</th>
                    <th>Moves</th>
                    <th>Time</th>
                    <th>Played At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($players as $player)
                <tr>
                    <td class="td-id">{{ $player->id }}</td>
                    <td class="td-name">{{ $player->name }}</td>
                    <td class="td-phone">{{ $player->phone }}</td>
                    <td>
                        @php $d = $player->difficulty; @endphp
                        <span class="badge badge-{{ $d }}">
                            {{ $d }} × {{ $d }}
                            @if($d == 3) Easy @elseif($d == 4) Medium @else Hard @endif
                        </span>
                    </td>
                    <td>
                        @if($player->result === 'win')
                            <span class="badge badge-win"><i class="fa-solid fa-trophy"></i> Win</span>
                        @elseif($player->result === 'timeout')
                            <span class="badge badge-timeout"><i class="fa-regular fa-clock"></i> Timeout</span>
                        @else
                            <span class="badge badge-playing"><i class="fa-solid fa-spinner fa-spin"></i> Playing</span>
                        @endif
                    </td>
                    <td class="td-num">{{ $player->moves ?? '—' }}</td>
                    <td class="td-num">
                        @if($player->time_taken !== null)
                            {{ str_pad(floor($player->time_taken / 60), 2, '0', STR_PAD_LEFT) }}:{{ str_pad($player->time_taken % 60, 2, '0', STR_PAD_LEFT) }}
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $player->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        @if($players->hasPages())
        <div class="pagination-wrap">
            <div class="page-info">
                Showing {{ $players->firstItem() }}–{{ $players->lastItem() }} of {{ $players->total() }}
            </div>
            <div class="page-links">
                {{-- Previous --}}
                @if($players->onFirstPage())
                    <span class="disabled"><i class="fa-solid fa-chevron-left" style="font-size:11px;"></i></span>
                @else
                    <a href="{{ $players->previousPageUrl() }}"><i class="fa-solid fa-chevron-left" style="font-size:11px;"></i></a>
                @endif

                {{-- Page numbers --}}
                @foreach($players->getUrlRange(max(1,$players->currentPage()-2), min($players->lastPage(),$players->currentPage()+2)) as $page => $url)
                    @if($page == $players->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($players->hasMorePages())
                    <a href="{{ $players->nextPageUrl() }}"><i class="fa-solid fa-chevron-right" style="font-size:11px;"></i></a>
                @else
                    <span class="disabled"><i class="fa-solid fa-chevron-right" style="font-size:11px;"></i></span>
                @endif
            </div>
        </div>
        @endif

        @else
        <div class="empty">
            <i class="fa-solid fa-inbox"></i>
            <p>No player records found.</p>
        </div>
        @endif

    </div>
</div>

</body>
</html>
