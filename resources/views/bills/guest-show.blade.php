// resources/views/bills/guest-show.blade.php
@extends('layouts.app')

@section('title', 'View Bill')

@section('content')
<div class="container">
    <h1>{{ $bill->name }}</h1>
    <p>Hosted by: {{ $bill->user->nickname }}</p>
    
    <div class="card">
        <div class="card-header">
            Expenses
        </div>
        <div class="card-body">
            @if($bill->expenses->isEmpty())
                <div class="alert alert-info">
                    No details
                </div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Paid By</th>
                            <th>Amount</th>
                            <th>Division</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bill->expenses as $expense)
                            <tr>
                                <td>{{ $expense->name }}</td>
                                <td>{{ $expense->paidBy->nickname }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td>{{ $expense->division_type }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    
    <p class="mt-3">Participants: {{ $bill->participants->count() }}</p>
    <a href="{{ route('guest.join') }}" class="btn btn-primary">Back</a>
</div>
@endsection