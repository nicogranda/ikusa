<?php

$page = $_GET['page'] ?? 'home';

/*
|--------------------------------------------------------------------------
| Páginas con logo y menú oscuros
|--------------------------------------------------------------------------
*/
$darkHeaderPages = [
    'contact',
    'admin',
    'rfq',
    'lead',
    'sitemap',
    'scraper',

    // Legal (valores reales según .htaccess)
    'legal/aviso-legal',
    'legal/politica-de-cookies',
    'legal/politica-de-proteccion-de-datos',
    'legal/terminos-y-condiciones',
    'legal/condiciones-para-sitio-web',
    'legal/posicionamiento-seo',
    'legal/propuesta-de-branding',

    'marketing-donostia',
    'logos',
    'merchandising',
    'cards',

    'desarrollo-web',
    'diseno-grafico',
    'agencia-de-marketing',

    'marketing-digital',
    'marketing-digital-irun',
     
    'proyectos',
    'avalon-estetic',
    'petit-cafe',
    'porlamar',
    'maleta-chic',
    'la-ex-cocteleria',
    'borjas-design',
    
    
];

$headerClass = in_array($page, $darkHeaderPages)
    ? 'dark-header'
    : '';

?>

<header id="main-header" class="<?= $headerClass; ?>">
    <div style="display:flex; align-items:center; gap:10px;">
        <div class="burger-menu" id="burger-menu" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    <div class="logo">
        <a href="/<?= htmlspecialchars($lang ?? 'es') ?>"><?php include dirname(__DIR__, 3) . '/public_html/assets/img/ikusa_inline.svg'; ?></a>
    </div>
    </div>

    <div class="menu" id="menu">
        <a href="/<?= htmlspecialchars($lang ?? 'es') ?>">Home</a>

        <a href="#" onclick="toggleServices()">Qué hacemos?</a>
        <div id="services-menu" class="dropdown">
            <a href="/es/diseno-grafico">Diseño Gráfico</a>
            <a href="/es/desarrollo-web">Diseño y Desarrollo Web</a>
            <a href="/es/marketing-digital">Marketing Digital</a>
        </div>

        <a href="#" onclick="togglePortfolio()">Portafolio</a>
        <div id="portfolio-menu" class="dropdown">
            <a href="/es/logos">Logos</a>
            <a href="/es/tarjetas-de-visitas">Cards</a>
            <a href="/es/merchandising">Merchandising</a>
        </div>
        
        <a href="/es/proyectos">Proyectos</a>
        
        <a href="/es/nosotros">Quiénes somos?</a>

    </div>

    <!--<div class="contact-us">-->
    <!--    <a href="/es/contacto">Contáctanos</a>-->
    <!--</div>-->
</header>

<!-- CHATBOT -->
<div id="chatbot-widget">
    <div id="chatbot-toggle">
        <img src="<?= htmlspecialchars(asset_url('img/chat-bot.svg'), ENT_QUOTES, 'UTF-8') ?>" alt="Chat Bot">
    </div>
    <div id="chatbot-box">
        <div class="chat-header">Soporte</div>
        <div class="chat-body" id="chat-messages"></div>
        <div class="chat-footer">
            <input type="text" id="chat-input" placeholder="Escribe..." />
            <button id="chat-send">Enviar</button>
        </div>
    </div>
</div>

<style>
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9999;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    padding: 15px 20px;
    box-sizing: border-box;
    transition: background 0.3s ease;
}

header.scrolled {
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.logo {
    display: flex;
    align-items: center;
}

.logo img {
    height: 40px;
    width: auto;
    display: block;
    transition: filter 0.3s ease;
}

.logo svg{
    height:40px;
    width:auto;
    display:block;
    color:#fff;
    transition:color .3s ease;
}

/* Home (antes del scroll) */
header:not(.scrolled):not(.dark-header) .logo svg{
    color:#fff;
}

/* Páginas claras */
header.dark-header .logo svg{
    color:#000;
}

/* Siempre negro al hacer scroll */
header.scrolled .logo svg{
    color:#000;
}




/* ── BURGER ── */
.burger-menu {
    display: flex;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    padding: 10px;
    z-index: 1000;
}

.bar {
    width: 25px;
    height: 3px;
    background: var(--brand-color);
    border-radius: 3px;
    transition: all 0.3s ease;
}


.burger-menu.active .bar:nth-child(1) {
    transform: translateY(8px) rotate(45deg);
}
.burger-menu.active .bar:nth-child(2) {
    opacity: 0;
}
.burger-menu.active .bar:nth-child(3) {
    transform: translateY(-8px) rotate(-45deg);
}

/* ── MENÚ ── */
.menu {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 70px;
    left: 0;
    width: 100%;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    z-index: 1000;
}

.menu.active {
    display: flex;
}

.menu a {
    padding: 14px 20px;
    text-decoration: none;
    color: #000;
    font-size: 15px;
    border-bottom: 1px solid #eee;
}

.menu a:hover {
    background: #f5f5f5;
}

/* ── DROPDOWNS ── */
.dropdown {
    display: none;
    flex-direction: column;
    background: #f9f9f9;
}

.dropdown.open {
    display: flex;
}

.dropdown a {
    padding: 12px 36px;
    font-size: 14px;
    color: #444;
    border-bottom: 1px solid #eee;
}

.dropdown a:hover {
    background: #efefef;
}

/* ── CONTACT US ── */
.contact-us {
    position: fixed;
    right: -30px;
    top: 50%;
    transform: translateY(-50%) rotate(-90deg);
    width: 120px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: var(--color-primary);
    z-index: 200;
}

.contact-us a {
    text-decoration: none;
    color: white;
    font-size: 14px;
    white-space: nowrap;
}

/* ── CHATBOT ── */
#chatbot-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 999;
}

#chatbot-toggle {
    width: 55px;
    height: 55px;
    cursor: pointer;
}

#chatbot-toggle img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

#chatbot-box {
    display: none;
    flex-direction: column;
    width: 300px;
    height: 400px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    overflow: hidden;
    position: absolute;
    bottom: 65px;
    right: 0;
}

#chatbot-box.open {
    display: flex;
}

.chat-header {
    background: #000;
    color: #fff;
    padding: 10px 14px;
    font-size: 14px;
    font-weight: 600;
}

.chat-body {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    font-size: 13px;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.chat-body .user {
    align-self: flex-end;
    background: #000;
    color: #fff;
    padding: 6px 10px;
    border-radius: 10px 10px 0 10px;
    max-width: 80%;
}

.chat-body .bot {
    align-self: flex-start;
    background: #f0f0f0;
    color: #000;
    padding: 6px 10px;
    border-radius: 10px 10px 10px 0;
    max-width: 80%;
}

.chat-footer {
    display: flex;
    border-top: 1px solid #ddd;
}

.chat-footer input {
    flex: 1;
    border: none;
    padding: 10px;
    outline: none;
    font-size: 13px;
}

.chat-footer button {
    border: none;
    background: #000;
    color: #fff;
    padding: 10px 14px;
    cursor: pointer;
    font-size: 13px;
}

.chat-footer button:hover {
    background: #333;
}
</style>

<script>
/* ── SCROLL: cambio de color header + logo ── */
window.addEventListener('scroll', function() {
    var header = document.getElementById('main-header');
    if (window.scrollY > 80) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

/* ── BURGER ── */
function toggleMenu() {
    document.getElementById('burger-menu').classList.toggle('active');
    document.getElementById('menu').classList.toggle('active');

    if (!document.getElementById('menu').classList.contains('active')) {
        document.getElementById('services-menu').style.display = 'none';
        document.getElementById('portfolio-menu').style.display = 'none';
    }
}

/* ── DROPDOWNS ── */
function toggleServices() {
    var menu = document.getElementById('services-menu');
    if (menu.style.display === 'flex') {
        menu.style.display = 'none';
    } else {
        document.getElementById('portfolio-menu').style.display = 'none';
        menu.style.display = 'flex';
    }
}

function togglePortfolio() {
    var menu = document.getElementById('portfolio-menu');
    if (menu.style.display === 'flex') {
        menu.style.display = 'none';
    } else {
        document.getElementById('services-menu').style.display = 'none';
        menu.style.display = 'flex';
    }
}

/* ── CHATBOT ── */
document.addEventListener('DOMContentLoaded', function() {
    var toggleBtn = document.getElementById('chatbot-toggle');
    var chatBox   = document.getElementById('chatbot-box');
    var sendBtn   = document.getElementById('chat-send');
    var input     = document.getElementById('chat-input');
    var messages  = document.getElementById('chat-messages');

    toggleBtn.addEventListener('click', function() {
        chatBox.classList.toggle('open');
    });

    sendBtn.addEventListener('click', sendMessage);

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') sendMessage();
    });

    function sendMessage() {
        var text = input.value.trim();
        if (!text) return;

        addMessage('user', text);
        input.value = '';

        fetch('/index.php?page=chat&action=send', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json; charset=UTF-8' },
            body: JSON.stringify({ message: text })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            addMessage('bot', data.response || 'Sin respuesta');
        })
        .catch(function() {
            addMessage('bot', 'Error de conexión');
        });
    }

    function addMessage(type, text) {
        var div = document.createElement('div');
        div.className = type;
        div.innerText = text;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }
});
</script>