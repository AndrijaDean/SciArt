/*
  Trilemma Sliders — sliders.js
  --------------------------------
  Relationship map:
    price   → quality same direction, speed opposite
    quality → price same direction,   speed opposite
    speed   → price opposite,         quality opposite

  Image order (worst → best, driven by quality value):
    horse-1  0–25   worst
    horse-2  26–50
    horse-3  51–75
    horse-4  76–100 best

  Required HTML element IDs:
    Sliders : s-price, s-quality, s-speed
    Images  : horse-1, horse-2, horse-3, horse-4
    Badge   : badge-verdict
*/

const s = {
  price:   document.getElementById('s-price'),
  quality: document.getElementById('s-quality'),
  speed:   document.getElementById('s-speed'),
};

const badge  = document.getElementById('badge-verdict');
const horses = ['horse-1', 'horse-2', 'horse-3', 'horse-4'];

let active = null;

const rightEl = document.querySelector('.right');
const horseBg = ['#ffffff', '#ffffff', '#c8c6c2', '#c8c6c2'];

function showHorse(idx) {
  horses.forEach((id, i) => {
    document.getElementById(id).style.opacity = i === idx ? '1' : '0';
  });
  rightEl.style.background = horseBg[idx];
}

function applyRules(changed, val) {
  if (changed === 'price') {
    s.quality.value = val;        // cheap → poor,  expensive → good
    s.speed.value   = 100 - val;  // cheap → fast,  expensive → slow
  } else if (changed === 'quality') {
    s.price.value   = val;        // poor  → cheap, good → expensive
    s.speed.value   = 100 - val;  // poor  → fast,  good → slow
  } else {
    s.price.value   = 100 - val;  // fast  → cheap, slow → expensive
    s.quality.value = 100 - val;  // fast  → poor,  slow → good
  }
}

function updateVisuals() {
  const q = +s.quality.value;

  if      (q <= 25) showHorse(0);
  else if (q <= 50) showHorse(1);
  else if (q <= 75) showHorse(2);
  else              showHorse(3);

  const p  = +s.price.value;
  const sp = +s.speed.value;
  const parts = [];

  if (p  < 35) parts.push('cheap');
  if (p  > 65) parts.push('expensive');
  if (q  < 35) parts.push('poor quality');
  if (q  > 65) parts.push('good quality');
  if (sp < 35) parts.push('slow');
  if (sp > 65) parts.push('fast');

  if (!parts.length) {
    badge.textContent = 'Balanced';
    badge.className   = 'badge badge-neutral';
    return;
  }

  badge.textContent = parts.join(' · ');
  const hasGood = parts.some(l => ['good quality', 'fast', 'cheap'].includes(l));
  const hasBad  = parts.some(l => ['poor quality', 'slow', 'expensive'].includes(l));
  badge.className = 'badge ' + (hasGood && !hasBad ? 'badge-cyan' : hasBad && !hasGood ? 'badge-coral' : 'badge-mixed');
}

Object.keys(s).forEach(key => {
  s[key].addEventListener('mousedown',  () => active = key);
  s[key].addEventListener('touchstart', () => active = key, { passive: true });
  s[key].addEventListener('input', () => {
    if (active !== key) return;
    applyRules(key, +s[key].value);
    updateVisuals();
  });
});

document.addEventListener('mouseup',  () => active = null);
document.addEventListener('touchend', () => active = null);

updateVisuals();