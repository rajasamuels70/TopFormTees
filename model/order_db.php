<?php
require_once 'Database.php';
require_once 'Order.php';

class OrderDB {
    public static function getOrders() {
        $db = Database::getDB();
        $query = "SELECT * FROM `order`";  // Changed table name to `orders`
        $statement = $db->prepare($query);
        $statement->execute();

        $orders = [];
        foreach ($statement as $row) {
            $orders[] = new Order(
                $row['OrderID'], 
                $row['CustomerID'], 
                $row['ShippingAddress'], 
                $row['ShippingCity'], 
                $row['ShippingState'], 
                $row['ShippingZip'], 
                $row['TotalCost'], 
                $row['ShippingFee'], 
                $row['Tax'], 
                $row['PaymentAuthorization'], 
                $row['DateOrdered']
            );
        }
        $statement->closeCursor();
        return $orders;
    }
    public static function getOrdersByCustomerId($customerId) {
    $db = Database::getDB();
    $query = "SELECT * FROM `order` WHERE CustomerID = :customerId"; // Fetch orders by CustomerID
    $statement = $db->prepare($query);
    $statement->bindValue(':customerId', $customerId, PDO::PARAM_INT);
    $statement->execute();

    $orders = [];
    foreach ($statement as $row) {
        $orders[] = new Order(
            $row['OrderID'], 
            $row['CustomerID'], 
            $row['ShippingAddress'], 
            $row['ShippingCity'], 
            $row['ShippingState'], 
            $row['ShippingZip'], 
            $row['TotalCost'], 
            $row['ShippingFee'], 
            $row['Tax'], 
            $row['PaymentAuthorization'], 
            $row['DateOrdered']
        );
    }
    $statement->closeCursor();
    return $orders; // Return the orders associated with the customer
}

    public static function getOrderWithProduct($order_id) {  // Added parameter $order_id
        $db = Database::getDB();
        $sql = "SELECT o.OrderID, o.TotalCost, o.DateOrdered, 
                       p.Name AS ProductName, oi.Quantity, oi.Price
                FROM order o
                JOIN orderitems oi ON o.OrderID = oi.OrderID
                JOIN products p ON oi.ProductID = p.ProductID
                WHERE o.OrderID = :order_id";

        $statement = $db->prepare($sql);
        $statement->bindValue(':order_id', $order_id, PDO::PARAM_INT); // Bind parameter correctly
        $statement->execute();
        $orderDetails = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch results

        $statement->closeCursor();
        return $orderDetails; // Return the data
    }

    public static function getOrderById($orderId) {
        $db = Database::getDB();
        $query = "SELECT * FROM `order` WHERE OrderID = :orderId"; // Changed table name to `orders`
        $statement = $db->prepare($query);
        $statement->bindValue(':orderId', $orderId, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC); // Use PDO::FETCH_ASSOC for consistency
        $statement->closeCursor();

        if ($row) {
            return new Order(
                $row['OrderID'], 
                $row['CustomerID'], 
                $row['ShippingAddress'], 
                $row['ShippingCity'], 
                $row['ShippingState'], 
                $row['ShippingZip'], 
                $row['TotalCost'], 
                $row['ShippingFee'], 
                $row['Tax'], 
                $row['PaymentAuthorization'], 
                $row['DateOrdered']
            );
        }
        return null;
    }

    public static function addOrder($customerId, $shippingAddress, $shippingCity, 
                                    $shippingState, $shippingZip, $totalCost, 
                                    $shippingFee, $tax, $paymentAuthorization) {
        $db = Database::getDB();
        $query = "INSERT INTO `order` (CustomerID, ShippingAddress, ShippingCity, ShippingState, 
                                       ShippingZip, TotalCost, ShippingFee, Tax, PaymentAuthorization, DateOrdered) 
                  VALUES (:customerId, :shippingAddress, :shippingCity, :shippingState, 
                          :shippingZip, :totalCost, :shippingFee, :tax, :paymentAuthorization, NOW())";
        $statement = $db->prepare($query);
        $statement->bindValue(':customerId', $customerId, PDO::PARAM_INT);
        $statement->bindValue(':shippingAddress', $shippingAddress, PDO::PARAM_STR);
        $statement->bindValue(':shippingCity', $shippingCity, PDO::PARAM_STR);
        $statement->bindValue(':shippingState', $shippingState, PDO::PARAM_STR);
        $statement->bindValue(':shippingZip', $shippingZip, PDO::PARAM_STR);
        $statement->bindValue(':totalCost', $totalCost, PDO::PARAM_STR);
        $statement->bindValue(':shippingFee', $shippingFee, PDO::PARAM_STR);
        $statement->bindValue(':tax', $tax, PDO::PARAM_STR);
        $statement->bindValue(':paymentAuthorization', $paymentAuthorization, PDO::PARAM_STR);
        $result = $statement->execute();
        $statement->closeCursor();
        return $result;
    }

    public static function deleteOrder($orderId) {
        $db = Database::getDB();
        $query = "DELETE FROM `order` WHERE OrderID = :orderId"; // Changed table name to `orders`
        $statement = $db->prepare($query);
        $statement->bindValue(':orderId', $orderId, PDO::PARAM_INT);
        $result = $statement->execute();
        $statement->closeCursor();
        return $result;
    }

    public static function updateOrder($orderId, $customerId, $shippingAddress, $shippingCity, 
                                       $shippingState, $shippingZip, $totalCost, 
                                       $shippingFee, $tax, $paymentAuthorization) {
        $db = Database::getDB();
        $query = "UPDATE `order` 
                  SET CustomerID = :customerId, 
                      ShippingAddress = :shippingAddress, 
                      ShippingCity = :shippingCity, 
                      ShippingState = :shippingState, 
                      ShippingZip = :shippingZip, 
                      TotalCost = :totalCost, 
                      ShippingFee = :shippingFee, 
                      Tax = :tax, 
                      PaymentAuthorization = :paymentAuthorization 
                  WHERE OrderID = :orderId";
        $statement = $db->prepare($query);
        $statement->bindValue(':orderId', $orderId, PDO::PARAM_INT);
        $statement->bindValue(':customerId', $customerId, PDO::PARAM_INT);
        $statement->bindValue(':shippingAddress', $shippingAddress, PDO::PARAM_STR);
        $statement->bindValue(':shippingCity', $shippingCity, PDO::PARAM_STR);
        $statement->bindValue(':shippingState', $shippingState, PDO::PARAM_STR);
        $statement->bindValue(':shippingZip', $shippingZip, PDO::PARAM_STR);
        $statement->bindValue(':totalCost', $totalCost, PDO::PARAM_STR);
        $statement->bindValue(':shippingFee', $shippingFee, PDO::PARAM_STR);
        $statement->bindValue(':tax', $tax, PDO::PARAM_STR);
        $statement->bindValue(':paymentAuthorization', $paymentAuthorization, PDO::PARAM_STR);
        $result = $statement->execute();
        $statement->closeCursor();
        return $result;
    }
}
?>
