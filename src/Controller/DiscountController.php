<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

use App\Entity\Products;
use App\Entity\Discounts;

class DiscountController extends AbstractController{

    public function create(){
        $request = new Request();
        $requestData = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Products::class)->findOneById($requestData['productId']);
        if (!$product) {
            return $this->json([
                'message' => 'Invalid Request'
            ]);
        }
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

    public function update($discountId){
        $request = new Request();
        $requestData = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $discount = $entityManager->getRepository(Discounts::class)->findOneById($discountId);
        if (!$discount) {
            return $this->json([
                'message' => 'Invalid Request'
            ]);
        }
        if(isset($requestData['amount'])){
            $discount->setAmount($requestData['amount']);
        }
        if(isset($requestData['type'])){
            $discount->setType($requestData['type']);
        }
        $discount->setUpdatedAt(new \DateTime());
        $entityManager->flush();

        return $this->json([
            'message' => 'Successfully Updated',
            'discount_id' => $discount->getId(),
        ]);
    }

    public function list(){
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

    public function delete($discountId){
        $entityManager = $this->getDoctrine()->getManager();
        $discount = $entityManager->getRepository(Discounts::class)->findOneById($discountId);
        try{
            $entityManager->remove($discount);
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
