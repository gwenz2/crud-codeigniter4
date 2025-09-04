<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->findAll();
        return view('product_view', $data);
    }
    public function create()
    {
        try {
            $model = new ProductModel();
            
            // Basic validation
            $productName = $this->request->getPost('product_name');
            $price = $this->request->getPost('price');
            
            if (empty($productName) || empty($price)) {
                return redirect()->to('/products?error=validation');
            }
            
            $data = [
                'product_name' => $productName,
                'description' => $this->request->getPost('description'),
                'price' => $price
            ];
            
            $result = $model->createProduct($data);
            
            if ($result) {
                return redirect()->to('/products?success=created');
            } else {
                return redirect()->to('/products?error=database');
            }
        } catch (\Exception $e) {
            return redirect()->to('/products?error=database');
        }
    }
    public function edit($id)
    {
        $model = new ProductModel();
        $data['product'] = $model->getProduct($id);
        return view('edit_product', $data);
    }
    public function update($id)
    {
        try {
            $model = new ProductModel();
            
            // Check if product exists
            $existingProduct = $model->getProduct($id);
            if (!$existingProduct) {
                return redirect()->to('/products?error=not_found');
            }
            
            // Basic validation
            $productName = $this->request->getPost('product_name');
            $price = $this->request->getPost('price');
            
            if (empty($productName) || empty($price)) {
                return redirect()->to('/products?error=validation');
            }
            
            $data = [
                'product_name' => $productName,
                'description' => $this->request->getPost('description'),
                'price' => $price
            ];
            
            $result = $model->updateProduct($id, $data);
            
            if ($result) {
                return redirect()->to('/products?success=updated');
            } else {
                return redirect()->to('/products?error=database');
            }
        } catch (\Exception $e) {
            return redirect()->to('/products?error=database');
        }
    }
    public function delete($id)
    {
        try {
            $model = new ProductModel();
            
            // Check if product exists
            $existingProduct = $model->getProduct($id);
            if (!$existingProduct) {
                return redirect()->to('/products?error=not_found');
            }
            
            $result = $model->deleteProduct($id);
            
            if ($result) {
                return redirect()->to('/products?success=deleted');
            } else {
                return redirect()->to('/products?error=database');
            }
        } catch (\Exception $e) {
            return redirect()->to('/products?error=database');
        }
    }
}
