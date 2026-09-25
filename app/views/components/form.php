<div class="cta">
    <!-- LEFT -->
    <div class="left">
      <h2>Cuéntanos qué quieres posicionar</h2>
      <p>Te respondemos con un análisis real en menos de 48h.</p>
    </div>
    <!-- RIGHT -->
    <div class="right">
      <form action="/?page=lead&action=store" method="POST">
        <div class="form-grid">
          <input type="text"  name="name"    placeholder="Nombre"  required />
          <input type="email" name="email"   placeholder="E-mail"  required />
          <input type="url"   name="website" placeholder="URL" />
          <button type="submit" class="form-btn">Solicitar</button>
        </div>
      </form>
    </div>
</div>

<style>
.cta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px 24px;
}

.left h2 {
    margin: 0;
    font-size: 48px;
    font-weight: 700;
    padding: 0px 10px;
}
.left p {
    padding: 10px 0 0 10px;
    font-size: 14px;
}

.form-grid {
    display:flex;
    flex-direction: column;
    width:100%;
    gap: 20px;
    padding: 0px 10px;
}
.form-grid input,
.form-grid button {
    height: 60px;
    padding: 10px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 15px;
}


@media (max-width: 768px) {
    .cta {
        grid-template-columns: 1fr;
        padding: 0px 0px;
        gap: 0px;
    }
  
  .left{
      height: 150px;
  }    
  .right form {
      padding: 0 10px;
  }
  .form-grid input,
  .form-grid button {
    height: 50px;
}   
}

</style>