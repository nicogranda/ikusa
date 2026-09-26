<?php
namespace App\Libraries\Admin;

use mysqli;

class Model
{
    protected $mysqli;
    protected $table;
    
    public function setTable($table)
    {
        $this->table = $table;
    }

    public function __construct()
    {
        global $mysqli; // Usar la variable $mysqli de connection.php

        // Asignar la conexi籀n existente a la propiedad $mysqli
        $this->mysqli = $mysqli;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $result = $this->mysqli->query($sql);

        if (!$result) {
            die('Error en la consulta: ' . $this->mysqli->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function create($data)
{
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));

    $stmt = $this->mysqli->prepare("INSERT INTO $this->table ($columns) VALUES ($placeholders)");
    
    if (!$stmt) {
        die("Error en prepare(): " . $this->mysqli->error);
    }

    // Vincular tipos din芍micamente
    $types = '';
    $params = [];
    foreach ($data as $value) {
        if (is_int($value)) $types .= 'i';
        elseif (is_float($value)) $types .= 'd';
        else $types .= 's';
        $params[] = $value;
    }

    $stmt->bind_param($types, ...$params);

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        die("Error en execute(): " . $stmt->error);
    }

    // Retorna el ID insertado
    return $this->mysqli->insert_id;
}

    
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Verificar si se encontr車 alguna cotizaci車n
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Devuelve el primer resultado (solo uno porque buscamos por ID)
        } else {
            return null; // No se encontr車 la cotizaci車n
        }
    }       
    
    public function searchById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    
    public function getByAlias($alias) {
        $sql = "SELECT * FROM {$this->table} WHERE alias = ?";
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param("s", $alias);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_assoc();
        }
        return null;
    }
    
    public function getUserByUsername($username) {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }
    
    // M谷todo para obtener todas las Operations paginadas
    public function getAllPaginated($limit, $offset)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT {$limit} OFFSET {$offset}";
        $result = $this->mysqli->query($sql);
        if (!$result) {
            die('Error en la consulta: ' . $this->mysqli->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function searchByName($name)
    {
        // Evitamos inyecci車n SQL asegurando que el campo 'name' existe en la tabla (depende de tu esquema)
        $sql = "SELECT * FROM {$this->table} WHERE name LIKE ? ORDER BY name ASC";
    
        $stmt = $this->mysqli->prepare($sql);
    
        if (!$stmt) {
            throw new \Exception("Error en la preparaci車n de la consulta: " . $this->mysqli->error);
        }
    
        $searchTerm = "%{$name}%";
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();
    
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchByDate($month, $year, $limit, $offset)
    {


    // Construir la consulta SQL din芍micamente
    $sql = "SELECT * FROM {$this->table} WHERE MONTH(created_at) = ? AND YEAR(created_at) = ? LIMIT ? OFFSET ?";
    
    // Preparar la consulta
    $stmt = $this->mysqli->prepare($sql);
    
    // Verificar si la consulta se prepar車 correctamente
    if (!$stmt) {
        echo "Error en la preparaci車n de la consulta: " . $mysqli->error;
        return false;
    }

    // Asociar los par芍metros
    $stmt->bind_param("iiii", $month, $year, $limit, $offset);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener los resultados
    $result = $stmt->get_result();
    
    // Retornar los resultados como un arreglo asociativo
    return $result->fetch_all(MYSQLI_ASSOC);
   }

public function getTotalByDateRange($startDate, $endDate)
{
    $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE created_at BETWEEN ? AND ?";

    $stmt = $this->mysqli->prepare($sql);

    if (!$stmt) {
        echo "Error en la preparaci車n de la consulta: " . $this->mysqli->error;
        return 0;
    }

    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'] ?? 0;
}

public function searchByDateRange($startDate, $endDate, $limit = null, $offset = null)
{
    $sql = "SELECT * FROM {$this->table} WHERE created_at BETWEEN ? AND ? ORDER BY created_at DESC";

    // Agregar paginaci車n si corresponde
    if ($limit !== null && $offset !== null) {
        $sql .= " LIMIT ? OFFSET ?";
    }

    $stmt = $this->mysqli->prepare($sql);

    if (!$stmt) {
        echo "Error en la preparaci車n de la consulta: " . $this->mysqli->error;
        return false;
    }

    // Asociar par芍metros seg迆n si hay limit/offset
    if ($limit !== null && $offset !== null) {
        $stmt->bind_param("ssii", $startDate, $endDate, $limit, $offset);
    } else {
        $stmt->bind_param("ss", $startDate, $endDate);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}



    public function getTotal($search = '')
    {
        if ($search !== '') {
            $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE id LIKE ?";
            $stmt = $this->mysqli->prepare($sql);
            $searchTerm = "%{$search}%";
            $stmt->bind_param('s', $searchTerm);
        } else {
            $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
            $stmt = $this->mysqli->prepare($sql);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function getTotalOperations($search = '')
    {
        if ($search !== '') {
            $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE id LIKE ?";
            $stmt = $this->mysqli->prepare($sql);
            $searchTerm = "%{$search}%";
            $stmt->bind_param('s', $searchTerm);
        } else {
            $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
            $stmt = $this->mysqli->prepare($sql);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function getByItemId($columnName, $value)
    {
        // Evita inyecci車n SQL asegurando que la columna es un string v芍lido
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $columnName)) {
            throw new Exception("Nombre de columna inv芍lido: " . htmlspecialchars($columnName));
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$columnName} = ?";
        $value = (int) $value;
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $value);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC); // Devuelve todos los resultados como array
    }
    
    public function updateById($id, $data) {
        $columns = array_keys($data);
        $values = array_values($data);
        
        $setClause = implode(' = ?, ', $columns) . ' = ?';
        
        $sql = "UPDATE {$this->table} SET $setClause, updated_at = NOW() WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        
        $types = str_repeat('s', count($values)) . 'i'; // Asume strings, ajusta seg迆n necesites
        $values[] = $id; // Agrega el ID al final
        
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }
    
   public function updateOperationByBusinessId($id, $businessId) 
   {
        $sql = "UPDATE {$this->table} SET business_id = ?, updated_at = NOW() WHERE id = ?";
    
        $stmt = $this->mysqli->prepare($sql);
    
        if (!$stmt) {
            return false; // O manejar el error de preparaci車n
        }

        $stmt->bind_param('ii', $businessId, $id); // Ambos son enteros (i)
        return $stmt->execute();
    }


        // M谷todo para actualizar los detalles de la operaci車n
    public function updateOperationDetailsByOperationId($operationId, $operationDetailData)
    {
        // Comenzamos la transacci車nhttps://github.com/ajaxorg/ace/wiki/Default-Keyboard-Shortcuts
        $this->mysqli->begin_transaction();

        try {
            // Instanciamos el modelo OperationsDetails para actualizar los detalles
            $operationDetails = new QuoteDetail(); // Ahora la clase est芍 correctamente importada
            
            foreach ($operationDetailData as $detailId => $data) {
                $operationDetails->updateById($detailId, $data); // Usamos el m谷todo updateById
            }

            // Si todo va bien, hacemos commit de la transacci車n
            $this->mysqli->commit();
            return true;
        } catch (Exception $e) {
            // En caso de fallo, revertimos la transacci車n
            $this->mysqli->rollback();
            return false;
        }
    }


    
    public function delete($id)
    {
        $stmt = $this->mysqli->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    
    public function deleteItemsByOperationId($operationId, $id)
    {
        // Eliminar registros de operation_details
        $sqlDetails = "DELETE FROM $this->table WHERE $operationId = ?";
        $stmtDetails = $this->mysqli->prepare($sqlDetails);
        $stmtDetails->bind_param('i', $id);
        $stmtDetails->execute();
    }

}

