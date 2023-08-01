@extends('layouts.app')
@section('content')

    <h2 class="font-bold text-4xl text-black-700 my-4 mx-3">Dashboard</h2> 
    <hr class="h-1 bg-blue-200">
    
   
        <div class="mt-4 grid grid-cols-3 gap-10">
            <a href="{{ route('product.index') }}" class="px-4 py-8 rounded-lg bg-blue-600 text-white felx justify-between">
                <p class="font-bold text-lg">Total Products</p>
                <p class="font-bold text-5xl">{{$products}}</p>
            </a>
        
            <a href="{{ route('brand.index') }}" class="px-4 py-8 rounded-lg bg-green-600 text-white felx justify-between">
                <p class="font-bold text-lg">Total Brand</p>
                <p class="font-bold text-5xl">{{$brand}}</p>
            </a>
        
            <a href="{{ route('category.index') }}" class="px-4 py-8 rounded-lg bg-red-600 text-white felx justify-between">
                <p class="font-bold text-lg">Total Categories</p>
                <p class="font-bold text-5xl">{{$categories}}</p>
            </a>
        
            <a href="{{ route('order.details') }}" class="px-4 py-8 rounded-lg bg-green-600 text-white felx justify-between">
                <p class="font-bold text-lg">Total Order</p>
                <p class="font-bold text-5xl">{{$order}}</p>
            </a>
        
            <a href="{{ route('user.userdetails') }}" class="px-4 py-8 rounded-lg bg-green-600 text-white felx justify-between">
                <p class="font-bold text-lg">Total Users</p>
                <p class="font-bold text-5xl">{{$users}}</p>
            </a>
            <a href="{{ route('user.userdetails') }}" class="px-4 py-8 rounded-lg bg-green-600 text-white felx justify-between">
                <p class="font-bold text-lg">Total Admin</p>
                <p class="font-bold text-5xl">{{$admin}}</p>
            </a>
        </div>







<body>
  <div class="mx-8 mt-4">
    <!-- Chart wrapper -->
    <input type="month" onchange="changemonth(this.value)" value="{{date('Y-m')}}">
  </div>
  <div class="container mx-auto px-4 py-8">
    <canvas id="myLineChart" class="w-full h-100 mt-4"></canvas>
  </div>

  <script>

function changemonth(date){

  $.ajax({
        url: "{{ route('changemonth')}}", // Replace with your server API endpoint
        method: "POST",
        dataType: "json",
        data:{
          month:date,
          _token:"{{csrf_token()}}"
        },
        success: function(response) {
          // Update the content with the fetched data
        //  console.log(response.sales);
         myLineChart.data.datasets[0].data=response.sales; 
         myLineChart.data.datasets[1].data=response.profits; 
         myLineChart.data.datasets[2].data=response.ordercounts; 

          
         myLineChart.data.labels=response.orderdates; 



         myLineChart.update();

         console.log(response);

        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Handle error if the request fails
          console.error("AJAX request failed: " + textStatus, errorThrown);
        }
      });
}










    // Sample data for the line chart
    const labels = @json($orderdates);
    const totalSalesData = @json($sales); // Replace with your total sales data for each day of the month
    const totalProfitData = @json($profits); // Replace with your total profit data for each day of the month
    const totalOrdersData = @json($ordercount); // Replace with your total orders data for each day of the month

    // Configuration options
    const options = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          beginAtZero: true
        },
        y: {
          beginAtZero: true
        }
      }
    };

    // Get the canvas element and initialize the chart
    const ctx = document.getElementById('myLineChart').getContext('2d');
    const myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Total Sales',
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            data: totalSalesData,
            fill: true,
          },
          {
            label: 'Total Profit',
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            data: totalProfitData,
            fill: true,
          },
          {
            label: 'Total Orders',
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            data: totalOrdersData,
            fill: true,
          },
        ]
      },
      options: options
    });



    console.log(myLineChart.data.labels);
  </script>
</body>


@endsection