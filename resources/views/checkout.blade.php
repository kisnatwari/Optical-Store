@extends('master')
@section('content')
@include('message')
<h2 class="h5 text-uppercase mb-4 text-dark" style="margin-left: 130px">Billing details</h2>
          <div class="row mx-3" >
            <div class="col-lg-8">
              <form action="{{route('order.store')}}" method="post">
                @csrf
                <div class="row gy-3"style="margin-left: 100px">
                  <div class="col-lg-6">
                    <label class="form-label text-sm text-uppercase" for="firstName">First name </label>
                    <input class="form-control form-control-lg" type="text" id="firstName" name="person_name"placeholder="Enter your first name" value="{{auth()->user()->name}}">
                  </div>
                 
                  <div class="col-lg-6">
                    <label class="form-label text-sm text-uppercase" for="email">Email address </label>
                    <input class="form-control form-control-lg" type="email" name= "email" id="email" placeholder="e.g. Jason@example.com"value="{{auth()->user()->email}}">
                  </div>
                  <div class="col-lg-6">
                    <label class="form-label text-sm text-uppercase" for="phone">Phone number </label>
                    <input class="form-control form-control-lg" type="text" name="phone" id="phone" placeholder="e.g. +977 982528690" value="{{auth()->user()->phone}}">
                  </div>
                  <div class="col-lg-6">
                    <label class="form-label text-sm text-uppercase" >Address </label>
                    <input class="form-control form-control-lg" type="text" name= "shipping_address" id="address" placeholder="Your company name" value="{{auth()->user()->address}}">
                  </div>
                  <div class="col-lg-12">
                    <label class="form-label text-sm text-uppercase" for="company">Payment Method</label>
                    <div class="mt-2">
                      <label class="inline-flex items-center">

                        <select name="payment_method"   onchange="paymentMethod(this.value)" id="paymentMethodSelect">
                          <option value="">--Select Payment Method--</option>
                          <option value="COD">Cash on Deleviry</option>
                          <option value="khalti">Khalti Payment </option>
                        </select>
                  
                      </label>
                     
                      
                    </div>
                  </div>

                
                  
                  <div class="col-lg-12 form-group ">
                    <button onclick="submitdata()" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" style="margin-bottom: 3rem; ">Place Order</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- ORDER SUMMARY-->
           
          </div>




          
            
            
            
            
            // var name=document.getElementById('firstName').value;
            // var email=document.getElementById('email').value;
            // var phone=document.getElementById('phone').value;
            // var address=document.getElementById('address').value;
            
            //       var config = {
            //           // replace the publicKey with yours
            //           "publicKey": "test_public_key_e1de1fecb7bd4baf9c0c57ad20e42f47",
            //           "productIdentity": "",
            //           "productName": "",
            //           "productUrl": "http://127.0.0.1:8000/cart",
            //           "paymentPreference": [
            //               "KHALTI",
            //               "EBANKING",
            //               "MOBILE_BANKING",
            //               "CONNECT_IPS",
            //               "SCT",
                    
            {{-- <script>

            
              
            
            
            function paymentMethod(method)
            {
            
                paymentMethodSelect=method;
                
                //  console.log(data);
            }
            
              function submitdata()
              {
                var name=document.getElementById('firstName').value;
                var email=document.getElementById('email').value;
                var phone=document.getElementById('phone').value;
                var address=document.getElementById('address').value;
            
            
            
               var data={
                data:{
                
                    person_name:cus_name,
                    // cus_email:cus_email,
                    phone:phone,
                    street:street,
                    city:city,
                    zipcode:zip,
                    country:country,    
                    
            
            
                },
                _token:"{{csrf_token()}}"
              };
            
            
                if(paymentMethodSelect=='KHALTI')
                {
            
                    khalti(data);
                    checkout.show({amount: 1000});
                  
                    // console.log(paymentMethodSelect);
                } 
                if(paymentMethodSelect=='COD')
                {
            
                //   data->data->paymentMethod='COD';
                        data['data']['payement_method']='COD';
            
                    loadAjaxContent(data);
                }
            
              }
            
            // Ajax
            function loadAjaxContent(data) {
                    $.ajax({
                        url: "{{route('order.orderedproduct')}}", // Replace with your AJAX endpoint URL
                        type: 'post', // Change to 'POST' if needed
                        data:data,
                        success: function (response) {
                            // The AJAX request was successful.
                            // 'data' contains the response from the server.
                            window.location.href="{{route('user.orderedproduct')}}";
                            
                            console.log(response);
                        },
                        error: function (xhr, status, error) {
                            // An error occurred during the AJAX request.
                            console.error(error);
                        }
                    });
                }
            
            
               function khalti(data)
               {
                var config = {
                        // replace the publicKey with yours
                        "publicKey": "test_public_key_e1de1fecb7bd4baf9c0c57ad20e42f47",
                        "productIdentity": "{{auth()->user()->id}}",
                        "productName": "{{auth()->user()->name}}",
                        "productUrl": "",
                        "paymentPreference": [
                            "KHALTI",
                            "EBANKING",
                            "MOBILE_BANKING",
                            "CONNECT_IPS",
                            "SCT",
                            ],
                        "eventHandler": {
                            onSuccess (payload) {
                                // hit merchant api for initiating verfication
                                console.log(payload);
                                
            
            
                      $.ajax({
                        type: 'POST',
                      url: "{{route('user.khalti.verify')}}",
                      data:{
                        _token:"{{ csrf_token() }}",
                        data:payload,
                      },
                        
                      datatype:'json',
                     
                      success: function(response) {
                        console.log(response);
            
                           data['data']['payement_method']='KHALTI';
            
                           loadAjaxContent(data);
            
                      },
                      error: function(xhr, status, error) {
                        console.log("Error: " + error);
                      }
                    });
            
            
            
            
            
                            },
                            onError (error) {
                                console.log(error);
                            },
                            onClose () {
                                console.log('widget is closing');
                            }
                        }
                    };
            
                     checkout = new KhaltiCheckout(config);
                    var btn = document.getElementById("payment-button");
                  
                    
               }
            
            </script>
            


 --}}










          
          @endsection