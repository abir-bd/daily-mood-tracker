@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Welcome ') }}{{ Auth::user()->name }}</div>
                    <div>{{ now()->toDateString() }}</div>
                
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('ENTER YOUR TODAYS MOOD') }}

                    <div class="card-body">
                       <!-- form start -->
                        <form method="POST" action="{{ route('submit.selection') }}">
                        @csrf
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="mood" id="happy" value="happy" checked>
                        <label class="form-check-label" for="happy">
                            Happy
                        </label>
                        </div>

                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="mood" id="sad" value="sad">
                        <label class="form-check-label" for="sad">
                            Sad
                        </label>
                        </div>

                         <div class="form-check">
                        <input class="form-check-input" type="radio" name="mood" id="angry" value="angry">
                        <label class="form-check-label" for="angry">
                            Angry
                        </label>
                        <div class="form-check">
                        <input type="hidden" name="date" value="{{ now()->toDateString() }}">
                        </div>
                       
                        </div>
                            <div>
                                <button type="submit" class="btn btn-success mt-4">Submit</button>  
                            </div>
                        </form>
                       <!-- form end -->
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                 <!-- mood board start -->
                     <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Mood</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">30 July 2025</th>
                        <td>Happy</td>
                        </tr>
                    </tbody>
                    </table>
                    <!-- mood board end -->
            </div>
        </div>
    </div>
</div>
@endsection
