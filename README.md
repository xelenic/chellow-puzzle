# Chellow Puzzle

A full-screen **drag-and-drop jigsaw puzzle game** built with Laravel, designed for **1080 × 1920 kiosk displays**. No build tools required — pure HTML, CSS, and vanilla JavaScript served by Laravel Blade.

---

## Game Flow

```
Splash Screen  →  Memorize Screen (5 s)  →  Game  →  Win / Game Over  →  Splash
```

| Screen | Description |
|---|---|
| **Splash** | Logo + animated "Start Game" 3D button, menu music plays |
| **Remember** | Full puzzle image shown for 5 seconds with countdown |
| **Game** | Two boards — assemble pieces by dragging from bottom to top |
| **Win** | Fireworks, congratulations, winning music |
| **Game Over** | Shown when 1-minute countdown reaches zero |

---

## Features

- **1080 × 1920 fixed layout** — no scrolling, built for kiosk machines
- **Two-board drag-and-drop** — pieces board (bottom) → assembly board (top)
- **Wrong placements allowed** — pieces show a red overlay and can be picked up again
- **1-minute countdown timer** — game ends automatically when time runs out
- **Three difficulty levels** — 3 × 3 (Easy), 4 × 4 (Medium), 5 × 5 (Hard)
- **Ghost hint images** — faint shadow of the correct piece in each empty slot (toggleable)
- **Full audio suite** — menu music, game music, pick SFX, win music, game-over music
- **Win fireworks** — canvas-based particle fireworks animation
- **Splash → Remember → Game** flow with smooth transitions
- **Settings modal** — difficulty selector + hint toggle via cog icon
- **Sky-blue / white theme** — clean, bright kiosk-friendly design
- **Patrick Hand** Google Font throughout

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13 (PHP) |
| Frontend | Vanilla HTML5, CSS3, JavaScript (no build tools) |
| Font | Google Fonts — Patrick Hand |
| Icons | Font Awesome 6 (CDN) |
| Canvas | HTML5 Canvas API (fireworks, sky background) |
| Storage | `localStorage` (scores, preferences) |

---

## Requirements

- PHP >= 8.2
- Composer
- Laravel 13.x

---

## Installation

```bash
# Clone the repository
git clone https://github.com/xelenic/chellow-puzzle.git
cd chellow-puzzle

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Start the development server
php artisan serve
```

Open **http://localhost:8000** in your browser.

---

## Project Structure

```
chellow-puzzle/
├── public/
│   ├── logo.png                  # Chellow logo (topbar, splash, win, game over)
│   ├── puzzle.png                # Puzzle image (2000 × 2000 px, square)
│   ├── background_music.mp3      # In-game background music (looped)
│   ├── menu_music.mp3            # Splash screen music (looped)
│   ├── pick_item.mp3             # Sound when picking up a puzzle piece
│   ├── wining.mp3                # Win screen music
│   └── game_over.mp3             # Game over screen music
├── resources/
│   └── views/
│       └── game.blade.php        # Entire game (HTML + CSS + JS, single file)
└── routes/
    └── web.php                   # Single route → game view
```

---

## Game Screens

### 1. Splash Screen
- Displays **logo.png** with a gentle floating animation
- **Start Game** — 3D sky-blue button
- Menu music plays in the background

### 2. Remember Screen
- Shows the full **puzzle.png** for **5 seconds**
- Large pulsing countdown (5 → 4 → 3 → 2 → 1)
- Gives players a chance to memorise the target image
- Game music begins here

### 3. Game Screen

**Top bar (fixed):**

| Position | Element |
|---|---|
| Left | Chellow logo |
| Centre | Countdown timer (starts at 1:00, turns amber at 60 s, red at 30 s) |
| Right | Mute · Reset · Settings cog |

**Assembly Board (top)** — empty slots with faint ghost hints

**Pieces Board (bottom)** — shuffled puzzle pieces to drag

**Drag rules:**
- Drop on correct slot → piece locks with sky-blue glow
- Drop on wrong slot → piece placed with red overlay (can be lifted and moved again)
- Drop outside both boards → piece returns to the pieces board

### 4. Win Screen
- Full white background with logo
- Rainbow gradient "Congratulation You Won!"
- Move count and time stats
- Canvas fireworks animation
- **Play Again** → returns to Splash screen

### 5. Game Over Screen
- Full white background with logo
- Bold red "Game Over" and "Time's Up!"
- **Try Again** → returns to Splash screen

---

## Settings Modal

Open via the cog icon in the top-right corner of the top bar.

| Setting | Options |
|---|---|
| **Difficulty** | 3 × 3 Easy · 4 × 4 Medium · 5 × 5 Hard |
| **Show hint image** | Toggle ghost image in empty assembly slots on/off |

---

## Audio Files

All audio files must be placed in the `public/` folder:

| File | Plays when |
|---|---|
| `menu_music.mp3` | Splash screen is displayed |
| `background_music.mp3` | Game is being played |
| `pick_item.mp3` | Player picks up a puzzle piece |
| `wining.mp3` | Win screen is shown |
| `game_over.mp3` | Game over screen is shown |

---

## Kiosk Setup

The game is designed for **1080 × 1920** portrait displays.

**Chrome kiosk mode example:**
```bash
google-chrome \
  --kiosk \
  --autoplay-policy=no-user-gesture-required \
  http://localhost:8000
```

**Recommended settings:**
- Full-screen / kiosk mode (no address bar or tabs)
- Autoplay audio enabled
- Browser zoom at 100%

---

## Customisation

| What to change | Where |
|---|---|
| Puzzle image | Replace `public/puzzle.png` (must be square) |
| Logo | Replace `public/logo.png` |
| Countdown duration | `TIME_LIMIT` constant in `game.blade.php` (default: `60`) |
| Remember screen duration | `count = 5` in `showRemember()` in `game.blade.php` |
| Music / SFX | Replace any `.mp3` file in `public/` |

---

## License

MIT © Chellow
