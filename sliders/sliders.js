/*
  Trilemma Sliders — sliders.js
  --------------------------------
  6 horses, quality-driven (range 10–90):
    horse-1  10–23   worst
    horse-2  24–37
    horse-3  38–51
    horse-4  52–65
    horse-5  66–79
    horse-6  80–90   best

  Limits:
    price   : 10–90
    quality : 10–90
    speed   : 10–100

  Luck Factor:
    - bad state  (quality < 50) → horse-luck-bad  (cubist/expressive style)
    - good state (quality >= 50) → horse-luck-good (unicorn/special)
    - turns off on any slider interaction
*/

const s = {
  price:   document.getElementById('s-price'),
  quality: document.getElementById('s-quality'),
  speed:   document.getElementById('s-speed'),
};

const vDisplay = {
  price:   document.getElementById('v-price'),
  quality: document.getElementById('v-quality'),
  speed:   document.getElementById('v-speed'),
};

const badge     = document.getElementById('badge-verdict');
const luckCb    = document.getElementById('luck-factor');
const rightEl   = document.querySelector('.right');

const horses    = ['horse-1','horse-2','horse-3','horse-4','horse-5','horse-6'];
const horseBg   = ['#ffffff','#ffffff','#ffffff','#c8c6c2','#c8c6c2','#c8c6c2'];
const luckImgs  = ['horse-luck-0','horse-luck-1','horse-luck-2','horse-luck-3','horse-luck-4','horse-luck-5'];

let active      = null;
let luckActive  = false;

// ── Helpers ──────────────────────────────────────────────

function showHorse(idx) {
  horses.forEach((id, i) => {
    document.getElementById(id).style.opacity = i === idx ? '1' : '0';
  });
  luckImgs.forEach(id => {
    document.getElementById(id).style.opacity = '0';
  });
  rightEl.style.background = horseBg[idx];
}

function showLuck() {
  const randomIdx = Math.floor(Math.random() * luckImgs.length);
  horses.forEach(id => {
    document.getElementById(id).style.opacity = '0';
  });
  luckImgs.forEach((id, i) => {
    document.getElementById(id).style.opacity = i === randomIdx ? '1' : '0';
  });
  rightEl.style.background = '#ffffff';
}

function getHorseIdx(q) {
  if      (q <= 23) return 0;
  else if (q <= 37) return 1;
  else if (q <= 51) return 2;
  else if (q <= 65) return 3;
  else if (q <= 79) return 4;
  else              return 5;
}

function clampPrice(v)   { return Math.min(90, Math.max(10, v)); }
function clampQuality(v) { return Math.min(90, Math.max(10, v)); }
function clampSpeed(v)   { return Math.min(100, Math.max(10, v)); }

function applyRules(changed, val) {
  /*
    Speed range:  10–100 (span = 90)
    Price/Quality range: 10–90 (span = 80)

    Mapping speed → price/quality (inverted, scaled):
      speed=10  → pq=90
      speed=100 → pq=10
      formula: pq = 90 - ((val - 10) / 90) * 80

    Mapping price/quality → speed (inverted, scaled):
      pq=10 → speed=100
      pq=90 → speed=10
      formula: speed = 100 - ((val - 10) / 80) * 90
  */
  if (changed === 'price') {
    s.price.value   = clampPrice(val);
    s.quality.value = clampQuality(val);
    s.speed.value   = clampSpeed(Math.round(100 - ((val - 10) / 80) * 90));
  } else if (changed === 'quality') {
    s.quality.value = clampQuality(val);
    s.price.value   = clampPrice(val);
    s.speed.value   = clampSpeed(Math.round(100 - ((val - 10) / 80) * 90));
  } else {
    s.speed.value   = clampSpeed(val);
    const inv = Math.round(90 - ((val - 10) / 90) * 80);
    s.price.value   = clampPrice(inv);
    s.quality.value = clampQuality(inv);
  }
}

function updateValueDisplays() {
  Object.keys(vDisplay).forEach(k => {
    vDisplay[k].textContent = s[k].value;
  });
}

function updateBadge() {
  const p  = +s.price.value;
  const q  = +s.quality.value;
  const sp = +s.speed.value;
  const parts = [];

  if (p  < 35) parts.push('cheap');
  if (p  > 65) parts.push('expensive');
  if (q  < 35) parts.push('poor quality');
  if (q  > 65) parts.push('good quality');
  if (sp < 40) parts.push('slow');
  if (sp > 70) parts.push('fast');

  if (!parts.length) {
    badge.textContent = 'Balanced';
    badge.className   = 'badge badge-neutral';
    return;
  }

  badge.textContent = parts.join(' · ');
  const hasGood = parts.some(l => ['good quality','fast','cheap'].includes(l));
  const hasBad  = parts.some(l => ['poor quality','slow','expensive'].includes(l));
  badge.className = 'badge ' + (hasGood && !hasBad ? 'badge-cyan' : hasBad && !hasGood ? 'badge-coral' : 'badge-mixed');
}

function updateVisuals() {
  if (luckActive) return; // don't change horse while luck is on
  showHorse(getHorseIdx(+s.quality.value));
  updateValueDisplays();
  updateBadge();
}

// ── Slider events ─────────────────────────────────────────

// Hard limits per slider
const LIMITS = {
  price:   { min: 10, max: 90  },
  quality: { min: 10, max: 90  },
  speed:   { min: 10, max: 100 },
};

function enforceLimits(key) {
  const lim = LIMITS[key];
  const v = +s[key].value;
  if (v < lim.min) s[key].value = lim.min;
  if (v > lim.max) s[key].value = lim.max;
}

Object.keys(s).forEach(key => {
  s[key].addEventListener('mousedown', () => {
    active = key;
    if (luckActive) {
      luckActive = false;
      luckCb.checked = false;
    }
  });
  s[key].addEventListener('touchstart', () => {
    active = key;
    if (luckActive) {
      luckActive = false;
      luckCb.checked = false;
    }
  }, { passive: true });
  s[key].addEventListener('input', () => {
    if (active !== key) return;
    enforceLimits(key);
    applyRules(key, +s[key].value);
    updateVisuals();
  });
});

document.addEventListener('mouseup',  () => active = null);
document.addEventListener('touchend', () => active = null);

// ── Luck Factor ───────────────────────────────────────────

luckCb.addEventListener('change', () => {
  luckActive = luckCb.checked;
  if (luckActive) {
    showLuck();
  } else {
    updateVisuals();
  }
});

// ── Init ──────────────────────────────────────────────────

updateVisuals();