<?php
/**
 * FAQ Component
 */
if (!isset($faqs) || !is_array($faqs) || empty($faqs)) {
    return;
}
$faqId = "faq_" . uniqid();
$schema = [
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => array_map(function ($faq) {
        return [
            "@type" => "Question",
            "name" => $faq['question'],
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => $faq['answer']
            ]
        ];
    }, $faqs)
];

$faqHeading = match($lang ?? 'es') {
    'en' => 'Frequently Asked Questions',
    'eu' => 'Galdera Ohikoenak',
    default => 'Preguntas frecuentes',
};
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
</script>

<div class="faq-wrapper">

    <h2 class="principal"><?= htmlspecialchars($faqHeading, ENT_QUOTES, 'UTF-8') ?></h2>

    <section class="faq" id="<?= $faqId ?>">
        <?php foreach ($faqs as $faq): ?>
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <?= htmlspecialchars($faq['question'], ENT_QUOTES, 'UTF-8') ?>
                </button>
                <div class="faq-answer">
                    <?= $faq['answer'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const root = document.getElementById("<?= $faqId ?>");
    if (!root) return;
    const items = root.querySelectorAll(".faq-item");
    items.forEach(item => {
        const btn = item.querySelector(".faq-question");
        btn.addEventListener("click", () => {
            const isOpen = item.classList.contains("open");
            items.forEach(i => i.classList.remove("open"));
            if (!isOpen) {
                item.classList.add("open");
            }
        });
    });
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap');

/* ─────────────────────────────
   FAQ GLOBAL
───────────────────────────── */

.faq-wrapper {
    padding: 30px;
}


/* Grid */
.faq {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    max-width: 960px;
    margin: 0 auto;
    font-family: 'Outfit', sans-serif;
}

/* ─────────────────────────────
   ITEM
───────────────────────────── */

.faq-item {
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    transition: box-shadow 0.2s ease, transform 0.15s ease;
}

.faq-item:hover {
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
    transform: translateY(-1px);
}

/* ─────────────────────────────
   QUESTION
───────────────────────────── */

.faq-question {
    width: 100%;
    padding: 18px 20px;
    text-align: left;

    font-family: 'Outfit', sans-serif;
    font-size: 0.97rem;
    font-weight: 500;

    color: #444;
    background: #fff;

    border: 0;
    cursor: pointer;

    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;

    line-height: 1.4;
    transition: background 0.15s ease;
}

.faq-question:hover {
    background: rgba(0, 0, 0, 0.02);
}

/* Flecha (visible en todos) */
.faq-question::after {
    content: '∨';
    color: var(--color-primary);
    font-size: 1.05rem;
    flex-shrink: 0;
    transition: transform 0.25s ease;
}

/* Rotación cuando está abierto */
.faq-item.open .faq-question::after {
    transform: rotate(180deg);
}

/* ─────────────────────────────
   ANSWER
───────────────────────────── */

.faq-answer {
    display: none;
    padding: 0 20px 16px;

    color: #555;
    font-size: 0.93rem;
    line-height: 1.65;
}

.faq-item.open .faq-answer {
    display: block;
}

/* ─────────────────────────────
   RESPONSIVE
───────────────────────────── */

@media (max-width: 768px) {
    .faq {
        grid-template-columns: 1fr;
    }
}
</style>