<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Products;
use App\Entity\Discounts;
use App\Entity\Bundles;
use App\Entity\BundleElements;

class BundleController extends AbstractController{

    public function create(){
        try{
            $request = new Request();
            $requestData = json_decode($request->getContent(), true);
            $entityManager = $this->getDoctrine()->getManager();

            $bundle = new Bundles();
            $bundle
                ->setName($requestData['name'])
                ->setPrice($requestData['price'])
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());
            $entityManager->persist($bundle);
            $entityManager->flush();

            foreach($requestData['products'] as $productId){
                $product = $entityManager->getRepository(Products::class)->findOneById($productId);
                if (!$product) 
                    throw new \Exception("Invalid Product");
                $bundleElement = new BundleElements();
                $bundleElement
                    ->setBundle($bundle)
                    ->setProduct($product);
                $entityManager->persist($bundleElement);
                $entityManager->flush();
            }
            return $this->json([
                'message' => 'Successfully Created',
                'bundle_id' => $bundle->getId(),
            ]);
        }
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>"Invalid Request"]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function update($bundleId){
        try{
            $request = new Request();
            $requestData = json_decode($request->getContent(), true);
            $entityManager = $this->getDoctrine()->getManager();
            $bundle = $entityManager->getRepository(Bundles::class)->findOneById($bundleId);
            if (!$bundle) 
                throw new \Exception("Invalid Bundle");

            if(isset($requestData['name']))
                $bundle->setName($requestData['name']);

            if(isset($requestData['price']))
                $bundle->setPrice($requestData['price']);   

            $bundle->setUpdatedAt(new \DateTime());
            $entityManager->flush();
            $bundleId = $bundle->getId();

            foreach($requestData['products'] as $productId){
                $qb = $entityManager->createQueryBuilder();
                $qb->delete('App\Entity\BundleElements', 'elm');
                $qb->where('elm.product = :productId');
                $qb->andWhere('elm.bundle = :bundleId');
                $qb->setParameter('productId',$productId);
                $qb->setParameter('bundleId',$bundleId);
                $qb->getQuery()->execute();

                $product = $entityManager->getRepository(Products::class)->findOneById($productId);
                if (!$product)
                    throw new \Exception("Invalid Product");

                $bundleElement = new BundleElements();
                $bundleElement
                    ->setBundle($bundle)
                    ->setProduct($product);
                $entityManager->persist($bundleElement);
                $entityManager->flush();
            }
            return $this->json([
                'message' => 'Successfully Updated',
                'product_id' => $bundle->getId(),
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
            $result = [];
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
            $queryResults = $query->getResult();
            
            foreach($queryResults as $qr){
                $productDetails = array("name"=>$qr['p_name'], "id"=>$qr['p_id']);
                $key = array_search($qr['id'], array_column($result, 'id'));
                if(gettype($key)==="integer"){
                    array_push($result[$key]['products'], $productDetails);
                }else{
                    array_push($result, array(
                        "id"=>$qr['id'],
                        "name"=>$qr['name'],
                        "price"=>$qr['price'],
                        "products"=>[$productDetails]
                    ));
                }
            }
            return $this->json([
                'message' => 'Successfully Updated',
                'data' => $result,
            ]);
        }
        catch(\Exception $e){
            $response = new Response($this->json(["message"=>"Invalid Request"]));
            $response->setStatusCode(400);
            return $response;
        }
    }

    public function delete($bundleId){
        try{
            $entityManager = $this->getDoctrine()->getManager();
            $bundle = $entityManager->getReference('App\Entity\Bundles', $bundleId);
            $entityManager->remove($bundle);
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
