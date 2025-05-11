<?php
class Order {
    private $orderId;
    private $customerId;
    private $shippingAddress;
    private $shippingCity;
    private $shippingState;
    private $shippingZip;
    private $totalCost;
    private $shippingFee;
    private $tax;
    private $paymentAuthorization;
    private $dateOrdered;

    public function __construct($orderId, $customerId, $shippingAddress, $shippingCity, 
                                $shippingState, $shippingZip, $totalCost, $shippingFee, 
                                $tax, $paymentAuthorization, $dateOrdered) {
        $this->orderId = $orderId;
        $this->customerId = $customerId;
        $this->shippingAddress = $shippingAddress;
        $this->shippingCity = $shippingCity;
        $this->shippingState = $shippingState;
        $this->shippingZip = $shippingZip;
        $this->totalCost = $totalCost;
        $this->shippingFee = $shippingFee;
        $this->tax = $tax;
        $this->paymentAuthorization = $paymentAuthorization;
        $this->dateOrdered = $dateOrdered;
    }

    // Getters
    public function getOrderId() { 
        return $this->orderId;
    }
    public function getCustomerId() { 
        return $this->customerId; 
        
    }
    public function getShippingAddress() { 
        return $this->shippingAddress; 
        
    }
    public function getShippingCity() { 
        return $this->shippingCity; 
        
    }
    public function getShippingState() { 
        return $this->shippingState; 
        
    }
    public function getShippingZip() { 
        return $this->shippingZip; 
        
    }
    public function getTotalCost() { 
        return $this->totalCost; 
        
    }
    public function getShippingFee() { 
        return $this->shippingFee; 
        
    }
    public function getTax() { 
        return $this->tax; 
        
    }
    public function getPaymentAuthorization() { 
        return $this->paymentAuthorization; 
        
    }
    public function getDateOrdered() { 
        return $this->dateOrdered; 
        
    }
    
    // Setters
    public function setCustomerId($customerId) { 
        $this->customerId = $customerId; 
        
    }
    public function setShippingAddress($shippingAddress) { 
        $this->shippingAddress = $shippingAddress; 
        
    }
    public function setShippingCity($shippingCity) { 
        $this->shippingCity = $shippingCity; 
        
    }
    public function setShippingState($shippingState) { 
        $this->shippingState = $shippingState; 
        
    }
    public function setShippingZip($shippingZip) { 
        $this->shippingZip = $shippingZip; 
        
    }
    public function setTotalCost($totalCost) { 
        $this->totalCost = $totalCost; 
        
    }
    public function setShippingFee($shippingFee) { 
        $this->shippingFee = $shippingFee; 
        
    }
    public function setTax($tax) { 
        $this->tax = $tax; 
        
    }
    public function setPaymentAuthorization($paymentAuthorization) { 
        $this->paymentAuthorization = $paymentAuthorization; 
        
    }
    public function setDateOrdered($dateOrdered) { 
        $this->dateOrdered = $dateOrdered; 
        
    }
}
?>
