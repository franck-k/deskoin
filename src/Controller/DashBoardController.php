<?php

namespace App\Controller;

use App\Entity\CryptoCurrency;
use App\Repository\CryptoCurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(CryptoCurrencyRepository $currencyRepo, EntityManagerInterface $em, Request $request)
    {
        $currencySelected = $request->query->get('currency');

        if(!$currencySelected){

            /*currencyALL*/
            $qb = $em->createQueryBuilder();
            $qb->select('crypto_currency.cryptoName, crypto_currency.logo')
                ->from(CryptoCurrency::class, 'crypto_currency');

            $queryCurrencyAll = $qb->getQuery();
            $queryCurrencyAllResult = $queryCurrencyAll->execute();


            /*curencyHome*/
            $currencyHomeTitle = 'bitcoin';
            $currencyHomeReq = $currencyRepo->findOneBy(['cryptoName'=>$currencyHomeTitle]);

            /*curencyHomeMarketData*/
            $currencyHomeMarketDataJson = $currencyHomeReq->getMarketData();
            $currencyHomeMarketDataJsonDecode = json_decode($currencyHomeMarketDataJson , true);
            $currencyHomeMarketDataJsonEncode  = json_encode($currencyHomeMarketDataJsonDecode['prices'], true);

            /*curencyHomeMarketPrice*/
            $currencyHomeMarketPriceJson = $currencyHomeReq->getMarketPrice();
            $currencyHomeMarketPriceJsonDecode = json_decode($currencyHomeMarketPriceJson , true);

            foreach($currencyHomeMarketPriceJsonDecode as $value){
                $currencyHomeMarketPrice[] = $value;
            }

            /*curencyHomeMarketitle*/
            $currencyHomeMarketTitle =  $currencyHomeReq->getCryptoName();
            /*curencyHomeMarketTag*/
            $currencyHomeMarketTag =  $currencyHomeReq->getCryptoTag();
            /*curencyHomeMarketLogo*/
            $currencyHomeMarketLogo =  $currencyHomeReq->getLogo();


        }else{

            $currencySelectReq = $currencyRepo->findOneBy(['cryptoName'=>$currencySelected]);

            /*curencySelectMarketData*/
            $currencySelectMarketDataJson = $currencySelectReq->getMarketData();
            $currencySelectMarketDataJsonDecode = json_decode($currencySelectMarketDataJson, true);

            /*curencyHomeMarketPrice*/
            $currencySelectMarketPriceJson = $currencySelectReq->getMarketPrice();
            $currencySelectMarketPriceJsonDecode = json_decode($currencySelectMarketPriceJson , true);

            /*curencyInformation*/
            $currencySelectMarketTitle = $currencySelectReq->getCryptoName();
            $currencySelectMarketTag = $currencySelectReq->getCryptoTag();
            $currencySelectMarketLogo = $currencySelectReq->getLogo();

            unset($currencySelectMarketDataJsonDecode['market_caps']);
            unset($currencySelectMarketDataJsonDecode['total_volumes']);
            $currencyInformation['market_informations']['title'] = $currencySelectMarketTitle;
            $currencyInformation['market_informations']['tag'] = $currencySelectMarketTag;
            $currencyInformation['market_informations']['logo'] = $currencySelectMarketLogo;
            $currencyInformation['market_price'] = $currencySelectMarketPriceJsonDecode;
            $currencyInformation['market_data'] = $currencySelectMarketDataJsonDecode;



            return $this->json([
                'market_informations'=>$currencyInformation['market_informations'],
                'market_price' => $currencySelectMarketPriceJsonDecode[$currencySelected],
                'market_data' => $currencySelectMarketDataJsonDecode['prices']
            ]);
        }


        return $this->render('dash_board/index.html.twig', [
            'currencyAll' => $queryCurrencyAllResult,
            'currencyHomeMarketTitle' =>  $currencyHomeMarketTitle,
            'currencyHomeMarketLogo' => $currencyHomeMarketLogo,
            'currencyHomeMarketLogoTag' => $currencyHomeMarketTag,
            'currencyHomeMarketData' => $currencyHomeMarketDataJsonEncode,
            'currencyHomeMarketPrice' => $currencyHomeMarketPrice
        ]);
    }
}

