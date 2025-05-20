//import Echo from "laravel-echo";
//import Echo from "../../app/Backend_API/node_modules/laravel-echo/dist/echo.js";

$(document).ready(function(){
    getAllFoodItems(); // Load food items
   
    //getAllOrders();
    test();
});

function getAllFoodItems(){
   
    $.ajax({
        method:'GET',
        url:'http://127.0.0.1:8000/api/foodItems/get',
        success:function(response){
           $.each(response.data,function(index,item){
         let menuHTML = `      <div class="col-md-3"> 
                                <div class="food-item">
                                <div class="item">
                                    <div class="image">
                                        <img src="${item.ImageURL}" alt="food-image">
                                        <div class="overlay">
                                            <button type="button" class="add-to-cart" 
                                                data-food-id="${item.FoodItemID}"
                                                data-food-image="${item.ImageURL}" 
                                                data-food-name="${item.Name}"
                                                data-food-price="${item.Price}">
                                                <i class='bx bx-plus'></i>
                                                <span>Add to Carts</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="name-price">
                                        <span class="food-name">${item.Name}</span>
                                        <span class="price"> ${item.Price}TSH</span>
                                    </div>
                                </div>
                                </div>
                                </div>
         `;
         $("#food-list").append(menuHTML);

           });
         
        },
        error:function(error){
console.log(error)
        }
    })



}

function getAllOrders(){

$.ajax({
    method: 'GET',
    url: 'http://127.0.0.1:8000/api/kitchen/orders',
    success: function(response) {
        let ordersGrouped = {};
        // Group orders by orderID
        $.each(response, function(index, item) {
            let orderID = item.OrderID;
            let orderStatus = item.OrderStatus; // Get order status

            if (!ordersGrouped[orderID]) {
                ordersGrouped[orderID] = {
                    id: orderID,
                    status: orderStatus,
                    items: []
                };
            }

            ordersGrouped[orderID].items.push(item);
        });

        // Append grouped orders to the DOM
        $.each(ordersGrouped, function(orderID, orderData) {
            // Determine background color based on status
            let headerBgColor = orderData.status === "In Progress" ? "blue" : "gray";

            let orderHTML = `<div class="col-md-4 mb-4"> 
                                <div class="card border-dark shadow order-card" data-order-id="${orderID}">
                                    <div class="card-header text-white text-center" style="background-color: ${headerBgColor};">
                                        <h5>Order ID: ${orderID}</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">`;

            orderData.items.forEach(item => {
                orderHTML += `<li class="list-group-item d-flex justify-content-between">
                                ${item.Name} <span class="badge bg-primary">Qty: ${item.Quantity}</span>
                              </li>`;
            });

            orderHTML += `</ul></div></div></div>`;

            $("#order_list").append(orderHTML);
        });
    },
    error: function(error) {
        console.log(error);
    }
});


}



// Handle order update when clicked
$(document).on("click", ".order-card", function() {
    const orderID = $(this).data("order-id");
    console.log(orderID);
    const formData ={
orderStatus: "In Progress" 
    }

    $.ajax({
        method: 'PUT',
        url: `http://127.0.0.1:8000/api/orderstatus/update/${orderID}`,
          dataType:'json',
            headers:{
                'Content-Type':'application/json'
            },
            data:JSON.stringify(formData),
        success: function(response) {
            console.log(`Order ${orderID} updated to "In Progress"`);
        },
        error: function(error) {
            console.log(`Error updating order ${orderID}:`, error);
        }
    });
});



function test(){

//window.io = require("socket.io-client");
window.io = io;

window.Echo = new Echo({
    broadcaster: "socket.io",
    host: "http://127.0.0.1:6001", // Replace with your Laravel WebSockets server URL
});

if (typeof io !== "undefined") {
    window.Echo = new Echo({
        broadcaster: "socket.io",
        host: "http://localhost:6001"
    });
    console.log("its")
} else {
    console.error("Socket.io client is missing!");
}

}