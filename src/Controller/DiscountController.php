<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Products;
use App\Entity\Discounts;

class DiscountController extends AbstractController{

    public function create(){
        try{
            $request = new Request();
            $requestData = json_decode($request->getContent(), true);
            $entityManager = $this->getDoctrine()->getManager();
            $product = $entityManager->getRepository(Products::class)->findOneById($requestData['productId']);
            if (!$product) 
                throw new \Exception("Invalid Product");
            $entityManager->flush();
            $discount = new Discounts();
            $discount
                ->setProduct($product)
                ->setAmount($requestData['amount'])
                ->setType($requestData['type'])
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());
            $entityManager->persist($discount);
            $entityManager->flush();

            return $this->json([
                'message' => 'Successfully Created',
                'discount_id'=> $discount->getId()
            ]);
        }
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>"Invalid Request"]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function update($discountId){
        try{
            $request = new Request();
            $requestData = json_decode($request->getContent(), true);
            $entityManager = $this->getDoctrine()->getManager();
            $discount = $entityManager->getRepository(Discounts::class)->findOneById($discountId);
            if (!$discount) 
                throw new \Exception("Invalid Discount");

            if(isset($requestData['amount']))
                $discount->setAmount($requestData['amount']);
            
            if(isset($requestData['type']))
                $discount->setType($requestData['type']);
            
            $discount->setUpdatedAt(new \DateTime());
            $entityManager->flush();

            return $this->json([
                'message' => 'Successfully Updated',
                'discount_id' => $discount->getId(),
            ]);
        }
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>"Invalid Request"]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function list(){
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $qb = $entityManager->createQueryBuilder();
            $qb->select('product.name, product.price, discount.amount, discount.type')
                ->from('App\Entity\Products', 'product')
                ->where('discount.amount < 0')
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
            $response = new Response($this->json(["message"=>"Invalid Request"]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function delete($discountId){
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $discount = $entityManager->getRepository(Discounts::class)->findOneById($discountId);
            $entityManager->remove($discount);
            $entityManager->flush();
            return $this->json([
                'message' => 'Successfully Deleted'
            ]);
        }
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>"Invalid Request"]));
            $response->setStatusCode(400);
            return $response;
        }
    }
}
