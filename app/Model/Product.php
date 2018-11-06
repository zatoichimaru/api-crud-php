<?php
namespace App\Model;

use Core\Model;
use \PDO;


class ProductModel extends Model
{

    private $id;
    private $name;
    private $price;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }
    
    public function getAll()
    {
        try{   
            
            $stmt = parent::query("SELECT id, name, price FROM product");

            return array(
                'message' => 'Product Listed Successfully!',
                'status' => false,
                'data' => $stmt->fetchAll(parent::FETCH_ASSOC)
            );

        
        } catch (Exception $e) {
            
            return array( 
                'message' => 'Error message - ' . $e->getMessage(),
                'status' => false
            );
        
        }
    
    }

    public function getById()
    {
        if( empty( $this->id ) OR !is_numeric( $this->id ) ){

            return array( 
                'message' => 'Error id invalid',
                'status' => false
            );

        }

        try{   
            
            $stmt = $dbh->prepare("SELECT id, name, price FROM product WHERE id = :id");
            $stmt->execute( array(':id' => $this->id ) );

            return array(
                'message' => 'Product Listed Successfully!',
                'status' => false,
                'data' => $stmt->fetch(parent::FETCH_ASSOC)
            );


        
        } catch (Exception $e) {
        
            return array( 
                'message' => 'Error message - ' . $e->getMessage(),
                'status' => false
            );        
        }
    
    }

    public function insert()
    {
        $id = 0;

        try{   
            
            $stmt = parent::prepare("INSERT INTO product (name, price) VALUES (:name, :price)");

            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);
            $stmt->execute();

            $id = $this->lastInsertId();

            if( !$id ){

               return array( 
                    'message' => 'Could not insert into database !',
                    'status' => false
                ); 

            }

            return array(
                'message' => 'Product inserted successfully!',
                'status' => false,
                'data' => $id
            );
        
        } catch (Exception $e) {
        
            return array( 
                'message' => 'Error message - ' . $e->getMessage(),
                'status' => false
            );        
        }
    }

    public function update()
    {
        try{   
            
            $stmt = parent::prepare("UPDATE product SET name = :name, price = :price WHERE id = :id");

            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $this->price, PDO::PARAM_STR);

            $stmt->execute();

            if( !$stmt->rowCount() ) {

               return array( 
                    'message' => 'Could not updated into database !',
                    'status' => false
                ); 

            }

            return array(
                'message' => 'Product updated successfully!',
                'status' => false,
                'data' => array( 'id' => $this->id )
            );

        } catch (Exception $e) {
        
            return array( 
                'message' => 'Error message - ' . $e->getMessage(),
                'status' => false
            );        
        }
    }

    public function remove()
    {
        try{   
            
            $stmt = parent::prepare("DELETE FROM product WHERE id = :id");

            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            $stmt->execute();

            if( !$stmt->rowCount() ) {

               return array( 
                    'message' => 'Could not remove into database !',
                    'status' => false
                ); 

            }

            return array(
                'message' => 'Product removed successfully!',
                'status' => false,
                'data' => $this->id
            );

        } catch (Exception $e) {
        
            return array( 
                'message' => 'Error message - ' . $e->getMessage(),
                'status' => false
            );        
        }
    }
}