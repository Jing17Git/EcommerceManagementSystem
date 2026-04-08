# Visual Popup Comparison

## Simple Warning Popup Design

```
╔═══════════════════════════════════════════════════════════╗
║                                                           ║
║                    ⚠️  WARNING ICON                       ║
║                  (Yellow gradient bg)                     ║
║                                                           ║
║              Invalid Credentials                          ║
║              (Bold, 2xl font)                            ║
║                                                           ║
║         ┌─────────────────────────────┐                  ║
║         │                             │                  ║
║         │            3                │                  ║
║         │     (Large number)          │                  ║
║         │                             │                  ║
║         │   Attempts Remaining        │                  ║
║         │                             │                  ║
║         └─────────────────────────────┘                  ║
║              (Amber background)                           ║
║                                                           ║
║    Invalid credentials. You have 3 attempt(s)            ║
║    remaining before temporary lockout.                   ║
║         (Small gray text)                                ║
║                                                           ║
║         ┌─────────────────────────────┐                  ║
║         │       Try Again             │                  ║
║         │    (Black button)           │                  ║
║         └─────────────────────────────┘                  ║
║                                                           ║
╚═══════════════════════════════════════════════════════════╝
```

## Simple Lockout Popup Design

```
╔═══════════════════════════════════════════════════════════╗
║                                                           ║
║                    🔒  LOCK ICON                          ║
║                   (Red gradient bg)                       ║
║                                                           ║
║               Account Locked                              ║
║               (Bold, 2xl font)                           ║
║                                                           ║
║         ┌─────────────────────────────┐                  ║
║         │                             │                  ║
║         │  Too many failed login      │                  ║
║         │  attempts. Please try       │                  ║
║         │  again after 5 minute(s).   │                  ║
║         │                             │                  ║
║         └─────────────────────────────┘                  ║
║              (Red background)                             ║
║                                                           ║
║         ┌─────────────────────────────┐                  ║
║         │  🔒  Security protection    │                  ║
║         │      active                 │                  ║
║         └─────────────────────────────┘                  ║
║              (Gray background)                            ║
║                                                           ║
║         ┌─────────────────────────────┐                  ║
║         │  ⏰  Auto-unlock in         │                  ║
║         │      5 minutes              │                  ║
║         └─────────────────────────────┘                  ║
║              (Gray background)                            ║
║                                                           ║
║         ┌─────────────────────────────┐                  ║
║         │         Got it              │                  ║
║         │     (Black button)          │                  ║
║         └─────────────────────────────┘                  ║
║                                                           ║
╚═══════════════════════════════════════════════════════════╝
```

## Mobile View (Responsive)

```
┌─────────────────────┐
│                     │
│      ⚠️ Icon        │
│                     │
│  Invalid            │
│  Credentials        │
│                     │
│  ┌───────────────┐  │
│  │      3        │  │
│  │   Attempts    │  │
│  │   Remaining   │  │
│  └───────────────┘  │
│                     │
│  Message text...    │
│                     │
│  ┌───────────────┐  │
│  │  Try Again    │  │
│  └───────────────┘  │
│                     │
└─────────────────────┘
```

## Color Scheme

### Warning Popup
```
Background:     White (#FFFFFF)
Overlay:        Dark with blur (rgba(15, 23, 42, 0.7))
Icon BG:        Yellow gradient (#FEF3C7 → #FDE68A)
Icon Color:     Amber (#D97706)
Message BG:     Amber light (#FEF3C7)
Message Text:   Amber dark (#78350F)
Button BG:      Black (#111827)
Button Text:    White (#FFFFFF)
```

### Lockout Popup
```
Background:     White (#FFFFFF)
Overlay:        Dark with blur (rgba(15, 23, 42, 0.7))
Icon BG:        Red gradient (#FEE2E2 → #FECACA)
Icon Color:     Red (#DC2626)
Message BG:     Red light (#FEE2E2)
Message Text:   Red dark (#991B1B)
Info Cards BG:  Gray (#F9FAFB)
Button BG:      Black (#111827)
Button Text:    White (#FFFFFF)
```

## Animation Sequence

```
Step 1: Overlay Fade In (0.3s)
┌─────────────────────────────────┐
│ Transparent → Dark with blur    │
└─────────────────────────────────┘

Step 2: Modal Slide Up (0.4s)
┌─────────────────────────────────┐
│ translateY(30px) → translateY(0)│
│ opacity: 0 → opacity: 1         │
└─────────────────────────────────┘

Step 3: Icon Pulse (2s loop)
┌─────────────────────────────────┐
│ scale(1) → scale(1.05) → scale(1)│
└─────────────────────────────────┘

Step 4: Sound Effect
┌─────────────────────────────────┐
│ Warning: 400Hz beep (0.1s)      │
│ Error: 200Hz + 150Hz (0.3s)     │
└─────────────────────────────────┘
```

## Interaction States

### Button Hover
```
Normal:     bg-gray-900
Hover:      bg-gray-800 + shadow
Active:     bg-gray-900 (pressed)
```

### Close Actions
```
✅ Click button       → Close with fade out
✅ Press ESC          → Close (warning only)
✅ Click backdrop     → Close (warning only)
❌ Click backdrop     → No action (lockout)
```

## Accessibility

```
✅ Keyboard Navigation
   - Tab to button
   - Enter to close
   - ESC to close (warning)

✅ Screen Reader
   - Role: dialog
   - Aria-label: "Security Alert"
   - Aria-describedby: message

✅ Focus Management
   - Trap focus in modal
   - Return focus on close
   - Prevent body scroll

✅ Color Contrast
   - Text: WCAG AA compliant
   - Icons: High contrast
   - Buttons: Clear visibility
```

## Size Specifications

```
Modal Width:        480px max
Modal Padding:      32px (p-8)
Icon Size:          80px diameter
Icon Inner:         40px (w-10 h-10)
Title Font:         24px (text-2xl)
Message Font:       14px (text-sm)
Button Height:      48px (py-3)
Border Radius:      24px (rounded-2xl)
```

## Spacing

```
Icon to Title:      24px (mb-6)
Title to Message:   12px (mb-3)
Message to Info:    24px (mb-6)
Info to Button:     24px (mb-6)
Between Info Cards: 12px (space-y-3)
```

## Typography

```
Title:      font-bold text-2xl text-gray-900
Subtitle:   font-normal text-sm text-gray-600
Message:    font-normal text-sm text-red/amber-800
Button:     font-semibold text-base text-white
Info:       font-normal text-sm text-gray-700
```

## Shadow & Effects

```
Modal Shadow:       0 25px 50px -12px rgba(0,0,0,0.25)
Button Shadow:      shadow-lg shadow-gray-900/20
Backdrop Blur:      blur(12px)
Border Radius:      24px (rounded-2xl)
Transitions:        all 0.3s ease
```

## Responsive Breakpoints

```
Mobile (< 640px):
- Modal width: 100% - 40px
- Padding: 24px (p-6)
- Font sizes: -2px

Tablet (640px - 1024px):
- Modal width: 480px
- Padding: 32px (p-8)
- Font sizes: normal

Desktop (> 1024px):
- Modal width: 480px
- Padding: 32px (p-8)
- Font sizes: normal
```

## Browser Support

```
✅ Chrome 90+
✅ Firefox 88+
✅ Safari 14+
✅ Edge 90+
✅ Mobile Safari
✅ Chrome Mobile
```

## Performance

```
Load Time:      < 50ms
Animation:      60fps
Memory:         < 1MB
CPU Usage:      < 5%
```

---

**Design System**: Minimal & Clean  
**Framework**: Tailwind CSS  
**Icons**: Heroicons (SVG)  
**Animations**: CSS Keyframes  
**Sound**: Web Audio API
