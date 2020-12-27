const allPageChart = document.getElementById('allPageChart');
let allAdmin = allPageChart.dataset.admin;
let allUser = allPageChart.dataset.user;
let allProduct = allPageChart.dataset.product;
let allOrder = allPageChart.dataset.order;
let allWishlist = allPageChart.dataset.wishlist;
new Chart(allPageChart, {
    type: 'bar',
    data: {
        labels: ['admin', 'user', 'product', 'order', 'wishlist'],
        datasets: [{
            label: 'All Page Access',
            data: [allAdmin, allUser, allProduct, allOrder, allWishlist],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
        }]
    }
});

const pageChart = document.getElementById('pageChart');
let admin = pageChart.dataset.admin;
let user = pageChart.dataset.user;
let product = pageChart.dataset.product;
let order = pageChart.dataset.order;
let wishlist = pageChart.dataset.wishlist;
let date = pageChart.dataset.date;
new Chart(pageChart, {
    type: 'bar',
    data: {
        labels: ['admin', 'user', 'product', 'order', 'wishlist'],
        datasets: [{
            label: date + " Page Access",
            data: [admin, user, product, order, wishlist],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
        }]
    }
});

