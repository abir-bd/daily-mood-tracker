@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Welcome ') }}{{ Auth::user()->name }}</div>
                    <div>{{ now()->toDateString() }}</div>
                    <div>{{ Auth::user()->phone }}</div>
                
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    

                    {{ __('EDIT YOUR TODAYS MOOD') }}
                    @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                    <div class="card-body">
                       <!-- form start -->
                        <form method="POST" action="{{ route('selection.update', $selection->id) }}">
                        @csrf
                        @method('PUT')
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
                        <input class="form-check-input" type="radio" name="mood" id="exited" value="exited">
                        <label class="form-check-label" for="sad">
                            Exited
                        </label>
                        </div>

                         <div class="form-check">
                        <input class="form-check-input" type="radio" name="mood" id="angry" value="angry">
                        <label class="form-check-label" for="angry">
                            Angry
                        </label>
                        <div class="form-check">
                        <input type="hidden" name="date" value="{{ now()->toDateString() }}">
                        <input type="hidden" name="post_id" value="{{ Auth::user()->id }}">
                        </div>
                       
                        </div>
                            <div>
                                <button type="submit" class="btn btn-success mt-4">Update</button>  
                            </div>
                        </form>
                        
                       <!-- form end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
