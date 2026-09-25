<style>
.kw-wrap { max-width: 900px; margin: 2rem auto; padding: 0 1rem; font-family: 'Roboto', sans-serif; }
.kw-wrap h1 { font-size: 1.4rem; font-weight: 500; margin-bottom: 1.5rem; color: #111; }
.kw-form { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
.kw-form input, .kw-form select {
    padding: .65rem .9rem; border: 1px solid #ddd; border-radius: 6px;
    font-size: .9rem; width: 100%; box-sizing: border-box;
}
.kw-form-full { grid-column: 1 / -1; }
.kw-btn {
    background: #E8332A; color: #fff; border: none; padding: .7rem 2rem;
    border-radius: 6px; font-size: .95rem; cursor: pointer; font-weight: 500;
}
.kw-btn:hover { background: #c2271f; }
.kw-btn:disabled { background: #aaa; cursor: not-allowed; }
.kw-results { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1.5rem; }
.kw-col h2 { font-size: .85rem; font-weight: 500; text-transform: uppercase;
    letter-spacing: .06em; color: #666; margin-bottom: .75rem; }
.kw-list { list-style: none; padding: 0; margin: 0; }
.kw-list li {
    display: flex; align-items: center; justify-content: space-between;
    padding: .5rem .75rem; border-bottom: 1px solid #f0f0f0;
    font-size: .88rem; color: #222;
}
.kw-list li:hover { background: #fafafa; }
.kw-copy {
    font-size: .75rem; color: #E8332A; cursor: pointer;
    border: none; background: none; padding: 2px 6px;
}
.kw-copy:hover { text-decoration: underline; }
.kw-empty { color: #999; font-size: .88rem; padding: .5rem 0; }
.kw-loader { display: none; color: #666; font-size: .9rem; margin-top: 1rem; }
.kw-error { color: #c00; font-size: .88rem; margin-top: 1rem; }
.kw-tag {
    display: inline-block; font-size: .72rem; padding: 1px 7px;
    border-radius: 20px; margin-left: 6px;
}
.kw-tag-geo { background: #e8f5e9; color: #2e7d32; }
.kw-tag-gen { background: #e3f2fd; color: #1565c0; }
</style>

<div class="kw-wrap">
    <h1><i class="fas fa-search" style="color:#E8332A;margin-right:8px;"></i>Keyword Research</h1>

    <div class="kw-form">
        <div class="kw-form-full">
            <input type="text" id="kw-niche" placeholder="Nicho — ej: catering, clínica estética, agencia de marketing" />
        </div>
        <input type="text" id="kw-city"     placeholder="Ciudad — ej: Irún" />
        <input type="text" id="kw-province" placeholder="Provincia — ej: Gipuzkoa" />
        <select id="kw-lang">
            <option value="es">Español</option>
            <option value="en">English</option>
        </select>
        <select id="kw-country">
            <option value="es">España</option>
            <option value="us">Estados Unidos</option>
            <option value="ve">Venezuela</option>
            <option value="mx">México</option>
            <option value="ar">Argentina</option>
        </select>
        <div></div>
        <button class="kw-btn" id="kw-submit" onclick="runResearch()">
            <i class="fas fa-bolt"></i> Generar keywords
        </button>
    </div>

    <div class="kw-loader" id="kw-loader">
        <i class="fas fa-spinner fa-spin"></i> Consultando Google Suggest...
    </div>
    <div class="kw-error" id="kw-error"></div>

    <div class="kw-results" id="kw-results" style="display:none;">
        <div class="kw-col">
            <h2><i class="fas fa-globe"></i> Genéricas nacionales</h2>
            <ul class="kw-list" id="kw-generic"></ul>
        </div>
        <div class="kw-col">
            <h2><i class="fas fa-map-marker-alt"></i> Geolocalizadas</h2>
            <ul class="kw-list" id="kw-geolocal"></ul>
        </div>
    </div>
</div>

<script>
function runResearch() {
    const niche    = document.getElementById('kw-niche').value.trim();
    const city     = document.getElementById('kw-city').value.trim();
    const province = document.getElementById('kw-province').value.trim();
    const lang     = document.getElementById('kw-lang').value;
    const country  = document.getElementById('kw-country').value;

    if (!niche) {
        document.getElementById('kw-error').textContent = 'El nicho es obligatorio.';
        return;
    }

    document.getElementById('kw-error').textContent = '';
    document.getElementById('kw-results').style.display = 'none';
    document.getElementById('kw-loader').style.display = 'block';
    document.getElementById('kw-submit').disabled = true;

    fetch('/admin/?page=keywords&action=suggest', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ niche, city, province, lang, country })
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('kw-loader').style.display = 'none';
        document.getElementById('kw-submit').disabled = false;

        if (data.error) {
            document.getElementById('kw-error').textContent = data.error;
            return;
        }

        renderList('kw-generic',  data.generic  || [], 'gen');
        renderList('kw-geolocal', data.geolocal || [], 'geo');
        document.getElementById('kw-results').style.display = 'grid';
    })
    .catch(err => {
        document.getElementById('kw-loader').style.display = 'none';
        document.getElementById('kw-submit').disabled = false;
        document.getElementById('kw-error').textContent = 'Error de conexión.';
    });
}

function renderList(id, items, type) {
    const ul = document.getElementById(id);
    ul.innerHTML = '';
    if (!items.length) {
        ul.innerHTML = '<li class="kw-empty">Sin resultados</li>';
        return;
    }
    items.forEach(kw => {
        const li = document.createElement('li');
        li.innerHTML = `
            <span>${kw}</span>
            <button class="kw-copy" onclick="copyKw(this, '${kw.replace(/'/g,"\\'")}')">
                <i class="fas fa-copy"></i> copiar
            </button>`;
        ul.appendChild(li);
    });
}

function copyKw(btn, text) {
    navigator.clipboard.writeText(text).then(() => {
        btn.innerHTML = '<i class="fas fa-check"></i> copiado';
        setTimeout(() => btn.innerHTML = '<i class="fas fa-copy"></i> copiar', 1500);
    });
}

document.getElementById('kw-niche').addEventListener('keydown', e => {
    if (e.key === 'Enter') runResearch();
});
</script>
