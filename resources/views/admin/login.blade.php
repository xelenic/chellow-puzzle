<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login — Chellow Puzzle</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    min-height:100vh;background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 50%,#e0f2fe 100%);
    display:flex;align-items:center;justify-content:center;
    font-family:'Inter',sans-serif;
}
.card{
    width:460px;background:#fff;border-radius:28px;
    padding:52px 48px;
    box-shadow:0 20px 60px rgba(14,165,233,.15),0 4px 16px rgba(0,0,0,.06);
    border:1px solid rgba(14,165,233,.15);
}
.logo-wrap{text-align:center;margin-bottom:36px;}
.logo-wrap img{height:64px;object-fit:contain;}
.card-title{font-size:22px;font-weight:700;color:#0c4a6e;text-align:center;margin-bottom:6px;}
.card-sub{font-size:14px;color:#64748b;text-align:center;margin-bottom:36px;}

.field{margin-bottom:20px;}
.field label{display:block;font-size:13px;font-weight:600;color:#0369a1;letter-spacing:.5px;text-transform:uppercase;margin-bottom:8px;}
.field input{
    width:100%;height:52px;padding:0 18px;
    border:1.5px solid rgba(14,165,233,.25);border-radius:12px;
    font-size:16px;color:#0c4a6e;font-family:'Inter',sans-serif;
    outline:none;transition:border-color .2s,box-shadow .2s;background:#fff;
}
.field input:focus{border-color:#0ea5e9;box-shadow:0 0 0 4px rgba(14,165,233,.1);}

.error{
    background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.25);
    color:#dc2626;font-size:14px;border-radius:10px;
    padding:10px 16px;margin-bottom:20px;display:flex;align-items:center;gap:8px;
}

.btn-login{
    width:100%;height:52px;border:none;border-radius:12px;cursor:pointer;
    background:linear-gradient(135deg,#0ea5e9,#0284c7);
    color:#fff;font-size:16px;font-weight:700;letter-spacing:.5px;
    transition:filter .15s,transform .1s;box-shadow:0 6px 20px rgba(14,165,233,.3);
}
.btn-login:hover{filter:brightness(1.08);transform:translateY(-1px);}
.btn-login:active{transform:translateY(1px);}
</style>
</head>
<body>
<div class="card">
    <div class="logo-wrap">
        <img src="{{ asset('logo.png') }}" alt="Chellow Puzzle">
    </div>
    <div class="card-title">Admin Panel</div>
    <div class="card-sub">Enter your password to continue</div>

    @if($errors->any())
    <div class="error">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ $errors->first('password') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" autofocus>
        </div>
        <button type="submit" class="btn-login">
            <i class="fa-solid fa-right-to-bracket" style="margin-right:8px;"></i>Sign In
        </button>
    </form>
</div>
</body>
</html>
