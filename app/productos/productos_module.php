<?php
require_once("../../config/conexion.php");

class Products extends Conectar
{
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LOS TIPO DE GASTOS EXISTENTES EN LA BASE DE DATOS*/
  public function getDataProductCategoriesBD()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM product_category_data_table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DEL NUEVO CODIGO DE GASTO QUE SE DESEAN CREAR EN LA BASE DE DATOS */
  public function getNewCodeProductByCategoryDB($id, $prefix)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT CONCAT('$prefix-', LPAD(COUNT(*) + 1, 2, '0')) AS newcode
            FROM product_data_table
            WHERE pc_id = :cate");
    $stmt->execute(['cate' => $id]);
    return $stmt->fetchColumn();
  }

  public function getDataProductUnitsBD()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM product_units_data_table");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA CREAR EL NUEVO GASTO EN LA BASE DE DATOS */
  public function createDataProductDB($id, $cate, $code, $name, $unit, $amountp, $amounts)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO product_data_table (p_id, pc_id, p_code, p_name, p_unit, p_price_p, p_price_s) VALUES (:id, :cate, :code, :name, :unit, :amountp, :amounts)");
    $stmt->execute(['id' => $id, 'cate' => $cate, 'code' => $code, 'name' => $name, 'unit' => $unit, 'amountp' => $amountp, 'amounts' => $amounts]);
    return $stmt->rowCount();
  }

  public function createDataItemsRecipeDB($recipe, $product, $name, $amount, $quantity, $unit, $total)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("INSERT INTO item_recipe_data_table (ir_recipe, ir_product, ir_name, ir_amount, ir_quantity, ir_unit, ir_total) VALUES (:recipe, :product, :name, :amount, :quantity, :unit, :total)");
    $stmt->execute(['recipe' => $recipe, 'product' => $product, 'name' => $name, 'amount' => $amount, 'quantity' => $quantity, 'unit' => $unit, 'total' => $total]);
    return $stmt->rowCount();
  }

  public function updateDataItemsRecipeDB($recipe, $product, $quantity)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE item_recipe_data_table SET ir_quantity = :quantity WHERE ir_recipe = :recipe AND ir_product=:product");
    $stmt->execute(['quantity' => $quantity, 'recipe' => $recipe, 'product' => $product]);
    return $stmt->rowCount();
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION DE LAS CUENTAS DE GASTOS EXISTENTES EN LA BASE DE DATOS */
  public function getDataListProductsDB()
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.p_id, B.pc_name, p_code, p_name, pu_name, p_price_p, p_price_s, pu_acronym
                                  FROM product_data_table AS A
                                  INNER JOIN product_category_data_table AS B ON A.pc_id=B.pc_id
                                  INNER JOIN product_units_data_table AS C ON A.p_unit=C.pu_id 
                                WHERE p_status=1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataListProductsByNameDB($name)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT A.p_id, B.pc_name, p_code, p_name, pu_name, p_price_p, p_price_s 
                                  FROM product_data_table AS A
                                  INNER JOIN product_category_data_table AS B ON A.pc_id=B.pc_id
                                  INNER JOIN product_units_data_table AS C ON A.p_unit=C.pu_id 
                                WHERE p_name LIKE :name AND p_status=1");
    $stmt->execute(['name' => $name]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /* FUNCION PARA EJECUTAR CONSULTAS SQL PARA TRAER INFORMACION UNA UNIDAD DEPARTAMENTAL EXISTENTE EN LA BASE DE DATOS */
  public function getDataProducDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM product_data_table WHERE p_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getDataItemsRecipeDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM item_recipe_data_table WHERE ir_recipe = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public function getDataProducRecipeDB($id)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM product_data_table AS A 
    INNER JOIN product_units_data_table AS C ON A.p_unit=C.pu_id 
    WHERE p_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }



  public function getDataProducOfRecipeDB($name)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT p_id, p_name FROM product_data_table AS A
                                  INNER JOIN product_units_data_table AS C ON A.p_unit=C.pu_id 
                                WHERE p_name LIKE :name AND p_status=1 AND pc_id=1");
    $stmt->execute(['name' => $name]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateDataProductDB($id, $name, $unit, $amountp, $amounts)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE product_data_table SET p_name = :name, p_unit = :unit, p_price_p = :pricep, p_price_s = :prices WHERE p_id = :id");
    $stmt->execute(['name' => $name, 'unit' => $unit, 'pricep' => $amountp, 'prices' => $amounts, 'id' => $id]);
    return $stmt->rowCount();
  }
  public function deleteDataProductDB($id)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE product_data_table SET p_status = :status WHERE p_id = :id");
    $stmt->execute(['status' => 0, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function deleteDataItemRecipeDB($id, $code)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("DELETE FROM item_recipe_data_table WHERE ir_recipe = :recipe AND ir_product=:product");
    $stmt->execute(['recipe' => $id, 'product' => $code]);
    return $stmt->rowCount();
  }

  public function addQuantityByProductDB($id, $quantity)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE product_data_table SET p_quantity = p_quantity + :quantity WHERE p_id = :id");
    $stmt->execute(['quantity' => $quantity, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function subtractQuantityByProductDB($id, $quantity)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE product_data_table SET p_quantity = p_quantity - :quantity WHERE p_id = :id");
    $stmt->execute(['quantity' => $quantity, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function matchQuantityByProductDB($id, $quantity)
  {
    $conectar = parent::conexion();
    $stmt = $conectar->prepare("UPDATE product_data_table SET p_quantity = :quantity WHERE p_id = :id");
    $stmt->execute(['quantity' => $quantity, 'id' => $id]);
    return $stmt->rowCount();
  }

  public function validateExitenceItemDB($id, $code)
  {
    $conectar = parent::conexion();
    parent::set_names();
    $stmt = $conectar->prepare("SELECT * FROM item_recipe_data_table WHERE ir_recipe = :recipe AND ir_product=:product");
    $stmt->execute(['recipe' => $id, 'product' => $code]);
    return $stmt->rowCount();
  }

}
