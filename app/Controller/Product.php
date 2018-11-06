<?php
namespace App\Controller;

use Core\Controller;
use Core\View;
use App\Model\ProductModel;

class Product extends Controller
{

    public function index()
    {
       $this->view->render('app/View/product/list.phtml');
    }
}
