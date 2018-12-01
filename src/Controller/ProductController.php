<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

use App\Entity\Products;
use App\Entity\Discounts;

class ProductController extends AbstractController{

    public function create(){
        $request = new Request();
        $requestData = json_decode($request->getContent(), true);
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

    public function update($productId){
        $request = new Request();
        $requestData = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Products::class)->find($entityManager, $productId);
        if (!$product) {
            return $this->json([
                'message' => 'Invalid Request'
            ]);
        }
        if(isset($requestData['name'])){
            $product->setName($requestData['name']);
        }
        if(isset($requestData['price'])){
            $product->setPrice($requestData['price']);
        }            
        $product->setUpdatedAt(new \DateTime());
        $entityManager->flush();

        return $this->json([
            'message' => 'Successfully Updated',
            'product_id' => $product->getId(),
        ]);
    }

    public function list(){
        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('product.name, product.price, discount.amount as discount_amount, discount.type as discount_type')
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

    public function catelog(){
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
        $result = $query->getResult();
          
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
        $queryResults = $query->getResult();
        foreach($queryResults as $qr){
            $productDetails = array("name"=>$qr['p_name'], "id"=>$qr['p_id']);
            $key = array_search($qr['name'], array_column($result, 'name'));
            if(gettype($key)==="integer"){
                array_push($result[$key]['products'], $productDetails);
            }else{
                array_push($result, array(
                    "id"=>$qr['id'],
                    "name"=>$qr['name'],
                    "price"=>$qr['price'],
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

    public function details($productId){
        $entityManager = $this->getDoctrine()->getManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('product.name, product.price, discount.amount, discount.type')
                ->from('App\Entity\Products', 'product')
                ->leftJoin(
                    'App\Entity\Discounts', 'discount', 
                    \Doctrine\ORM\Query\Expr\Join::WITH, 
                    'product.id = discount.product')
                ->where("product.id = $productId ")
                ->orderBy('product.created_at', 'DESC');
        $query = $qb->getQuery();
        $results = $query->getResult();

        if(!$results){
            return $this->json([
                'message' => 'Invalid Request'
            ]);
        }
        return $this->json([
            'message' => 'Successfully Updated',
            'data' => $results[0],
        ]);
    }

    public function delete($productId){
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getReference('App\Entity\Products', $productId);
        try{
            $entityManager->remove($product);
            $entityManager->flush();
            return $this->json([
                'message' => 'Successfully Deleted'
            ]);
        }
        catch(\Exception $e){
            return $this->json([
                'message' => 'Invalid Request'
            ]);
        }
    }
}
