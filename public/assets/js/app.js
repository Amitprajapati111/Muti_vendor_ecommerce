(function(){
  const $ = (sel, ctx=document)=>ctx.querySelector(sel);
  const $$ = (sel, ctx=document)=>Array.from(ctx.querySelectorAll(sel));

  // Loader fade out
  function hideLoader(){
    const loader = $('#loader');
    if (loader) loader.style.display = 'none';
    const app = $('#app');
    if (app) app.classList.remove('opacity-0');
  }
  // Hide as soon as DOM is ready
  document.addEventListener('DOMContentLoaded', ()=>{ setTimeout(hideLoader, 150); });
  // Also hide on full load (redundant safety)
  window.addEventListener('load', ()=>{ setTimeout(hideLoader, 150); });
  // Last-resort fallback in case external CDNs hang
  setTimeout(hideLoader, 2500);

  // Dark mode toggle
  const html = document.documentElement;
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme) html.setAttribute('data-theme', savedTheme);
  $('#darkToggle')?.addEventListener('click', ()=>{
    const cur = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', cur);
    localStorage.setItem('theme', cur);
  });

  // AOS
  if (window.AOS) {
    AOS.init({ duration: 600, once: true, offset: 80 });
  }

  // Global AJAX search
  const input = $('#globalSearch');
  const results = $('#searchResults');
  let timer;
  const BASE = (window.APP_BASE || '/');
  function hideResults(){ results?.classList.add('d-none'); if (results) results.innerHTML=''; }
  function showResults(){ results?.classList.remove('d-none'); }
  function render(items){
    if (!results) return;
    if (!items.length) { results.innerHTML = '<div class="list-group-item">No results</div>'; return; }
    results.innerHTML = items.map(p=>`<a href="${BASE}product/detail/${p.id}" class="list-group-item list-group-item-action">
      <div class="d-flex align-items-center">
        <div class="flex-grow-1">
          <div class="fw-semibold">${p.name}</div>
          <div class="small text-muted">${p.category_name ?? ''} • ₹${parseFloat(p.price).toFixed(2)}</div>
        </div>
      </div>
    </a>`).join('');
  }
  input?.addEventListener('input', ()=>{
    const q = input.value.trim();
    clearTimeout(timer);
    if (!q) { hideResults(); return; }
    timer = setTimeout(async ()=>{
      try {
        const url = BASE + 'product/search?q=' + encodeURIComponent(q);
        const res = await fetch(url);
        const data = await res.json();
        render(data.items || []);
        showResults();
      } catch(e){ hideResults(); }
    }, 250);
  });
  document.addEventListener('click', (e)=>{
    if (!results || !input) return;
    if (!results.contains(e.target) && !input.contains(e.target)) hideResults();
  });
})();
