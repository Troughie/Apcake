@extends('layouts.master')
@section('main-content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Contact Us</a>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Contact Us</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/mail') }}" name="frm-contact">
                            <p class="form-row">
                                <input type="text" name="name" value="" placeholder="Your Name"
                                    class="txt-input">
                            </p>
                            <p class="form-row">
                                <input type="email" name="email" value="" placeholder="Email Address"
                                    class="txt-input">
                            </p>
                            <p class="form-row">
                                <input type="tel" name="phone" value="" placeholder="Phone Number"
                                    class="txt-input">
                            </p>
                            <p class="form-row">
                                <textarea name="mes" id="mes-1" cols="30" rows="9" placeholder="Leave Message"></textarea>
                            </p>
                            <p class="form-row">
                                <button class="btn btn-submit" type="submit">send message</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
