<?php
class ProductController extends Controller
{

    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        //redirect if not logged in or not admin //
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $db = (new Database())->connect();
        $this->productModel = new ProductModel($db);
        $this->categoryModel = new CategoryModel($db);
    }

    //GET /admin/products - show all products
    public function index()
    {
        $products = $this->productModel->getAllProducts();

        $this->view('admin/products/index', [
            'products' => $products
        ]);
    }


    public function create()
    {
        $categories = $this->categoryModel->getAllCategory();

        $this->view('admin/products/create', [
            'categories' => $categories
        ]);
    }

    //POST /admin/products/store - save new product
    public function store()
    {
        //handle the image upload
        $image1 = $this->uploadImage('image1');
        $image2 = $this->uploadImage('image2');

        $data = [
            'category_id' => $_POST['category_id'],
            'product_name' => trim($_POST['product_name']),
            'product_desc' => trim($_POST['product_desc']),
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'image1' => $image1,
            'image2' => $image2
        ];

        $this->productModel->addNewProduct($data);

        $_SESSION['success'] = 'Product added successfully!';
        header('Location: /admin/products');
        exit;
    }



    //GET /admin/products/edit - show edit form
    public function edit()
    {
        $id = $_GET['id'];
        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getAllCategory();

        $this->view('admin/products/edit', [
            'product' => $product,
            'categories' => $categories

        ]);
    }


    //POST - save changes
    public function update()
    {
        $id = $_POST['product_id'];

        //handle image upload - keep old image if no new upload
        $image1 = !empty($_FILES['image1']['name'])
            ? $this->uploadImage('image1')
            : $_POST['old_image1'];

        $image2 = !empty($_FILES['image2']['name'])
            ? $this->uploadImage('image2')
            : $_POST['old_image2'];

        $data = [
            'category_id'  => $_POST['category_id'],
            'product_name' => trim($_POST['product_name']),
            'product_desc' => trim($_POST['product_desc']),
            'price'        => $_POST['price'],
            'stock'        => $_POST['stock'],
            'image1'       => $image1,
            'image2'       => $image2
        ];


        $this->productModel->updateProduct($id, $data);

        $_SESSION['success'] = 'Product updated successfully!';
        header('Location: /admin/products');
        exit;
    }
    public function delete()
    {
        $id = $_POST['product_id'];
        $this->productModel->deleteProduct($id);

        $_SESSION['success'] = 'Product deleted!';
        header('Location: /admin/products');
        exit;
    }


    //private helper - handles image upload
    //private means - only this controller can use it, the ProductController
    private function uploadImage($fieldName)
    {
        if(empty($_FILES[$fieldName]['name'])) {
            return null;
        }

        $filename = time() . '_' . $_FILES[$fieldName]['name'];
        $uploadDir = '../public/assets/shared/images/products/';
        $uploadPath = $uploadDir . $filename;

        move_uploaded_file($_FILES[$fieldName]['tmp_name'], $uploadPath);

        return $filename;
    }
}
