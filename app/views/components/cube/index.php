<style>
 
    .container-hero-home {
        width: 100%;
        height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: black;
    }

    .caja {
        position: relative;
        width: 200px;
        height: 200px;
        transform-style: preserve-3d;
        transform-origin: 200px 200px 0;
        animation: girar 15s ease-in-out alternate infinite;
    }

    .cara {
        position: absolute;
        width: 200px;
        height: 200px;
        backface-visibility: hidden;
    }

    .cara img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cara1 {
        transform: translateZ(100px);
    }

    .cara2 {
        transform: rotateY(90deg) translateZ(100px);
    }

    .cara3 {
        transform: rotateY(90deg) rotateX(90deg) translateZ(100px);
    }

    .cara4 {
        transform: rotateX(180deg) rotateZ(-90deg) translateZ(100px);
    }

    .cara5 {
        transform: rotateY(-90deg) rotateZ(90deg) translateZ(100px);
    }

    .cara6 {
        transform: rotateX(-90deg) translateZ(100px) rotateZ(-90deg);
    }

    @keyframes girar {
        0% {
            transform: none;
        }
        13%, 16.6% {
            transform: rotateY(-90deg);
        }
        30%, 33.33% {
            transform: rotateY(-90deg) rotateZ(90deg);
        }
        46%, 49.999% {
            transform: rotateY(-270deg) rotateZ(90deg);
        }
        63%, 66% {
            transform: rotateY(90deg);
        }
        80%, 83% {
            transform: rotateY(-180deg) rotateZ(90deg);
        }
        97%, 100% {
            transform: none;
        }
    }

    


    @media only screen and (max-width: 600px) {
        .caja {
            width: 200px;
            height: 200px;
            transform-origin: 200px 200px 0;
        }

        .cara {
            width: 200px;
            height: 200px;
        }

        .cara img {
            width: 100%;
            height: 100%;
        }
    }
</style>


<div class="container-hero-home">
    <div class="caja">
        <div class="cara cara1">
            <img src="assets/img/heros/cube/1.jpg" alt="Cara 1">
        </div>
        <div class="cara cara2">
            <img src="assets/img/heros/cube/2.jpg" alt="Cara 2">
        </div>
        <div class="cara cara3">
            <img src="assets/img/heros/cube/3.jpg" alt="Cara 3">
        </div>
        <div class="cara cara4">
            <img src="assets/img/heros/cube/4.jpg" alt="Cara 4">
        </div>
        <div class="cara cara5">
            <img src="assets/img/heros/cube/5.jpg" alt="Cara 5">
        </div>
        <div class="cara cara6">
            <img src="assets/img/heros/cube/6.jpg" alt="Cara 6">
        </div>
    </div>
</div>

<div class='desk'>
   
    <article class="hero-banner-text">
        <h1 class='hero-banner-title'>Agencia de Diseño Gráfico,<br>Desarrollo Web<br> y Marketing Digital</h1>
        <p class='hero-banner-container'>Estrategias de marketing para liderar tu sector</p>
    </article>
</div>

