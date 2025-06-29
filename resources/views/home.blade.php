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

                    

                    {{ __('ENTER YOUR TODAYS MOOD') }}
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
                                <button type="submit" class="btn btn-success mt-4">Submit</button>  
                            </div>
                        </form>
                        
                            <!-- form end -->
                            </div>
                        </div>
                    </div>
            
            <div class="card mt-4">
                 <!-- mood board start -->
                     <table class="table text-center" >
                    <thead>
                        <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Mood</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selections as $selection)
                        <tr class="">
                        <td>{{ $selection->date }}</td>
                        <td>{{ $selection->selection }}</td>
                        <td>
                        <form action="{{ route('selection.edit', $selection->id) }}" method="GET" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-warning">Edit</button>
                        </form>
                        <!-- <a href="{{ route('selection.edit', $selection->id) }}"><i class="fas fa-edit"></i></a> -->
                        <!-- Delete Button -->
                        <form action="{{ route('selection.delete', $selection->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <!-- mood board end -->
            </div>
            <!-- filter form -->
            <div class="card mt-4">
                  <div class="card-body">
                          <!-- Date Range Filter Form -->
                    <form method="GET" action="{{ route('view.selections') }}" class="mb-3">
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ request('start_date') }}">
                            </div>

                            <div class="col-md-3">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ request('end_date') }}">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary mt-4">Filter</button>
                            </div>
                        </div>
                    </form>
                  </div>
            </div>
            <!-- filter form -->

            <!-- view chart -->
             <div class="card mt-4">
                <div class="card-body">
                     <div class="container">
        <h2>Weekly Mood Summary</h2>

        <!-- Canvas element for the chart -->
        <canvas id="submissionsChart" width="400" height="200"></canvas>

        <script>
            // Get data from PHP and pass it to JavaScript
            var submissionsData = @json($selections);

            // Prepare data for Chart.js
            var labels = submissionsData.map(function(item) { return item.date; });
            var data = submissionsData.map(function(item) { return item.count; });

            // Create the chart
            var ctx = document.getElementById('submissionsChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar', // Set chart type to 'bar'
                data: {
                    labels: labels, // Dates for X-axis
                    datasets: [{
                        label: 'Moods', // Label for the dataset
                        data: data, // Number of submissions
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                        borderColor: 'rgba(75, 192, 192, 1)', // Border color
                        borderWidth: 1
                    }]
                },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true // Start Y-axis at 0
                                }
                            }
                        }
                    });
                </script>
            </div>
                </div>
             </div>
            <!-- view chart -->
        </div>
    </div>
</div>
@endsection
