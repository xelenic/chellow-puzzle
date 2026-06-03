<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=1080">
<title>Chellow Puzzle</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ── Sky Blue + White Theme — 1080×1920 kiosk, no scroll ── */
*{margin:0;padding:0;box-sizing:border-box;}
html,body{
    width:1080px;height:1920px;
    overflow:hidden;
    background:#f0f9ff;
    font-family:'Patrick Hand',system-ui,sans-serif;color:#0c4a6e;
    user-select:none;-webkit-user-select:none;
}
#bg{position:fixed;top:0;left:0;width:1080px;height:1920px;z-index:0;pointer-events:none;}
.page{
    position:relative;z-index:1;
    margin-top:90px;          /* clear fixed topbar */
    height:1830px;            /* 1920 - 90 */
    display:flex;flex-direction:column;
    align-items:center;justify-content:center;
    overflow:hidden;
}

/* ── Header ── */
.logo{
    font-size:90px;font-weight:900;letter-spacing:14px;line-height:1;
    background:linear-gradient(135deg,#0c4a6e 0%,#0ea5e9 55%,#38bdf8 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    filter:drop-shadow(0 2px 16px rgba(14,165,233,.35));
}
.subtitle{font-size:24px;letter-spacing:9px;color:rgba(3,105,161,.5);text-transform:uppercase;margin-top:10px;margin-bottom:44px;}

/* ── Stats ── */
.stats{
    width:1000px;height:116px;display:flex;align-items:center;justify-content:space-around;
    background:rgba(255,255,255,.88);border:1px solid rgba(14,165,233,.22);
    border-radius:20px;margin-bottom:36px;
    box-shadow:0 4px 20px rgba(14,165,233,.1),0 1px 4px rgba(0,0,0,.05);
}
.st{display:flex;flex-direction:column;align-items:center;gap:5px;}
.st-v{font-size:46px;font-weight:800;color:#0ea5e9;line-height:1;font-variant-numeric:tabular-nums;}
.st-l{font-size:16px;letter-spacing:4px;color:rgba(3,105,161,.5);text-transform:uppercase;}
.st-sep{width:1px;height:56px;background:rgba(14,165,233,.2);}

/* ── Target preview bar ── */
.target-bar{
    width:1000px;display:flex;align-items:center;gap:32px;
    background:rgba(255,255,255,.88);border:1px solid rgba(14,165,233,.2);
    border-radius:18px;padding:20px 36px;margin-bottom:44px;
    box-shadow:0 4px 16px rgba(14,165,233,.08);
}
.target-lbl{font-size:18px;letter-spacing:5px;color:rgba(3,105,161,.5);text-transform:uppercase;white-space:nowrap;}
#preview{width:180px;height:180px;border-radius:12px;border:2px solid rgba(14,165,233,.3);display:block;flex-shrink:0;box-shadow:0 4px 14px rgba(14,165,233,.15);}
.target-info{flex:1;}
.target-title{font-size:26px;font-weight:700;margin-bottom:10px;color:#0c4a6e;}
.prog-wrap{width:100%;height:10px;background:rgba(14,165,233,.12);border-radius:5px;overflow:hidden;margin-bottom:8px;}
#prog-bar{height:100%;background:linear-gradient(90deg,#0ea5e9,#7dd3fc);border-radius:5px;width:0%;transition:width .4s ease;}
#prog-txt{font-size:19px;color:#0369a1;}

/* ── Two boards ── */
.boards{display:flex;flex-direction:column;align-items:center;gap:30px;}
.board-col{display:flex;flex-direction:column;align-items:center;}
.board-hd{display:flex;align-items:center;gap:12px;font-size:20px;font-weight:700;letter-spacing:4px;color:#0369a1;text-transform:uppercase;}
.badge{padding:5px 16px;border-radius:16px;font-size:16px;font-weight:700;}
.badge-a{background:rgba(14,165,233,.14);color:#0369a1;border:1px solid rgba(14,165,233,.35);}
.badge-p{background:rgba(56,189,248,.12);color:#0284c7;border:1px solid rgba(56,189,248,.32);}
.board-frame{
    padding:10px;border-radius:22px;
    background:rgba(255,255,255,.75);
    border:1px solid rgba(14,165,233,.2);
    box-shadow:0 8px 32px rgba(14,165,233,.12),0 2px 6px rgba(0,0,0,.05);
    display:inline-block;
}
.board-frame.af{border-color:rgba(14,165,233,.4);background:rgba(255,255,255,.92);}
.board-frame.pf{border-color:rgba(56,189,248,.3);background:rgba(240,249,255,.85);}
.board-grid{display:grid;border-radius:12px;overflow:hidden;}

/* ── Slots (left board) ── */
.slot{
    position:relative;background:rgba(224,242,254,.55);border:1px solid rgba(14,165,233,.18);
    overflow:hidden;transition:background .15s,border-color .15s,box-shadow .15s;
}
.slot .ghost{position:absolute;inset:0;opacity:.18;background-repeat:no-repeat;pointer-events:none;}
.slot .placed{position:absolute;inset:0;background-repeat:no-repeat;animation:snap .32s cubic-bezier(.34,1.56,.64,1);}
.slot.hover{background:rgba(14,165,233,.16);border-color:rgba(14,165,233,.65);box-shadow:inset 0 0 16px rgba(14,165,233,.18);}
.slot.filled{border-color:rgba(14,165,233,.35);animation:glow .65s ease-out;}
.slot.wrong-fill{border-color:rgba(220,38,38,.45);}
.wrong-overlay{position:absolute;inset:0;pointer-events:none;background:rgba(220,38,38,.18);border:2.5px solid rgba(220,38,38,.45);}
@keyframes wrong-place{0%{box-shadow:inset 0 0 0 3px rgba(220,38,38,.85),0 0 24px rgba(220,38,38,.4)}100%{box-shadow:none}}
.slot.wrong-fill{animation:wrong-place .65s ease-out;}

/* ── Pieces (right board) ── */
.piece{
    position:relative;background-repeat:no-repeat;cursor:grab;
    border:1px solid rgba(14,165,233,.15);
    transition:filter .12s,box-shadow .12s;
}
.piece:hover:not(.used){z-index:5;filter:brightness(1.08);box-shadow:0 0 0 2.5px rgba(14,165,233,.55),0 6px 18px rgba(14,165,233,.2);}
.piece.used{filter:grayscale(.85) opacity(.22);cursor:not-allowed;pointer-events:none;}
.piece.src{filter:grayscale(.6) opacity(.25) !important;}

/* ── Floating clone ── */
#clone{
    position:fixed;pointer-events:none;z-index:9999;
    transform:scale(1.07);transform-origin:top left;
    box-shadow:0 16px 48px rgba(14,165,233,.28),0 0 0 2.5px rgba(14,165,233,.55);
    border-radius:6px;opacity:.94;background-repeat:no-repeat;
}

/* ── Keyframes ── */
@keyframes snap{0%{transform:scale(.82);opacity:.35}60%{transform:scale(1.05)}100%{transform:scale(1);opacity:1}}
@keyframes glow{0%{box-shadow:inset 0 0 0 3px rgba(14,165,233,.85),0 0 26px rgba(14,165,233,.4)}100%{box-shadow:none}}
@keyframes wrongf{0%,100%{background:rgba(224,242,254,.55);border-color:rgba(14,165,233,.18)}45%{background:rgba(220,38,38,.1);border-color:rgba(220,38,38,.55);box-shadow:inset 0 0 16px rgba(220,38,38,.15)}}

/* ── Controls ── */
.controls{display:flex;gap:22px;margin-bottom:34px;}
.btn{
    height:88px;padding:0 50px;border-radius:16px;border:none;
    font-size:24px;font-weight:800;letter-spacing:3px;text-transform:uppercase;
    cursor:pointer;transition:transform .1s,filter .1s,box-shadow .1s;
}
.btn:hover{transform:translateY(-3px);filter:brightness(1.08);}
.btn:active{transform:translateY(1px);}
.btn-new{background:linear-gradient(135deg,#0ea5e9,#38bdf8);color:#fff;box-shadow:0 8px 28px rgba(14,165,233,.4);}
.btn-img{background:linear-gradient(135deg,#0284c7,#0ea5e9);color:#fff;box-shadow:0 8px 28px rgba(2,132,199,.35);}
.btn-rst{background:#fff;color:#0369a1;border:1.5px solid rgba(14,165,233,.35);box-shadow:0 4px 12px rgba(14,165,233,.1);}

/* ── Difficulty ── */
.sec-hd{font-size:21px;letter-spacing:6px;color:rgba(3,105,161,.45);text-transform:uppercase;margin-bottom:16px;text-align:center;}
.diff-row{display:flex;gap:16px;margin-bottom:54px;}
.diff-btn{
    width:306px;height:78px;border-radius:13px;
    border:2px solid rgba(14,165,233,.2);background:rgba(255,255,255,.8);
    color:#0369a1;font-size:21px;font-weight:700;letter-spacing:2px;cursor:pointer;transition:all .18s;
    box-shadow:0 2px 8px rgba(14,165,233,.08);
}
.diff-btn:hover,.diff-btn.active{
    border-color:#0ea5e9;background:rgba(14,165,233,.12);
    color:#0c4a6e;box-shadow:0 4px 20px rgba(14,165,233,.2);
}

/* ── Scores ── */
.scores{
    width:1000px;background:rgba(255,255,255,.88);border:1px solid rgba(14,165,233,.2);
    border-radius:22px;padding:34px 42px;margin-bottom:54px;
    box-shadow:0 4px 20px rgba(14,165,233,.08);
}
.sc-row{display:flex;align-items:center;padding:15px 0;border-bottom:1px solid rgba(14,165,233,.1);gap:22px;}
.sc-row:last-child{border-bottom:none;}
.sc-rank{font-size:27px;font-weight:900;width:52px;color:rgba(12,74,110,.2);}
.sc-rank.gold{color:#f59e0b;}.sc-rank.silver{color:#64748b;}.sc-rank.bronze{color:#92400e;}
.sc-main{flex:1;}
.sc-moves{font-size:23px;font-weight:700;color:#0c4a6e;}
.sc-time{font-size:18px;color:#0369a1;margin-top:2px;}
.sc-date{font-size:17px;color:rgba(3,105,161,.45);}
.no-sc{text-align:center;color:rgba(3,105,161,.38);font-size:21px;padding:34px 0;}

/* ── Win screen ── */
#win{
    position:fixed;inset:0;width:1080px;height:1920px;
    background:#fff;
    display:none;flex-direction:column;align-items:center;justify-content:center;
    z-index:1000;
}
#win.show{display:flex;}

#fw-canvas{
    position:absolute;inset:0;width:1080px;height:1920px;
    pointer-events:none;z-index:1;
}

.win-content{
    position:relative;z-index:2;
    display:flex;flex-direction:column;align-items:center;
    gap:44px;text-align:center;padding:0 60px;
}

.win-logo{
    width:380px;height:auto;
    animation:win-logo-pop .7s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes win-logo-pop{
    0%{transform:scale(0) rotate(-12deg);opacity:0}
    100%{transform:scale(1) rotate(0deg);opacity:1}
}

.win-congrats{
    font-size:88px;font-weight:900;line-height:1.1;
    background:linear-gradient(135deg,#f59e0b 0%,#ef4444 30%,#ec4899 55%,#8b5cf6 75%,#0ea5e9 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    animation:win-slide-up .6s ease-out .25s both;
    filter:drop-shadow(0 4px 12px rgba(14,165,233,.18));
}

.win-sub{
    font-size:58px;font-weight:800;color:#f59e0b;
    animation:win-slide-up .6s ease-out .4s both;
    text-shadow:0 3px 12px rgba(245,158,11,.3);
}

@keyframes win-slide-up{
    0%{transform:translateY(36px);opacity:0}
    100%{transform:translateY(0);opacity:1}
}

.win-stats{
    display:flex;gap:40px;
    animation:win-slide-up .6s ease-out .55s both;
}

.win-stat{
    display:flex;flex-direction:column;align-items:center;gap:10px;
    background:rgba(14,165,233,.07);border:2px solid rgba(14,165,233,.2);
    border-radius:26px;padding:32px 64px;
}
.win-stat-v{font-size:72px;font-weight:900;color:#0ea5e9;line-height:1;font-variant-numeric:tabular-nums;}
.win-stat-l{font-size:22px;letter-spacing:5px;color:rgba(3,105,161,.5);text-transform:uppercase;}

.win-play-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:18px;
    padding:0 110px;height:130px;border-radius:24px;border:none;cursor:pointer;
    font-family:'Patrick Hand',system-ui,sans-serif;
    font-size:42px;font-weight:900;letter-spacing:5px;text-transform:uppercase;color:#fff;
    background:linear-gradient(180deg,#60c8f5 0%,#0ea5e9 45%,#0277bd 100%);
    box-shadow:0 12px 0 #015f94, 0 16px 40px rgba(14,165,233,.4);
    transform:translateY(0);transition:transform .08s ease,box-shadow .08s ease;
    animation:win-slide-up .6s ease-out .7s both;
    text-shadow:0 2px 6px rgba(0,0,0,.15);
}
.win-play-btn:hover{
    background:linear-gradient(180deg,#7dd3fc 0%,#38bdf8 45%,#0ea5e9 100%);
    transform:translateY(-3px);box-shadow:0 15px 0 #015f94,0 20px 48px rgba(14,165,233,.45);
}
.win-play-btn:active{transform:translateY(12px);box-shadow:0 1px 0 #015f94,0 4px 14px rgba(14,165,233,.3);}

/* ── Game Over screen ── */
#gameover{
    position:fixed;inset:0;width:1080px;height:1920px;
    background:#fff;
    display:none;flex-direction:column;align-items:center;justify-content:center;
    z-index:1001;gap:52px;text-align:center;padding:0 60px;
}
#gameover.show{display:flex;}

.go-logo{
    width:340px;height:auto;
    animation:win-logo-pop .7s cubic-bezier(.34,1.56,.64,1) both;
}
.go-title{
    font-size:120px;font-weight:900;line-height:1;
    background:linear-gradient(180deg,#ef4444 0%,#b91c1c 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    filter:drop-shadow(0 6px 18px rgba(239,68,68,.25));
    animation:win-slide-up .6s ease-out .2s both;
}
.go-sub{
    font-size:52px;font-weight:700;color:#64748b;
    animation:win-slide-up .6s ease-out .38s both;
}
.go-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:18px;
    padding:0 110px;height:130px;border-radius:24px;border:none;cursor:pointer;
    font-family:'Patrick Hand',system-ui,sans-serif;
    font-size:42px;font-weight:900;letter-spacing:5px;text-transform:uppercase;color:#fff;
    background:linear-gradient(180deg,#f87171 0%,#ef4444 45%,#b91c1c 100%);
    box-shadow:0 12px 0 #7f1d1d, 0 16px 40px rgba(239,68,68,.4);
    transform:translateY(0);transition:transform .08s ease,box-shadow .08s ease;
    animation:win-slide-up .6s ease-out .55s both;
}
.go-btn:hover{transform:translateY(-3px);box-shadow:0 15px 0 #7f1d1d,0 20px 48px rgba(239,68,68,.45);}
.go-btn:active{transform:translateY(12px);box-shadow:0 1px 0 #7f1d1d,0 4px 14px rgba(239,68,68,.3);}

/* ── Confetti ── */
.cf{position:fixed;pointer-events:none;z-index:9999;animation:cf-fall linear forwards;}
@keyframes cf-fall{0%{transform:translateY(-30px) rotate(0deg);opacity:1}100%{transform:translateY(2000px) rotate(800deg);opacity:0}}

/* ── Splash screen ── */
#splash{
    position:fixed;inset:0;width:1080px;height:1920px;
    background:#fff;
    z-index:8000;
    display:flex;flex-direction:column;align-items:center;justify-content:center;
    gap:72px;
    transition:opacity .55s ease;
}
#splash.hide{opacity:0;pointer-events:none;}

.splash-logo{
    width:420px;height:auto;
    filter:drop-shadow(0 10px 32px rgba(14,165,233,.22));
    animation:splash-float 3s ease-in-out infinite;
}
@keyframes splash-float{
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-14px)}
}

.splash-btn{
    display:inline-flex;align-items:center;justify-content:center;
    padding:0 100px;height:120px;border-radius:22px;border:none;
    cursor:pointer;
    font-size:38px;font-weight:900;letter-spacing:6px;text-transform:uppercase;
    color:#fff;
    background:linear-gradient(180deg,#60c8f5 0%,#0ea5e9 45%,#0277bd 100%);
    box-shadow:0 10px 0 #015f94, 0 14px 36px rgba(14,165,233,.4);
    transform:translateY(0);
    transition:transform .08s ease,box-shadow .08s ease,background .15s;
    text-shadow:0 2px 6px rgba(0,0,0,.18);
}
.splash-btn:hover{
    background:linear-gradient(180deg,#7dd3fc 0%,#38bdf8 45%,#0ea5e9 100%);
    box-shadow:0 12px 0 #015f94, 0 18px 44px rgba(14,165,233,.45);
    transform:translateY(-3px);
}
.splash-btn:active{
    transform:translateY(10px);
    box-shadow:0 1px 0 #015f94, 0 4px 14px rgba(14,165,233,.3);
}

/* ── Fixed top bar ── */
.topbar{
    position:fixed;top:0;left:0;width:1080px;height:90px;z-index:700;
    background:rgba(255,255,255,.96);border-bottom:1.5px solid rgba(14,165,233,.18);
    backdrop-filter:blur(16px);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 36px;
    box-shadow:0 2px 16px rgba(14,165,233,.1);
}
/* Logo image */
.tb-logo{
    height:62px;
    width:auto;
    object-fit:contain;
    display:block;
    flex-shrink:0;
}
/* Center stats group */
.tb-center{display:flex;align-items:center;gap:10px;}
.tb-sep{width:1px;height:44px;background:rgba(14,165,233,.2);}
.tb-cell{display:flex;align-items:center;gap:12px;padding:0 14px;}
.tb-icon{font-size:26px;color:#0ea5e9;}
.tb-info{display:flex;flex-direction:column;line-height:1;}
.tb-val{font-size:38px;font-weight:800;color:#0c4a6e;font-variant-numeric:tabular-nums;}
.tb-lbl{font-size:12px;letter-spacing:4px;color:rgba(3,105,161,.45);text-transform:uppercase;margin-top:3px;}
.tb-val.warn{color:#f59e0b;}
.tb-val.danger{color:#ef4444;animation:pulse-red .65s ease infinite alternate;}
@keyframes pulse-red{0%{opacity:1}100%{opacity:.45}}
/* Right action buttons */
.tb-actions{display:flex;align-items:center;gap:10px;}
.tb-btn{
    width:62px;height:62px;border-radius:50%;flex-shrink:0;
    border:1.5px solid rgba(14,165,233,.28);
    background:rgba(14,165,233,.07);color:#0ea5e9;
    font-size:24px;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    transition:background .2s,transform .25s;
}
.tb-btn:hover{background:rgba(14,165,233,.18);transform:rotate(-40deg);}

/* ── Cog button (lives inside topbar) ── */
.cog-btn{
    width:66px;height:66px;border-radius:50%;flex-shrink:0;
    border:1.5px solid rgba(14,165,233,.3);
    background:rgba(14,165,233,.08);color:#0ea5e9;
    font-size:28px;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    transition:background .2s,transform .35s;
}
.cog-btn:hover{background:rgba(14,165,233,.18);transform:rotate(60deg);}
.cog-btn.open{transform:rotate(120deg);}

/* ── Settings modal ── */
#settings-modal{
    position:fixed;inset:0;
    background:rgba(14,165,233,.13);
    display:none;align-items:center;justify-content:center;
    z-index:900;backdrop-filter:blur(14px);
}
#settings-modal.show{display:flex;}

.modal-card{
    width:920px;max-height:88vh;overflow-y:auto;
    background:rgba(255,255,255,.98);
    border:2px solid rgba(14,165,233,.25);border-radius:30px;
    padding:52px 52px 44px;
    box-shadow:0 24px 80px rgba(14,165,233,.22);
    animation:modal-in .28s cubic-bezier(.34,1.2,.64,1);
}
@keyframes modal-in{0%{transform:translateY(-24px) scale(.97);opacity:0}100%{transform:none;opacity:1}}

.modal-hd{
    display:flex;align-items:center;justify-content:space-between;
    padding-bottom:22px;margin-bottom:36px;
    border-bottom:1px solid rgba(14,165,233,.15);
}
.modal-title{font-size:38px;font-weight:800;color:#0c4a6e;display:flex;align-items:center;gap:16px;}
.modal-title i{font-size:32px;color:#0ea5e9;}
.modal-close{
    width:60px;height:60px;border-radius:50%;border:1.5px solid rgba(14,165,233,.25);
    background:rgba(14,165,233,.07);color:#0369a1;font-size:22px;
    cursor:pointer;display:flex;align-items:center;justify-content:center;
    transition:all .15s;
}
.modal-close:hover{background:rgba(14,165,233,.18);color:#0c4a6e;border-color:rgba(14,165,233,.5);}

.modal-section{margin-bottom:40px;}
.modal-section:last-child{margin-bottom:0;}
.modal-section-hd{
    font-size:20px;letter-spacing:5px;color:rgba(3,105,161,.5);
    text-transform:uppercase;margin-bottom:18px;
}

/* difficulty inside modal */
.modal-card .diff-row{margin-bottom:0;justify-content:center;}
.modal-card .diff-btn{width:260px;}

/* scores inside modal */
.modal-scores{
    background:rgba(240,249,255,.6);border:1px solid rgba(14,165,233,.15);
    border-radius:18px;padding:24px 32px;
}
.modal-scores .sc-row{padding:13px 0;}

/* ── Remember screen (5-sec puzzle preview) ── */
#remember{
    position:fixed;inset:0;width:1080px;height:1920px;
    background:#fff;z-index:7000;
    display:none;flex-direction:column;align-items:center;justify-content:center;
    gap:48px;padding:60px;
    animation:fade-in .4s ease both;
}
#remember.show{display:flex;}
#remember.hide-out{animation:fade-out .45s ease both;}
@keyframes fade-in{from{opacity:0}to{opacity:1}}
@keyframes fade-out{from{opacity:1}to{opacity:0}}

.rmb-title{
    font-size:52px;font-weight:900;color:#0c4a6e;letter-spacing:2px;text-align:center;
}
.rmb-img{
    width:840px;height:840px;object-fit:cover;
    border-radius:24px;border:3px solid rgba(14,165,233,.3);
    box-shadow:0 12px 48px rgba(14,165,233,.18);
    display:block;
}
.rmb-count-wrap{display:flex;flex-direction:column;align-items:center;gap:14px;}
.rmb-num{
    font-size:160px;font-weight:900;color:#0ea5e9;line-height:1;
    animation:count-pulse .9s ease infinite;
}
@keyframes count-pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.12)}}
.rmb-lbl{font-size:30px;letter-spacing:6px;color:rgba(3,105,161,.45);text-transform:uppercase;}

/* ── Toggle switch ── */
.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:10px 0;}
.toggle-label{font-size:22px;font-weight:600;color:#0c4a6e;}
.toggle-desc{font-size:16px;color:rgba(3,105,161,.5);margin-top:3px;}
.sw{position:relative;display:inline-block;width:76px;height:40px;flex-shrink:0;}
.sw input{opacity:0;width:0;height:0;position:absolute;}
.sw-track{
    position:absolute;inset:0;border-radius:20px;cursor:pointer;
    background:rgba(14,165,233,.15);border:1.5px solid rgba(14,165,233,.3);
    transition:background .25s,border-color .25s;
}
.sw input:checked+.sw-track{background:#0ea5e9;border-color:#0ea5e9;}
.sw-thumb{
    position:absolute;top:4px;left:4px;width:28px;height:28px;
    border-radius:50%;background:#fff;
    box-shadow:0 2px 6px rgba(0,0,0,.2);
    transition:transform .25s;pointer-events:none;
}
.sw input:checked+.sw-track .sw-thumb{transform:translateX(36px);}

/* ── Hide ghost hint on assembly board ── */
#a-grid.no-hint .ghost{opacity:0 !important;}
</style>
</head>
<body>

<!-- ── Splash / Start Screen ── -->
<div id="splash">
    <img src="{{ asset('logo.png') }}" class="splash-logo" alt="Chellow Puzzle">
    <button class="splash-btn" onclick="G.startGame()" id="splash-btn">
        <i class="fa-solid fa-play" style="margin-right:18px;font-size:32px;"></i>Start Game
    </button>
</div>

<canvas id="bg"></canvas>

<!-- Fixed top bar -->
<div class="topbar">

    <!-- Left: Logo image -->
    <img src="{{ asset('logo.png') }}" class="tb-logo" alt="Chellow Puzzle">

    <!-- Centre: countdown + score -->
    <div class="tb-center">
        <div class="tb-cell">
            <i class="fa-regular fa-clock tb-icon"></i>
            <div class="tb-info">
                <div class="tb-val" id="s-time">01:00</div>
                <div class="tb-lbl">Time</div>
            </div>
        </div>
    </div>
    <div style="display:none" id="s-placed">0/9</div>

    <!-- Right: Mute + Reset + Settings -->
    <div class="tb-actions">
        <button class="tb-btn" id="mute-btn" onclick="G.toggleMute()" title="Music">
            <i class="fa-solid fa-volume-high" id="mute-icon"></i>
        </button>
        <button class="tb-btn" onclick="G.reset()" title="Reset Game">
            <i class="fa-solid fa-arrow-rotate-left"></i>
        </button>
        <button class="cog-btn" id="cog-btn" onclick="G.openSettings()" title="Settings">
            <i class="fa-solid fa-gear"></i>
        </button>
    </div>

</div>

<!-- Remember / Preview screen -->
<div id="remember">
    <div class="rmb-title">Memorize the Puzzle!</div>
    <img src="{{ asset('puzzle.png') }}" class="rmb-img" alt="Puzzle">
    <div class="rmb-count-wrap">
        <div class="rmb-num" id="rmb-count">5</div>
        <div class="rmb-lbl">Starting in…</div>
    </div>
</div>

<!-- Settings modal -->
<div id="settings-modal">
    <div class="modal-card">
        <div class="modal-hd">
            <div class="modal-title">
                <i class="fa-solid fa-sliders"></i> Settings
            </div>
            <button class="modal-close" onclick="G.closeSettings()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-section">
            <div class="modal-section-hd">Difficulty</div>
            <div class="diff-row">
                <button class="diff-btn active" id="d3" onclick="G.setSize(3,this)">3 × 3 &nbsp;Easy</button>
                <button class="diff-btn"         id="d4" onclick="G.setSize(4,this)">4 × 4 &nbsp;Medium</button>
                <button class="diff-btn"         id="d5" onclick="G.setSize(5,this)">5 × 5 &nbsp;Hard</button>
            </div>
        </div>
        <div class="modal-section">
            <div class="modal-section-hd">Assembly Board</div>
            <div class="toggle-row">
                <div>
                    <div class="toggle-label">Show hint image in empty slots</div>
                    <div class="toggle-desc">Faint shadow of the correct piece in each empty slot</div>
                </div>
                <label class="sw">
                    <input type="checkbox" id="hint-toggle" checked onchange="G.toggleHint(this.checked)">
                    <span class="sw-track"><span class="sw-thumb"></span></span>
                </label>
            </div>
        </div>

        <div style="display:none"><div id="sc-list"></div></div>
    </div>
</div>

<!-- Page: only the two puzzle boards -->
<div class="page">
    <div class="boards">
        <div class="board-col">
            <div class="board-frame af">
                <div class="board-grid" id="a-grid"></div>
            </div>
        </div>
        <div class="board-col">
            <div class="board-frame pf">
                <div class="board-grid" id="p-grid"></div>
            </div>
        </div>
    </div>
</div>

<audio id="menu-music" src="{{ asset('menu_music.mp3') }}"       loop preload="auto"></audio>
<audio id="bgm"       src="{{ asset('background_music.mp3') }}" loop preload="auto"></audio>
<audio id="sfx-pick"  src="{{ asset('pick_item.mp3') }}"        preload="auto"></audio>
<audio id="sfx-win"      src="{{ asset('wining.mp3') }}"    preload="auto"></audio>
<audio id="sfx-gameover" src="{{ asset('game_over.mp3') }}" preload="auto"></audio>

<!-- Win screen -->
<div id="win">
    <canvas id="fw-canvas"></canvas>
    <div class="win-content">
        <img src="{{ asset('logo.png') }}" class="win-logo" alt="Chellow">
        <div class="win-congrats">Congratulation<br>You Won!</div>
        <div class="win-stats">
            <div class="win-stat">
                <div class="win-stat-v" id="win-moves-v">—</div>
                <div class="win-stat-l">Moves</div>
            </div>
            <div class="win-stat">
                <div class="win-stat-v" id="win-time-v">—</div>
                <div class="win-stat-l">Time</div>
            </div>
        </div>
        <button class="win-play-btn" onclick="G.goToStart()">
            <i class="fa-solid fa-rotate-right"></i> Play Again
        </button>
    </div>
</div>

<!-- Game Over screen -->
<div id="gameover">
    <img src="{{ asset('logo.png') }}" class="go-logo" alt="Chellow">
    <div class="go-title">Game Over</div>
    <div class="go-sub">Time's Up!</div>
    <button class="go-btn" onclick="G.goToStart()">
        <i class="fa-solid fa-rotate-right"></i> Try Again
    </button>
</div>

<script>
const G = (() => {
    // 840 px board: tiles are 280/210/168 px for 3×3/4×4/5×5 (all integers)
    // Two 860 px frames + 30 px gap = 1750 px — fits inside 1830 px content area
    const BOARD = 840;
    const SRC   = 960;   // source image resolution (high quality)

    const PUZZLE_URL = "{{ asset('puzzle.png') }}";

    let N = 3;
    let placed     = new Set();
    let pieceOrder = [];
    let imgURL     = null;
    let puzzleImg  = null; // loaded from puzzle.png
    let moves      = 0;
    let tick       = null;
    let running    = false;
    let timeLeft   = 0;
    const TIME_LIMIT = { 3: 60, 4: 60, 5: 60 }; // 1 minute for all difficulties

    // drag
    let dVal = null, dOrig = null, dClone = null, dFromSlot = null;
    let dOX = 0, dOY = 0, dHover = null;

    const store = {
        best: () => JSON.parse(localStorage.getItem('cp3b') || '{}'),
        setBest: v => localStorage.setItem('cp3b', JSON.stringify(v)),
        hist: () => JSON.parse(localStorage.getItem('cp3h') || '[]'),
        setHist: v => localStorage.setItem('cp3h', JSON.stringify(v)),
    };

    /* ── Sky background ────────────────────────────────── */
    function initBg() {
        const cv = document.getElementById('bg');
        cv.width = 1080; cv.height = 1920;
        const cx = cv.getContext('2d');

        // Sky gradient base
        const bg = cx.createLinearGradient(0, 0, 0, 1920);
        bg.addColorStop(0,   '#ffffff');
        bg.addColorStop(0.2, '#f0f9ff');
        bg.addColorStop(0.5, '#e0f2fe');
        bg.addColorStop(0.8, '#bae6fd');
        bg.addColorStop(1,   '#e0f2fe');
        cx.fillStyle = bg; cx.fillRect(0, 0, 1080, 2400);

        // Soft glowing orbs (clouds/light)
        [{x:160,y:280,r:320,c:'#7dd3fc'},{x:970,y:650,r:280,c:'#38bdf8'},
         {x:320,y:1100,r:300,c:'#7dd3fc'},{x:860,y:1600,r:340,c:'#bae6fd'},
         {x:100,y:1820,r:250,c:'#0ea5e9'},{x:660,y:960,r:230,c:'#e0f2fe'},
         {x:540,y:440,r:200,c:'#38bdf8'}].forEach(({x,y,r,c})=>{
            const g=cx.createRadialGradient(x,y,0,x,y,r);
            g.addColorStop(0,c+'30'); g.addColorStop(1,c+'00');
            cx.fillStyle=g; cx.beginPath(); cx.arc(x,y,r,0,Math.PI*2); cx.fill();
        });

        // Tiny sparkle dots in sky blue
        for(let i=0;i<130;i++){
            const x=Math.random()*1080, y=Math.random()*1920;
            const r=Math.random()*2.2+0.4, a=Math.random()*0.3+0.07;
            cx.beginPath(); cx.arc(x,y,r,0,Math.PI*2);
            cx.fillStyle=`rgba(14,165,233,${a})`; cx.fill();
        }
    }

    /* ── Build source canvas from puzzle.png ───────────── */
    function makeImg() {
        const cv = document.createElement('canvas');
        cv.width = cv.height = SRC;
        cv.getContext('2d').drawImage(puzzleImg, 0, 0, SRC, SRC);
        return cv;
    }

    /* ── Sprite helper ─────────────────────────────────── */
    function sprite(el, val, tilePx) {
        const r=Math.floor(val/N), c=val%N;
        el.style.backgroundImage    = `url(${imgURL})`;
        el.style.backgroundSize     = `${BOARD}px ${BOARD}px`;
        el.style.backgroundPosition = `-${c*tilePx}px -${r*tilePx}px`;
    }

    /* ── Build both boards ─────────────────────────────── */
    function build() {
        const total=N*N, tile=BOARD/N;

        // shuffle pieces for right board
        pieceOrder = Array.from({length:total},(_,i)=>i);
        for(let i=total-1;i>0;i--){
            const j=Math.floor(Math.random()*(i+1));
            [pieceOrder[i],pieceOrder[j]]=[pieceOrder[j],pieceOrder[i]];
        }

        // ── assembly grid (left) ──
        const ag=document.getElementById('a-grid');
        ag.style.cssText=`grid-template-columns:repeat(${N},${tile}px);grid-template-rows:repeat(${N},${tile}px);width:${BOARD}px;height:${BOARD}px;`;
        ag.innerHTML='';

        for(let i=0;i<total;i++){
            const slot=document.createElement('div');
            slot.className='slot'; slot.dataset.t=i;
            slot.style.width=slot.style.height=tile+'px';

            if(placed.has(i)){
                slot.classList.add('filled');
                const pp=document.createElement('div');
                pp.className='placed'; sprite(pp,i,tile);
                slot.appendChild(pp);
            } else {
                const gh=document.createElement('div');
                gh.className='ghost'; sprite(gh,i,tile);
                slot.appendChild(gh);
            }
            ag.appendChild(slot);
        }

        // ── pieces grid (right) ──
        const pg=document.getElementById('p-grid');
        pg.style.cssText=`grid-template-columns:repeat(${N},${tile}px);grid-template-rows:repeat(${N},${tile}px);width:${BOARD}px;height:${BOARD}px;`;
        pg.innerHTML='';

        pieceOrder.forEach(val=>{
            const pc=document.createElement('div');
            pc.className='piece'+(placed.has(val)?' used':'');
            pc.dataset.v=val;
            pc.style.width=pc.style.height=tile+'px';
            sprite(pc,val,tile);
            pg.appendChild(pc);
        });
    }

    /* ── Drag: mouse ───────────────────────────────────── */
    document.addEventListener('mousedown', e=>{
        if(dClone) return;
        // Priority: wrong-filled slot on left board first
        const ws=e.target.closest('.slot.wrong-fill');
        if(ws){ e.preventDefault(); startDragFromSlot(ws, e.clientX, e.clientY); return; }
        const pc=e.target.closest('.piece:not(.used)');
        if(!pc) return;
        e.preventDefault();
        startDrag(pc, e.clientX, e.clientY);
    });

    document.addEventListener('mousemove', e=>{
        if(!dClone) return;
        moveDrag(e.clientX, e.clientY);
        hover(e.target.closest?.('.slot:not(.filled), .slot.wrong-fill') || null);
    });

    document.addEventListener('mouseup', e=>{
        if(!dClone) return;
        drop(e.target.closest?.('.slot:not(.filled), .slot.wrong-fill') || null);
    });

    /* ── Drag: touch ───────────────────────────────────── */
    document.addEventListener('touchstart', e=>{
        if(dClone) return;
        const t=e.touches[0];
        const el=document.elementFromPoint(t.clientX,t.clientY);
        const ws=el?.closest('.slot.wrong-fill');
        if(ws){ e.preventDefault(); startDragFromSlot(ws, t.clientX, t.clientY); return; }
        const pc=el?.closest('.piece:not(.used)');
        if(!pc) return;
        e.preventDefault();
        startDrag(pc, t.clientX, t.clientY);
    },{passive:false});

    document.addEventListener('touchmove', e=>{
        if(!dClone) return;
        e.preventDefault();
        const t=e.touches[0];
        moveDrag(t.clientX, t.clientY);
        dClone.style.display='none';
        const under=document.elementFromPoint(t.clientX,t.clientY);
        dClone.style.display='';
        hover(under?.closest?.('.slot:not(.filled), .slot.wrong-fill') || null);
    },{passive:false});

    document.addEventListener('touchend', e=>{
        if(!dClone) return;
        const t=e.changedTouches[0];
        dClone.style.display='none';
        const under=document.elementFromPoint(t.clientX,t.clientY);
        dClone.style.display='';
        drop(under?.closest?.('.slot:not(.filled), .slot.wrong-fill') || null);
    });

    /* ── Drag helpers ──────────────────────────────────── */

    // Start drag from RIGHT board piece
    function startDrag(pc, cx, cy) {
        const rect=pc.getBoundingClientRect();
        dOX=cx-rect.left; dOY=cy-rect.top;
        dVal=parseInt(pc.dataset.v);
        dOrig=pc; dFromSlot=null;
        makeClone(rect, pc.style.backgroundImage, pc.style.backgroundSize, pc.style.backgroundPosition);
        pc.classList.add('src');
        playPick();
        if(!running) startTimer();
    }

    // Start drag from LEFT board wrong-filled slot
    function startDragFromSlot(slot, cx, cy) {
        const rect=slot.getBoundingClientRect();
        dOX=cx-rect.left; dOY=cy-rect.top;
        dVal=parseInt(slot.dataset.placedVal);
        dFromSlot=slot; dOrig=null;
        // Clone shows the placed piece image
        const pp=slot.querySelector('.placed');
        makeClone(rect, pp.style.backgroundImage, pp.style.backgroundSize, pp.style.backgroundPosition);
        // Immediately clear the slot back to empty ghost
        clearSlotToGhost(slot);
        playPick();
        if(!running) startTimer();
    }

    function makeClone(rect, bgImg, bgSize, bgPos) {
        dClone=document.createElement('div');
        dClone.id='clone';
        dClone.style.cssText=`width:${rect.width}px;height:${rect.height}px;left:${rect.left}px;top:${rect.top}px;background-image:${bgImg};background-size:${bgSize};background-position:${bgPos};`;
        document.body.appendChild(dClone);
    }

    // Restore a slot to its empty ghost state (no placed piece)
    function clearSlotToGhost(slot) {
        const tile=BOARD/N;
        const tv=parseInt(slot.dataset.t);
        slot.innerHTML='';
        slot.classList.remove('wrong-fill','filled');
        delete slot.dataset.placedVal;
        const gh=document.createElement('div');
        gh.className='ghost'; sprite(gh,tv,tile);
        slot.appendChild(gh);
    }

    function moveDrag(cx, cy) {
        dClone.style.left=(cx-dOX)+'px';
        dClone.style.top =(cy-dOY)+'px';
    }

    function hover(slot) {
        if(slot===dHover) return;
        dHover?.classList.remove('hover');
        dHover=slot;
        dHover?.classList.add('hover');
    }

    function drop(slot) {
        hover(null);
        dClone.remove(); dClone=null;
        dOrig?.classList.remove('src');

        if(slot){
            moves++;
            placeInSlot(slot, dVal, parseInt(slot.dataset.t) === dVal);
        } else if(dFromSlot) {
            // Dropped outside any slot → return piece to right board
            document.querySelector(`.piece[data-v="${dVal}"]`)?.classList.remove('used');
        }
        // If from right board and dropped outside → piece stays greyed (cancel drag)

        dOrig=null; dFromSlot=null; dVal=null;
    }

    /* ── Place piece into slot (correct OR wrong) ─────── */
    function placeInSlot(slot, val, isCorrect) {
        const tile = BOARD/N;

        // If replacing a previously wrong piece, un-use it in the right board
        if(slot.classList.contains('wrong-fill')) {
            const prev = parseInt(slot.dataset.placedVal ?? -1);
            if(prev >= 0) {
                document.querySelector(`.piece[data-v="${prev}"]`)?.classList.remove('used');
            }
        }

        slot.innerHTML = '';
        slot.classList.remove('wrong-fill', 'filled');

        const pp = document.createElement('div');
        pp.className = 'placed';
        sprite(pp, val, tile);
        slot.appendChild(pp);

        if(isCorrect) {
            placed.add(val);
            slot.classList.add('filled');
            delete slot.dataset.placedVal;
        } else {
            slot.classList.add('wrong-fill');
            slot.dataset.placedVal = val;
            // red overlay
            const ov = document.createElement('div');
            ov.className = 'wrong-overlay';
            slot.appendChild(ov);
        }

        // grey out in right board
        document.querySelector(`.piece[data-v="${val}"]`)?.classList.add('used');

        updateProg();
        if(placed.size === N*N) setTimeout(winGame, 350);
    }

    /* ── Score display ─────────────────────────────────── */
    function updateProg() {
        document.getElementById('s-placed').textContent=`${placed.size}/${N*N}`;
    }

    /* ── Countdown timer ───────────────────────────────── */
    function renderTime() {
        const el = document.getElementById('s-time');
        const mm = String(Math.floor(timeLeft/60)).padStart(2,'0');
        const ss = String(timeLeft%60).padStart(2,'0');
        el.textContent = `${mm}:${ss}`;
        el.className = 'tb-val';
        if (timeLeft <= 30)      el.classList.add('danger');
        else if (timeLeft <= 60) el.classList.add('warn');
    }

    function startTimer() {
        running = true;
        timeLeft = TIME_LIMIT[N];
        renderTime();
        tick = setInterval(() => {
            timeLeft--;
            renderTime();
            if (timeLeft <= 0) { stopTimer(); gameOver(); }
        }, 1000);
    }

    function stopTimer(){ clearInterval(tick); tick=null; running=false; }

    function resetStats(){
        stopTimer(); moves=0; timeLeft=TIME_LIMIT[N];
        renderTime();
        document.getElementById('s-placed').textContent=`0/${N*N}`;
    }

    /* ── Win ───────────────────────────────────────────── */
    function winGame() {
        stopTimer();
        const elapsed = TIME_LIMIT[N] - timeLeft;
        const mm=String(Math.floor(elapsed/60)).padStart(2,'0'), ss=String(elapsed%60).padStart(2,'0');
        const key=`${N}x${N}`;
        const best=store.best();
        if(!best[key]||moves<best[key].moves){ best[key]={moves,time:elapsed}; store.setBest(best); }
        const hist=store.hist();
        hist.unshift({size:key,moves,time:elapsed,date:new Date().toLocaleDateString()});
        if(hist.length>10) hist.pop();
        store.setHist(hist);
        renderHistory();
        document.getElementById('win-moves-v').textContent = moves;
        document.getElementById('win-time-v').textContent  = `${mm}:${ss}`;
        document.getElementById('win').classList.add('show');
        bgm.pause();
        sfxWin.currentTime = 0;
        sfxWin.play().catch(()=>{});
        startFireworks();
    }

    /* ── Public API ────────────────────────────────────── */
    function init(n) {
        N=n; placed.clear();
        const src = makeImg();
        imgURL = src.toDataURL('image/jpeg', .92);
        resetStats(); build(); updateProg(); renderHistory();
    }

    /* ── Audio ─────────────────────────────────────────── */
    const menuMusic = document.getElementById('menu-music');
    const bgm       = document.getElementById('bgm');
    const sfxPick   = document.getElementById('sfx-pick');
    const sfxWin      = document.getElementById('sfx-win');
    const sfxGameOver = document.getElementById('sfx-gameover');
    menuMusic.volume   = 0.5;
    bgm.volume         = 0.5;
    sfxPick.volume     = 0.8;
    sfxWin.volume      = 0.8;
    sfxGameOver.volume = 0.8;

    function playPick() {
        sfxPick.currentTime = 0;
        sfxPick.play().catch(()=>{});
    }

    /* ── Game Over ─────────────────────────────────────── */
    function gameOver() {
        bgm.pause();
        sfxGameOver.currentTime = 0;
        sfxGameOver.play().catch(()=>{});
        document.getElementById('gameover').classList.add('show');
    }

    function restartFromGameOver() {
        sfxGameOver.pause();
        sfxGameOver.currentTime = 0;
        document.getElementById('gameover').classList.remove('show');
        newGame();
        bgm.play().catch(()=>{});
    }

    function startGame(){
        // Fade out splash
        const sp = document.getElementById('splash');
        sp.classList.add('hide');
        setTimeout(() => { sp.style.display = 'none'; showRemember(); }, 550);
        // Switch music
        menuMusic.pause(); menuMusic.currentTime = 0;
        bgm.play().catch(()=>{});
    }

    function showRemember(){
        const screen  = document.getElementById('remember');
        const numEl   = document.getElementById('rmb-count');
        let count = 5;
        numEl.textContent = count;
        screen.classList.remove('hide-out');
        screen.classList.add('show');

        const iv = setInterval(() => {
            count--;
            numEl.textContent = count;
            // restart pulse animation
            numEl.style.animation = 'none';
            void numEl.offsetWidth;
            numEl.style.animation = '';
            if(count <= 0){
                clearInterval(iv);
                screen.classList.add('hide-out');
                setTimeout(() => screen.classList.remove('show', 'hide-out'), 450);
            }
        }, 1000);
    }

    function goToStart(){
        closeWin();
        sfxGameOver.pause(); sfxGameOver.currentTime = 0;
        document.getElementById('gameover').classList.remove('show');
        bgm.pause(); bgm.currentTime = 0;
        newGame();
        // Return to splash
        const sp = document.getElementById('splash');
        sp.style.display = '';
        sp.classList.remove('hide');
        menuMusic.currentTime = 0;
        menuMusic.play().catch(()=>{});
    }

    function toggleMute(){
        bgm.muted = !bgm.muted;
        document.getElementById('mute-icon').className =
            bgm.muted ? 'fa-solid fa-volume-xmark' : 'fa-solid fa-volume-high';
    }

    function newGame(){ closeWin(); placed.clear(); resetStats(); build(); updateProg(); }
    function newImage(){ init(N); } // image is fixed (puzzle.png)
    function reset(){ newGame(); }
    function closeWin(){
        document.getElementById('win').classList.remove('show');
        stopFireworks();
        sfxWin.pause();
        sfxWin.currentTime = 0;
        bgm.play().catch(()=>{});
    }

    function toggleHint(show) {
        document.getElementById('a-grid').classList.toggle('no-hint', !show);
        localStorage.setItem('cp3_hint', show ? '1' : '0');
    }

    function openSettings(){
        document.getElementById('settings-modal').classList.add('show');
        document.getElementById('cog-btn').classList.add('open');
    }
    function closeSettings(){
        document.getElementById('settings-modal').classList.remove('show');
        document.getElementById('cog-btn').classList.remove('open');
    }

    // close modal when clicking backdrop
    document.getElementById('settings-modal').addEventListener('click', e=>{
        if(e.target===document.getElementById('settings-modal')) closeSettings();
    });

    function setSize(n, btn){
        // sync all diff buttons (there is one set inside the modal)
        document.querySelectorAll('.diff-btn').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        init(n);
    }

    function renderHistory(){
        const hist=store.hist();
        const el=document.getElementById('sc-list');
        if(!hist.length){ el.innerHTML='<div class="no-sc">No scores yet — complete a puzzle!</div>'; return; }
        const mk=['gold','silver','bronze','',''];
        el.innerHTML=hist.slice(0,5).map((h,i)=>{
            const mm=String(Math.floor(h.time/60)).padStart(2,'0'),ss=String(h.time%60).padStart(2,'0');
            return `<div class="sc-row"><div class="sc-rank ${mk[i]}">#${i+1}</div><div class="sc-main"><div class="sc-moves">${h.moves} moves · ${h.size}</div><div class="sc-time">${mm}:${ss}</div></div><div class="sc-date">${h.date}</div></div>`;
        }).join('');
    }

    /* ── Fireworks ──────────────────────────────────────── */
    const fwCv  = document.getElementById('fw-canvas');
    const fwCtx = fwCv.getContext('2d');
    fwCv.width  = 1080;
    fwCv.height = 1920;

    let fwParticles = [], fwAnimId = null, fwLaunchId = null;
    const FW_COLS = ['#ff6b9d','#f59e0b','#0ea5e9','#34d399','#c084fc','#ef4444','#38bdf8','#fbbf24'];

    function fwBurst() {
        const x = 120 + Math.random() * 840;
        const y = 200 + Math.random() * 900;
        const col = FW_COLS[Math.floor(Math.random() * FW_COLS.length)];
        const count = 55 + Math.floor(Math.random() * 30);
        for(let i = 0; i < count; i++) {
            const angle = (Math.PI * 2 / count) * i + Math.random() * 0.3;
            const spd   = 4 + Math.random() * 9;
            fwParticles.push({
                x, y,
                vx: Math.cos(angle) * spd,
                vy: Math.sin(angle) * spd,
                alpha: 1,
                col,
                r: 2.5 + Math.random() * 3.5,
                decay: 0.012 + Math.random() * 0.014,
                gravity: 0.18,
            });
        }
    }

    function fwTick() {
        fwCtx.clearRect(0, 0, 1080, 1920);
        for(let i = fwParticles.length - 1; i >= 0; i--) {
            const p = fwParticles[i];
            p.x  += p.vx; p.y += p.vy;
            p.vy += p.gravity;
            p.vx *= 0.97;
            p.alpha -= p.decay;
            if(p.alpha <= 0){ fwParticles.splice(i,1); continue; }
            fwCtx.globalAlpha = p.alpha;
            fwCtx.fillStyle   = p.col;
            fwCtx.beginPath();
            fwCtx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            fwCtx.fill();
        }
        fwCtx.globalAlpha = 1;
        fwAnimId = requestAnimationFrame(fwTick);
    }

    function startFireworks() {
        fwParticles = [];
        // rapid bursts at start, then slow
        let shots = 0;
        fwBurst(); fwBurst();
        fwLaunchId = setInterval(()=>{
            fwBurst();
            if(Math.random() > 0.4) fwBurst();
            shots++;
            if(shots >= 14) {
                clearInterval(fwLaunchId);
                fwLaunchId = setInterval(fwBurst, 1800); // gentle ongoing
            }
        }, 350);
        fwTick();
    }

    function stopFireworks() {
        clearInterval(fwLaunchId);
        cancelAnimationFrame(fwAnimId);
        fwCtx.clearRect(0, 0, 1080, 1920);
        fwParticles = [];
    }

    /* ── Boot: load puzzle.png then initialise ─────────── */
    // Start menu music immediately (plays once browser allows it)
    menuMusic.play().catch(()=>{});
    initBg();

    // If autoplay was blocked, retry menu music on first touch/click of splash
    document.getElementById('splash').addEventListener('pointerdown', ()=>{
        menuMusic.play().catch(()=>{});
    }, { once: true });

    // Restore hint toggle preference
    (()=>{
        const saved = localStorage.getItem('cp3_hint');
        const show  = saved !== '0'; // default ON
        document.getElementById('hint-toggle').checked = show;
        if(!show) document.getElementById('a-grid').classList.add('no-hint');
    })();
    const _img = new Image();
    _img.onload = () => { puzzleImg = _img; init(3); };
    _img.onerror = () => console.error('puzzle.png failed to load');
    _img.src = PUZZLE_URL;

    return { startGame, newGame, newImage, reset, setSize, closeWin, openSettings, closeSettings, toggleHint, toggleMute, restartFromGameOver, goToStart };
})();
</script>

</body>
</html>
