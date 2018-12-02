<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Products;
use App\Entity\Discounts;

class ProductController extends AbstractController{

    public function create(){
        try{
            $request = new Request();
            $requestData = json_decode($request->getContent(), true);
            if(!isset($requestData['name']))
                throw new \Exception("Product name is required");

            if(!isset($requestData['price']) || !is_numeric($requestData['price']))
                throw new \Exception("Numeric Product Price is required");

            $entityManager = $this->getDoctrine()->getManager();
            $product = new Products();
            $product
                ->setName($requestData['name'])
                ->setPrice($requestData['price'])
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->json([
                'message' => 'Successfully Created',
                'product_id' => $product->getId(),
            ]);
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>$e->getMessage()]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function update($productId){
        try{
            $valid = false;
            $request = new Request();
            $requestData = json_decode($request->getContent(), true);

            $entityManager = $this->getDoctrine()->getManager();
            $product = $entityManager->getRepository(Products::class)->findOneById($productId);
            if(!$product)
                throw new \Exception("Invalid Product");

            if(isset($requestData['name'])){
                $valid=true;
                $product->setName($requestData['name']);
            }

            if(isset($requestData['price'])){
                $valid=true;
                $product->setPrice($requestData['price']);
            }

            if(!$valid)
                throw new \Exception("Please provide valid Name & Price");

            $product->setUpdatedAt(new \DateTime());
            $entityManager->flush();

            return $this->json([
                'message' => 'Successfully Updated',
                'product_id' => $product->getId(),
            ]);
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>$e->getMessage()]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function list(){
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $qb = $entityManager->createQueryBuilder();
            $qb->select('product.id, product.name, product.price, discount.amount as discount_amount, discount.type as discount_type')
                ->from('App\Entity\Products', 'product')
                ->leftJoin(
                    'App\Entity\Discounts', 'discount', 
                    \Doctrine\ORM\Query\Expr\Join::WITH, 
                    'product.id = discount.product')
                ->orderBy('product.created_at', 'DESC');
            $query = $qb->getQuery();
            $results = $query->getResult();

            return $this->json([
                'message' => 'Successfully Updated',
                'data' => $results,
            ]);
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>$e->getMessage()]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function catelog(){
        try{
            $result = $this->productList();
            $bundleProducts = $this->bundleList();

            foreach($bundleProducts as $bundle){
                $productDetails = array("name"=>$bundle['p_name'], "id"=>$bundle['p_id']);
                $key = array_search($bundle['name'], array_column($result, 'name'));
                if(gettype($key)==="integer"){
                    array_push($result[$key]['products'], $productDetails);
                }else{
                    array_push($result, array(
                        "id"=>$bundle['id'],
                        "name"=>$bundle['name'],
                        "price"=>$bundle['price'],
                        "products"=>[$productDetails],
                        "type" => "BUNDLES"
                    ));
                }
            }

            return $this->json([
                'message' => 'Successfully Fetched',
                'data' => $result,
            ]);
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>$e->getMessage()]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function details($productId){
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $qb = $entityManager->createQueryBuilder();
            $qb->select('product.name, product.price, discount.amount as discount_amount, discount.type as discount_type')
                    ->from('App\Entity\Products', 'product')
                    ->leftJoin(
                        'App\Entity\Discounts', 'discount', 
                        \Doctrine\ORM\Query\Expr\Join::WITH, 
                        'product.id = discount.product')
                    ->where("product.id = $productId ")
                    ->orderBy('product.created_at', 'DESC');
            $query = $qb->getQuery();
            $results = $query->getResult();

            if(!isset($results[0]))
                throw new \Exception("Invalid Product");
                
            return $this->json([
                'message' => 'Successfully fetched',
                'data' => $results[0],
            ]);
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>$e->getMessage()]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function delete($productId){
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $product = $entityManager->getReference('App\Entity\Products', $productId);
            $entityManager->remove($product);
            $result = $entityManager->flush();
            return $this->json([
                'message' => 'Successfully Deleted'
            ]);
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>"Invalid Product"]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    private function productList(){
        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('product.id, product.name, product.price, discount.amount as discount_amount, discount.type as discount_type, \'PRODUCTS\' as type')
            ->from('App\Entity\Products', 'product')
            ->leftJoin(
                'App\Entity\Discounts', 'discount', 
                \Doctrine\ORM\Query\Expr\Join::WITH, 
                'product.id = discount.product')
            ->orderBy('product.created_at', 'DESC');
        $query = $qb->getQuery();
        return $query->getResult();
    }

    private function bundleList(){
        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('bundle.id,bundle.name,bundle.price, product.name as p_name,product.id as p_id')
            ->from('App\Entity\BundleElements', 'ref')
            ->leftJoin(
                'App\Entity\Bundles', 'bundle', 
                \Doctrine\ORM\Query\Expr\Join::WITH, 
                'ref.bundle = bundle.id')
            ->leftJoin(
                'App\Entity\Products', 'product', 
                \Doctrine\ORM\Query\Expr\Join::WITH, 
                'ref.product = product.id')
            ->orderBy('bundle.created_at', 'ASC');
        $query = $qb->getQuery();
        return $query->getResult();
    }
}
