(() => {

    const root = document.querySelector('[data-geo-seo]');

    if (!root) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | INFORMACIÓN DE MUNICIPIOS
    |--------------------------------------------------------------------------
    */

    const municipalities = {

        'donostia-san-sebastian': {
            name: 'Donostia / San Sebastián',
            sectors: [
                'Turismo y alojamiento',
                'Restauración y gastronomía',
                'Comercio y retail',
                'Servicios profesionales',
                'Salud y bienestar'
            ]
        },

        'irun': {
            name: 'Irun',
            sectors: [
                'Comercio',
                'Logística y transporte',
                'Servicios profesionales',
                'Hostelería y restauración',
                'Industria'
            ]
        },

        'hondarribia': {
            name: 'Hondarribia',
            sectors: [
                'Turismo',
                'Alojamiento',
                'Restauración y gastronomía',
                'Comercio local',
                'Servicios turísticos'
            ]
        },

        'astigarraga': {
            name: 'Astigarraga',
            sectors: [
                'Sidrerías y gastronomía',
                'Hostelería',
                'Industria',
                'Servicios profesionales',
                'Comercio local'
            ]
        },

        'tolosa': {
            name: 'Tolosa',
            sectors: [
                'Comercio local',
                'Industria',
                'Gastronomía',
                'Servicios profesionales',
                'Turismo'
            ]
        },

        'zumaia': {
            name: 'Zumaia',
            sectors: [
                'Turismo',
                'Alojamiento',
                'Restauración',
                'Industria',
                'Servicios locales'
            ]
        },

        'zarautz': {
            name: 'Zarautz',
            sectors: [
                'Turismo',
                'Alojamiento',
                'Surf y actividades deportivas',
                'Restauración',
                'Comercio'
            ]
        },

        'hernani': {
            name: 'Hernani',
            sectors: [
                'Industria',
                'Servicios profesionales',
                'Comercio',
                'Hostelería',
                'Construcción'
            ]
        },

        'errenteria': {
            name: 'Errenteria',
            sectors: [
                'Comercio',
                'Servicios profesionales',
                'Industria',
                'Construcción',
                'Hostelería'
            ]
        },

        'oiartzun': {
            name: 'Oiartzun',
            sectors: [
                'Industria',
                'Logística',
                'Comercio',
                'Servicios profesionales',
                'Hostelería'
            ]
        },

        'deba': {
            name: 'Deba',
            sectors: [
                'Turismo',
                'Industria',
                'Alojamiento',
                'Restauración',
                'Comercio local'
            ]
        },

        'eibar': {
            name: 'Eibar',
            sectors: [
                'Industria',
                'Manufactura',
                'Comercio',
                'Servicios profesionales',
                'Formación'
            ]
        },

        'lasarte-oria': {
            name: 'Lasarte-Oria',
            sectors: [
                'Comercio',
                'Servicios profesionales',
                'Industria',
                'Hostelería',
                'Construcción'
            ]
        }

    };


    /*
    |--------------------------------------------------------------------------
    | CREAR MODAL
    |--------------------------------------------------------------------------
    */

    const modal = document.createElement('div');

    modal.className = 'geo-modal';

    modal.setAttribute('aria-hidden', 'true');

    modal.innerHTML = `

        <div class="geo-modal__backdrop" data-geo-close></div>

        <div
            class="geo-modal__dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="geo-modal-title"
        >

            <button
                class="geo-modal__close"
                type="button"
                aria-label="Cerrar"
                data-geo-close
            >
                ×
            </button>

            <p class="geo-modal__eyebrow">
                SEO LOCAL · GIPUZKOA
            </p>

            <p
                class="geo-modal__title"
                id="geo-modal-title"
            ></p>

            <p class="geo-modal__intro">
                Algunos de los sectores con mayor actividad
                en esta zona:
            </p>

            <div
                class="geo-modal__sectors"
                data-geo-sectors
            ></div>

            <div class="geo-modal__cta">

                <p>
                    ¿Tu sector no está mencionado?
                    Cuéntanos tu proyecto y estudiamos cómo
                    convertir su visibilidad digital en una
                    oportunidad de crecimiento.
                </p>

                <a
                    href="/es/contacto"
                    class="geo-modal__button"
                >
                    Cuéntanos tu proyecto
                </a>

            </div>

        </div>
    `;

    document.body.appendChild(modal);


    const title =
        modal.querySelector('.geo-modal__title');

    const sectorsContainer =
        modal.querySelector('[data-geo-sectors]');

    const closeButtons =
        modal.querySelectorAll('[data-geo-close]');


    /*
    |--------------------------------------------------------------------------
    | ABRIR MODAL
    |--------------------------------------------------------------------------
    */

    function openModal(slug, path) {

        const municipality =
            municipalities[slug];

        if (!municipality) {
            return;
        }


        /*
         * Municipio seleccionado
         */

        root
            .querySelectorAll(
                '.municipality--interactive'
            )
            .forEach(item => {

                item.classList.remove(
                    'is-active'
                );

            });


        path.classList.add(
            'is-active'
        );


        /*
         * Nombre
         */

        title.textContent =
            municipality.name;


        /*
         * Sectores
         */

        sectorsContainer.innerHTML = '';

        municipality.sectors.forEach(
            sector => {

                const item =
                    document.createElement('span');

                item.className =
                    'geo-modal__sector';

                item.textContent =
                    sector;

                sectorsContainer.appendChild(
                    item
                );

            }
        );


        /*
         * Mostrar
         */

        modal.classList.add(
            'is-open'
        );

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.classList.add(
            'geo-modal-open'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CERRAR MODAL
    |--------------------------------------------------------------------------
    */

    function closeModal() {

        modal.classList.remove(
            'is-open'
        );

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.classList.remove(
            'geo-modal-open'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MUNICIPIOS
    |--------------------------------------------------------------------------
    */

    root
        .querySelectorAll(
            '.municipality--interactive'
        )
        .forEach(path => {

            const slug =
                path.dataset.municipality;

            if (!municipalities[slug]) {
                return;
            }

            path.addEventListener(
                'click',
                event => {

                    event.preventDefault();

                    openModal(
                        slug,
                        path
                    );

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | CERRAR
    |--------------------------------------------------------------------------
    */

    closeButtons.forEach(
        button => {

            button.addEventListener(
                'click',
                closeModal
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        event => {

            if (
                event.key === 'Escape' &&
                modal.classList.contains(
                    'is-open'
                )
            ) {

                closeModal();

            }

        }
    );

})();