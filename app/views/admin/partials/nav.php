<!-- Bootstrap 5 + Bootstrap Icons (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
    :root {
        --ikusa-accent: #FF2400;
        --ikusa-dark: #1a1a1a;
    }

    .navbar-ikusa {
        background: #fff;
        border-bottom: 1px solid #eee;
        padding: 10px 20px;
    }

    .navbar-ikusa .user-info {
        font-size: 14px;
        color: var(--ikusa-dark);
    }

    .navbar-ikusa .user-info i {
        color: var(--ikusa-accent);
        margin-right: 8px;
    }

    .burger-btn {
        border: none;
        background: transparent;
        font-size: 22px;
        color: var(--ikusa-dark);
    }

    /* Offcanvas menu */
    #ikusaMenu {
        width: 280px;
    }

    #ikusaMenu .offcanvas-header {
        border-bottom: 1px solid #eee;
    }

    #ikusaMenu .offcanvas-title {
        font-weight: 700;
        color: var(--ikusa-accent);
    }

    #ikusaMenu .accordion-button {
        font-weight: 600;
        font-size: 14px;
        background: #f8f8f8;
        color: var(--ikusa-dark);
        box-shadow: none;
    }

    #ikusaMenu .accordion-button:not(.collapsed) {
        background: #fff0eb;
        color: var(--ikusa-accent);
    }

    #ikusaMenu .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(255, 36, 0, 0.2);
    }

    #ikusaMenu .accordion-button::after {
        filter: none;
    }

    #ikusaMenu .list-group-item {
        border: none;
        padding: 10px 20px;
        font-size: 14px;
    }

    #ikusaMenu .list-group-item a {
        color: var(--ikusa-dark);
        text-decoration: none;
        display: block;
    }

    #ikusaMenu .list-group-item a:hover {
        color: var(--ikusa-accent);
    }

    #ikusaMenu .quick-links a {
        color: var(--ikusa-dark);
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        padding: 10px 20px;
    }

    #ikusaMenu .quick-links a:hover {
        color: var(--ikusa-accent);
    }

    #ikusaMenu .quick-links i {
        width: 20px;
        margin-right: 10px;
    }

    #ikusaMenu hr {
        margin: 8px 0;
        opacity: 0.08;
    }
</style>

<nav class="navbar-ikusa d-flex align-items-center justify-content-between">
    <button class="burger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#ikusaMenu" aria-controls="ikusaMenu">
        <i class="bi bi-list"></i>
    </button>

    <div class="user-info d-flex align-items-center">
        <i class="fa fa-user"></i>
        <span><?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
    </div>
</nav>

<!-- Offcanvas menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="ikusaMenu" aria-labelledby="ikusaMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="ikusaMenuLabel">Ikusa Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0">

        <!-- User quick links -->
        <div class="quick-links pt-2">
            <a href="index.php?page=profile"><i class="bi bi-person"></i> Profile</a>
            <a href="index.php?page=logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
        <hr>

        <div class="accordion accordion-flush" id="ikusaAccordion">

            <!-- Products & Supplies -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProducts">
                        <i class="bi bi-box-seam me-2"></i> Products &amp; Supplies
                    </button>
                </h2>
                <div id="collapseProducts" class="accordion-collapse collapse" data-bs-parent="#ikusaAccordion">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="index.php?page=products&action=index">Products</a></li>
                        <li class="list-group-item"><a href="index.php?page=supplies&action=index">Supplies</a></li>
                        <li class="list-group-item"><a href="index.php?page=providers&action=index">Providers</a></li>
                        <li class="list-group-item"><a href="index.php?page=clients&action=index">Clients</a></li>
                    </ul>
                </div>
            </div>

            <!-- Provider -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProvider">
                        <i class="bi bi-truck me-2"></i>Buy
                    </button>
                </h2>
                <div id="collapseProvider" class="accordion-collapse collapse" data-bs-parent="#ikusaAccordion">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="index.php?page=requests&action=index">RFQ</a></li>
                        <li class="list-group-item"><a href="index.php?page=order&action=index">Order</a></li>
                    </ul>
                </div>
            </div>

            <!-- Clients -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClients">
                        <i class="bi bi-receipt me-2"></i> Sales
                    </button>
                </h2>
                <div id="collapseClients" class="accordion-collapse collapse" data-bs-parent="#ikusaAccordion">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="index.php?page=quotes&action=index">Quotes</a></li>
                        <li class="list-group-item"><a href="index.php?page=invoices&action=index">Invoices</a></li>
                        <li class="list-group-item"><a href="index.php?page=colletions&action=index">Collections</a></li>
                    </ul>
                </div>
            </div>

            <!-- Email -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmail">
                        <i class="bi bi-envelope me-2"></i> E-mail
                    </button>
                </h2>
                <div id="collapseEmail" class="accordion-collapse collapse" data-bs-parent="#ikusaAccordion">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="index.php?page=E-mail&action=create">Create</a></li>
                        <li class="list-group-item"><a href="https://ikusa.net/webmail" target="_blank" rel="noopener">Read</a></li>
                    </ul>
                </div>
            </div>

            <!-- Tax -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTax">
                        <i class="bi bi-file-earmark-text me-2"></i> IRS
                    </button>
                </h2>
                <div id="collapseTax" class="accordion-collapse collapse" data-bs-parent="#ikusaAccordion">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="index.php?page=irs&action=index&company_id=1">Declaraciones IRS</a></li>
                    </ul>
                </div>
            </div>

            <!-- SEO -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeo">
                        <i class="bi bi-graph-up-arrow me-2"></i> SEO
                    </button>
                </h2>
                <div id="collapseSeo" class="accordion-collapse collapse" data-bs-parent="#ikusaAccordion">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="index.php?page=keywords">Keywords</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS bundle (Popper incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>