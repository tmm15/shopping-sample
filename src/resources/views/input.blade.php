<!doctype html>
<html lang="en">
  <head>
   <!-- Required meta tags -->
    <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>shopping-sample</title>
  </head>

  <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid justify-content-start">
          <a class="navbar-brand">  shopping-sample  </a>
        <form class="d-flex">
            <input  class="form-control me-2" placeholder="Search" name="search" type="search" aria-label="Search" value="{{ $keyword; }}"/>
            <button class="btn btn-outline-danger" type="submit">Search</button>
        </form>
          </div>
        </div>
      </nav>

    <main>
      <div class="container">
        <div class="row">
          <div class="col-2">
            <div class="card" style="col-2">
              <div class="card-header">
                価格
              </div>
              <a href="/price/0" class="list-group-item list-group-item-action {!! ($price == 0) ? 'active' : '' !!} ">¥0〜2,000</a>
              <a href="/price/2000" class="list-group-item list-group-item-action {!! ($price == 2000) ? 'active' : '' !!} ">¥2,000〜4,000</a>
              <a href="/price/4000" class="list-group-item list-group-item-action {!! ($price == 4000) ? 'active' : '' !!} ">¥4,000〜6,000</a>
              <a href="/price/6000" class="list-group-item list-group-item-action {!! ($price == 6000) ? 'active' : '' !!} ">¥6,000〜8,000</a>
              <a href="/price/8000" class="list-group-item list-group-item-action {!! ($price == 8000) ? 'active' : '' !!} ">¥8,000〜10,000</a>
              <a href="/price/10000" class="list-group-item list-group-item-action {!! ($price == 10000) ? 'active' : '' !!} ">¥10,000以上</a>
            </div>

            <div class="card" style="col-2">
              <div class="card-header">
                  ジャンル
              </div>
                <a href="/genre/clothes" class="list-group-item list-group-item-action {!! ($genre == 'clothes') ? 'active' : '' !!} ">服</a>
                <a href="/genre/bags" class="list-group-item list-group-item-action {!! ($genre == 'bags') ? 'active' : '' !!} ">バッグ</a>
                <a href="/genre/shoes" class="list-group-item list-group-item-action {!! ($genre == 'shoes') ? 'active' : '' !!} ">靴</a>
                <a href="/genre/cosmetics" class="list-group-item list-group-item-action {!! ($genre == 'cosmetics') ? 'active' : '' !!} ">コスメ</a>              
            </div>
          </div>       
          
          <div class="col-10">
            @if($error_message)
              <div class="alert alert-danger" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                  <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                {{ $error_message }}
              </div>

            @else
              <h5 class="text">検索結果  {{ ( $first_result ); }}〜{{ ( $last_result ); }}件 （{{ number_format( $count_result ); }}件）</h5>
              <div class="row">
                @foreach ($result as $item)
                  <div class="col-4">
                    <div class="card">
                      <img src={{ $item['smallImageUrls']; }} class="card-img-top" alt="...">
                      <div class="card-body">
                        <h6 class="card-Inline text">{{ $item['shopName']; }}</h6>
                        <h5 class="card-text d-inline-block text-truncate " style="width: 225px;">{{ $item['itemName']; }}</h5>
                        <h3 class="card-text"> ¥{{ number_format($item ['itemPrice']); }}</h3>
                        <h6 class="card-Inline-text"> ★{{ $item['reviewAverage']; }}（{{ $item['reviewCount'] }}件）</h6>
                        <a href={{ $item['itemUrl']; }} class="btn btn-danger">楽天市場へGo</a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>            
              
              @if ($pagenation)
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">
                    <?php for($i = $pagenation['min_page'] ; $i <= $pagenation['show_page'] ; ++$i ) { ?>
                      <li class="page-item <?php if($i == $pagenation['this_page']) echo 'active'; ?>">
                        <a class="page-link" href="{{ $pagenation['base_link'] }}{{ $i }}">{{ $i }}</a>
                      </li>
                    <?php } ?>
                  </ul>
                </nav>
              @endif

            @endif
          </div>
        </div>
      </div>
    </main>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>