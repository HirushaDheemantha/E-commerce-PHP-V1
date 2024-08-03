document.addEventListener('DOMContentLoaded', () => {
    // Example data fetching
    fetchData();

    function fetchData() {
        // Fetch user data
        fetch('/server/get_users.php')
            .then(response => response.json())
            .then(data => populateTable('user-table', data));

        // Fetch product data
        fetch('/server/get_products.php')
            .then(response => response.json())
            .then(data => populateTable('product-table', data));

        // Fetch order data
        fetch('/server/get_orders.php')
            .then(response => response.json())
            .then(data => populateTable('order-table', data));
    }

    function populateTable(tableId, data) {
        const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        table.innerHTML = '';
        data.forEach(item => {
            const row = table.insertRow();
            Object.values(item).forEach(text => {
                const cell = row.insertCell();
                cell.textContent = text;
            });
            const actionsCell = row.insertCell();
            actionsCell.innerHTML = '<button>Edit</button> <button>Delete</button>';
        });
    }
});
