<?php
/**
 * Ecommerce Calculators
 * ROAS | POAS | Discount Impact
 * Built for UK Ecommerce Businesses
 */

$page_title    = 'Ecommerce Calculators';
$page_subtitle = 'ROAS, POAS and Discount Impact — all based on real accounting logic.';
$current_year  = date('Y');
$current_date  = date('d F Y');

// Default values (can be overridden via GET params or CMS)
$defaults = [
    'roas_spend_0' => 100000,
    'roas_rev_0'   => 1000000,
    'd_price'      => 50,
    'd_cogs'       => 20,
    'd_units'      => 500,
    'poas_target'  => 40,
];

// Channels list
$channels = [
    'Google Search',
    'Google Shopping',
    'Meta (Facebook)',
    'Meta (Instagram)',
    'TikTok Ads',
    'Microsoft Ads',
    'Pinterest Ads',
    'Amazon Ads',
    'Email Marketing',
    'Other',
];

$discount_rates  = [0, 5, 10, 15, 20, 25];
$default_uplift  = [0, 5, 10, 20, 30, 45];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($page_title); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
:root {
  --primary: #00A3E8;
  --secondary: #007DB3;
  --text: #143D58;
  --accent: #F6961B;
  --bg: #F0F8FD;
  --card: #FFFFFF;
  --border: #D0EAF8;
  --muted: #6B8FA8;
  --success: #16a34a;
  --danger: #dc2626;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Urbanist', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

header { background: var(--text); padding: 18px 40px; display: flex; align-items: center; gap: 12px; }
.logo-mark { width: 36px; height: 36px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; font-weight: 900; color: #fff; }
.logo-text { color: #fff; font-size: 17px; font-weight: 700; }
.logo-text span { color: var(--primary); }

.hero { background: linear-gradient(135deg, var(--text) 0%, #1a5275 60%, var(--secondary) 100%); padding: 48px 40px 40px; text-align: center; }
.hero-tag { display: inline-block; background: rgba(246,150,27,0.2); color: var(--accent); font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 14px; border-radius: 20px; border: 1px solid rgba(246,150,27,0.35); margin-bottom: 16px; }
.hero h1 { font-size: clamp(24px,4vw,44px); font-weight: 900; color: #fff; line-height: 1.1; margin-bottom: 10px; }
.hero h1 span { color: var(--primary); }
.hero p { color: rgba(255,255,255,0.65); font-size: 15px; max-width: 500px; margin: 0 auto 24px; line-height: 1.6; }

.tabs-wrap { text-align: center; background: var(--bg); padding: 20px 20px 0; }
.tabs-nav { display: inline-flex; background: #fff; border-radius: 14px; padding: 4px; gap: 4px; border: 1.5px solid var(--border); box-shadow: 0 2px 12px rgba(20,61,88,0.08); }
.tab-btn { padding: 10px 24px; border-radius: 10px; border: none; font-family: 'Urbanist', sans-serif; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; color: var(--muted); background: transparent; }
.tab-btn.active { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(0,163,232,0.4); }
.tab-btn:hover:not(.active) { color: var(--text); background: var(--bg); }

main { max-width: 1100px; margin: 0 auto 60px; padding: 28px 20px 0; }
.tab-panel { display: none; }
.tab-panel.active { display: block; }

.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start; }
@media(max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }

.section-divider { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--muted); margin: 20px 0 12px; display: flex; align-items: center; gap: 10px; }
.section-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

.card { background: var(--card); border-radius: 16px; border: 1.5px solid var(--border); padding: 22px; box-shadow: 0 2px 16px rgba(20,61,88,0.05); margin-bottom: 16px; }
.card-title { font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.card-title .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--primary); }

.field { margin-bottom: 14px; }
.field label { display: flex; align-items: center; font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 5px; gap: 6px; }
.info-btn { width: 16px; height: 16px; border-radius: 50%; background: var(--border); border: none; cursor: pointer; font-size: 10px; font-weight: 700; color: var(--muted); display: inline-flex; align-items: center; justify-content: center; transition: background 0.2s; }
.info-btn:hover { background: var(--primary); color: #fff; }
.input-wrap { position: relative; display: flex; align-items: center; }
.input-wrap .prefix, .input-wrap .suffix { position: absolute; font-size: 13px; font-weight: 600; color: var(--muted); pointer-events: none; }
.input-wrap .prefix { left: 12px; }
.input-wrap .suffix { right: 12px; }
.input-wrap input { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-family: 'Urbanist', sans-serif; font-size: 14px; font-weight: 600; color: var(--text); background: #F7FBFF; transition: border-color 0.2s; outline: none; }
.input-wrap input:focus { border-color: var(--primary); background: #fff; }
.input-wrap.has-prefix input { padding-left: 28px; }
.input-wrap.has-suffix input { padding-right: 32px; }

.slider-field { margin-bottom: 14px; }
.slider-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
.slider-header label { font-size: 12px; font-weight: 600; color: var(--muted); display: flex; align-items: center; gap: 6px; }
.slider-val { font-size: 13px; font-weight: 700; color: var(--text); background: var(--bg); padding: 2px 9px; border-radius: 7px; border: 1.5px solid var(--border); min-width: 48px; text-align: center; }
input[type=range] { -webkit-appearance: none; width: 100%; height: 4px; border-radius: 4px; outline: none; background: var(--border); cursor: pointer; }
input[type=range]::-webkit-slider-thumb { -webkit-appearance: none; width: 16px; height: 16px; border-radius: 50%; background: var(--primary); border: 3px solid #fff; box-shadow: 0 2px 6px rgba(0,163,232,0.4); cursor: pointer; }

.result-card { background: linear-gradient(145deg, var(--text), #1d5070); border-radius: 16px; padding: 22px; color: white; box-shadow: 0 8px 32px rgba(20,61,88,0.2); margin-bottom: 16px; }
.result-card .rc-title { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.45); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.result-card .rc-title .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--accent); }
.metric-big { margin-bottom: 16px; }
.metric-big .lbl { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.45); margin-bottom: 3px; }
.metric-big .val { font-size: 36px; font-weight: 900; line-height: 1; color: #fff; }
.metric-big .val.accent { color: var(--accent); }
.metric-big .val.green { color: #4ade80; }
.metric-big .val.red   { color: #f87171; }
.divider { border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 14px 0; }
.metric-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid rgba(255,255,255,0.07); font-size: 13px; }
.metric-row:last-child { border-bottom: none; }
.metric-row .mn { color: rgba(255,255,255,0.55); font-weight: 500; }
.metric-row .mv { font-weight: 700; color: #fff; }
.metric-row .mv.green  { color: #4ade80; }
.metric-row .mv.red    { color: #f87171; }
.metric-row .mv.orange { color: var(--accent); }

.verdict { margin-top: 14px; padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 600; display: flex; align-items: flex-start; gap: 8px; line-height: 1.5; }
.verdict.good { background: rgba(74,222,128,0.12); color: #4ade80; border: 1px solid rgba(74,222,128,0.2); }
.verdict.ok   { background: rgba(246,150,27,0.12); color: var(--accent); border: 1px solid rgba(246,150,27,0.2); }
.verdict.bad  { background: rgba(248,113,113,0.12); color: #f87171; border: 1px solid rgba(248,113,113,0.2); }

.bench-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.bench-table th { text-align: left; padding: 7px 10px; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: rgba(255,255,255,0.4); border-bottom: 1px solid rgba(255,255,255,0.1); }
.bench-table td { padding: 6px 10px; border-bottom: 1px solid rgba(255,255,255,0.07); color: rgba(255,255,255,0.75); }
.bench-table tr:last-child td { border-bottom: none; }
.bench-table td:last-child { color: rgba(255,255,255,0.5); font-size: 11px; }
.bench-badge { display: inline-block; padding: 2px 8px; border-radius: 5px; font-weight: 700; font-size: 11px; }
.bench-bad   { background: rgba(248,113,113,0.2); color: #f87171; }
.bench-ok    { background: rgba(246,150,27,0.2);  color: var(--accent); }
.bench-good  { background: rgba(74,222,128,0.2);  color: #4ade80; }
.bench-great { background: rgba(0,163,232,0.2);   color: var(--primary); }

.ch-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.ch-table thead tr { border-bottom: 1.5px solid var(--border); }
.ch-table th { text-align: left; padding: 6px 8px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); white-space: nowrap; }
.ch-table th:not(:first-child) { text-align: right; }
.ch-table td { padding: 7px 8px; border-bottom: 1px solid var(--border); white-space: nowrap; }
.ch-table td:first-child { width: 38%; }
.ch-table td:not(:first-child) { text-align: right; }
.ch-table td input { width: 100%; text-align: right; border: none; background: transparent; font-family: 'Urbanist', sans-serif; font-size: 13px; font-weight: 600; color: var(--text); outline: none; padding: 2px 4px; border-radius: 5px; }
.ch-table td input:focus { background: #EBF5FC; }
.ch-table tfoot td { font-weight: 700; color: var(--text); border-top: 1.5px solid var(--border); border-bottom: none; padding-top: 9px; white-space: nowrap; }
.ch-table tfoot td:not(:first-child) { text-align: right; }
.roas-pill { display: inline-block; padding: 2px 8px; border-radius: 6px; font-weight: 700; font-size: 12px; white-space: nowrap; }

.disc-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.disc-table th { padding: 7px 10px; text-align: right; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); border-bottom: 1.5px solid var(--border); }
.disc-table th:first-child { text-align: left; }
.disc-table td { padding: 7px 10px; border-bottom: 1px solid var(--border); text-align: right; font-weight: 600; font-size: 12px; }
.disc-table td:first-child { text-align: left; color: var(--muted); font-weight: 500; }
.disc-table input[type=number] { width: 60px; text-align: right; border: 1.5px solid var(--border); border-radius: 6px; font-family: 'Urbanist', sans-serif; font-size: 12px; font-weight: 700; color: var(--primary); outline: none; padding: 3px 6px; background: #EBF5FC; }
.disc-table input[type=number]:focus { border-color: var(--primary); }
.verdict-cell { font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 5px; white-space: nowrap; }
.v-baseline { background: rgba(0,163,232,0.1); color: var(--primary); }
.v-warn { background: rgba(246,150,27,0.15); color: var(--accent); }
.v-bad  { background: rgba(248,113,113,0.15); color: #dc2626; }

.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(20,61,88,0.55); z-index: 1000; align-items: center; justify-content: center; }
.modal-overlay.open { display: flex; }
.modal { background: #fff; border-radius: 20px; padding: 28px 30px; max-width: 420px; width: 90%; position: relative; box-shadow: 0 20px 60px rgba(20,61,88,0.25); animation: modalIn 0.2s ease; }
@keyframes modalIn { from { transform: scale(0.92); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.modal-close { position: absolute; top: 16px; right: 18px; background: var(--border); border: none; border-radius: 8px; width: 30px; height: 30px; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; color: var(--muted); }
.modal-close:hover { background: var(--text); color: #fff; }
.modal h3 { font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 10px; }
.modal p { font-size: 13px; color: var(--muted); line-height: 1.65; }
.modal .formula-box { background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; padding: 12px 14px; margin-top: 12px; font-size: 13px; font-weight: 600; color: var(--text); font-family: monospace; }

.pdf-wrap { text-align: center; margin: 28px 0 40px; }
.pdf-btn { background: var(--text); color: #fff; font-family: 'Urbanist', sans-serif; font-size: 15px; font-weight: 700; border: none; padding: 14px 32px; border-radius: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 20px rgba(20,61,88,0.2); transition: transform 0.15s; }
.pdf-btn:hover { transform: translateY(-2px); }

@media print {
  @page { size: A4; margin: 10mm; }
  body > * { display: none !important; }
  #print-summary { display: flex !important; flex-direction: column; justify-content: space-between; min-height: calc(100vh - 20mm); }
}
#print-summary { display: none; font-family: Arial, sans-serif; }
.ps-header { display: flex; align-items: center; gap: 12px; padding-bottom: 12px; margin-bottom: 16px; border-bottom: 2px solid #00A3E8; }
.ps-logo { width: 34px; height: 34px; background: #143D58; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 15px; }
.ps-title { font-size: 18px; font-weight: 800; color: #143D58; }
.ps-sub { font-size: 10px; color: #6B8FA8; letter-spacing: 1px; text-transform: uppercase; }
.ps-date { margin-left: auto; font-size: 10px; color: #6B8FA8; }
.ps-box { border: 2px solid #143D58; border-radius: 10px; padding: 14px 18px; margin-bottom: 10px; flex: 1; background: #fff; }
.ps-box-title { font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #6B8FA8; margin-bottom: 8px; display: flex; align-items: center; gap: 7px; }
.ps-box-title::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #F6961B; flex-shrink: 0; }
.ps-big { font-size: 26px; font-weight: 900; color: #F6961B; margin-bottom: 8px; line-height: 1; }
.ps-big span { font-size: 11px; font-weight: 600; color: #6B8FA8; display: block; margin-bottom: 2px; }
.ps-rows { border-top: 1px solid #D0EAF8; padding-top: 6px; }
.ps-row { display: flex; justify-content: space-between; padding: 3px 0; border-bottom: 1px solid #EEF5FB; font-size: 11px; }
.ps-row:last-child { border-bottom: none; }
.ps-row .psl { color: #6B8FA8; }
.ps-row .psv { font-weight: 700; color: #143D58; }
.ps-row .psv.g { color: #16a34a; }
.ps-row .psv.r { color: #dc2626; }
.ps-row .psv.o { color: #F6961B; }
.ps-footer { text-align: center; font-size: 10px; color: #6B8FA8; margin-top: 10px; padding-top: 8px; border-top: 1px solid #D0EAF8; }
</style>
</head>
<body>

<header>
  <div class="logo-mark">£</div>
  <span class="logo-text">profit<span>calc</span></span>
</header>

<div class="hero">
  <div class="hero-tag">🇬🇧 Built for UK Ecommerce</div>
  <h1>Smart <span>Ad &amp; Margin</span> Calculators</h1>
  <p><?php echo htmlspecialchars($page_subtitle); ?></p>
</div>

<div class="tabs-wrap">
  <div class="tabs-nav">
    <button class="tab-btn active" onclick="switchTab('roas')">📊 ROAS</button>
    <button class="tab-btn" onclick="switchTab('poas')">💰 POAS</button>
    <button class="tab-btn" onclick="switchTab('discount')">🏷️ Discount Impact</button>
  </div>
</div>

<main>

<!-- ══ TAB 1: ROAS ══ -->
<div class="tab-panel active" id="tab-roas">
  <div class="grid-2">
    <div>
      <div class="section-divider">Advertising Channels</div>
      <div class="card">
        <div class="card-title"><span class="dot"></span> Ad Spend &amp; Revenue by Channel <button class="info-btn" onclick="showInfo('roas-what')">i</button></div>
        <table class="ch-table">
          <thead>
            <tr>
              <th>Channel</th>
              <th>Ad Spend (£)</th>
              <th>Revenue (£)</th>
              <th>ROAS</th>
            </tr>
          </thead>
          <tbody id="roas-tbody">
            <?php foreach ($channels as $i => $ch): ?>
            <tr>
              <td><?php echo htmlspecialchars($ch); ?></td>
              <td><input type="number" id="roas-spend-<?php echo $i; ?>" value="<?php echo $i === 0 ? $defaults['roas_spend_0'] : 0; ?>" oninput="calcROAS()" placeholder="0"></td>
              <td><input type="number" id="roas-rev-<?php echo $i; ?>" value="<?php echo $i === 0 ? $defaults['roas_rev_0'] : 0; ?>" oninput="calcROAS()" placeholder="0"></td>
              <td id="roas-pill-<?php echo $i; ?>">—</td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td>TOTAL</td>
              <td id="roas-total-spend">£0</td>
              <td id="roas-total-rev">£0</td>
              <td id="roas-total-roas">—</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div>
      <div class="section-divider">Summary</div>
      <div class="result-card">
        <div class="rc-title"><span class="dot"></span> Summary Metrics <button class="info-btn" style="background:rgba(255,255,255,0.15);color:rgba(255,255,255,0.6);" onclick="showInfo('roas-summary')">i</button></div>
        <div class="metric-big">
          <div class="lbl">Overall ROAS</div>
          <div class="val accent" id="roas-overall">—</div>
        </div>
        <hr class="divider">
        <div class="metric-row"><span class="mn">Total Ad Spend</span><span class="mv" id="roas-sum-spend">—</span></div>
        <div class="metric-row"><span class="mn">Total Revenue</span><span class="mv green" id="roas-sum-rev">—</span></div>
        <div class="metric-row"><span class="mn">Gross Profit (Revenue – Spend)</span><span class="mv" id="roas-gross">—</span></div>
        <div class="metric-row"><span class="mn">Cost per £1 Revenue</span><span class="mv orange" id="roas-cpr">—</span></div>
        <hr class="divider">
        <div class="rc-title" style="margin-bottom:10px;"><span class="dot"></span> ROAS Benchmark Guide</div>
        <table class="bench-table">
          <thead><tr><th>ROAS</th><th>What it means</th></tr></thead>
          <tbody>
            <tr><td><span class="bench-badge bench-bad">Below 1.0×</span></td><td>Spending more than you earn — review urgently</td></tr>
            <tr><td><span class="bench-badge bench-ok">1.0× – 2.0×</span></td><td>Breaking even or marginal return</td></tr>
            <tr><td><span class="bench-badge bench-good">2.0× – 4.0×</span></td><td>Positive return — typical for most e-commerce</td></tr>
            <tr><td><span class="bench-badge bench-great">4.0× – 8.0×</span></td><td>Strong performance</td></tr>
            <tr><td><span class="bench-badge bench-great">8.0×+</span></td><td>Exceptional — check attribution is correct</td></tr>
          </tbody>
        </table>
        <div class="verdict" id="roas-verdict" style="margin-top:14px;">
          <span>💡</span><span>Enter ad spend and revenue to see your ROAS verdict.</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ══ TAB 2: POAS ══ -->
<div class="tab-panel" id="tab-poas">
  <div class="grid-2">
    <div>
      <div class="section-divider">Inputs</div>
      <div class="card">
        <div class="card-title"><span class="dot"></span> Core Inputs</div>
        <div class="field">
          <label>Ad Spend (£) <button class="info-btn" onclick="showInfo('ad-spend')">i</button></label>
          <div class="input-wrap has-prefix"><span class="prefix">£</span><input type="number" id="poas-spend" value="0" oninput="calcPOAS()"></div>
        </div>
        <div class="field">
          <label>Revenue (£) <button class="info-btn" onclick="showInfo('revenue')">i</button></label>
          <div class="input-wrap has-prefix"><span class="prefix">£</span><input type="number" id="poas-rev" value="0" oninput="calcPOAS()"></div>
        </div>
        <div class="field">
          <label>Cost of Goods Sold – COGS (£) <button class="info-btn" onclick="showInfo('cogs')">i</button></label>
          <div class="input-wrap has-prefix"><span class="prefix">£</span><input type="number" id="poas-cogs" value="0" oninput="calcPOAS()"></div>
        </div>
        <div class="field">
          <label>Other Variable Costs (£) <button class="info-btn" onclick="showInfo('variable-costs')">i</button></label>
          <div class="input-wrap has-prefix"><span class="prefix">£</span><input type="number" id="poas-other" value="0" oninput="calcPOAS()"></div>
        </div>
      </div>

      <div class="section-divider">Target POAS</div>
      <div class="card">
        <div class="card-title"><span class="dot"></span> Target POAS Calculator <button class="info-btn" onclick="showInfo('target-poas')">i</button></div>
        <div class="slider-field">
          <div class="slider-header">
            <label>Target Gross Margin %</label>
            <span class="slider-val" id="poas-target-val"><?php echo $defaults['poas_target']; ?>%</span>
          </div>
          <input type="range" id="poas-target" min="1" max="80" step="1" value="<?php echo $defaults['poas_target']; ?>" oninput="syncSliderPct('poas-target','poas-target-val'); calcPOAS()">
        </div>
        <div class="metric-row" style="border:none; padding:0; font-size:14px; margin-top:8px;">
          <span style="color:var(--muted); font-weight:600;">Target POAS</span>
          <span style="font-weight:800; color:var(--primary); font-size:20px;" id="poas-target-result">—</span>
        </div>
        <div class="metric-row" style="border:none; padding-top:8px; font-size:13px;">
          <span style="color:var(--muted); font-weight:600;">Implied Max Ad Spend Ratio</span>
          <span style="font-weight:700;" id="poas-max-ratio">—</span>
        </div>
        <div class="metric-row" style="border:none; padding-top:6px; font-size:13px;">
          <span style="color:var(--muted); font-weight:600;">Implied Max Ad Spend (£)</span>
          <span style="font-weight:700; color:var(--accent);" id="poas-max-spend">—</span>
        </div>
      </div>

      <div class="section-divider">By Channel (Optional)</div>
      <div class="card">
        <div class="card-title"><span class="dot"></span> POAS by Channel</div>
        <table class="ch-table">
          <thead><tr><th>Channel</th><th>Ad Spend (£)</th><th>Gross Profit (£)</th><th>POAS</th></tr></thead>
          <tbody id="poas-tbody">
            <?php foreach ($channels as $i => $ch): ?>
            <tr>
              <td><?php echo htmlspecialchars($ch); ?></td>
              <td><input type="number" id="poas-ch-spend-<?php echo $i; ?>" value="0" oninput="calcPOAS()" placeholder="0"></td>
              <td><input type="number" id="poas-ch-gp-<?php echo $i; ?>" value="0" oninput="calcPOAS()" placeholder="0"></td>
              <td id="poas-ch-pill-<?php echo $i; ?>">—</td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot><tr><td>TOTAL</td><td id="poas-ch-spend">£0</td><td id="poas-ch-gp">£0</td><td id="poas-ch-poas">—</td></tr></tfoot>
        </table>
      </div>
    </div>
    <div>
      <div class="section-divider">Results</div>
      <div class="result-card">
        <div class="rc-title"><span class="dot"></span> Core Calculations</div>
        <div class="metric-big">
          <div class="lbl">POAS (Profit on Ad Spend)</div>
          <div class="val accent" id="poas-val">—</div>
        </div>
        <hr class="divider">
        <div class="metric-row"><span class="mn">Gross Profit (£)</span><span class="mv green" id="poas-gp">—</span></div>
        <div class="metric-row"><span class="mn">Gross Margin %</span><span class="mv" id="poas-gm">—</span></div>
        <div class="metric-row"><span class="mn">ROAS</span><span class="mv orange" id="poas-roas">—</span></div>
        <div class="metric-row"><span class="mn">Profit After Ad Spend (£)</span><span class="mv" id="poas-profit">—</span></div>
        <div class="metric-row"><span class="mn">Profit After Ad Spend %</span><span class="mv" id="poas-profit-pct">—</span></div>
        <hr class="divider">
        <div class="rc-title" style="margin-bottom:10px;"><span class="dot"></span> POAS Benchmark Guide</div>
        <table class="bench-table">
          <thead><tr><th>POAS</th><th>What it means</th></tr></thead>
          <tbody>
            <tr><td><span class="bench-badge bench-bad">Below 0.0×</span></td><td>Ad spend exceeds gross profit — loss-making</td></tr>
            <tr><td><span class="bench-badge bench-ok">0.0× – 0.5×</span></td><td>Gross profit covers spend but slim margin</td></tr>
            <tr><td><span class="bench-badge bench-ok">0.5× – 1.0×</span></td><td>Positive but tight — monitor closely</td></tr>
            <tr><td><span class="bench-badge bench-good">1.0× – 2.0×</span></td><td>Healthy — ad spend well covered by profit</td></tr>
            <tr><td><span class="bench-badge bench-great">2.0×+</span></td><td>Strong performance</td></tr>
          </tbody>
        </table>
        <div class="verdict" id="poas-verdict" style="margin-top:14px;">
          <span>💡</span><span>Enter your inputs to see your POAS verdict.</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ══ TAB 3: DISCOUNT IMPACT ══ -->
<div class="tab-panel" id="tab-discount">
  <div class="grid-2">
    <div style="display:flex; flex-direction:column;">
      <div class="section-divider">Base Inputs</div>
      <div class="card">
        <div class="card-title"><span class="dot"></span> Your Product Data</div>
        <div class="field">
          <label>Selling Price per Unit (£) <button class="info-btn" onclick="showInfo('selling-price')">i</button></label>
          <div class="input-wrap has-prefix"><span class="prefix">£</span><input type="number" id="d-price" value="<?php echo $defaults['d_price']; ?>" oninput="calcDiscount()"></div>
        </div>
        <div class="field">
          <label>Cost of Goods per Unit (£) <button class="info-btn" onclick="showInfo('cogs')">i</button></label>
          <div class="input-wrap has-prefix"><span class="prefix">£</span><input type="number" id="d-cogs" value="<?php echo $defaults['d_cogs']; ?>" oninput="calcDiscount()"></div>
        </div>
        <div class="field">
          <label>Monthly Units Sold (no discount) <button class="info-btn" onclick="showInfo('units-sold')">i</button></label>
          <div class="input-wrap"><input type="number" id="d-units" value="<?php echo $defaults['d_units']; ?>" oninput="calcDiscount()"></div>
        </div>
        <div style="margin-top:14px; padding:12px 14px; background:var(--bg); border-radius:10px; border:1.5px solid var(--border);">
          <div class="metric-row" style="padding:4px 0;"><span style="color:var(--muted); font-size:12px; font-weight:600;">Gross Margin per Unit</span><span style="font-weight:800; color:var(--text);" id="d-base-gm">£0</span></div>
          <div class="metric-row" style="padding:4px 0; border:none;"><span style="color:var(--muted); font-size:12px; font-weight:600;">Gross Margin % (base)</span><span style="font-weight:800; color:var(--primary);" id="d-base-gmpct">0%</span></div>
        </div>
      </div>

      <div class="section-divider">Volume Uplift Assumptions</div>
      <div class="card" style="flex:1;">
        <div class="card-title"><span class="dot"></span> Edit Expected Volume Uplift <button class="info-btn" onclick="showInfo('volume-uplift')">i</button></div>
        <p style="font-size:12px; color:var(--muted); margin-bottom:14px; line-height:1.5;">Adjust to reflect what you realistically expect for your business.</p>
        <?php foreach ($discount_rates as $i => $rate): ?>
          <?php if ($rate === 0) continue; ?>
          <div class="metric-row" style="padding:6px 0; font-size:13px;">
            <span style="color:var(--muted);font-weight:600;"><?php echo $rate; ?>% Discount — Expected Volume Uplift</span>
            <div class="input-wrap has-suffix" style="width:100px;">
              <input type="number" id="uplift-<?php echo $rate; ?>" value="<?php echo $default_uplift[$i]; ?>" oninput="calcDiscount()" style="padding-right:28px;">
              <span class="suffix">%</span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div>
      <div class="section-divider">Discount Scenarios</div>
      <div class="card" style="overflow-x:auto;">
        <div class="card-title"><span class="dot"></span> Impact Analysis</div>
        <table class="disc-table">
          <thead>
            <tr>
              <th>Metric</th>
              <th>No Discount</th>
              <?php foreach ($discount_rates as $rate): ?>
                <?php if ($rate === 0) continue; ?>
                <th><?php echo $rate; ?>%</th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody id="disc-tbody"></tbody>
        </table>
      </div>

      <div class="section-divider">Break-Even Analysis</div>
      <div class="card" style="overflow-x:auto;">
        <div class="card-title"><span class="dot"></span> Units Needed to Match Base Gross Profit</div>
        <table class="disc-table">
          <thead>
            <tr>
              <th>Metric</th>
              <th>No Discount</th>
              <?php foreach ($discount_rates as $rate): ?>
                <?php if ($rate === 0) continue; ?>
                <th><?php echo $rate; ?>%</th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody id="be-tbody"></tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="section-divider" style="margin-top:8px;">Key Takeaway</div>
  <div class="card" style="overflow-x:auto;">
    <div class="card-title"><span class="dot"></span> Gross Margin Impact</div>
    <table class="disc-table">
      <thead>
        <tr>
          <th>Metric</th>
          <th>No Discount</th>
          <?php foreach ($discount_rates as $rate): ?>
            <?php if ($rate === 0) continue; ?>
            <th><?php echo $rate; ?>%</th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody id="takeaway-tbody"></tbody>
    </table>
  </div>
</div>

<div class="pdf-wrap">
  <button class="pdf-btn" onclick="exportPDF()">📄 Print / Save as PDF</button>
  <p style="font-size:12px; color:var(--muted); margin-top:8px; font-family:'Urbanist',sans-serif;">Enable "Background graphics" in print dialog</p>
</div>

</main>

<!-- PRINT SUMMARY -->
<div id="print-summary">
  <div class="ps-header">
    <div class="ps-logo">£</div>
    <div><div class="ps-sub">Ecommerce Calculators</div><div class="ps-title">Results Summary</div></div>
    <div class="ps-date" id="ps-date"><?php echo $current_date; ?></div>
  </div>
  <div class="ps-box">
    <div class="ps-box-title">📊 ROAS — Return on Ad Spend</div>
    <div class="ps-big"><span>Overall ROAS</span><span id="ps-roas"></span></div>
    <div class="ps-rows">
      <div class="ps-row"><span class="psl">Total Ad Spend</span><span class="psv" id="ps-roas-spend"></span></div>
      <div class="ps-row"><span class="psl">Total Revenue</span><span class="psv g" id="ps-roas-rev"></span></div>
      <div class="ps-row"><span class="psl">Gross Profit (Revenue – Spend)</span><span class="psv" id="ps-roas-gp"></span></div>
      <div class="ps-row"><span class="psl">Cost per £1 Revenue</span><span class="psv o" id="ps-roas-cpr"></span></div>
    </div>
  </div>
  <div class="ps-box">
    <div class="ps-box-title">💰 POAS — Profit on Ad Spend</div>
    <div class="ps-big"><span>POAS</span><span id="ps-poas"></span></div>
    <div class="ps-rows">
      <div class="ps-row"><span class="psl">Gross Profit</span><span class="psv g" id="ps-poas-gp"></span></div>
      <div class="ps-row"><span class="psl">Gross Margin %</span><span class="psv" id="ps-poas-gm"></span></div>
      <div class="ps-row"><span class="psl">ROAS</span><span class="psv o" id="ps-poas-roas"></span></div>
      <div class="ps-row"><span class="psl">Profit After Ad Spend</span><span class="psv" id="ps-poas-profit"></span></div>
    </div>
  </div>
  <div class="ps-box">
    <div class="ps-box-title">🏷️ Discount Impact — Base Product</div>
    <div class="ps-big"><span>Base Gross Margin</span><span id="ps-disc-gm"></span></div>
    <div class="ps-rows">
      <div class="ps-row"><span class="psl">Selling Price</span><span class="psv" id="ps-disc-price"></span></div>
      <div class="ps-row"><span class="psl">COGS</span><span class="psv r" id="ps-disc-cogs"></span></div>
      <div class="ps-row"><span class="psl">GP at 10% Discount</span><span class="psv" id="ps-disc-10"></span></div>
      <div class="ps-row"><span class="psl">GP at 20% Discount</span><span class="psv" id="ps-disc-20"></span></div>
      <div class="ps-row"><span class="psl">Break-even Units at 20% Disc.</span><span class="psv o" id="ps-disc-be20"></span></div>
    </div>
  </div>
  <div class="ps-footer">Generated by ProfitCalc · <?php echo $current_date; ?> · For UK Ecommerce Businesses</div>
</div>

<!-- INFO MODAL -->
<div class="modal-overlay" id="modal-overlay" onclick="closeModal(event)">
  <div class="modal">
    <button class="modal-close" onclick="closeInfo()">✕</button>
    <h3 id="modal-title"></h3>
    <p id="modal-body"></p>
    <div class="formula-box" id="modal-formula" style="display:none;"></div>
  </div>
</div>

<script>
const CHANNELS      = <?php echo json_encode($channels); ?>;
const DISCOUNT_RATES = <?php echo json_encode(array_map(fn($r) => $r / 100, $discount_rates)); ?>;
const DISC_RATES_PCT = <?php echo json_encode($discount_rates); ?>;

const fmt  = (n,d=2) => isNaN(n)||!isFinite(n) ? '—' : '£'+Math.abs(n).toLocaleString('en-GB',{minimumFractionDigits:d,maximumFractionDigits:d});
const fmtP = n => isNaN(n)||!isFinite(n) ? '—' : n.toFixed(1)+'%';
const fmtN = n => isNaN(n) ? '—' : Math.round(n).toLocaleString('en-GB');
const v    = id => parseFloat(document.getElementById(id)?.value)||0;

function setEl(id,val,cls=''){
  const el=document.getElementById(id); if(!el)return;
  el.textContent=val;
  if(cls) el.className='mv '+cls;
}

function roasPill(roas){
  if(!roas||isNaN(roas)||!isFinite(roas)) return '<span class="roas-pill" style="background:rgba(107,143,168,0.15);color:#6B8FA8">—</span>';
  let cls = roas<1 ? 'bench-bad' : roas<2 ? 'bench-ok' : roas<4 ? 'bench-good' : 'bench-great';
  return `<span class="roas-pill ${cls}">${roas.toFixed(2)}×</span>`;
}

function syncSliderPct(sid,lid){ document.getElementById(lid).textContent=document.getElementById(sid).value+'%'; }

function switchTab(name){
  document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
  document.getElementById('tab-'+name).classList.add('active');
  const map={roas:0,poas:1,discount:2};
  document.querySelectorAll('.tab-btn')[map[name]].classList.add('active');
}

// ── ROAS ──────────────────────────────────────────────────
function calcROAS(){
  let totalSpend=0, totalRev=0;
  CHANNELS.forEach((ch,i)=>{
    const spend=parseFloat(document.getElementById(`roas-spend-${i}`)?.value)||0;
    const rev  =parseFloat(document.getElementById(`roas-rev-${i}`)?.value)||0;
    totalSpend+=spend; totalRev+=rev;
    document.getElementById(`roas-pill-${i}`).innerHTML = spend>0||rev>0 ? roasPill(spend>0?rev/spend:0) : '—';
  });
  const overall = totalSpend>0 ? totalRev/totalSpend : 0;
  const gp = totalRev - totalSpend;

  document.getElementById('roas-total-spend').textContent = fmt(totalSpend,0);
  document.getElementById('roas-total-rev').textContent   = fmt(totalRev,0);
  document.getElementById('roas-total-roas').innerHTML    = totalSpend>0 ? roasPill(overall) : '—';
  document.getElementById('roas-overall').textContent     = totalSpend>0 ? overall.toFixed(2)+'×' : '—';
  setEl('roas-sum-spend', fmt(totalSpend,0));
  setEl('roas-sum-rev',   fmt(totalRev,0), 'green');
  setEl('roas-gross',     fmt(gp,0), gp>=0?'green':'red');
  setEl('roas-cpr',       totalRev>0 ? '£'+( totalSpend/totalRev).toFixed(4) : '—', 'orange');

  const verd=document.getElementById('roas-verdict');
  if(!totalSpend){ verd.className='verdict'; verd.innerHTML='<span>💡</span><span>Enter ad spend and revenue above.</span>'; return; }
  if(overall<1)     { verd.className='verdict bad';  verd.innerHTML=`<span>🔴</span><span>ROAS below 1.0× — spending more than you earn. Review campaigns urgently.</span>`; }
  else if(overall<2){ verd.className='verdict ok';   verd.innerHTML=`<span>⚠️</span><span>ROAS ${overall.toFixed(2)}× — breaking even or marginal return. Consider optimising bids.</span>`; }
  else if(overall<4){ verd.className='verdict good'; verd.innerHTML=`<span>✅</span><span>ROAS ${overall.toFixed(2)}× — positive return, typical for most e-commerce.</span>`; }
  else              { verd.className='verdict good'; verd.innerHTML=`<span>🚀</span><span>ROAS ${overall.toFixed(2)}× — strong performance! Verify attribution before scaling.</span>`; }
}

// ── POAS ──────────────────────────────────────────────────
function calcPOAS(){
  const spend=v('poas-spend'), rev=v('poas-rev'), cogs=v('poas-cogs'), other=v('poas-other');
  const gp=rev-cogs-other, gm=rev>0?(gp/rev)*100:0;
  const roas=spend>0?rev/spend:0, poas=spend>0?gp/spend:0;
  const profitAfter=gp-spend, profitAfterPct=rev>0?(profitAfter/rev)*100:0;

  document.getElementById('poas-val').textContent = spend>0 ? poas.toFixed(2)+'×' : '—';
  document.getElementById('poas-val').className   = 'val '+(poas>=1?'green':poas>=0?'accent':'red');
  setEl('poas-gp',          fmt(gp),         'green');
  setEl('poas-gm',          fmtP(gm));
  setEl('poas-roas',        spend>0?roas.toFixed(2)+'×':'—', 'orange');
  setEl('poas-profit',      fmt(profitAfter), profitAfter>=0?'green':'red');
  setEl('poas-profit-pct',  fmtP(profitAfterPct));

  const tgm=v('poas-target')/100;
  document.getElementById('poas-target-result').textContent = tgm>0 ? (tgm/(1-tgm)).toFixed(2)+'×' : '—';
  document.getElementById('poas-max-ratio').textContent     = fmtP(tgm*100);
  document.getElementById('poas-max-spend').textContent     = rev>0 ? fmt(rev*tgm,0) : '—';

  let chSpend=0, chGP=0;
  CHANNELS.forEach((ch,i)=>{
    const cs=parseFloat(document.getElementById(`poas-ch-spend-${i}`)?.value)||0;
    const cg=parseFloat(document.getElementById(`poas-ch-gp-${i}`)?.value)||0;
    chSpend+=cs; chGP+=cg;
    document.getElementById(`poas-ch-pill-${i}`).innerHTML = cs>0||cg>0 ? roasPill(cs>0?cg/cs:0) : '—';
  });
  document.getElementById('poas-ch-spend').textContent = fmt(chSpend,0);
  document.getElementById('poas-ch-gp').textContent    = fmt(chGP,0);
  document.getElementById('poas-ch-poas').innerHTML    = chSpend>0 ? roasPill(chGP/chSpend) : '—';

  const verd=document.getElementById('poas-verdict');
  if(!spend){ verd.className='verdict'; verd.innerHTML='<span>💡</span><span>Enter your inputs above.</span>'; return; }
  if(poas<0)      { verd.className='verdict bad';  verd.innerHTML='<span>🔴</span><span>Ad spend exceeds gross profit — losing money on ads.</span>'; }
  else if(poas<0.5){ verd.className='verdict ok';  verd.innerHTML=`<span>⚠️</span><span>POAS ${poas.toFixed(2)}× — gross profit covers spend but slim margin remaining.</span>`; }
  else if(poas<1)  { verd.className='verdict ok';  verd.innerHTML=`<span>⚡</span><span>POAS ${poas.toFixed(2)}× — positive but tight. Need above 1.0× for net contribution.</span>`; }
  else if(poas<2)  { verd.className='verdict good'; verd.innerHTML=`<span>✅</span><span>POAS ${poas.toFixed(2)}× — healthy return. Ad spend well covered by gross profit.</span>`; }
  else             { verd.className='verdict good'; verd.innerHTML=`<span>🚀</span><span>POAS ${poas.toFixed(2)}× — strong performance!</span>`; }
}

// ── DISCOUNT ──────────────────────────────────────────────
function calcDiscount(){
  const price=v('d-price'), cogs=v('d-cogs'), baseUnits=v('d-units');
  const baseGM=price-cogs, baseGMpct=price>0?(baseGM/price)*100:0, baseGP=baseGM*baseUnits;

  document.getElementById('d-base-gm').textContent    = fmt(baseGM);
  document.getElementById('d-base-gmpct').textContent = fmtP(baseGMpct);

  const upliftVals = DISC_RATES_PCT.map(r => r===0 ? 0 : (v(`uplift-${r}`)||0)/100);

  const rows = [
    { label:'Discount %',                    vals: DISC_RATES_PCT.map(r=>fmtP(r)) },
    { label:'Assumed Volume Uplift %',        vals: upliftVals.map(u=>fmtP(u*100)) },
    { label:'Discounted Price (£)',           vals: DISCOUNT_RATES.map(r=>fmt(price*(1-r))) },
    { label:'Gross Margin per Unit (£)',      vals: DISCOUNT_RATES.map(r=>fmt(price*(1-r)-cogs)) },
    { label:'Gross Margin %',                 vals: DISCOUNT_RATES.map(r=>{ const dp=price*(1-r); return dp>0?fmtP(((dp-cogs)/dp)*100):'—'; }) },
    { label:'Units Sold',                     vals: DISCOUNT_RATES.map((r,i)=>fmtN(baseUnits*(1+upliftVals[i]))) },
    { label:'Total Revenue (£)',              vals: DISCOUNT_RATES.map((r,i)=>fmt(price*(1-r)*baseUnits*(1+upliftVals[i]),0)) },
    { label:'Total Gross Profit (£)',         vals: DISCOUNT_RATES.map((r,i)=>{const dp=price*(1-r);return fmt((dp-cogs)*baseUnits*(1+upliftVals[i]),0);}), bold:true },
    { label:'Gross Profit vs No Discount (£)',vals: DISCOUNT_RATES.map((r,i)=>{if(i===0)return '—';const dp=price*(1-r);const diff=(dp-cogs)*baseUnits*(1+upliftVals[i])-baseGP;return (diff>=0?'+':'')+fmt(diff,0);}), colored:true },
  ];

  const tbody=document.getElementById('disc-tbody'); tbody.innerHTML='';
  rows.forEach(row=>{
    const tr=document.createElement('tr');
    let cells=`<td>${row.label}</td>`;
    row.vals.forEach((val,i)=>{
      let style='';
      if(row.colored&&i>0){ const dp=price*(1-DISCOUNT_RATES[i]); const diff=(dp-cogs)*baseUnits*(1+upliftVals[i])-baseGP; style=diff>=0?'color:var(--success)':'color:var(--danger)'; }
      if(row.bold) style='font-weight:700;color:var(--text)';
      cells+=`<td style="${style}">${val}</td>`;
    });
    tr.innerHTML=cells; tbody.appendChild(tr);
  });

  const beRows=[
    { label:'Units Needed to Match Base GP',           vals:DISCOUNT_RATES.map((r,i)=>{if(i===0)return fmtN(baseUnits);const gmu=price*(1-r)-cogs;return gmu>0?fmtN(Math.ceil(baseGP/gmu)):'∞';}), bold:true },
    { label:'Extra Units Required',                    vals:DISCOUNT_RATES.map((r,i)=>{if(i===0)return '—';const gmu=price*(1-r)-cogs;if(gmu<=0)return '∞';return '+'+(Math.ceil(baseGP/gmu)-baseUnits).toLocaleString('en-GB');}), orange:true },
    { label:'Required Volume Uplift % to Break Even',  vals:DISCOUNT_RATES.map((r,i)=>{if(i===0)return '—';const gmu=price*(1-r)-cogs;if(gmu<=0)return '∞';return fmtP(((Math.ceil(baseGP/gmu)-baseUnits)/baseUnits)*100);}) },
  ];
  const betbody=document.getElementById('be-tbody'); betbody.innerHTML='';
  beRows.forEach(row=>{
    const tr=document.createElement('tr');
    let cells=`<td>${row.label}</td>`;
    row.vals.forEach((val,i)=>{ let style=row.bold?'font-weight:700':''; if(row.orange&&i>0)style='color:var(--accent);font-weight:700'; cells+=`<td style="${style}">${val}</td>`; });
    tr.innerHTML=cells; betbody.appendChild(tr);
  });

  const tabody=document.getElementById('takeaway-tbody'); tabody.innerHTML='';
  const impactRow=document.createElement('tr');
  let icells='<td>Gross Margin % Impact vs No Discount</td>';
  DISCOUNT_RATES.forEach((r,i)=>{
    if(i===0){icells+='<td>—</td>';return;}
    const dp=price*(1-r); const impact=(dp>0?((dp-cogs)/dp):0)-(baseGMpct/100);
    icells+=`<td style="color:var(--danger);font-weight:700">${(impact*100).toFixed(1)}%</td>`;
  });
  impactRow.innerHTML=icells; tabody.appendChild(impactRow);

  const verdRow=document.createElement('tr');
  let vcells='<td>Verdict</td>';
  DISCOUNT_RATES.forEach((r,i)=>{
    if(i===0){vcells+='<td><span class="verdict-cell v-baseline">Baseline</span></td>';return;}
    const dp=price*(1-r); const gp=(dp-cogs)*baseUnits*(1+upliftVals[i]); const diffPct=baseGP>0?((gp-baseGP)/baseGP)*100:0;
    let cls='v-warn', label='⚠ GP within 10%';
    if(diffPct<-10){cls='v-bad';label='✖ GP loss >10%';} else if(diffPct>=0){cls='v-baseline';label='✔ GP maintained';}
    vcells+=`<td><span class="verdict-cell ${cls}">${label}</span></td>`;
  });
  verdRow.innerHTML=vcells; tabody.appendChild(verdRow);
}

// ── INFO MODAL ────────────────────────────────────────────
const INFO = {
  'roas-what':      { title:'What is ROAS?',                body:'Return on Ad Spend measures revenue generated per £1 of ad spend. Enter spend and revenue per channel — ROAS is calculated automatically. Use consistent time periods across all channels.',                                                                formula:'ROAS = Revenue ÷ Ad Spend' },
  'roas-summary':   { title:'Summary Metrics',              body:'Gross Profit here is Revenue minus Ad Spend only — it does not account for COGS. For a true profit picture use the POAS tab. Cost per £1 Revenue shows how much ad spend generates £1 of revenue.',                                                         formula:'Gross Profit = Revenue − Ad Spend' },
  'ad-spend':       { title:'Ad Spend',                     body:'Total amount spent on paid advertising during your chosen period. Include all channels: Google, Meta, TikTok, etc.',                                                                                                                                          formula:'Sum of all channel ad spend' },
  'revenue':        { title:'Revenue',                      body:"Total revenue attributed to your ads. Use your platform's reported revenue (Google Ads, Meta Ads Manager) or analytics tool.",                                                                                                                                formula:null },
  'cogs':           { title:'Cost of Goods Sold (COGS)',    body:'The direct cost of producing or purchasing the products sold. Does not include overheads, shipping, or marketing costs.',                                                                                                                                      formula:'COGS = Purchase Cost + Manufacturing Cost' },
  'variable-costs': { title:'Other Variable Costs',         body:'Costs that vary per sale: fulfilment, payment processing fees, returns, packaging. Include everything that changes per order.',                                                                                                                                formula:'e.g. Fulfilment + Payment fees + Returns' },
  'target-poas':    { title:'Target POAS Calculator',       body:'Enter your target gross margin % and the tool calculates the minimum POAS needed for ad spend to remain profitable. A POAS of 1.0× means ad spend equals gross profit — you need above 1.0× to make a net contribution.',                                    formula:'Target POAS = Gross Margin % ÷ (1 − Gross Margin %)' },
  'selling-price':  { title:'Selling Price per Unit',       body:'The full retail price you charge customers before any discount. This is the price customers pay at checkout.',                                                                                                                                                 formula:null },
  'units-sold':     { title:'Monthly Units Sold',           body:'Your typical monthly sales volume when no discount is running. This is your baseline to compare discount scenarios against.',                                                                                                                                  formula:null },
  'volume-uplift':  { title:'Volume Uplift Assumption',     body:'The estimated % increase in units sold when running a discount. Adjust based on past promotions or realistic expectations. The break-even analysis shows how much uplift you actually need to maintain gross profit.',                                         formula:'Uplifted Units = Base Units × (1 + Uplift %)' },
};

function showInfo(key){
  const info=INFO[key]; if(!info)return;
  document.getElementById('modal-title').textContent=info.title;
  document.getElementById('modal-body').textContent=info.body;
  const fbox=document.getElementById('modal-formula');
  if(info.formula){fbox.style.display='block';fbox.textContent=info.formula;}else{fbox.style.display='none';}
  document.getElementById('modal-overlay').classList.add('open');
}
function closeInfo(){ document.getElementById('modal-overlay').classList.remove('open'); }
function closeModal(e){ if(e.target===document.getElementById('modal-overlay')) closeInfo(); }

// ── PDF ───────────────────────────────────────────────────
function exportPDF(){
  const d = new Date().toLocaleDateString('en-GB',{day:'numeric',month:'long',year:'numeric'});
  document.getElementById('ps-date').textContent = d;

  function cp(from,to,cls){ const f=document.getElementById(from),t=document.getElementById(to); if(f&&t){t.textContent=f.textContent; if(cls)t.className='psv '+cls;} }
  cp('roas-overall','ps-roas'); cp('roas-sum-spend','ps-roas-spend'); cp('roas-sum-rev','ps-roas-rev','g'); cp('roas-gross','ps-roas-gp'); cp('roas-cpr','ps-roas-cpr','o');
  cp('poas-val','ps-poas'); cp('poas-gp','ps-poas-gp','g'); cp('poas-gm','ps-poas-gm'); cp('poas-roas','ps-poas-roas','o'); cp('poas-profit','ps-poas-profit');

  const price=v('d-price'), cogs=v('d-cogs'), baseUnits=v('d-units');
  document.getElementById('ps-disc-gm').textContent    = document.getElementById('d-base-gmpct').textContent;
  document.getElementById('ps-disc-price').textContent = '£'+price;
  document.getElementById('ps-disc-cogs').textContent  = '£'+cogs;
  const u10=(v('uplift-10')||0)/100, u20=(v('uplift-20')||0)/100;
  document.getElementById('ps-disc-10').textContent   = fmt((price*0.9-cogs)*baseUnits*(1+u10),0);
  document.getElementById('ps-disc-20').textContent   = fmt((price*0.8-cogs)*baseUnits*(1+u20),0);
  const be20 = price*0.8-cogs>0 ? Math.ceil((price-cogs)*baseUnits/(price*0.8-cogs)) : Infinity;
  document.getElementById('ps-disc-be20').textContent = isFinite(be20) ? fmtN(be20) : '∞';

  window.print();
}

// ── INIT ──────────────────────────────────────────────────
calcROAS();
calcPOAS();
calcDiscount();
</script>
</body>
</html>