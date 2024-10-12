<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
           <div class="table-responsive">
               <table class="table">
                   <thead>
                   <tr>
                       <th>No</th>
                       <th>Payable</th>
                       <th>Shipping</th>
                       <th>Delivery</th>
                       <th>Payment</th>
                       <th>More</th>
                   </tr>
                   </thead>
                   <tbody id="OrderList">

                   </tbody>
               </table>
           </div>
        </div>
    </div>
</div>

<div class="modal" id="ReviewModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-6" id="exampleModalLabel1">Add Review</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h6 id="ProductTitle"></h6>
                <input id="ProductID" class="d-none">
                <label class="form-label">Write Your Review</label>
                <textarea class="form-control form-control-sm" id="reviewTextID" rows="5" placeholder="Your Review"></textarea>
                <label class="form-label mt-2">Rating Score</label>
                <input min="1" value="0" max="5" id="reviewScore" type="number" class="form-control-sm form-control">
                <button onclick="AddReview()" class="btn btn-danger mt-3 btn-sm">Submit</button>



            </div>
        </div>
    </div>
</div>

<div class="modal" id="InvoiceProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-6" id="exampleModalLabel">Products</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody id="productList">

                    </tbody>
                </table>



            </div>
        </div>
    </div>
</div>


<script>



    async function OrderListRequest() {
        let res= await axios.get("{{ route('invoice.getAll') }}");
        let json=res.data['data']

        $("#OrderList").empty();


        if(json.length!==0){
            json.forEach((item,i)=>{
                let rows=`<tr>
                       <td>${item['id']}</td>
                       <td>$ ${item['payable']} </td>
                       <td>${item['ship_detail']}</td>
                       <td>${item['delivery_status']}</td>
                       <td>${item['payment_status']}</td>
                       <td><button data-id=${item['id']} class="btn more btn-danger btn-sm">More</button></td>
                   </tr>`

                $("#OrderList").append(rows);
            })


            $(".more").on('click',function () {
                    let id=$(this).data('id');
                    InvoiceProductList(id)
            })

        }
    }




   async function InvoiceProductList(id) {

       $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
       let res= await axios.get("/_api/invoice-detail/"+id);
       $("#InvoiceProductModal").modal('show');
       $(".preloader").delay(90).fadeOut(100).addClass('loaded');



       $("#productList").empty();

       res.data['data'].forEach((item,i)=>{
           let rows=`<tr>
            <td>${item['product']['title']}</td>
            <td>${item['qty']}</td>
            <td>$ ${item['sale_price']}</td>
            <td><button data-title="${item['product']['title']}" data-id=${item['product_id']} class="btn review btn-line-fill btn-sm">Review</button></td>
            </tr>`
            $("#productList").append(rows);
        });

        $(".review").on('click',function () {
            let id=$(this).data('id');
            let title=$(this).data('title');

            document.getElementById('ProductTitle').innerText = title
            document.getElementById('ProductID').innerText = id

            $("#InvoiceProductModal").modal('hide');
            $("#ReviewModal").modal('show');
        })
    }


    async function AddReview(){
        let reviewText=document.getElementById('reviewTextID').value;
        let reviewScore=document.getElementById('reviewScore').value;
        let id=document.getElementById('ProductID').innerText
        if(reviewScore.length===0){
            alert("Rating Required !")
        }
        else if(reviewText.length===0){
            alert("Review Required !")
        }
        else{
            $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
            let postBody={review:reviewText, rating:reviewScore, product_id:id}
            let res=await axios.post("{{ route('review.save') }}",postBody);
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            $("#ReviewModal").modal('hide');
        }


    }

</script>
