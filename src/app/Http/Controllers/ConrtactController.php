<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConrtactRequest;
use App\Mail\ContactThanks;


class ConrtactController extends Controller
{
    private $datas = [
        'price' => [] ,
        'genre' => [] ,
        'result' => [] ,
        'keyword' => "" ,
        'count_result' => 0 ,
        'page_result' => 0 ,
        'first_result' => 0 ,
        'last_result' => 0 ,
        'pageCount_resuslt' => 0,
        'pagenation' => false ,
        'error_message' => false ,
    ];

    private function updateKeyword(Request $request) {
        $requests = $request->all();
        if (!empty($requests['search'])) {
            $request->session()->put('keyword', $requests['search']);
        }
        $keyword = empty($requests['search']) ? $request->session()->get('keyword'): $requests['search'];
        $this->datas['keyword'] = $keyword;
    }

    public function index(Request $request){
        $this->updateKeyword($request);
        \Cookie::queue("keyword", "服", 24 * 60 * 7);
        return view('input', $this->datas);
    }


    //[price]    
    public function price(Request $request, $price, $page = 1){
        $this->updateKeyword($request);
        // 初期化
        $itemList = 0;
        $itemCount = 0;
        $nowPage = 0;
        $countFirst = 0;
        $countLast = 0;
        $pageCount = 0;

        if (empty($this->datas['keyword'])) {
            // エラー処理
            $this->datas['error_message'] = '検索キーワードが入力されていません';
            return view('input',$this->datas);
        }

        $params = [
            "applicationId" => "1097020028825865426" ,
            "keyword" => $this->datas['keyword'] ,
            "page" => $page ,
        ];
    
        $params['hits'] = 30;
        if ($price == 0) {
            $params['minPrice'] = 1;
            $params['maxPrice'] = 2000;
        } else if ($price == 2000) {
            $params['minPrice'] = 2000;
            $params['maxPrice'] = 4000;
        } else if ($price == 4000) {
            $params['minPrice'] = 4000;
            $params['maxPrice'] = 6000;
        } else if ($price == 6000) {
            $params['minPrice'] = 6000;
            $params['maxPrice'] = 8000;
        } else if ($price == 8000) {
            $params['minPrice'] = 8000;
            $params['maxPrice'] = 10000;
        } else if ($price == 10000) {
            $params['minPrice'] = 10000;
            $params['maxPrice'] = 999999999;
        }

        $params = http_build_query($params, "", "&");
        $url = "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706?{$params}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result =  curl_exec($ch);
        curl_close($ch); 

        $result = json_decode($result, true);
        $itemList = [];
        $itemCount = $result[ 'count' ];
        $nowPage = $result[ 'page' ];
        $countFirst = $result[ 'first' ];
        $countLast = $result[ 'last' ];
        $pageCount = $result['pageCount'];
        foreach( $result[ 'Items' ] as $item ) {
            $itemList[] = [
                "itemName" => $item['Item']['itemName'] ,
                "itemPrice" => $item['Item']['itemPrice'] ,
                "smallImageUrls" => $item['Item']['smallImageUrls'][0]['imageUrl'] ,
                "shopName" => $item['Item']['shopName'] ,
                "reviewAverage" => $item['Item']['reviewAverage'] ,
                "reviewCount" => $item['Item']['reviewCount'] ,
                "itemUrl" => $item['Item']['itemUrl'] ,
            ];
        }

        $this->datas['price'] = $price;
        $this->datas['result'] = $itemList;
        $this->datas['count_result'] = $itemCount;
        $this->datas['page_result'] = $nowPage;
        $this->datas['first_result'] = $countFirst;
        $this->datas['last_result'] = $countLast;
        $this->datas['pageCount_resuslt'] = $pageCount;

        $max_page = (ceil($itemCount / 30) > 100) ? 100 : ceil($itemCount / 30);
        $this->datas['pagenation'] = [
            "min_page" => ( $page >= 7 ) ? $page - 5 : 1 ,
            "max_page" => $max_page ,
            "show_page" => 11 , // ページ数を奇数に
            "this_page" => $page ,
            "base_link" =>  "/price/{$price}/",
        ];
        if ($max_page < 11) {
            $this->datas['pagenation']['show_page'] = $max_page;
        } else if (( $page + 5 ) > $max_page ) {
            $this->datas['pagenation']['show_page'] = $max_page;
        } else if( $page >= 7 ) {
            $this->datas['pagenation']['show_page'] = $page + 5;
        }

        $responce = response()->view('input',$this->datas);
//        $responce->cookie("keyword", $this->datas['keyword'], 24 * 60 * 7);
        return $responce;
    }


    //[genre]
    public function genre(Request $request, $genre, $page = 1){
        $this->updateKeyword($request);
        // 初期化
        $itemList = 0;
        $itemCount = 0;
        $nowPage = 0;
        $countFirst = 0;
        $countLast = 0;
        $pageCount = 0;

        if (empty($this->datas['keyword'])) {
            // エラー処理
            $this->datas['error_message'] = '検索キーワードが入力されていません';
            return view('input',$this->datas);
        }

        $params = [
            "applicationId" => "1097020028825865426" ,
            "keyword" => $this->datas['keyword'] ,
        ];

        $params['hits'] = 30;
        if ($genre == 'clothes') {
            $params['genreId'] = 100371;
        } else if ($genre == 'bags') {
            $params['genreId'] = 565210;
        } else if($genre == 'shoes') {
            $params['genreId'] = 558885;
        } else if($genre == 'cosmetics') {
            $params['genreId'] = 100939;
        }
    
        $params = http_build_query($params, "", "&");
        $url = "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706?{$params}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result =  curl_exec($ch);
        curl_close($ch); 

        $result = json_decode($result, true);
        $itemList = [];
        $itemCount = $result[ 'count' ];
        $nowPage = $result[ 'page' ];
        $countFirst = $result[ 'first' ];
        $countLast = $result[ 'last' ];
        $pageCount = $result['pageCount'];



        foreach( $result[ 'Items' ] as $item ) {
            $itemList[] = [
                "itemName" => $item['Item']['itemName'] ,
                "itemPrice" => $item['Item']['itemPrice'] ,
                "smallImageUrls" => $item['Item']['smallImageUrls'][0]['imageUrl'] ,
                "shopName" => $item['Item']['shopName'] ,
                "reviewAverage" => $item['Item']['reviewAverage'] ,
                "reviewCount" => $item['Item']['reviewCount'] ,
                "itemUrl" => $item['Item']['itemUrl'] ,
            ];
        }

        $this->datas['genre'] = $genre;
        $this->datas['result'] = $itemList;
        $this->datas['count_result'] = $itemCount;
        $this->datas['page_result'] = $nowPage;
        $this->datas['first_result'] = $countFirst;
        $this->datas['last_result'] = $countLast;
        $this->datas['pageCount_resuslt'] = $pageCount;

        $max_page = (ceil($itemCount / 30) > 100) ? 100 : ceil($itemCount / 30);
        $this->datas['pagenation'] = [
            "min_page" => ( $page >= 7 ) ? $page - 5 : 1 ,
            "max_page" => $max_page ,
            "show_page" => 11 , // ページ数を奇数に
            "this_page" => $page ,
            "base_link" =>  "/genre/{$genre}/",
        ];
        if ($max_page < 11) {
            $this->datas['pagenation']['show_page'] = $max_page;
        } else if (( $page + 5 ) > $max_page ) {
            $this->datas['pagenation']['show_page'] = $max_page;
        } else if( $page >= 7 ) {
            $this->datas['pagenation']['show_page'] = $page + 5;
        }


        $responce = response()->view('input',$this->datas);
        //$responce->cookie("keyword", $this->datas['keyword'], 24 * 60 * 7);
        return $responce;
    }

    
    //
    public function comp(ConrtactRequest $request){
        $inputs=$request->all();
        \Mail::send(new ContactThanks($inputs['email']));
        return view('comp',$inputs);
    }
}
