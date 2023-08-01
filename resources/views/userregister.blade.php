@extends('master')
@section('content')
@include('message')

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Custom CSS -->


<div class="container-fluid  text-dark py-5">
    <div class="container w-50 my-5">
        <div class="card p-4 rounded shadow ">
            <h2 class="font-bold text-center my-4">Register</h2>
            <form action="{{ route('user.register') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                <div class="mb-3">
                    <input type="text" id="name" name="name" placeholder="Enter valid Name" class="form-control" required pattern="[A-Za-z ]+">
                    <i class="fas fa-user"></i>
                </div>
                <div class="mb-3">
                    <input type="text" id="phone" name="phone" placeholder="Enter Phone" class="form-control">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="mb-3">
                    <input type="text" id="address" name="address" placeholder="Enter Address" class="form-control" required>
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="mb-3">
                    <input type="text" id="email" name="email" placeholder="Email" class="form-control" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="mb-3">
                    <input type="password" id="password" name="password" placeholder="Password" class="form-control" required>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="mb-3">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-Enter Password" class="form-control" required>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="text-center">
                    <input type="submit" value="Register" class="btn btn-primary">
                </div>
                <div class="text-center mt-3">
                    <p>If you have already an account?</p>
                    <a href="{{ route('userlogin') }}" class="bg-dark px-2 py-2 text-white rounded-lg">Login Here</a>
                </div>
            </form>
            <div id="successMessage" class="alert alert-success text-center mt-4 d-none">
                Registered Successfully!
            </div>
        </div>
    </div>
</div>


    <!--validation-->
<script>
    function validateForm() {
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;
  
        if (name.trim() === '') {
            alert('Please enter your Full Name.');
            return false;
        }
  
        if (phone.trim() === '') {
            alert('Please enter your Phone number.');
            return false;
        }
  
        if (address.trim() === '') {
            alert('Please enter your Address.');
            return false;
        }
  
        if (email.trim() === '') {
            alert('Please enter your Email.');
            return false;
        } else if (!isValidEmail(email)) {
            alert('Please enter a valid Email address.');
            return false;
        }
  
        if (password.trim() === '') {
            alert('Please enter a Password.');
            return false;
        }
  
        if (password !== password_confirmation) {
            alert('Passwords do not match.');
            return false;
        }
  
        // If the form passes validation, you can allow the form submission
        showSuccessMessage();
        return true;
    }
  
    function isValidEmail(email) {
        // Basic email validation using a regular expression
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
  
    function showSuccessMessage() {
        // Show the success message element by removing the "hidden" class
        const successMessage = document.getElementById('successMessage');
        successMessage.classList.remove('hidden');
  
        // Hide the success message after a few seconds
        setTimeout(() => {
            successMessage.classList.add('hidden');
        }, 3000);
    }
  </script>
@endsection
