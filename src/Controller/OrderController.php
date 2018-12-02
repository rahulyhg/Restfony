<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Products;
use App\Entity\Discounts;
use App\Entity\Bundles;
use App\Entity\BundleElements;
use App\Entity\Sales;
use App\Entity\SalesItems;

class OrderController extends AbstractController{

    public function place(){
        try{
            $request = new Request();
            $requestData = json_decode($request->getContent(), true);
            $entityManager = $this->getDoctrine()->getManager();
            $subTotal = 0;
            $totalDiscount = 0; 
            $orderItems = [];
            foreach($requestData['cart'] as $item){
                $itemId = $item['id'];
                if($item['type'] === "BUNDLES"){
                    $cartItems = $this->getBundleProducts($itemId, $item['quantity']);
                }else{
                    $cartItems = $this->getProduct($itemId, $item['quantity']);
                }
                $itemName = $cartItems->name;
                $itemPrice = $cartItems->price;
                array_push($orderItems, $cartItems);
                $totalDiscount += $cartItems['discount'];
                $subTotal += $itemPrice * $item['quantity'];
            }
            $sales = new Sales();
            $sales
                ->setSubTotal($subTotal)
                ->setDiscount($totalDiscount)
                ->setTotal($subTotal - $totalDiscount)
                ->setCreatedAt(new \DateTime());
            $entityManager->persist($sales);
            $entityManager->flush();
            foreach($orderItems as $item){
                $salesItem = new SalesItems();
                $salesItem
                    ->setSales($sales)
                    ->setItemId($item['id'])
                    ->setItemType($item['type'])
                    ->setQuantity($item['quantity'])
                    ->setPrice($item['price'])
                    ->setDiscounts($item['discount'])
                    ->setTotal($item['price']-$item['discount']);
                $entityManager->persist($salesItem);
                $entityManager->flush();
            }
            return $this->json([
                'message' => 'Thanks for your order',
                'sub_total' => $subTotal,
                'discount' => $totalDiscount,
                'order_total'=>$subTotal - $totalDiscount,
                'order_items'=>$orderItems,
            ]);
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>"Invalid Request"]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    private function getBundleProducts($bundleId, $quantity){
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $qb = $entityManager->createQueryBuilder();
            $qb->select('bundle.id,bundle.name,bundle.price, product.name as p_name')
                ->from('App\Entity\BundleElements', 'ref')
                ->leftJoin('App\Entity\Bundles', 'bundle', \Doctrine\ORM\Query\Expr\Join::WITH, 'ref.bundle = bundle.id')
                ->leftJoin('App\Entity\Products', 'product', \Doctrine\ORM\Query\Expr\Join::WITH, 'ref.product = product.id')
                ->where('ref.bundle=:bundleId')
                ->setParameter('bundleId',$bundleId);
            $query = $qb->getQuery();
            $queryResults = $query->getResult();
            $result = array( 
                "id" => $bundleId,
                "name" => $queryResults[0]['name'],
                "type" => "BUNDLES", 
                "price" => $queryResults[0]['price'],
                "quantity" => $quantity, 
                "discount"=>0, 
                "products"=>[]
            );
            foreach($queryResults as $qr){
                array_push($result['products'], array("name"=>$qr['p_name']));
            }
            return $result;
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>$e->getMessage()]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    private function getProduct($itemId, $quantity){
        try{
            $itemDiscount = 0;
            $entityManager = $this->getDoctrine()->getManager();
            $qb = $entityManager->createQueryBuilder();
            $qb->select('product.name, product.price, discount.amount as discount_amount, discount.type as discount_type')
                ->from('App\Entity\Products', 'product')
                ->leftJoin('App\Entity\Discounts', 'discount', \Doctrine\ORM\Query\Expr\Join::WITH,'product.id = discount.product')
                ->where("product.id = $itemId")
                ->orderBy('product.created_at', 'DESC');
            $query = $qb->getQuery();
            $results = $query->getResult();
            if(!isset($results[0])) 
                throw new \Exception("Invalid Product");
            $productDetails = array("id"=>$itemId,"name" => $results[0]['name'], "type"=>"PRODUCTS","price" => $results[0]['price'], "quantity"=> $quantity);
            
            if($results && $results[0]['discount_amount']){
                if($results[0]['discount_type'] === "PERCENT"){
                    $itemDiscount = (abs($results[0]['discount_amount']) * $results[0]['price'] / 100) * $quantity;
                }else{
                    $itemDiscount = abs($results[0]['discount_amount']) * $quantity;
                }
            }
            
            $productDetails['discount'] = $itemDiscount;
            return $productDetails;
        }  
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>$e->getMessage()]));
            $response->setStatusCode(400);
            return $response;
        }
    }
}
