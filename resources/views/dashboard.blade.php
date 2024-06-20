<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <!-- Order Form -->
                    <h3 class="mt-4">Order Form</h3>
                    <form id="orderForm">
                        <div class="form-group">
                            <label for="customerName">Customer Name:</label>
                            <input type="text" class="form-control" id="customerName" name="customerName" required>
                        </div>
                        <div class="form-group">
                            <label for="orderValue">Order Value:</label>
                            <input type="number" class="form-control" id="orderValue" name="orderValue" required>
                        </div>
                        <div class="form-group">
                            <label for="orderDate">Order Date:</label>
                            <input type="datetime-local" class="form-control" id="orderDate" name="orderDate" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>

                    <!-- Order List -->
                    <h3 class="mt-4">Order List</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Order Value</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody id="orderTableBody">
                            <!-- Orders will be populated here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let db;
    const request = indexedDB.open('OrderDB', 1);

    request.onupgradeneeded = (event) => {
        db = event.target.result;
        const objectStore = db.createObjectStore('orders', { keyPath: 'id', autoIncrement: true });
        objectStore.createIndex('customerName', 'customerName', { unique: false });
        objectStore.createIndex('orderValue', 'orderValue', { unique: false });
        objectStore.createIndex('orderDate', 'orderDate', { unique: false });
    };

    request.onsuccess = (event) => {
        db = event.target.result;
        displayOrders();
    };

    request.onerror = (event) => {
        console.error('Database error:', event.target.errorCode);
    };

    $('#orderForm').submit(function(event) {
        event.preventDefault();

        const customerName = $('#customerName').val();
        const orderValue = $('#orderValue').val();
        const orderDate = $('#orderDate').val();

        const transaction = db.transaction(['orders'], 'readwrite');
        const objectStore = transaction.objectStore('orders');
        const order = { customerName, orderValue, orderDate };

        objectStore.add(order).onsuccess = () => {
            displayOrders();
            $('#orderForm')[0].reset();
        };
    });

    function displayOrders() {
        const transaction = db.transaction(['orders'], 'readonly');
        const objectStore = transaction.objectStore('orders');
        const tableBody = $('#orderTableBody');

        tableBody.empty();

        objectStore.openCursor().onsuccess = (event) => {
            const cursor = event.target.result;
            if (cursor) {
                const { id, customerName, orderValue, orderDate } = cursor.value;
                const row = `<tr>
                    <td>${id}</td>
                    <td>${customerName}</td>
                    <td>${orderValue}</td>
                    <td>${orderDate}</td>
                </tr>`;
                tableBody.append(row);
                cursor.continue();
            }
        };
    }
});
</script>
@endsection
