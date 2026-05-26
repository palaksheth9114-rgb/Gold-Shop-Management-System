<?php
require_once 'config.php';

header('Content-Type: application/json');
$conn = getDBConnection();

$action = isset($_POST['action']) ? sanitizeInput($_POST['action']) : '';

switch ($action) {
    // CUSTOMER OPERATIONS
    case 'getCustomers':
        $sql = "SELECT * FROM customers ORDER BY created_at DESC";
        $result = $conn->query($sql);
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
        sendResponse(true, 'Customers retrieved', $customers);
        break;
    
    case 'addCustomer':
        $id = generateNextID($conn, 'customers', 'CUS');
        $name = sanitizeInput($_POST['name']);
        $phone = sanitizePhone($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        $address = sanitizeInput($_POST['address']);
        $createdAt = date('Y-m-d');
        
        $stmt = $conn->prepare("INSERT INTO customers (id, name, phone, email, address, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $id, $name, $phone, $email, $address, $createdAt);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Customer added successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to add customer');
        }
        break;
    
    case 'updateCustomer':
        $id = sanitizeInput($_POST['id']);
        $name = sanitizeInput($_POST['name']);
        $phone = sanitizePhone($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        $address = sanitizeInput($_POST['address']);
        
        $stmt = $conn->prepare("UPDATE customers SET name=?, phone=?, email=?, address=? WHERE id=?");
        $stmt->bind_param("sssss", $name, $phone, $email, $address, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Customer updated successfully');
        } else {
            sendResponse(false, 'Failed to update customer');
        }
        break;
    
    case 'deleteCustomer':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM customers WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Customer deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete customer');
        }
        break;
    
    // EMPLOYEE OPERATIONS
    case 'getEmployees':
        $sql = "SELECT * FROM employees ORDER BY hire_date DESC";
        $result = $conn->query($sql);
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        sendResponse(true, 'Employees retrieved', $employees);
        break;
    
    case 'addEmployee':
        $id = generateNextID($conn, 'employees', 'EMP');
        $name = sanitizeInput($_POST['name']);
        $role = sanitizeInput($_POST['role']);
        $hireDate = sanitizeDate($_POST['hireDate']);
        $salary = sanitizeInput($_POST['salary']);
        $phone = sanitizePhone($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        
        $stmt = $conn->prepare("INSERT INTO employees (id, name, role, hire_date, salary, phone, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdss", $id, $name, $role, $hireDate, $salary, $phone, $email);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Employee added successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to add employee');
        }
        break;
    
    case 'updateEmployee':
        $id = sanitizeInput($_POST['id']);
        $name = sanitizeInput($_POST['name']);
        $role = sanitizeInput($_POST['role']);
        $hireDate = sanitizeDate($_POST['hireDate']);
        $salary = sanitizeInput($_POST['salary']);
        $phone = sanitizePhone($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        
        $stmt = $conn->prepare("UPDATE employees SET name=?, role=?, hire_date=?, salary=?, phone=?, email=? WHERE id=?");
        $stmt->bind_param("sssdsss", $name, $role, $hireDate, $salary, $phone, $email, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Employee updated successfully');
        } else {
            sendResponse(false, 'Failed to update employee');
        }
        break;
    
    case 'deleteEmployee':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM employees WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Employee deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete employee');
        }
        break;
    
    // SUPPLIER OPERATIONS
    case 'getSuppliers':
        $sql = "SELECT * FROM suppliers ORDER BY name";
        $result = $conn->query($sql);
        $suppliers = [];
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
        sendResponse(true, 'Suppliers retrieved', $suppliers);
        break;
    
    case 'addSupplier':
        $id = generateNextID($conn, 'suppliers', 'SUP');
        $name = sanitizeInput($_POST['name']);
        $contact = sanitizeInput($_POST['contact']);
        $phone = sanitizePhone($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        $address = sanitizeInput($_POST['address']);
        $status = sanitizeInput($_POST['status']);
        
        $stmt = $conn->prepare("INSERT INTO suppliers (id, name, contact_person, phone, email, address, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $id, $name, $contact, $phone, $email, $address, $status);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Supplier added successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to add supplier');
        }
        break;
    
    case 'updateSupplier':
        $id = sanitizeInput($_POST['id']);
        $name = sanitizeInput($_POST['name']);
        $contact = sanitizeInput($_POST['contact']);
        $phone = sanitizePhone($_POST['phone']);
        $email = sanitizeInput($_POST['email']);
        $address = sanitizeInput($_POST['address']);
        $status = sanitizeInput($_POST['status']);
        
        $stmt = $conn->prepare("UPDATE suppliers SET name=?, contact_person=?, phone=?, email=?, address=?, status=? WHERE id=?");
        $stmt->bind_param("sssssss", $name, $contact, $phone, $email, $address, $status, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Supplier updated successfully');
        } else {
            sendResponse(false, 'Failed to update supplier');
        }
        break;
    
    case 'deleteSupplier':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM suppliers WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Supplier deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete supplier');
        }
        break;
    
    // PRODUCT OPERATIONS
    case 'getProducts':
        $sql = "SELECT * FROM products ORDER BY name";
        $result = $conn->query($sql);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        sendResponse(true, 'Products retrieved', $products);
        break;
    
    case 'addProduct':
        $id = generateNextID($conn, 'products', 'PRD');
        $name = sanitizeInput($_POST['name']);
        $category = sanitizeInput($_POST['category']);
        $weight = sanitizeInput($_POST['weight']);
        $purity = sanitizeInput($_POST['purity']);
        $purchasePrice = sanitizeInput($_POST['purchasePrice']);
        $stock = sanitizeInput($_POST['stock']);
        
        $stmt = $conn->prepare("INSERT INTO products (id, name, category, weight, purity, purchase_price, stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiddi", $id, $name, $category, $weight, $purity, $purchasePrice, $stock);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Product added successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to add product');
        }
        break;
    
    case 'updateProduct':
        $id = sanitizeInput($_POST['id']);
        $name = sanitizeInput($_POST['name']);
        $category = sanitizeInput($_POST['category']);
        $weight = sanitizeInput($_POST['weight']);
        $purity = sanitizeInput($_POST['purity']);
        $purchasePrice = sanitizeInput($_POST['purchasePrice']);
        $stock = sanitizeInput($_POST['stock']);
        
        $stmt = $conn->prepare("UPDATE products SET name=?, category=?, weight=?, purity=?, purchase_price=?, stock=? WHERE id=?");
        $stmt->bind_param("ssdddis", $name, $category, $weight, $purity, $purchasePrice, $stock, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Product updated successfully');
        } else {
            sendResponse(false, 'Failed to update product');
        }
        break;
    
    case 'deleteProduct':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Product deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete product');
        }
        break;
    
    // INVENTORY OPERATIONS
    case 'getInventory':
        $sql = "SELECT i.*, p.name as product_name, s.name as supplier_name 
                FROM inventory i 
                JOIN products p ON i.product_id = p.id 
                JOIN suppliers s ON i.supplier_id = s.id 
                ORDER BY i.last_updated DESC";
        $result = $conn->query($sql);
        $inventory = [];
        while ($row = $result->fetch_assoc()) {
            $inventory[] = $row;
        }
        sendResponse(true, 'Inventory retrieved', $inventory);
        break;
    
    case 'addInventory':
        $id = generateNextID($conn, 'inventory', 'INV');
        $productId = sanitizeInput($_POST['productId']);
        $supplierId = sanitizeInput($_POST['supplierId']);
        $quantity = sanitizeInput($_POST['quantity']);
        $availableStock = sanitizeInput($_POST['availableStock']);
        $lastUpdated = sanitizeInput($_POST['lastUpdated']);
        
        $stmt = $conn->prepare("INSERT INTO inventory (id, product_id, supplier_id, quantity, available_stock, last_updated) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdds", $id, $productId, $supplierId, $quantity, $availableStock, $lastUpdated);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Inventory added successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to add inventory');
        }
        break;
    
    case 'updateInventory':
        $id = sanitizeInput($_POST['id']);
        $productId = sanitizeInput($_POST['productId']);
        $supplierId = sanitizeInput($_POST['supplierId']);
        $quantity = sanitizeInput($_POST['quantity']);
        $availableStock = sanitizeInput($_POST['availableStock']);
        $lastUpdated = sanitizeInput($_POST['lastUpdated']);
        
        $stmt = $conn->prepare("UPDATE inventory SET product_id=?, supplier_id=?, quantity=?, available_stock=?, last_updated=? WHERE id=?");
        $stmt->bind_param("ssddss", $productId, $supplierId, $quantity, $availableStock, $lastUpdated, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Inventory updated successfully');
        } else {
            sendResponse(false, 'Failed to update inventory');
        }
        break;
    
    case 'deleteInventory':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM inventory WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Inventory deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete inventory');
        }
        break;
    
    // BILLS OPERATIONS
    case 'getBills':
        $sql = "SELECT b.*, c.name as customer_name, e.name as employee_name 
                FROM bills b 
                JOIN customers c ON b.customer_id = c.id 
                JOIN employees e ON b.employee_id = e.id 
                ORDER BY b.bill_date DESC, b.created_at DESC";
        $result = $conn->query($sql);
        $bills = [];
        while ($row = $result->fetch_assoc()) {
            // Get bill items
            $billId = $row['id'];
            $itemsSql = "SELECT * FROM bill_items WHERE bill_id = '$billId'";
            $itemsResult = $conn->query($itemsSql);
            $items = [];
            while ($item = $itemsResult->fetch_assoc()) {
                $items[] = $item;
            }
            $row['items'] = $items;
            $bills[] = $row;
        }
        sendResponse(true, 'Bills retrieved', $bills);
        break;
    
    case 'addBill':
        $id = generateNextID($conn, 'bills', 'BIL');
        $customerId = sanitizeInput($_POST['customerId']);
        $employeeId = sanitizeInput($_POST['employeeId']);
        $billDate = sanitizeDate($_POST['billDate']);
        $subtotal = sanitizeInput($_POST['subtotal']);
        $gst = sanitizeInput($_POST['gst']);
        $discount = sanitizeInput($_POST['discount']);
        $netPayable = sanitizeInput($_POST['netPayable']);
        $paymentMethod = sanitizeInput($_POST['paymentMethod']);
        $items = json_decode($_POST['items'], true);
        
        $conn->begin_transaction();
        try {
            // Insert bill
            $stmt = $conn->prepare("INSERT INTO bills (id, customer_id, employee_id, bill_date, subtotal, gst, discount, net_payable, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssdddds", $id, $customerId, $employeeId, $billDate, $subtotal, $gst, $discount, $netPayable, $paymentMethod);
            $stmt->execute();
            
            // Insert bill items
            $itemStmt = $conn->prepare("INSERT INTO bill_items (bill_id, product_id, product_name, weight, purity, gold_price, making_charges, item_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($items as $item) {
                $itemStmt->bind_param("sssdsddd", 
                    $id,
                    $item['productId'],
                    $item['productName'],
                    $item['weight'],
                    $item['purity'],
                    $item['goldPrice'],
                    $item['makingCharges'],
                    $item['itemTotal']
                );
                $itemStmt->execute();
            }
            
            $conn->commit();
            sendResponse(true, 'Bill and invoice created successfully! Invoice ID: ' . $id, ['id' => $id]);
        } catch (Exception $e) {
            $conn->rollback();
            sendResponse(false, 'Failed to generate bill: ' . $e->getMessage());
        }
        break;
    
    case 'updateBill':
        $id = sanitizeInput($_POST['id']);
        $customerId = sanitizeInput($_POST['customerId']);
        $employeeId = sanitizeInput($_POST['employeeId']);
        $billDate = sanitizeDate($_POST['billDate']);
        $subtotal = sanitizeInput($_POST['subtotal']);
        $gst = sanitizeInput($_POST['gst']);
        $discount = sanitizeInput($_POST['discount']);
        $netPayable = sanitizeInput($_POST['netPayable']);
        $paymentMethod = sanitizeInput($_POST['paymentMethod']);
        $items = json_decode($_POST['items'], true);
        
        $conn->begin_transaction();
        try {
            // Update bill
            $stmt = $conn->prepare("UPDATE bills SET customer_id=?, employee_id=?, bill_date=?, subtotal=?, gst=?, discount=?, net_payable=?, payment_method=? WHERE id=?");
            $stmt->bind_param("sssddddss", $customerId, $employeeId, $billDate, $subtotal, $gst, $discount, $netPayable, $paymentMethod, $id);
            $stmt->execute();
            
            // Delete old items
            $conn->query("DELETE FROM bill_items WHERE bill_id = '$id'");
            
            // Insert new items
            $itemStmt = $conn->prepare("INSERT INTO bill_items (bill_id, product_id, product_name, weight, purity, gold_price, making_charges, item_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($items as $item) {
                $itemStmt->bind_param("sssdsddd", 
                    $id,
                    $item['productId'],
                    $item['productName'],
                    $item['weight'],
                    $item['purity'],
                    $item['goldPrice'],
                    $item['makingCharges'],
                    $item['itemTotal']
                );
                $itemStmt->execute();
            }
            
            $conn->commit();
            sendResponse(true, 'Bill updated successfully');
        } catch (Exception $e) {
            $conn->rollback();
            sendResponse(false, 'Failed to update bill: ' . $e->getMessage());
        }
        break;
    
    case 'deleteBill':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM bills WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Bill deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete bill');
        }
        break;
    
    // REGULAR ORDERS OPERATIONS
    case 'getRegularOrders':
        $sql = "SELECT o.*, c.name as customer_name, e.name as employee_name 
                FROM regular_orders o 
                JOIN customers c ON o.customer_id = c.id 
                JOIN employees e ON o.employee_id = e.id 
                ORDER BY o.order_date DESC";
        $result = $conn->query($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        sendResponse(true, 'Regular orders retrieved', $orders);
        break;
    
    case 'addRegularOrder':
        $id = generateNextID($conn, 'regular_orders', 'ORD');
        $customerId = sanitizeInput($_POST['customerId']);
        $employeeId = sanitizeInput($_POST['employeeId']);
        $orderDate = sanitizeDate($_POST['orderDate']);
        $weight = sanitizeInput($_POST['weight']);
        $amount = sanitizeInput($_POST['amount']);
        $paymentMethod = sanitizeInput($_POST['paymentMethod']);
        $status = sanitizeInput($_POST['status']);
        
        $stmt = $conn->prepare("INSERT INTO regular_orders (id, customer_id, employee_id, order_date, weight, amount, payment_method, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssddss", $id, $customerId, $employeeId, $orderDate, $weight, $amount, $paymentMethod, $status);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Regular order added successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to add regular order');
        }
        break;
    
    case 'updateRegularOrder':
        $id = sanitizeInput($_POST['id']);
        $customerId = sanitizeInput($_POST['customerId']);
        $employeeId = sanitizeInput($_POST['employeeId']);
        $orderDate = sanitizeDate($_POST['orderDate']);
        $weight = sanitizeInput($_POST['weight']);
        $amount = sanitizeInput($_POST['amount']);
        $paymentMethod = sanitizeInput($_POST['paymentMethod']);
        $status = sanitizeInput($_POST['status']);
        
        $stmt = $conn->prepare("UPDATE regular_orders SET customer_id=?, employee_id=?, order_date=?, weight=?, amount=?, payment_method=?, status=? WHERE id=?");
        $stmt->bind_param("sssddsss", $customerId, $employeeId, $orderDate, $weight, $amount, $paymentMethod, $status, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Regular order updated successfully');
        } else {
            sendResponse(false, 'Failed to update regular order');
        }
        break;
    
    case 'deleteRegularOrder':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM regular_orders WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Regular order deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete regular order');
        }
        break;
    
    // ADVANCE ORDERS OPERATIONS
    case 'getAdvanceOrders':
        $sql = "SELECT o.*, c.name as customer_name, e.name as employee_name 
                FROM advance_orders o 
                JOIN customers c ON o.customer_id = c.id 
                JOIN employees e ON o.employee_id = e.id 
                ORDER BY o.order_date DESC";
        $result = $conn->query($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        sendResponse(true, 'Advance orders retrieved', $orders);
        break;
    
    case 'addAdvanceOrder':
        $id = generateNextID($conn, 'advance_orders', 'ADV');
        $customerId = sanitizeInput($_POST['customerId']);
        $employeeId = sanitizeInput($_POST['employeeId']);
        $orderDate = sanitizeDate($_POST['orderDate']);
        $deliveryDate = sanitizeDate($_POST['deliveryDate']);
        $weight = sanitizeInput($_POST['weight']);
        $amount = sanitizeInput($_POST['amount']);
        $advancePaid = sanitizeInput($_POST['advancePaid']);
        $paymentMethod = sanitizeInput($_POST['paymentMethod']);
        $status = sanitizeInput($_POST['status']);
        
        $stmt = $conn->prepare("INSERT INTO advance_orders (id, customer_id, employee_id, order_date, delivery_date, weight, amount, advance_paid, payment_method, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssdddss", $id, $customerId, $employeeId, $orderDate, $deliveryDate, $weight, $amount, $advancePaid, $paymentMethod, $status);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Advance order added successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to add advance order');
        }
        break;
    
    case 'updateAdvanceOrder':
        $id = sanitizeInput($_POST['id']);
        $customerId = sanitizeInput($_POST['customerId']);
        $employeeId = sanitizeInput($_POST['employeeId']);
        $orderDate = sanitizeDate($_POST['orderDate']);
        $deliveryDate = sanitizeDate($_POST['deliveryDate']);
        $weight = sanitizeInput($_POST['weight']);
        $amount = sanitizeInput($_POST['amount']);
        $advancePaid = sanitizeInput($_POST['advancePaid']);
        $paymentMethod = sanitizeInput($_POST['paymentMethod']);
        $status = sanitizeInput($_POST['status']);
        
        $stmt = $conn->prepare("UPDATE advance_orders SET customer_id=?, employee_id=?, order_date=?, delivery_date=?, weight=?, amount=?, advance_paid=?, payment_method=?, status=? WHERE id=?");
        $stmt->bind_param("ssssdddsss", $customerId, $employeeId, $orderDate, $deliveryDate, $weight, $amount, $advancePaid, $paymentMethod, $status, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Advance order updated successfully');
        } else {
            sendResponse(false, 'Failed to update advance order');
        }
        break;
    
    case 'deleteAdvanceOrder':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM advance_orders WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Advance order deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete advance order');
        }
        break;
    
    // VYAJ ORDERS OPERATIONS
    case 'getVyajOrders':
        $sql = "SELECT o.*, c.name as customer_name, e.name as employee_name 
                FROM vyaj_orders o 
                JOIN customers c ON o.customer_id = c.id 
                JOIN employees e ON o.employee_id = e.id 
                ORDER BY o.order_date DESC";
        $result = $conn->query($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        sendResponse(true, 'Vyaj orders retrieved', $orders);
        break;
    
    case 'addVyajOrder':
        $id = generateNextID($conn, 'vyaj_orders', 'VYJ');
        $customerId = sanitizeInput($_POST['customerId']);
        $employeeId = sanitizeInput($_POST['employeeId']);
        $orderDate = sanitizeDate($_POST['orderDate']);
        $dueDate = sanitizeDate($_POST['dueDate']);
        $weight = sanitizeInput($_POST['weight']);
        $baseAmount = sanitizeInput($_POST['baseAmount']);
        $vyajRate = sanitizeInput($_POST['vyajRate']);
        $vyajAmount = sanitizeInput($_POST['vyajAmount']);
        $month1 = sanitizeInput($_POST['month1']);
        $month2 = sanitizeInput($_POST['month2']);
        $month3 = sanitizeInput($_POST['month3']);
        $totalPrice = sanitizeInput($_POST['totalPrice']);
        $paidAmount = sanitizeInput($_POST['paidAmount']);
        $paymentStatus = sanitizeInput($_POST['paymentStatus']);
        
        $stmt = $conn->prepare("INSERT INTO vyaj_orders (id, customer_id, employee_id, order_date, due_date, weight, base_amount, vyaj_rate, vyaj_amount, month1_payment, month2_payment, month3_payment, total_price, paid_amount, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssddddddddds", $id, $customerId, $employeeId, $orderDate, $dueDate, $weight, $baseAmount, $vyajRate, $vyajAmount, $month1, $month2, $month3, $totalPrice, $paidAmount, $paymentStatus);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Vyaj order added successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to add vyaj order');
        }
        break;
    
    case 'updateVyajOrder':
        $id = sanitizeInput($_POST['id']);
        $customerId = sanitizeInput($_POST['customerId']);
        $employeeId = sanitizeInput($_POST['employeeId']);
        $orderDate = sanitizeDate($_POST['orderDate']);
        $dueDate = sanitizeDate($_POST['dueDate']);
        $weight = sanitizeInput($_POST['weight']);
        $baseAmount = sanitizeInput($_POST['baseAmount']);
        $vyajRate = sanitizeInput($_POST['vyajRate']);
        $vyajAmount = sanitizeInput($_POST['vyajAmount']);
        $month1 = sanitizeInput($_POST['month1']);
        $month2 = sanitizeInput($_POST['month2']);
        $month3 = sanitizeInput($_POST['month3']);
        $totalPrice = sanitizeInput($_POST['totalPrice']);
        $paidAmount = sanitizeInput($_POST['paidAmount']);
        $paymentStatus = sanitizeInput($_POST['paymentStatus']);
        
        $stmt = $conn->prepare("UPDATE vyaj_orders SET customer_id=?, employee_id=?, order_date=?, due_date=?, weight=?, base_amount=?, vyaj_rate=?, vyaj_amount=?, month1_payment=?, month2_payment=?, month3_payment=?, total_price=?, paid_amount=?, payment_status=? WHERE id=?");
        $stmt->bind_param("ssssdddddddddss", $customerId, $employeeId, $orderDate, $dueDate, $weight, $baseAmount, $vyajRate, $vyajAmount, $month1, $month2, $month3, $totalPrice, $paidAmount, $paymentStatus, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Vyaj order updated successfully');
        } else {
            sendResponse(false, 'Failed to update vyaj order');
        }
        break;
    
    case 'deleteVyajOrder':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM vyaj_orders WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Vyaj order deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete vyaj order');
        }
        break;
    
    // GOLD SALES OPERATIONS
    case 'getGoldSales':
        $sql = "SELECT g.*, c.name as customer_name, p.name as product_name 
                FROM gold_sales g 
                JOIN customers c ON g.customer_id = c.id 
                JOIN products p ON g.product_id = p.id 
                ORDER BY g.getting_date DESC";
        $result = $conn->query($sql);
        $sales = [];
        while ($row = $result->fetch_assoc()) {
            $sales[] = $row;
        }
        sendResponse(true, 'Gold sales retrieved', $sales);
        break;
    
    case 'addGoldSale':
        $id = generateNextID($conn, 'gold_sales', 'GLS');
        $customerId = sanitizeInput($_POST['customerId']);
        $productId = sanitizeInput($_POST['productId']);
        $quantity = sanitizeInput($_POST['quantity']);
        $purity = sanitizeInput($_POST['purity']);
        $gettingDate = sanitizeDate($_POST['gettingDate']);
        $totalAmount = sanitizeInput($_POST['totalAmount']);
        $paymentCustomer = sanitizeInput($_POST['paymentCustomer']);
        $paymentMethod = sanitizeInput($_POST['paymentMethod']);
        
        $stmt = $conn->prepare("INSERT INTO gold_sales (id, customer_id, product_id, quantity, purity, getting_date, total_amount, payment_to_customer, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssissds", $id, $customerId, $productId, $quantity, $purity, $gettingDate, $totalAmount, $paymentCustomer, $paymentMethod);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Gold sale recorded successfully', ['id' => $id]);
        } else {
            sendResponse(false, 'Failed to record gold sale');
        }
        break;
    
    case 'updateGoldSale':
        $id = sanitizeInput($_POST['id']);
        $customerId = sanitizeInput($_POST['customerId']);
        $productId = sanitizeInput($_POST['productId']);
        $quantity = sanitizeInput($_POST['quantity']);
        $purity = sanitizeInput($_POST['purity']);
        $gettingDate = sanitizeDate($_POST['gettingDate']);
        $totalAmount = sanitizeInput($_POST['totalAmount']);
        $paymentCustomer = sanitizeInput($_POST['paymentCustomer']);
        $paymentMethod = sanitizeInput($_POST['paymentMethod']);
        
        $stmt = $conn->prepare("UPDATE gold_sales SET customer_id=?, product_id=?, quantity=?, purity=?, getting_date=?, total_amount=?, payment_to_customer=?, payment_method=? WHERE id=?");
        $stmt->bind_param("ssdisddss", $customerId, $productId, $quantity, $purity, $gettingDate, $totalAmount, $paymentCustomer, $paymentMethod, $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Gold sale updated successfully');
        } else {
            sendResponse(false, 'Failed to update gold sale');
        }
        break;
    
    case 'deleteGoldSale':
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM gold_sales WHERE id=?");
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Gold sale deleted successfully');
        } else {
            sendResponse(false, 'Failed to delete gold sale');
        }
        break;
    
    // CSV EXPORT OPERATIONS
    case 'exportCustomersCSV':
        $sql = "SELECT * FROM customers ORDER BY created_at DESC";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'customers_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        // Write to file
        $fileOutput = fopen($filepath, 'w');
        
        // Add BOM for UTF-8 to help Excel recognize encoding
        fwrite($fileOutput, "\xEF\xBB\xBF");
        
        fputcsv($fileOutput, ['Customer ID', 'Name', 'Phone', 'Email', 'Address', 'Created At']);
        
        while ($row = $result->fetch_assoc()) {
            // Format phone as text (prefix with apostrophe to force Excel to treat as text)
            $phone = "'" . $row['phone'];
            // Format date as text (prefix with apostrophe to force Excel to treat as text)
            $createdAt = $row['created_at'] ? "'" . date('Y-m-d', strtotime($row['created_at'])) : '';
            fputcsv($fileOutput, [$row['id'], $row['name'], $phone, $row['email'], $row['address'], $createdAt]);
        }
        fclose($fileOutput);
        
        // Also trigger browser download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF";
        
        // Output file content for download
        readfile($filepath);
        exit;
        break;
    
    case 'exportEmployeesCSV':
        $sql = "SELECT * FROM employees ORDER BY hire_date DESC";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'employees_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        // Write to file
        $fileOutput = fopen($filepath, 'w');
        
        fwrite($fileOutput, "\xEF\xBB\xBF");
        
        fputcsv($fileOutput, ['Employee ID', 'Name', 'Role', 'Hire Date', 'Salary', 'Phone', 'Email']);
        
        while ($row = $result->fetch_assoc()) {
            $hireDate = $row['hire_date'] ? "'" . date('Y-m-d', strtotime($row['hire_date'])) : '';
            $phone = "'" . $row['phone'];
            fputcsv($fileOutput, [$row['id'], $row['name'], $row['role'], $hireDate, $row['salary'], $phone, $row['email']]);
        }
        fclose($fileOutput);
        
        // Also trigger browser download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF";
        
        // Output file content for download
        readfile($filepath);
        exit;
        break;
    
    case 'exportSuppliersCSV':
        $sql = "SELECT * FROM suppliers ORDER BY name";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'suppliers_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        // Write to file
        $fileOutput = fopen($filepath, 'w');
        
        fwrite($fileOutput, "\xEF\xBB\xBF");
        
        fputcsv($fileOutput, ['Supplier ID', 'Name', 'Contact Person', 'Phone', 'Email', 'Address', 'Status']);
        
        while ($row = $result->fetch_assoc()) {
            $phone = "'" . $row['phone'];
            fputcsv($fileOutput, [$row['id'], $row['name'], $row['contact_person'], $phone, $row['email'], $row['address'], $row['status']]);
        }
        fclose($fileOutput);
        
        // Also trigger browser download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF";
        
        // Output file content for download
        readfile($filepath);
        exit;
        break;
    
    case 'exportProductsCSV':
        $sql = "SELECT * FROM products ORDER BY name";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'products_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        // Write to file
        $fileOutput = fopen($filepath, 'w');
        
        fwrite($fileOutput, "\xEF\xBB\xBF");
        
        fputcsv($fileOutput, ['Product ID', 'Name', 'Category', 'Weight', 'Purity', 'Purchase Price', 'Stock']);
        
        while ($row = $result->fetch_assoc()) {
            fputcsv($fileOutput, [$row['id'], $row['name'], $row['category'], $row['weight'], $row['purity'], $row['purchase_price'], $row['stock']]);
        }
        fclose($fileOutput);
        
        // Also trigger browser download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF";
        
        // Output file content for download
        readfile($filepath);
        exit;
        break;
    
    case 'exportInventoryCSV':
        $sql = "SELECT i.*, p.name as product_name, s.name as supplier_name 
                FROM inventory i 
                JOIN products p ON i.product_id = p.id 
                JOIN suppliers s ON i.supplier_id = s.id 
                ORDER BY i.last_updated DESC";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'inventory_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        // Write to file
        $fileOutput = fopen($filepath, 'w');
        
        fwrite($fileOutput, "\xEF\xBB\xBF");
        
        fputcsv($fileOutput, ['Inventory ID', 'Product Name', 'Supplier Name', 'Quantity', 'Available Stock', 'Last Updated']);
        
        while ($row = $result->fetch_assoc()) {
            $lastUpdated = $row['last_updated'] ? "'" . date('Y-m-d H:i:s', strtotime($row['last_updated'])) : '';
            fputcsv($fileOutput, [$row['id'], $row['product_name'], $row['supplier_name'], $row['quantity'], $row['available_stock'], $lastUpdated]);
        }
        fclose($fileOutput);
        
        // Also trigger browser download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF";
        
        // Output file content for download
        readfile($filepath);
        exit;
        break;
    
    case 'exportBillsCSV':
        $sql = "SELECT b.*, c.name as customer_name, e.name as employee_name 
                FROM bills b 
                JOIN customers c ON b.customer_id = c.id 
                JOIN employees e ON b.employee_id = e.id 
                ORDER BY b.bill_date DESC, b.created_at DESC";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'bills_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        // Write to file
        $fileOutput = fopen($filepath, 'w');
        
        fwrite($fileOutput, "\xEF\xBB\xBF");
        
        fputcsv($fileOutput, ['Bill ID', 'Customer Name', 'Employee Name', 'Bill Date', 'Subtotal', 'GST', 'Discount', 'Net Payable', 'Payment Method', 'Created At']);
        
        while ($row = $result->fetch_assoc()) {
            $billDate = $row['bill_date'] ? "'" . date('Y-m-d', strtotime($row['bill_date'])) : '';
            $createdAt = $row['created_at'] ? "'" . date('Y-m-d H:i:s', strtotime($row['created_at'])) : '';
            fputcsv($fileOutput, [$row['id'], $row['customer_name'], $row['employee_name'], $billDate, $row['subtotal'], $row['gst'], $row['discount'], $row['net_payable'], $row['payment_method'], $createdAt]);
        }
        fclose($fileOutput);
        
        // Also trigger browser download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF";
        
        // Output file content for download
        readfile($filepath);
        exit;
        break;
    
    case 'exportRegularOrdersCSV':
        $sql = "SELECT o.*, c.name as customer_name, e.name as employee_name 
                FROM regular_orders o 
                JOIN customers c ON o.customer_id = c.id 
                JOIN employees e ON o.employee_id = e.id 
                ORDER BY o.order_date DESC";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'regular_orders_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        // Write to file
        $fileOutput = fopen($filepath, 'w');
        
        fwrite($fileOutput, "\xEF\xBB\xBF");
        
        fputcsv($fileOutput, ['Order ID', 'Customer Name', 'Employee Name', 'Order Date', 'Weight', 'Amount', 'Payment Method', 'Status']);
        
        while ($row = $result->fetch_assoc()) {
            $orderDate = $row['order_date'] ? "'" . date('Y-m-d', strtotime($row['order_date'])) : '';
            fputcsv($fileOutput, [$row['id'], $row['customer_name'], $row['employee_name'], $orderDate, $row['weight'], $row['amount'], $row['payment_method'], $row['status']]);
        }
        fclose($fileOutput);
        
        // Also trigger browser download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF";
        
        // Output file content for download
        readfile($filepath);
        exit;
        break;
    
    case 'exportAdvanceOrdersCSV':
        $sql = "SELECT o.*, c.name as customer_name, e.name as employee_name 
                FROM advance_orders o 
                JOIN customers c ON o.customer_id = c.id 
                JOIN employees e ON o.employee_id = e.id 
                ORDER BY o.order_date DESC";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'advance_orders_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        $output = fopen($filepath, 'w');
        
        fwrite($output, "\xEF\xBB\xBF");
        
        fputcsv($output, ['Order ID', 'Customer Name', 'Employee Name', 'Order Date', 'Delivery Date', 'Weight', 'Amount', 'Advance Paid', 'Payment Method', 'Status']);
        
        while ($row = $result->fetch_assoc()) {
            $orderDate = $row['order_date'] ? "'" . date('Y-m-d', strtotime($row['order_date'])) : '';
            $deliveryDate = $row['delivery_date'] ? "'" . date('Y-m-d', strtotime($row['delivery_date'])) : '';
            fputcsv($output, [$row['id'], $row['customer_name'], $row['employee_name'], $orderDate, $deliveryDate, $row['weight'], $row['amount'], $row['advance_paid'], $row['payment_method'], $row['status']]);
        }
        fclose($output);
        
        sendResponse(true, 'CSV file saved successfully', ['filename' => $filename, 'path' => $filepath]);
        break;
    
    case 'exportVyajOrdersCSV':
        $sql = "SELECT o.*, c.name as customer_name, e.name as employee_name 
                FROM vyaj_orders o 
                JOIN customers c ON o.customer_id = c.id 
                JOIN employees e ON o.employee_id = e.id 
                ORDER BY o.order_date DESC";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'vyaj_orders_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        $output = fopen($filepath, 'w');
        
        fwrite($output, "\xEF\xBB\xBF");
        
        fputcsv($output, ['Order ID', 'Customer Name', 'Employee Name', 'Order Date', 'Due Date', 'Weight', 'Base Amount', 'Vyaj Rate', 'Vyaj Amount', 'Month1 Payment', 'Month2 Payment', 'Month3 Payment', 'Total Price', 'Paid Amount', 'Payment Status']);
        
        while ($row = $result->fetch_assoc()) {
            $orderDate = $row['order_date'] ? "'" . date('Y-m-d', strtotime($row['order_date'])) : '';
            $dueDate = $row['due_date'] ? "'" . date('Y-m-d', strtotime($row['due_date'])) : '';
            fputcsv($output, [$row['id'], $row['customer_name'], $row['employee_name'], $orderDate, $dueDate, $row['weight'], $row['base_amount'], $row['vyaj_rate'], $row['vyaj_amount'], $row['month1_payment'], $row['month2_payment'], $row['month3_payment'], $row['total_price'], $row['paid_amount'], $row['payment_status']]);
        }
        fclose($output);
        
        sendResponse(true, 'CSV file saved successfully', ['filename' => $filename, 'path' => $filepath]);
        break;
    
    case 'exportGoldSalesCSV':
        $sql = "SELECT g.*, c.name as customer_name, p.name as product_name 
                FROM gold_sales g 
                JOIN customers c ON g.customer_id = c.id 
                JOIN products p ON g.product_id = p.id 
                ORDER BY g.getting_date DESC";
        $result = $conn->query($sql);
        
        // Create downloads folder if it doesn't exist
        $downloadsDir = __DIR__ . '/downloads';
        if (!file_exists($downloadsDir)) {
            mkdir($downloadsDir, 0777, true);
        }
        
        $filename = 'gold_sales_' . date('Y-m-d') . '.csv';
        $filepath = $downloadsDir . '/' . $filename;
        
        $output = fopen($filepath, 'w');
        
        fwrite($output, "\xEF\xBB\xBF");
        
        fputcsv($output, ['Sale ID', 'Customer Name', 'Product Name', 'Quantity', 'Purity', 'Getting Date', 'Total Amount', 'Payment to Customer', 'Payment Method']);
        
        while ($row = $result->fetch_assoc()) {
            $gettingDate = $row['getting_date'] ? "'" . date('Y-m-d', strtotime($row['getting_date'])) : '';
            fputcsv($output, [$row['id'], $row['customer_name'], $row['product_name'], $row['quantity'], $row['purity'], $gettingDate, $row['total_amount'], $row['payment_to_customer'], $row['payment_method']]);
        }
        fclose($output);
        
        sendResponse(true, 'CSV file saved successfully', ['filename' => $filename, 'path' => $filepath]);
        break;
    
    default:
        sendResponse(false, 'Invalid action');
        break;
}

$conn->close();