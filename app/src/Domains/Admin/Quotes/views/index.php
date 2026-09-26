<main class="container">
<div class="search-bar">
    <?php if ($currentPage > 1): ?>
        <a href="index.php?page=quotes&action=index&currentPage=<?= $currentPage - 1 ?>">&lt;&lt;</a>
    <?php endif; ?>
    
    <?php if ($currentPage < $totalPages): ?>
        <a href="index.php?page=quotes&action=index&currentPage=<?= $currentPage + 1 ?>">&gt;&gt;</a>
    <?php endif; ?>
    
    <form method="POST" action="index.php?page=quotes&action=search">
        <input type="text" name="search" placeholder="Search Quote Id" 
               value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        
        <select name="month">
            <option value="">Mes</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>">
                    <?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>
                </option>
            <?php endfor; ?>
        </select>
        
        <select name="year">
            <option value="">Año</option>
            <?php for ($y = date("Y"); $y >= (date("Y") - 10); $y--): ?>
                <option value="<?= $y ?>"> <?= $y ?> </option>
            <?php endfor; ?>
        </select>
        
        <button type="submit">Buscar</button>
        
        <a href="index.php?page=quotes&action=create">+</a>
    </form>
</div>

<table class="container-form">
 
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Client</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
  
<?php 
$totalAmount = 0; // Inicializar el total
foreach ($operations as $operation): 
    $totalAmount += $operation['amount']; // Sumar el monto a $totalAmount
?>
<tr>
    <td style="text-align: right;">
        <a href="index.php?page=quotes&action=show&id=<?php echo $operation['id']; ?>">
            <?php echo $operation['id']; ?>
        </a>
    </td>
    <td style="padding: 0 0 0 10px;">
        <?php echo date('Y-m-d', strtotime($operation['created_at'])); ?>
    </td>
    <td style="padding: 0 0 0 10px;">
        <?php echo $operation['client_name']; ?>
    </td>
    <td style="padding: 0 0 0 10px; text-align: right;">
        <?php echo number_format($operation['amount'], 2); ?>
    </td>
    <td>
        <?php 
        if($operation['required']) { echo "Invoice ".$operation['required']; 
        }else{ ?>
        <a href="javascript:void(0);" class="delete-btn" data-id="<?php echo $operation['id']; ?>">Delete</a>
        <?php } ?>
    </td>
</tr>
<?php endforeach; ?>

<!-- Línea de total -->
<tr>
    <td colspan="3" style="text-align: right; font-weight: bold;">Total</td>
    <td style="text-align: right; font-weight: bold;">
        <?php echo number_format($totalAmount, 2); ?>
    </td>
    <td></td>
</tr>


   
</table>


<!-- Modal de Confirmación -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>¿Estás seguro de que deseas eliminar esta cotización?</p>
        <button id="confirmDelete">Sí, eliminar</button>
        <button id="cancelDelete">Cancelar</button>
    </div>
</div>
</main>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let deleteId = null;
    const modal = document.getElementById("deleteModal");
    const confirmBtn = document.getElementById("confirmDelete");
    const cancelBtn = document.getElementById("cancelDelete");

    // Mostrar modal al hacer clic en "Delete"
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            deleteId = this.getAttribute("data-id");
            modal.style.display = "block";
        });
    });

    // Confirmar eliminación
    confirmBtn.addEventListener("click", function () {
        if (deleteId) {
            window.location.href = `index.php?page=quotes&action=delete&id=${deleteId}`;
        }
    });

    // Cancelar eliminación
    cancelBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Cerrar modal al hacer clic fuera
    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>


