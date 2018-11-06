<?php
namespace App\Controller;

use Core\Controller;
use Core\View;
use App\Model\ProductModel;

class Api extends Controller
{

    public function index()
    {
        switch ($_SERVER["REQUEST_METHOD"]){
            case 'POST':
                $this->product_create();
                break;
            case 'PUT':
                $this->product_update();
                break;
            case 'DELETE':
                $this->product_delete();
                break;
            case 'GET':
            default:
                $this->product_list();
                break;
        }
    }

    private function product_create()
    {
        $data= json_decode(file_get_contents("php://input"));
        $product = new ProductModel();
        $product->setName($data->name);
        $product->setPrice($data->price);
        $result = $product->insert();
        echo json_encode($result);
    }

    private function product_update()
    {
        $data= json_decode(file_get_contents("php://input"));
        $product = new ProductModel();
        $product->setId($data->id);
        $product->setName($data->name);
        $product->setPrice($data->price);
        $result = $product->update();
        echo json_encode($result);
    }

    private function product_delete()
    {
        $data= json_decode(file_get_contents("php://input"));
        $product = new ProductModel();
        $product->setId($data->id);
        $result = $product->remove();
        echo json_encode($result);
    }

    private function product_list()
    {
        $product = new ProductModel();
        $result = $product->getAll();
        header('Content-type: application/json');
        echo json_encode($result);
    }
}
