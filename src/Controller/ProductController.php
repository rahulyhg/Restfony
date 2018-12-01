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
        $qb->select('product.name, product.price, discount.amount, discount.type')
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
