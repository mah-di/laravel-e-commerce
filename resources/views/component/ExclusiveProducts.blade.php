<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s1 text-center">
                    <h2>Exclusive Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tab-style1">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="arrival-tab" data-bs-toggle="tab" href="#Popular" role="tab" aria-controls="arrival" aria-selected="true">Popular</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sellers-tab" data-bs-toggle="tab" href="#New" role="tab" aria-controls="sellers" aria-selected="false">New</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="featured-tab" data-bs-toggle="tab" href="#Hot" role="tab" aria-controls="featured" aria-selected="false">Hot</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="discount-tab" data-bs-toggle="tab" href="#Discount" role="tab" aria-controls="discount" aria-selected="false">Discount</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="flash-sale-tab" data-bs-toggle="tab" href="#FlashSale" role="tab" aria-controls="flash-sale" aria-selected="false">Flash Sale</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="trending-tab" data-bs-toggle="tab" href="#Trending" role="tab" aria-controls="trending" aria-selected="false">Trending</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="Popular" role="tabpanel" aria-labelledby="arrival-tab">
                        <div id="PopularItem" class="row shop_container">




                        </div>
                    </div>
                    <div class="tab-pane fade" id="New" role="tabpanel" aria-labelledby="sellers-tab">
                        <div id="NewItem"  class="row shop_container">


                        </div>
                    </div>
                    <div class="tab-pane fade" id="Hot" role="tabpanel" aria-labelledby="featured-tab">
                        <div id="HotItem" class="row shop_container">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="Discount" role="tabpanel" aria-labelledby="discount-tab">
                        <div id="DiscountItem" class="row shop_container">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="FlashSale" role="tabpanel" aria-labelledby="flash-sale-tab">
                        <div id="FlashSaleItem"  class="row shop_container">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="Trending" role="tabpanel" aria-labelledby="trending-tab">
                        <div id="TrendingItem"  class="row shop_container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script>


    function constructCards(item) {
        return `<div class="col-lg-3 col-md-4 col-6">
                    <div class="product">
                        <div class="product_img">
                            <a href="#">
                                <img src="${item['image']}" alt="product_img9">
                            </a>
                            <div class="product_action_box">
                                <ul class="list_none pr_action_btn">
                                    <li><a href="/details?id=${item['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product_info">
                            <h6 class="product_title"><a href="/details?id=${item['id']}">${item['title']}</a></h6>
                            <div class="product_price">
                                <span class="price">$ ${item['price']}</span>
                            </div>
                            <div class="rating_wrap">
                                <div class="rating">
                                    <div class="product_rate" style="width:${item['star']*20}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
    }

    async function Popular(){
        let res=await axios.get("{{ url('/api/remark/popular/products') }}");
        $("#PopularItem").empty();
        res.data['data'].forEach((item,i)=>{
            let EachItem=constructCards(item)
            $("#PopularItem").append(EachItem);
        })

    }


    async function New (){
        let res=await axios.get("{{ url('/api/remark/new/products') }}");
        $("#NewItem").empty();
        res.data['data'].forEach((item,i)=>{
            let EachItem=constructCards(item)
            $("#NewItem").append(EachItem);
        })
    }


    async function Hot(){
        let res=await axios.get("{{ url('/api/remark/hot/products') }}");
        $("#HotItem").empty();
        res.data['data'].forEach((item,i)=>{
            let EachItem=constructCards(item)
            $("#HotItem").append(EachItem);

        })
    }



    async function Discount(){
        let res=await axios.get("{{ url('/api/remark/popular/products') }}");
        $("#DiscountItem").empty();

        res.data['data'].forEach((item,i)=>{
            let EachItem=constructCards(item)
            $("#DiscountItem").append(EachItem);

        })
    }



    async function FlashSale(){
        let res=await axios.get("{{ url('/api/remark/flash%20sale/products') }}");
        $("#FlashSaleItem").empty();
        res.data['data'].forEach((item,i)=>{
            let EachItem=constructCards(item)
            $("#FlashSaleItem").append(EachItem);

        })
    }


    async function Trending(){
        let res=await axios.get("{{ url('/api/remark/trending/products') }}");
        $("#TrendingItem").empty();
        res.data['data'].forEach((item,i)=>{
            let EachItem=constructCards(item)
            $("#TrendingItem").append(EachItem);

        })
    }

</script>

