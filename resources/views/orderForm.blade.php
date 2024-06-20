<!DOCTYPE html>
<html>

<head>
    <title>Order Form</title>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Open or create the IndexedDB database
            let db;
            const request = indexedDB.open('OrderDB', 1);

            request.onupgradeneeded = event => {
                db = event.target.result;
                db.createObjectStore('orders', {
                    keyPath: 'id',
                    autoIncrement: true
                });
            };

            request.onsuccess = event => {
                db = event.target.result;
            };

            request.onerror = event => {
                console.error('IndexedDB error:', event.target.errorCode);
            };

            // Handle form submission
            document.getElementById('orderForm').onsubmit = event => {
                event.preventDefault();

                const customerName = document.getElementById('customer_name').value;
                const orderValue = document.getElementById('order_value').value;

                const transaction = db.transaction(['orders'], 'readwrite');
                const store = transaction.objectStore('orders');
                store.add({
                    customer_name: customerName,
                    order_value: orderValue
                });

                transaction.oncomplete = () => {
                    alert('Order stored in IndexedDB!');
                };

                transaction.onerror = event => {
                    console.error('Transaction error:', event.target.errorCode);
                };
            };
        });
    </script>
</head>

<body>
    <form id="orderForm">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" required><br>

        <label for="order_value">Order Value:</label>
        <input type="number" id="order_value" name="order_value" required><br>

        <button type="submit">Submit Order</button>
    </form>
</body>

</html>
