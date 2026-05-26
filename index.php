<?php
// Include authentication check
require_once 'auth_check.php';
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold Shop Management System</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif}body{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;padding:20px}.container{max-width:1400px;margin:0 auto;background:#fff;border-radius:15px;box-shadow:0 20px 60px rgba(0,0,0,0.3);overflow:hidden}.header{background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%);padding:30px;text-align:center;color:#fff;position:relative}.header h1{font-size:2.5em;margin-bottom:10px;text-shadow:2px 2px 4px rgba(0,0,0,0.2)}.header p{font-size:1.1em;opacity:0.9}.user-info{position:absolute;top:20px;right:30px;text-align:right;font-size:14px}.user-info .username{font-weight:600;margin-bottom:5px}.user-info .role{opacity:0.8;font-size:12px;text-transform:uppercase}.logout-btn{background:#fff;color:#f5576c;border:none;padding:8px 20px;border-radius:6px;cursor:pointer;font-weight:600;margin-top:8px;transition:all 0.3s}.logout-btn:hover{transform:scale(1.05);box-shadow:0 4px 12px rgba(0,0,0,0.2)}.nav-tabs{display:flex;background:#2d3748;overflow-x:auto;flex-wrap:wrap}.nav-tabs button{flex:1;min-width:120px;padding:15px 20px;background:transparent;border:none;color:#fff;cursor:pointer;font-size:14px;font-weight:600;transition:all 0.3s;border-bottom:3px solid transparent}.nav-tabs button:hover{background:#4a5568}.nav-tabs button.active{background:#4299e1;border-bottom:3px solid #fff}.content{padding:30px}.module{display:none}.module.active{display:block}.module h2{color:#2d3748;margin-bottom:25px;padding-bottom:15px;border-bottom:3px solid #4299e1;font-size:1.8em}.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-bottom:25px}.form-group{display:flex;flex-direction:column}.form-group label{margin-bottom:8px;color:#4a5568;font-weight:600;font-size:14px}.form-group input,.form-group select,.form-group textarea{padding:12px;border:2px solid #e2e8f0;border-radius:8px;font-size:14px;transition:border 0.3s}.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:#4299e1}.form-group input:disabled,.form-group input:readonly{background:#f7fafc;cursor:not-allowed}.form-group textarea{resize:vertical;min-height:80px}.btn{padding:12px 30px;border:none;border-radius:8px;cursor:pointer;font-size:15px;font-weight:600;transition:all 0.3s;margin-right:10px;margin-top:10px}.btn-primary{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff}.btn-primary:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(102,126,234,0.4)}.btn-success{background:linear-gradient(135deg,#11998e 0%,#38ef7d 100%);color:#fff}.btn-success:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(56,239,125,0.4)}.btn-danger{background:linear-gradient(135deg,#eb3349 0%,#f45c43 100%);color:#fff}.btn-danger:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(235,51,73,0.4)}.btn-warning{background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%);color:#fff}.btn-warning:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(245,87,108,0.4)}.table-container{overflow-x:auto;margin-top:25px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1)}table{width:100%;border-collapse:collapse;background:#fff}th{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;padding:15px;text-align:left;font-weight:600;font-size:14px}td{padding:12px 15px;border-bottom:1px solid #e2e8f0;font-size:14px}tr:hover{background:#f7fafc}.action-btn{padding:6px 12px;margin:0 3px;border:none;border-radius:5px;cursor:pointer;font-size:12px;font-weight:600;transition:all 0.2s}.edit-btn{background:#4299e1;color:#fff}.edit-btn:hover{background:#3182ce}.delete-btn{background:#f56565;color:#fff}.delete-btn:hover{background:#e53e3e}.alert{padding:15px 20px;margin-bottom:20px;border-radius:8px;font-weight:500;display:none}.alert.show{display:block}.alert-success{background:#c6f6d5;color:#22543d;border-left:4px solid #38a169}.alert-danger{background:#fed7d7;color:#742a2a;border-left:4px solid #e53e3e}.alert-info{background:#bee3f8;color:#2c5282;border-left:4px solid #3182ce}.bill-items{background:#f7fafc;padding:20px;border-radius:8px;margin:20px 0}.bill-item{background:#fff;padding:15px;border-radius:8px;margin-bottom:15px;border:2px solid #e2e8f0}.bill-summary{background:#fff;padding:20px;border-radius:8px;border:2px solid #4299e1;margin-top:20px}.summary-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #e2e8f0}.summary-row.total{font-size:1.3em;font-weight:bold;color:#4299e1;border-top:2px solid #4299e1;margin-top:10px}@media(max-width:768px){.form-grid{grid-template-columns:1fr}.nav-tabs{flex-direction:column}.nav-tabs button{min-width:100%}.user-info{position:static;text-align:center;margin-top:15px}}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="user-info">
                <div class="username">👤 <?php echo htmlspecialchars($currentUser['username']); ?></div>
                <div class="role">🔑 <?php echo htmlspecialchars($currentUser['role']); ?></div>
                <button class="logout-btn" onclick="logout()">🚪 Logout</button>
            </div>
            <h1>💎 Gold Shop Management System</h1>
            <p>Complete Jewelry Business Management Solution</p>
        </div>

        <div class="nav-tabs">
            <button class="active" onclick="showModule('customer')">👥 Customers</button>
            <button onclick="showModule('employee')">👔 Employees</button>
            <button onclick="showModule('supplier')">🏭 Suppliers</button>
            <button onclick="showModule('product')">📦 Products</button>
            <button onclick="showModule('inventory')">📊 Inventory</button>
            <button onclick="showModule('bills')">🧾 Bills</button>
            <button onclick="showModule('order')">🛒 Orders</button>
            <button onclick="showModule('goldsale')">💰 Gold Sales</button>
        </div>

        <div class="content">
            <!-- Customer Module -->
            <div id="customer" class="module active">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                    <h2 style="margin:0;">Customer Management</h2>
                    <button onclick="exportCSV('exportCustomersCSV')" class="btn btn-success">📥 Export CSV</button>
                </div>
                <div class="alert alert-success" id="customerAlert"></div>
                
                <form id="customerForm" onsubmit="handleCustomerSubmit(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Customer ID*</label>
                            <input type="text" id="customerID" required disabled>
                        </div>
                        <div class="form-group">
                            <label>Full Name*</label>
                            <input type="text" id="customerName" required>
                        </div>
                        <div class="form-group">
                            <label>Phone*</label>
                            <input type="tel" id="customerPhone" required>
                        </div>
                        <div class="form-group">
                            <label>Email*</label>
                            <input type="email" id="customerEmail" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea id="customerAddress"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="customerSubmitBtn">Add Customer</button>
                    <button type="button" class="btn btn-warning" onclick="cancelEdit('customer')">Cancel</button>
                </form>

                <div class="table-container">
                    <table id="customerTable">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Employee Module -->
            <div id="employee" class="module">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                    <h2 style="margin:0;">Employee Management</h2>
                    <button onclick="exportCSV('exportEmployeesCSV')" class="btn btn-success">📥 Export CSV</button>
                </div>
                <div class="alert alert-success" id="employeeAlert"></div>
                
                <form id="employeeForm" onsubmit="handleEmployeeSubmit(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Employee ID*</label>
                            <input type="text" id="employeeID" required disabled>
                        </div>
                        <div class="form-group">
                            <label>Full Name*</label>
                            <input type="text" id="employeeName" required>
                        </div>
                        <div class="form-group">
                            <label>Role*</label>
                            <select id="employeeRole" required>
                                <option value="">Select Role</option>
                                <option value="Manager">Manager</option>
                                <option value="Salesperson">Salesperson</option>
                                <option value="Cashier">Cashier</option>
                                <option value="Supervisor">Supervisor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hire Date*</label>
                            <input type="date" id="employeeHireDate" required>
                        </div>
                        <div class="form-group">
                            <label>Salary*</label>
                            <input type="number" step="0.01" id="employeeSalary" required>
                        </div>
                        <div class="form-group">
                            <label>Phone*</label>
                            <input type="tel" id="employeePhone" required>
                        </div>
                        <div class="form-group">
                            <label>Email*</label>
                            <input type="email" id="employeeEmail" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="employeeSubmitBtn">Add Employee</button>
                    <button type="button" class="btn btn-warning" onclick="cancelEdit('employee')">Cancel</button>
                </form>

                <div class="table-container">
                    <table id="employeeTable">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Hire Date</th>
                                <th>Salary</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Supplier Module -->
            <div id="supplier" class="module">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                    <h2 style="margin:0;">Supplier Management</h2>
                    <button onclick="exportCSV('exportSuppliersCSV')" class="btn btn-success">📥 Export CSV</button>
                </div>
                <div class="alert alert-success" id="supplierAlert"></div>
                
                <form id="supplierForm" onsubmit="handleSupplierSubmit(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Supplier ID*</label>
                            <input type="text" id="supplierID" required disabled>
                        </div>
                        <div class="form-group">
                            <label>Supplier Name*</label>
                            <input type="text" id="supplierName" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Person*</label>
                            <input type="text" id="supplierContact" required>
                        </div>
                        <div class="form-group">
                            <label>Phone*</label>
                            <input type="tel" id="supplierPhone" required>
                        </div>
                        <div class="form-group">
                            <label>Email*</label>
                            <input type="email" id="supplierEmail" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea id="supplierAddress"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status*</label>
                            <select id="supplierStatus" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="supplierSubmitBtn">Add Supplier</button>
                    <button type="button" class="btn btn-warning" onclick="cancelEdit('supplier')">Cancel</button>
                </form>

                <div class="table-container">
                    <table id="supplierTable">
                        <thead>
                            <tr>
                                <th>Supplier ID</th>
                                <th>Name</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Product Module -->
            <div id="product" class="module">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                    <h2 style="margin:0;">Product Management</h2>
                    <button onclick="exportCSV('exportProductsCSV')" class="btn btn-success">📥 Export CSV</button>
                </div>
                <div class="alert alert-success" id="productAlert"></div>
                
                <form id="productForm" onsubmit="handleProductSubmit(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Product ID*</label>
                            <input type="text" id="productID" required disabled>
                        </div>
                        <div class="form-group">
                            <label>Product Name*</label>
                            <input type="text" id="productName" required>
                        </div>
                        <div class="form-group">
                            <label>Category*</label>
                            <select id="productCategory" required>
                                <option value="">Select Category</option>
                                <option value="Necklace">Necklace</option>
                                <option value="Ring">Ring</option>
                                <option value="Bracelet">Bracelet</option>
                                <option value="Earring">Earring</option>
                                <option value="Chain">Chain</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Weight (grams)*</label>
                            <input type="number" step="0.01" id="productWeight" required>
                        </div>
                        <div class="form-group">
                            <label>Purity (Karat)*</label>
                            <select id="productPurity" required>
                                <option value="18">18K</option>
                                <option value="22">22K</option>
                                <option value="24">24K</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Purchase Price/gram*</label>
                            <input type="number" step="0.01" id="productPurchasePrice" required>
                        </div>
                        <div class="form-group">
                            <label>Stock Quantity*</label>
                            <input type="number" id="productStock" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="productSubmitBtn">Add Product</button>
                    <button type="button" class="btn btn-warning" onclick="cancelEdit('product')">Cancel</button>
                </form>

                <div class="table-container">
                    <table id="productTable">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Weight(g)</th>
                                <th>Purity</th>
                                <th>Purchase Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Inventory Module -->
            <div id="inventory" class="module">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                    <h2 style="margin:0;">Inventory Management</h2>
                    <button onclick="exportCSV('exportInventoryCSV')" class="btn btn-success">📥 Export CSV</button>
                </div>
                <div class="alert alert-success" id="inventoryAlert"></div>
                
                <form id="inventoryForm" onsubmit="handleInventorySubmit(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Inventory ID*</label>
                            <input type="text" id="inventoryID" required disabled>
                        </div>
                        <div class="form-group">
                            <label>Product*</label>
                            <select id="inventoryProductID" required>
                                <option value="">Select Product</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Supplier*</label>
                            <select id="inventorySupplierID" required>
                                <option value="">Select Supplier</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity (grams)*</label>
                            <input type="number" step="0.01" id="inventoryQuantity" required>
                        </div>
                        <div class="form-group">
                            <label>Available Stock (grams)*</label>
                            <input type="number" step="0.01" id="inventoryAvailableStock" required>
                        </div>
                        <div class="form-group">
                            <label>Last Updated*</label>
                            <input type="datetime-local" id="inventoryLastUpdated" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="inventorySubmitBtn">Add Inventory</button>
                    <button type="button" class="btn btn-warning" onclick="cancelEdit('inventory')">Cancel</button>
                </form>

                <div class="table-container">
                    <table id="inventoryTable">
                        <thead>
                            <tr>
                                <th>Inventory ID</th>
                                <th>Product</th>
                                <th>Supplier</th>
                                <th>Quantity(g)</th>
                                <th>Available Stock(g)</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Bills Module -->
            <div id="bills" class="module">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                    <h2 style="margin:0;">Bills Management</h2>
                    <button onclick="exportCSV('exportBillsCSV')" class="btn btn-success">📥 Export CSV</button>
                </div>
                <div class="alert alert-success" id="billsAlert"></div>
                
                <div style="margin-bottom: 25px;">
                    <button type="button" class="btn btn-primary" onclick="showBillForm()">📄 Create New Bill</button>
                </div>

                <div id="billFormSection" style="display:none;">
                    <form id="billsForm" onsubmit="handleBillsSubmit(event)">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Bill ID*</label>
                                <input type="text" id="billID" required disabled>
                            </div>
                            <div class="form-group">
                                <label>Customer*</label>
                                <select id="billCustomerID" required>
                                    <option value="">Select Customer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Employee*</label>
                                <select id="billEmployeeID" required>
                                    <option value="">Select Employee</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bill Date*</label>
                                <input type="date" id="billDate" required>
                            </div>
                            <div class="form-group">
                                <label>Payment Method*</label>
                                <select id="billPaymentMethod" required>
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                        </div>

                        <h3 style="margin:20px 0;color:#4299e1;">Add Products to Bill</h3>
                        <div class="bill-items" id="billItemsSection">
                            <div class="bill-item">
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label>Select Product*</label>
                                        <select class="billProduct" onchange="updateProductDetails(this)" required>
                                            <option value="">Select Product</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Weight (grams)*</label>
                                        <input type="number" step="0.01" class="billWeight" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Purity*</label>
                                        <input type="text" class="billPurity" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Gold Price/gram*</label>
                                        <input type="number" step="0.01" class="billGoldPrice" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Making Charges/gram*</label>
                                        <input type="number" step="0.01" class="billMakingCharges" oninput="calculateItemTotal(this)" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Total Price*</label>
                                        <input type="number" step="0.01" class="billItemTotal" readonly>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger" onclick="removeBillItem(this)" style="margin-top:10px;">Remove Item</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success" onclick="addBillItem()">+ Add Another Product</button>

                        <div class="bill-summary">
                            <h3 style="color:#4299e1;margin-bottom:15px;">Bill Summary</h3>
                            <div class="summary-row">
                                <span>Subtotal (Gold + Making):</span>
                                <span id="billSubtotal">₹0.00</span>
                            </div>
                            <div class="summary-row">
                                <span>GST (3%):</span>
                                <span id="billGST">₹0.00</span>
                            </div>
                            <div class="summary-row">
                                <span>Discount:</span>
                                <input type="number" step="0.01" id="billDiscount" value="0" oninput="calculateBillTotal()" style="width:150px;text-align:right;padding:5px;border:2px solid #e2e8f0;border-radius:5px;">
                            </div>
                            <div class="summary-row total">
                                <span>Net Payable:</span>
                                <span id="billNetPayable">₹0.00</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="billsSubmitBtn">Generate Bill</button>
                        <button type="button" class="btn" style="background:#ec4899;color:#fff" onclick="hideBillForm()">Cancel</button>
                    </form>
                </div>

                <div class="table-container">
                    <table id="billsTable">
                        <thead>
                            <tr>
                                <th>Bill ID</th>
                                <th>Customer</th>
                                <th>Employee</th>
                                <th>Bill Date</th>
                                <th>Subtotal</th>
                                <th>GST</th>
                                <th>Discount</th>
                                <th>Net Payable</th>
                                <th>Payment Method</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Order Module -->
            <div id="order" class="module">
                <h2>Order Management</h2>
                <div class="alert alert-success" id="orderAlert"></div>
                
                <div style="margin-bottom:20px;">
                    <button class="btn btn-primary" onclick="showOrderType('regular')">Regular Orders</button>
                    <button class="btn btn-success" onclick="showOrderType('advance')">Advance Orders</button>
                    <button class="btn btn-warning" onclick="showOrderType('vyaj')">Vyaj Orders</button>
                </div>

                <!-- Regular Order -->
                <div id="regularOrder" class="order-type">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                        <h3 style="color:#4299e1;margin:0;">Regular Orders</h3>
                        <button onclick="exportCSV('exportRegularOrdersCSV')" class="btn btn-success">📥 Export CSV</button>
                    </div>
                    <form id="regularOrderForm" onsubmit="handleRegularOrderSubmit(event)">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Order ID*</label>
                                <input type="text" id="orderID" required disabled>
                            </div>
                            <div class="form-group">
                                <label>Customer*</label>
                                <select id="orderCustomerID" required>
                                    <option value="">Select Customer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Employee*</label>
                                <select id="orderEmployeeID" required>
                                    <option value="">Select Employee</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Order Date*</label>
                                <input type="date" id="orderDate" required>
                            </div>
                            <div class="form-group">
                                <label>Total Weight (grams)*</label>
                                <input type="number" step="0.01" id="orderWeight" required>
                            </div>
                            <div class="form-group">
                                <label>Total Amount*</label>
                                <input type="number" step="0.01" id="orderAmount" required>
                            </div>
                            <div class="form-group">
                                <label>Payment Method*</label>
                                <select id="orderPaymentMethod" required>
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status*</label>
                                <select id="orderStatus" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="regularOrderSubmitBtn">Add Order</button>
                        <button type="button" class="btn btn-warning" onclick="cancelEdit('regularOrder')">Cancel</button>
                    </form>

                    <div class="table-container">
                        <table id="regularOrderTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Employee</th>
                                    <th>Order Date</th>
                                    <th>Weight(g)</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <!-- Advance Order -->
                <div id="advanceOrder" class="order-type" style="display:none;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                        <h3 style="color:#4299e1;margin:0;">Advance Orders</h3>
                        <button onclick="exportCSV('exportAdvanceOrdersCSV')" class="btn btn-success">📥 Export CSV</button>
                    </div>
                    <form id="advanceOrderForm" onsubmit="handleAdvanceOrderSubmit(event)">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Advance Order ID*</label>
                                <input type="text" id="advanceOrderID" required disabled>
                            </div>
                            <div class="form-group">
                                <label>Customer*</label>
                                <select id="advanceCustomerID" required>
                                    <option value="">Select Customer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Employee*</label>
                                <select id="advanceEmployeeID" required>
                                    <option value="">Select Employee</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Order Date*</label>
                                <input type="date" id="advanceOrderDate" required>
                            </div>
                            <div class="form-group">
                                <label>Expected Delivery*</label>
                                <input type="date" id="advanceDeliveryDate" required>
                            </div>
                            <div class="form-group">
                                <label>Total Weight (grams)*</label>
                                <input type="number" step="0.01" id="advanceWeight" required>
                            </div>
                            <div class="form-group">
                                <label>Total Amount*</label>
                                <input type="number" step="0.01" id="advanceAmount" required>
                            </div>
                            <div class="form-group">
                                <label>Advance Paid*</label>
                                <input type="number" step="0.01" id="advancePaid" required>
                            </div>
                            <div class="form-group">
                                <label>Payment Method*</label>
                                <select id="advancePaymentMethod" required>
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status*</label>
                                <select id="advanceStatus" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Pending Delivery">Pending Delivery</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success" id="advanceOrderSubmitBtn">Add Advance Order</button>
                        <button type="button" class="btn btn-warning" onclick="cancelEdit('advanceOrder')">Cancel</button>
                    </form>

                    <div class="table-container">
                        <table id="advanceOrderTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Employee</th>
                                    <th>Order Date</th>
                                    <th>Expected Delivery</th>
                                    <th>Weight(g)</th>
                                    <th>Amount</th>
                                    <th>Advance Paid</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <!-- Vyaj Order -->
                <div id="vyajOrder" class="order-type" style="display:none;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                        <h3 style="color:#4299e1;margin:0;">Vyaj Orders</h3>
                        <button onclick="exportCSV('exportVyajOrdersCSV')" class="btn btn-success">📥 Export CSV</button>
                    </div>
                    <form id="vyajOrderForm" onsubmit="handleVyajOrderSubmit(event)">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Vyaj Order ID*</label>
                                <input type="text" id="vyajOrderID" required disabled>
                            </div>
                            <div class="form-group">
                                <label>Customer*</label>
                                <select id="vyajCustomerID" required>
                                    <option value="">Select Customer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Employee*</label>
                                <select id="vyajEmployeeID" required>
                                    <option value="">Select Employee</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Order Date*</label>
                                <input type="date" id="vyajOrderDate" required>
                            </div>
                            <div class="form-group">
                                <label>Due Date*</label>
                                <input type="date" id="vyajDueDate" required>
                            </div>
                            <div class="form-group">
                                <label>Total Weight (grams)*</label>
                                <input type="number" step="0.01" id="vyajWeight" required>
                            </div>
                            <div class="form-group">
                                <label>Base Amount*</label>
                                <input type="number" step="0.01" id="vyajBaseAmount" required>
                            </div>
                            <div class="form-group">
                                <label>Vyaj Rate (%)*</label>
                                <input type="number" step="0.01" id="vyajRate" required>
                            </div>
                            <div class="form-group">
                                <label>Vyaj Amount*</label>
                                <input type="number" step="0.01" id="vyajAmount" required>
                            </div>
                            <div class="form-group">
                                <label>Month 1 Payment</label>
                                <input type="number" step="0.01" id="vyajMonth1" value="0">
                            </div>
                            <div class="form-group">
                                <label>Month 2 Payment</label>
                                <input type="number" step="0.01" id="vyajMonth2" value="0">
                            </div>
                            <div class="form-group">
                                <label>Month 3 Payment</label>
                                <input type="number" step="0.01" id="vyajMonth3" value="0">
                            </div>
                            <div class="form-group">
                                <label>Total Price*</label>
                                <input type="number" step="0.01" id="vyajTotalPrice" required>
                            </div>
                            <div class="form-group">
                                <label>Paid Amount*</label>
                                <input type="number" step="0.01" id="vyajPaidAmount" required>
                            </div>
                            <div class="form-group">
                                <label>Payment Status*</label>
                                <select id="vyajPaymentStatus" required>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Partially Paid">Partially Paid</option>
                                    <option value="Paid">Paid</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning" id="vyajOrderSubmitBtn">Add Vyaj Order</button>
                        <button type="button" class="btn btn-danger" onclick="cancelEdit('vyajOrder')">Cancel</button>
                    </form>

                    <div class="table-container">
                        <table id="vyajOrderTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Order Date</th>
                                    <th>Due Date</th>
                                    <th>Weight(g)</th>
                                    <th>Base Amount</th>
                                    <th>Vyaj Rate</th>
                                    <th>Total Price</th>
                                    <th>Paid Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Gold Sale Module -->
            <div id="goldsale" class="module">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                    <h2 style="margin:0;">Gold Sold by Customer</h2>
                    <button onclick="exportCSV('exportGoldSalesCSV')" class="btn btn-success">📥 Export CSV</button>
                </div>
                <div class="alert alert-success" id="goldsaleAlert"></div>
                
                <form id="goldsaleForm" onsubmit="handleGoldsaleSubmit(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Gold Sale ID*</label>
                            <input type="text" id="goldSaleID" required disabled>
                        </div>
                        <div class="form-group">
                            <label>Customer*</label>
                            <select id="goldCustomerID" required>
                                <option value="">Select Customer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Product*</label>
                            <select id="goldProductID" required>
                                <option value="">Select Product</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity (grams)*</label>
                            <input type="number" step="0.01" id="goldQuantity" required>
                        </div>
                        <div class="form-group">
                            <label>Purity (Karat)*</label>
                            <select id="goldPurity" required>
                                <option value="18">18K</option>
                                <option value="22">22K</option>
                                <option value="24">24K</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Getting Date*</label>
                            <input type="date" id="goldGettingDate" required>
                        </div>
                        <div class="form-group">
                            <label>Total Amount*</label>
                            <input type="number" step="0.01" id="goldTotalAmount" required>
                        </div>
                        <div class="form-group">
                            <label>Payment to Customer*</label>
                            <input type="number" step="0.01" id="goldPaymentCustomer" required>
                        </div>
                        <div class="form-group">
                            <label>Payment Method*</label>
                            <select id="goldPaymentMethod" required>
                                <option value="">Select Method</option>
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="UPI">UPI</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="goldsaleSubmitBtn">Add Gold Sale</button>
                    <button type="button" class="btn btn-warning" onclick="cancelEdit('goldsale')">Cancel</button>
                </form>

                <div class="table-container">
                    <table id="goldsaleTable">
                        <thead>
                            <tr>
                                <th>Sale ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity(g)</th>
                                <th>Purity</th>
                                <th>Getting Date</th>
                                <th>Total Amount</th>
                                <th>Payment to Customer</th>
                                <th>Payment Method</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }

        // Session timeout warning (optional)
        let sessionTimeout;
        function resetSessionTimeout() {
            clearTimeout(sessionTimeout);
            // Warn user 2 minutes before session expires
            sessionTimeout = setTimeout(function() {
                alert('Your session will expire in 2 minutes due to inactivity. Please save your work.');
            }, 28 * 60 * 1000); // 28 minutes
        }

        // Reset timeout on user activity
        document.addEventListener('mousemove', resetSessionTimeout);
        document.addEventListener('keypress', resetSessionTimeout);
        resetSessionTimeout();
      
        let editMode = {};
        let dataCache = {customers: [], employees: [], suppliers: [], products: [], inventory: [], bills: [], regularOrders: [], advanceOrders: [], vyajOrders: [], goldSales: []};

        // API Call Helper
        async function apiCall(action, data = {}) {
            const formData = new FormData();
            formData.append('action', action);
            for (let key in data) {
                formData.append(key, data[key]);
            }
            
            const response = await fetch('api.php', {method: 'POST', body: formData});
            return await response.json();
        }

        // Show Alert
        function showAlert(moduleId, message, type = 'success') {
            const alert = document.getElementById(moduleId + 'Alert');
            alert.className = 'alert alert-' + type + ' show';
            alert.textContent = message;
            setTimeout(() => alert.classList.remove('show'), 3000);
        }

        // Export CSV
        async function exportCSV(action) {
            try {
                const formData = new FormData();
                formData.append('action', action);
                
                const response = await fetch('api.php', {
                    method: 'POST',
                    body: formData
                });
                
                // Check if response is CSV (file download)
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/csv')) {
                    // Get filename from response headers
                    const contentDisposition = response.headers.get('content-disposition');
                    let filename = 'export_' + new Date().toISOString().split('T')[0] + '.csv';
                    if (contentDisposition) {
                        const filenameMatch = contentDisposition.match(/filename="(.+)"/);
                        if (filenameMatch) {
                            filename = filenameMatch[1];
                        }
                    }
                    
                    // Download the file
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                    
                    // Show success notification
                    const moduleName = action.replace('export', '').replace('CSV', '').toLowerCase();
                    showNotification('CSV file created and downloaded successfully! Saved to downloads folder.', 'success');
                } else {
                    // If not CSV, try to parse as JSON
                    const result = await response.json();
                    if (result.success) {
                        showNotification('CSV file created successfully! Saved to downloads folder.', 'success');
                    } else {
                        showNotification('Failed to create CSV file: ' + result.message, 'error');
                    }
                }
            } catch (error) {
                console.error('CSV export error:', error);
                showNotification('Failed to export CSV: ' + error.message, 'error');
            }
        }
        
        // Show notification function
        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background: ${type === 'success' ? '#22c55e' : '#ef4444'};
                color: white;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                z-index: 10000;
                font-size: 14px;
                font-weight: 500;
                min-width: 300px;
                animation: slideIn 0.3s ease-out;
            `;
            notification.textContent = message;
            
            // Add animation style if not exists
            if (!document.getElementById('notification-style')) {
                const style = document.createElement('style');
                style.id = 'notification-style';
                style.textContent = `
                    @keyframes slideIn {
                        from {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                    @keyframes slideOut {
                        from {
                            transform: translateX(0);
                            opacity: 1;
                        }
                        to {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            }
            
            document.body.appendChild(notification);
            
            // Remove notification after 4 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }

        // Module Navigation
        function showModule(moduleName) {
            document.querySelectorAll('.module').forEach(m => m.classList.remove('active'));
            document.querySelectorAll('.nav-tabs button').forEach(t => t.classList.remove('active'));
            document.getElementById(moduleName).classList.add('active');
            event.target.classList.add('active');
            
            if (moduleName === 'customer') loadCustomers();
            else if (moduleName === 'employee') loadEmployees();
            else if (moduleName === 'supplier') loadSuppliers();
            else if (moduleName === 'product') loadProducts();
            else if (moduleName === 'inventory') loadInventory();
            else if (moduleName === 'bills') loadBills();
            else if (moduleName === 'order') {loadRegularOrders(); updateAllDropdowns();}
            else if (moduleName === 'goldsale') loadGoldSales();
        }

        // Order Type Navigation
        function showOrderType(type) {
            document.getElementById('regularOrder').style.display = type === 'regular' ? 'block' : 'none';
            document.getElementById('advanceOrder').style.display = type === 'advance' ? 'block' : 'none';
            document.getElementById('vyajOrder').style.display = type === 'vyaj' ? 'block' : 'none';
            
            if (type === 'regular') loadRegularOrders();
            else if (type === 'advance') loadAdvanceOrders();
            else if (type === 'vyaj') loadVyajOrders();
        }

        // Cancel Edit
        function cancelEdit(module) {
            editMode[module] = null;
            const formId = module + 'Form';
            if (module === 'regularOrder') document.getElementById('regularOrderForm').reset();
            else if (module === 'advanceOrder') document.getElementById('advanceOrderForm').reset();
            else if (module === 'vyajOrder') document.getElementById('vyajOrderForm').reset();
            else document.getElementById(formId).reset();
            
            const btnText = module === 'customer' ? 'Add Customer' :
                           module === 'employee' ? 'Add Employee' :
                           module === 'supplier' ? 'Add Supplier' :
                           module === 'product' ? 'Add Product' :
                           module === 'inventory' ? 'Add Inventory' :
                           module === 'bills' ? 'Generate Bill' :
                           module === 'regularOrder' ? 'Add Order' :
                           module === 'advanceOrder' ? 'Add Advance Order' :
                           module === 'vyajOrder' ? 'Add Vyaj Order' :
                           module === 'goldsale' ? 'Add Gold Sale' : 'Add';
            
            document.getElementById(module + 'SubmitBtn').textContent = btnText;
        }

        // Update Dropdowns
        function updateAllDropdowns() {
            updateCustomerDropdowns();
            updateEmployeeDropdowns();
            updateProductDropdowns();
            updateSupplierDropdowns();
        }

        function updateCustomerDropdowns() {
            const dropdowns = ['billCustomerID', 'orderCustomerID', 'advanceCustomerID', 'vyajCustomerID', 'goldCustomerID'];
            dropdowns.forEach(id => {
                const select = document.getElementById(id);
                if (select) {
                    select.innerHTML = '<option value="">Select Customer</option>' + 
                        dataCache.customers.map(c => `<option value="${c.id}">${c.name} (${c.id})</option>`).join('');
                }
            });
        }

        function updateEmployeeDropdowns() {
            const dropdowns = ['billEmployeeID', 'orderEmployeeID', 'advanceEmployeeID', 'vyajEmployeeID'];
            dropdowns.forEach(id => {
                const select = document.getElementById(id);
                if (select) {
                    select.innerHTML = '<option value="">Select Employee</option>' + 
                        dataCache.employees.map(e => `<option value="${e.id}">${e.name} (${e.id})</option>`).join('');
                }
            });
        }

        function updateProductDropdowns() {
            const dropdowns = ['inventoryProductID', 'goldProductID'];
            dropdowns.forEach(id => {
                const select = document.getElementById(id);
                if (select) {
                    select.innerHTML = '<option value="">Select Product</option>' + 
                        dataCache.products.map(p => `<option value="${p.id}">${p.name} (${p.id})</option>`).join('');
                }
            });
            
            document.querySelectorAll('.billProduct').forEach(select => {
                select.innerHTML = '<option value="">Select Product</option>' + 
                    dataCache.products.map(p => `<option value="${p.id}">${p.name} (${p.id})</option>`).join('');
            });
        }

        function updateSupplierDropdowns() {
            const select = document.getElementById('inventorySupplierID');
            if (select) {
                select.innerHTML = '<option value="">Select Supplier</option>' + 
                    dataCache.suppliers.map(s => `<option value="${s.id}">${s.name} (${s.id})</option>`).join('');
            }
        }

        // CUSTOMER OPERATIONS
        async function loadCustomers() {
            const result = await apiCall('getCustomers');
            if (result.success) {
                dataCache.customers = result.data;
                renderCustomerTable();
                updateCustomerDropdowns();
            }
        }

        function renderCustomerTable() {
            const tbody = document.querySelector('#customerTable tbody');
            tbody.innerHTML = dataCache.customers.map((c, i) => `
                <tr>
                    <td>${c.id}</td>
                    <td>${c.name}</td>
                    <td>${c.phone}</td>
                    <td>${c.email}</td>
                    <td>${c.address || ''}</td>
                    <td>${c.created_at}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editCustomer('${c.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteCustomer('${c.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleCustomerSubmit(e) {
            e.preventDefault();
            const data = {
                name: document.getElementById('customerName').value,
                phone: document.getElementById('customerPhone').value,
                email: document.getElementById('customerEmail').value,
                address: document.getElementById('customerAddress').value
            };
            
            if (editMode.customer) {
                data.id = document.getElementById('customerID').value;
                const result = await apiCall('updateCustomer', data);
                showAlert('customer', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addCustomer', data);
                showAlert('customer', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('customer');
            loadCustomers();
        }

        function editCustomer(id) {
            const c = dataCache.customers.find(item => item.id === id);
            if (!c) return;
            
            document.getElementById('customerID').value = c.id;
            document.getElementById('customerName').value = c.name;
            document.getElementById('customerPhone').value = c.phone;
            document.getElementById('customerEmail').value = c.email;
            document.getElementById('customerAddress').value = c.address || '';
            
            editMode.customer = id;
            document.getElementById('customerSubmitBtn').textContent = 'Update Customer';
            window.scrollTo(0, 0);
        }

        async function deleteCustomer(id) {
            if (!confirm('Are you sure you want to delete this customer?')) return;
            const result = await apiCall('deleteCustomer', {id});
            showAlert('customer', result.message, result.success ? 'success' : 'danger');
            loadCustomers();
        }

        // EMPLOYEE OPERATIONS
        async function loadEmployees() {
            const result = await apiCall('getEmployees');
            if (result.success) {
                dataCache.employees = result.data;
                renderEmployeeTable();
                updateEmployeeDropdowns();
            }
        }

        function renderEmployeeTable() {
            const tbody = document.querySelector('#employeeTable tbody');
            tbody.innerHTML = dataCache.employees.map(e => `
                <tr>
                    <td>${e.id}</td>
                    <td>${e.name}</td>
                    <td>${e.role}</td>
                    <td>${e.hire_date}</td>
                    <td>₹${parseFloat(e.salary).toFixed(2)}</td>
                    <td>${e.phone}</td>
                    <td>${e.email}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editEmployee('${e.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteEmployee('${e.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleEmployeeSubmit(e) {
            e.preventDefault();
            const data = {
                name: document.getElementById('employeeName').value,
                role: document.getElementById('employeeRole').value,
                hireDate: document.getElementById('employeeHireDate').value,
                salary: document.getElementById('employeeSalary').value,
                phone: document.getElementById('employeePhone').value,
                email: document.getElementById('employeeEmail').value
            };
            
            if (editMode.employee) {
                data.id = document.getElementById('employeeID').value;
                const result = await apiCall('updateEmployee', data);
                showAlert('employee', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addEmployee', data);
                showAlert('employee', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('employee');
            loadEmployees();
        }

        function editEmployee(id) {
            const e = dataCache.employees.find(item => item.id === id);
            if (!e) return;
            
            document.getElementById('employeeID').value = e.id;
            document.getElementById('employeeName').value = e.name;
            document.getElementById('employeeRole').value = e.role;
            document.getElementById('employeeHireDate').value = e.hire_date;
            document.getElementById('employeeSalary').value = e.salary;
            document.getElementById('employeePhone').value = e.phone;
            document.getElementById('employeeEmail').value = e.email;
            
            editMode.employee = id;
            document.getElementById('employeeSubmitBtn').textContent = 'Update Employee';
            window.scrollTo(0, 0);
        }

        async function deleteEmployee(id) {
            if (!confirm('Are you sure you want to delete this employee?')) return;
            const result = await apiCall('deleteEmployee', {id});
            showAlert('employee', result.message, result.success ? 'success' : 'danger');
            loadEmployees();
        }

        // SUPPLIER OPERATIONS
        async function loadSuppliers() {
            const result = await apiCall('getSuppliers');
            if (result.success) {
                dataCache.suppliers = result.data;
                renderSupplierTable();
                updateSupplierDropdowns();
            }
        }

        function renderSupplierTable() {
            const tbody = document.querySelector('#supplierTable tbody');
            tbody.innerHTML = dataCache.suppliers.map(s => `
                <tr>
                    <td>${s.id}</td>
                    <td>${s.name}</td>
                    <td>${s.contact_person}</td>
                    <td>${s.phone}</td>
                    <td>${s.email}</td>
                    <td>${s.address || ''}</td>
                    <td>${s.status}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editSupplier('${s.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteSupplier('${s.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleSupplierSubmit(e) {
            e.preventDefault();
            const data = {
                name: document.getElementById('supplierName').value,
                contact: document.getElementById('supplierContact').value,
                phone: document.getElementById('supplierPhone').value,
                email: document.getElementById('supplierEmail').value,
                address: document.getElementById('supplierAddress').value,
                status: document.getElementById('supplierStatus').value
            };
            
            if (editMode.supplier) {
                data.id = document.getElementById('supplierID').value;
                const result = await apiCall('updateSupplier', data);
                showAlert('supplier', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addSupplier', data);
                showAlert('supplier', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('supplier');
            loadSuppliers();
        }

        function editSupplier(id) {
            const s = dataCache.suppliers.find(item => item.id === id);
            if (!s) return;
            
            document.getElementById('supplierID').value = s.id;
            document.getElementById('supplierName').value = s.name;
            document.getElementById('supplierContact').value = s.contact_person;
            document.getElementById('supplierPhone').value = s.phone;
            document.getElementById('supplierEmail').value = s.email;
            document.getElementById('supplierAddress').value = s.address || '';
            document.getElementById('supplierStatus').value = s.status;
            
            editMode.supplier = id;
            document.getElementById('supplierSubmitBtn').textContent = 'Update Supplier';
            window.scrollTo(0, 0);
        }

        async function deleteSupplier(id) {
            if (!confirm('Are you sure you want to delete this supplier?')) return;
            const result = await apiCall('deleteSupplier', {id});
            showAlert('supplier', result.message, result.success ? 'success' : 'danger');
            loadSuppliers();
        }

        // PRODUCT OPERATIONS
        async function loadProducts() {
            const result = await apiCall('getProducts');
            if (result.success) {
                dataCache.products = result.data;
                renderProductTable();
                updateProductDropdowns();
            }
        }

        function renderProductTable() {
            const tbody = document.querySelector('#productTable tbody');
            tbody.innerHTML = dataCache.products.map(p => `
                <tr>
                    <td>${p.id}</td>
                    <td>${p.name}</td>
                    <td>${p.category}</td>
                    <td>${parseFloat(p.weight).toFixed(2)}</td>
                    <td>${p.purity}K</td>
                    <td>₹${parseFloat(p.purchase_price).toFixed(2)}</td>
                    <td>${p.stock}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editProduct('${p.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteProduct('${p.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleProductSubmit(e) {
            e.preventDefault();
            const data = {
                name: document.getElementById('productName').value,
                category: document.getElementById('productCategory').value,
                weight: document.getElementById('productWeight').value,
                purity: document.getElementById('productPurity').value,
                purchasePrice: document.getElementById('productPurchasePrice').value,
                stock: document.getElementById('productStock').value
            };
            
            if (editMode.product) {
                data.id = document.getElementById('productID').value;
                const result = await apiCall('updateProduct', data);
                showAlert('product', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addProduct', data);
                showAlert('product', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('product');
            loadProducts();
        }

        function editProduct(id) {
            const p = dataCache.products.find(item => item.id === id);
            if (!p) return;
            
            document.getElementById('productID').value = p.id;
            document.getElementById('productName').value = p.name;
            document.getElementById('productCategory').value = p.category;
            document.getElementById('productWeight').value = p.weight;
            document.getElementById('productPurity').value = p.purity;
            document.getElementById('productPurchasePrice').value = p.purchase_price;
            document.getElementById('productStock').value = p.stock;
            
            editMode.product = id;
            document.getElementById('productSubmitBtn').textContent = 'Update Product';
            window.scrollTo(0, 0);
        }

        async function deleteProduct(id) {
            if (!confirm('Are you sure you want to delete this product?')) return;
            const result = await apiCall('deleteProduct', {id});
            showAlert('product', result.message, result.success ? 'success' : 'danger');
            loadProducts();
        }

        // INVENTORY OPERATIONS
        async function loadInventory() {
            const result = await apiCall('getInventory');
            if (result.success) {
                dataCache.inventory = result.data;
                renderInventoryTable();
                await loadProducts();
                await loadSuppliers();
            }
        }

        function renderInventoryTable() {
            const tbody = document.querySelector('#inventoryTable tbody');
            tbody.innerHTML = dataCache.inventory.map(inv => `
                <tr>
                    <td>${inv.id}</td>
                    <td>${inv.product_name}</td>
                    <td>${inv.supplier_name}</td>
                    <td>${parseFloat(inv.quantity).toFixed(2)}</td>
                    <td>${parseFloat(inv.available_stock).toFixed(2)}</td>
                    <td>${inv.last_updated}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editInventory('${inv.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteInventory('${inv.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleInventorySubmit(e) {
            e.preventDefault();
            const data = {
                productId: document.getElementById('inventoryProductID').value,
                supplierId: document.getElementById('inventorySupplierID').value,
                quantity: document.getElementById('inventoryQuantity').value,
                availableStock: document.getElementById('inventoryAvailableStock').value,
                lastUpdated: document.getElementById('inventoryLastUpdated').value
            };
            
            if (editMode.inventory) {
                data.id = document.getElementById('inventoryID').value;
                const result = await apiCall('updateInventory', data);
                showAlert('inventory', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addInventory', data);
                showAlert('inventory', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('inventory');
            loadInventory();
        }

        function editInventory(id) {
            const inv = dataCache.inventory.find(item => item.id === id);
            if (!inv) return;
            
            document.getElementById('inventoryID').value = inv.id;
            document.getElementById('inventoryProductID').value = inv.product_id;
            document.getElementById('inventorySupplierID').value = inv.supplier_id;
            document.getElementById('inventoryQuantity').value = inv.quantity;
            document.getElementById('inventoryAvailableStock').value = inv.available_stock;
            document.getElementById('inventoryLastUpdated').value = inv.last_updated.replace(' ', 'T');
            
            editMode.inventory = id;
            document.getElementById('inventorySubmitBtn').textContent = 'Update Inventory';
            window.scrollTo(0, 0);
        }

        async function deleteInventory(id) {
            if (!confirm('Are you sure you want to delete this inventory?')) return;
            const result = await apiCall('deleteInventory', {id});
            showAlert('inventory', result.message, result.success ? 'success' : 'danger');
            loadInventory();
        }

        // BILLS OPERATIONS
        async function loadBills() {
            const result = await apiCall('getBills');
            if (result.success) {
                dataCache.bills = result.data;
                renderBillsTable();
                await loadCustomers();
                await loadEmployees();
                await loadProducts();
            }
        }

        function renderBillsTable() {
            const tbody = document.querySelector('#billsTable tbody');
            tbody.innerHTML = dataCache.bills.map(b => `
                <tr>
                    <td>${b.id}</td>
                    <td>${b.customer_name}</td>
                    <td>${b.employee_name}</td>
                    <td>${b.bill_date}</td>
                    <td>₹${parseFloat(b.subtotal).toFixed(2)}</td>
                    <td>₹${parseFloat(b.gst).toFixed(2)}</td>
                    <td>₹${parseFloat(b.discount).toFixed(2)}</td>
                    <td>₹${parseFloat(b.net_payable).toFixed(2)}</td>
                    <td>${b.payment_method}</td>
                    <td>
                        <button class="action-btn" style="background:#22c55e;color:#fff" onclick="generateBillPDF('${b.id}')">Print</button>
                        <button class="action-btn delete-btn" onclick="deleteBill('${b.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        function showBillForm() {
            document.getElementById('billFormSection').style.display = 'block';
            document.getElementById('billDate').valueAsDate = new Date();
            updateProductDropdowns();
        }

        function hideBillForm() {
            document.getElementById('billFormSection').style.display = 'none';
            cancelEdit('bills');
        }

        function addBillItem() {
            const itemHTML = `
                <div class="bill-item">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Select Product*</label>
                            <select class="billProduct" onchange="updateProductDetails(this)" required>
                                <option value="">Select Product</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Weight (grams)*</label>
                            <input type="number" step="0.01" class="billWeight" readonly>
                        </div>
                        <div class="form-group">
                            <label>Purity*</label>
                            <input type="text" class="billPurity" readonly>
                        </div>
                        <div class="form-group">
                            <label>Gold Price/gram*</label>
                            <input type="number" step="0.01" class="billGoldPrice" readonly>
                        </div>
                        <div class="form-group">
                            <label>Making Charges/gram*</label>
                            <input type="number" step="0.01" class="billMakingCharges" oninput="calculateItemTotal(this)" required>
                        </div>
                        <div class="form-group">
                            <label>Total Price*</label>
                            <input type="number" step="0.01" class="billItemTotal" readonly>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="removeBillItem(this)" style="margin-top:10px;">Remove Item</button>
                </div>
            `;
            document.getElementById('billItemsSection').insertAdjacentHTML('beforeend', itemHTML);
            updateProductDropdowns();
        }

        function removeBillItem(btn) {
            const items = document.querySelectorAll('.bill-item');
            if (items.length > 1) {
                btn.parentElement.remove();
                calculateBillTotal();
            } else {
                alert('At least one product is required!');
            }
        }

        function updateProductDetails(select) {
            const productId = select.value;
            if (!productId) return;
            
            const product = dataCache.products.find(p => p.id === productId);
            if (!product) return;
            
            const item = select.closest('.bill-item');
            item.querySelector('.billWeight').value = product.weight;
            item.querySelector('.billPurity').value = product.purity + 'K';
            item.querySelector('.billGoldPrice').value = product.purchase_price;
            item.querySelector('.billMakingCharges').value = '';
            item.querySelector('.billItemTotal').value = '';
        }

        function calculateItemTotal(input) {
            const item = input.closest('.bill-item');
            const weight = parseFloat(item.querySelector('.billWeight').value) || 0;
            const goldPrice = parseFloat(item.querySelector('.billGoldPrice').value) || 0;
            const makingCharges = parseFloat(item.querySelector('.billMakingCharges').value) || 0;
            
            const total = weight * (goldPrice + makingCharges);
            item.querySelector('.billItemTotal').value = total.toFixed(2);
            
            calculateBillTotal();
        }

        function calculateBillTotal() {
            let subtotal = 0;
            document.querySelectorAll('.bill-item').forEach(item => {
                const itemTotal = parseFloat(item.querySelector('.billItemTotal').value) || 0;
                subtotal += itemTotal;
            });
            
            const gst = subtotal * 0.03;
            const discount = parseFloat(document.getElementById('billDiscount').value) || 0;
            const netPayable = subtotal + gst - discount;
            
            document.getElementById('billSubtotal').textContent = '₹' + subtotal.toFixed(2);
            document.getElementById('billGST').textContent = '₹' + gst.toFixed(2);
            document.getElementById('billNetPayable').textContent = '₹' + netPayable.toFixed(2);
        }

        async function handleBillsSubmit(e) {
            e.preventDefault();
            
            const items = [];
            document.querySelectorAll('.bill-item').forEach(item => {
                const productSelect = item.querySelector('.billProduct');
                if (productSelect.value) {
                    items.push({
                        productId: productSelect.value,
                        productName: productSelect.options[productSelect.selectedIndex].text,
                        weight: item.querySelector('.billWeight').value,
                        purity: item.querySelector('.billPurity').value,
                        goldPrice: item.querySelector('.billGoldPrice').value,
                        makingCharges: item.querySelector('.billMakingCharges').value,
                        itemTotal: item.querySelector('.billItemTotal').value
                    });
                }
            });
            
            if (items.length === 0) {
                alert('Please add at least one product to the bill!');
                return;
            }
            
            const subtotal = parseFloat(document.getElementById('billSubtotal').textContent.replace('₹', ''));
            const gst = parseFloat(document.getElementById('billGST').textContent.replace('₹', ''));
            const discount = parseFloat(document.getElementById('billDiscount').value) || 0;
            const netPayable = parseFloat(document.getElementById('billNetPayable').textContent.replace('₹', ''));
            
            const data = {
                customerId: document.getElementById('billCustomerID').value,
                employeeId: document.getElementById('billEmployeeID').value,
                billDate: document.getElementById('billDate').value,
                items: JSON.stringify(items),
                subtotal: subtotal.toFixed(2),
                gst: gst.toFixed(2),
                discount: discount.toFixed(2),
                netPayable: netPayable.toFixed(2),
                paymentMethod: document.getElementById('billPaymentMethod').value
            };
            
            const result = await apiCall('addBill', data);
            showAlert('bills', result.message, result.success ? 'success' : 'danger');
            
            if (result.success) {
                // Show notification about invoice creation
                showNotification('Invoice created successfully! Bill ID: ' + result.data.id, 'success');
                hideBillForm();
                loadBills();
            } else {
                showNotification('Failed to create invoice: ' + result.message, 'error');
            }
        }

        async function deleteBill(id) {
            if (!confirm('Are you sure you want to delete this bill?')) return;
            const result = await apiCall('deleteBill', {id});
            showAlert('bills', result.message, result.success ? 'success' : 'danger');
            loadBills();
        }

        function generateBillPDF(billId) {
            // Redirect to invoice.php
            const invoiceUrl = `invoice.php?billId=${encodeURIComponent(billId)}`;
            
            // Construct full URL
            let fullUrl;
            const currentPath = window.location.pathname;
            
            if (currentPath.includes('/NUTAN/')) {
                fullUrl = window.location.origin + '/NUTAN/' + invoiceUrl;
            } else {
                // Get base path from current location
                const basePath = currentPath.substring(0, currentPath.lastIndexOf('/') + 1);
                fullUrl = window.location.origin + basePath + invoiceUrl;
            }
            
            // Try to open in system browser using pywebview API first
            if (window.pywebview && window.pywebview.api && typeof window.pywebview.api.open_browser === 'function') {
                try {
                    window.pywebview.api.open_browser(fullUrl);
                    return;
                } catch (e) {
                    console.log('Pywebview API failed, using window.open:', e);
                }
            }
            
            // Open in new window/tab (will open in system browser)
            window.open(fullUrl, '_blank');
        }

        // REGULAR ORDERS
        async function loadRegularOrders() {
            const result = await apiCall('getRegularOrders');
            if (result.success) {
                dataCache.regularOrders = result.data;
                renderRegularOrderTable();
            }
        }

        function renderRegularOrderTable() {
            const tbody = document.querySelector('#regularOrderTable tbody');
            tbody.innerHTML = dataCache.regularOrders.map(o => `
                <tr>
                    <td>${o.id}</td>
                    <td>${o.customer_name}</td>
                    <td>${o.employee_name}</td>
                    <td>${o.order_date}</td>
                    <td>${parseFloat(o.weight).toFixed(2)}</td>
                    <td>₹${parseFloat(o.amount).toFixed(2)}</td>
                    <td>${o.payment_method}</td>
                    <td>${o.status}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editRegularOrder('${o.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteRegularOrder('${o.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleRegularOrderSubmit(e) {
            e.preventDefault();
            const data = {
                customerId: document.getElementById('orderCustomerID').value,
                employeeId: document.getElementById('orderEmployeeID').value,
                orderDate: document.getElementById('orderDate').value,
                weight: document.getElementById('orderWeight').value,
                amount: document.getElementById('orderAmount').value,
                paymentMethod: document.getElementById('orderPaymentMethod').value,
                status: document.getElementById('orderStatus').value
            };
            
            if (editMode.regularOrder) {
                data.id = document.getElementById('orderID').value;
                const result = await apiCall('updateRegularOrder', data);
                showAlert('order', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addRegularOrder', data);
                showAlert('order', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('regularOrder');
            loadRegularOrders();
        }

        function editRegularOrder(id) {
            const o = dataCache.regularOrders.find(item => item.id === id);
            if (!o) return;
            
            document.getElementById('orderID').value = o.id;
            document.getElementById('orderCustomerID').value = o.customer_id;
            document.getElementById('orderEmployeeID').value = o.employee_id;
            document.getElementById('orderDate').value = o.order_date;
            document.getElementById('orderWeight').value = o.weight;
            document.getElementById('orderAmount').value = o.amount;
            document.getElementById('orderPaymentMethod').value = o.payment_method;
            document.getElementById('orderStatus').value = o.status;
            
            editMode.regularOrder = id;
            document.getElementById('regularOrderSubmitBtn').textContent = 'Update Order';
            window.scrollTo(0, 0);
        }

        async function deleteRegularOrder(id) {
            if (!confirm('Are you sure you want to delete this order?')) return;
            const result = await apiCall('deleteRegularOrder', {id});
            showAlert('order', result.message, result.success ? 'success' : 'danger');
            loadRegularOrders();
        }

        // ADVANCE ORDERS
        async function loadAdvanceOrders() {
            const result = await apiCall('getAdvanceOrders');
            if (result.success) {
                dataCache.advanceOrders = result.data;
                renderAdvanceOrderTable();
            }
        }

        function renderAdvanceOrderTable() {
            const tbody = document.querySelector('#advanceOrderTable tbody');
            tbody.innerHTML = dataCache.advanceOrders.map(o => `
                <tr>
                    <td>${o.id}</td>
                    <td>${o.customer_name}</td>
                    <td>${o.employee_name}</td>
                    <td>${o.order_date}</td>
                    <td>${o.delivery_date}</td>
                    <td>${parseFloat(o.weight).toFixed(2)}</td>
                    <td>₹${parseFloat(o.amount).toFixed(2)}</td>
                    <td>₹${parseFloat(o.advance_paid).toFixed(2)}</td>
                    <td>${o.payment_method}</td>
                    <td>${o.status}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editAdvanceOrder('${o.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteAdvanceOrder('${o.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleAdvanceOrderSubmit(e) {
            e.preventDefault();
            const data = {
                customerId: document.getElementById('advanceCustomerID').value,
                employeeId: document.getElementById('advanceEmployeeID').value,
                orderDate: document.getElementById('advanceOrderDate').value,
                deliveryDate: document.getElementById('advanceDeliveryDate').value,
                weight: document.getElementById('advanceWeight').value,
                amount: document.getElementById('advanceAmount').value,
                advancePaid: document.getElementById('advancePaid').value,
                paymentMethod: document.getElementById('advancePaymentMethod').value,
                status: document.getElementById('advanceStatus').value
            };
            
            if (editMode.advanceOrder) {
                data.id = document.getElementById('advanceOrderID').value;
                const result = await apiCall('updateAdvanceOrder', data);
                showAlert('order', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addAdvanceOrder', data);
                showAlert('order', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('advanceOrder');
            loadAdvanceOrders();
        }

        function editAdvanceOrder(id) {
            const o = dataCache.advanceOrders.find(item => item.id === id);
            if (!o) return;
            
            document.getElementById('advanceOrderID').value = o.id;
            document.getElementById('advanceCustomerID').value = o.customer_id;
            document.getElementById('advanceEmployeeID').value = o.employee_id;
            document.getElementById('advanceOrderDate').value = o.order_date;
            document.getElementById('advanceDeliveryDate').value = o.delivery_date;
            document.getElementById('advanceWeight').value = o.weight;
            document.getElementById('advanceAmount').value = o.amount;
            document.getElementById('advancePaid').value = o.advance_paid;
            document.getElementById('advancePaymentMethod').value = o.payment_method;
            document.getElementById('advanceStatus').value = o.status;
            
            editMode.advanceOrder = id;
            document.getElementById('advanceOrderSubmitBtn').textContent = 'Update Advance Order';
            window.scrollTo(0, 0);
        }

        async function deleteAdvanceOrder(id) {
            if (!confirm('Are you sure you want to delete this advance order?')) return;
            const result = await apiCall('deleteAdvanceOrder', {id});
            showAlert('order', result.message, result.success ? 'success' : 'danger');
            loadAdvanceOrders();
        }

        // VYAJ ORDERS
        async function loadVyajOrders() {
            const result = await apiCall('getVyajOrders');
            if (result.success) {
                dataCache.vyajOrders = result.data;
                renderVyajOrderTable();
            }
        }

        function renderVyajOrderTable() {
            const tbody = document.querySelector('#vyajOrderTable tbody');
            tbody.innerHTML = dataCache.vyajOrders.map(o => `
                <tr>
                    <td>${o.id}</td>
                    <td>${o.customer_name}</td>
                    <td>${o.order_date}</td>
                    <td>${o.due_date}</td>
                    <td>${parseFloat(o.weight).toFixed(2)}</td>
                    <td>₹${parseFloat(o.base_amount).toFixed(2)}</td>
                    <td>${parseFloat(o.vyaj_rate).toFixed(2)}%</td>
                    <td>₹${parseFloat(o.total_price).toFixed(2)}</td>
                    <td>₹${parseFloat(o.paid_amount).toFixed(2)}</td>
                    <td>${o.payment_status}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editVyajOrder('${o.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteVyajOrder('${o.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleVyajOrderSubmit(e) {
            e.preventDefault();
            const data = {
                customerId: document.getElementById('vyajCustomerID').value,
                employeeId: document.getElementById('vyajEmployeeID').value,
                orderDate: document.getElementById('vyajOrderDate').value,
                dueDate: document.getElementById('vyajDueDate').value,
                weight: document.getElementById('vyajWeight').value,
                baseAmount: document.getElementById('vyajBaseAmount').value,
                vyajRate: document.getElementById('vyajRate').value,
                vyajAmount: document.getElementById('vyajAmount').value,
                month1: document.getElementById('vyajMonth1').value,
                month2: document.getElementById('vyajMonth2').value,
                month3: document.getElementById('vyajMonth3').value,
                totalPrice: document.getElementById('vyajTotalPrice').value,
                paidAmount: document.getElementById('vyajPaidAmount').value,
                paymentStatus: document.getElementById('vyajPaymentStatus').value
            };
            
            if (editMode.vyajOrder) {
                data.id = document.getElementById('vyajOrderID').value;
                const result = await apiCall('updateVyajOrder', data);
                showAlert('order', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addVyajOrder', data);
                showAlert('order', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('vyajOrder');
            loadVyajOrders();
        }

        function editVyajOrder(id) {
            const o = dataCache.vyajOrders.find(item => item.id === id);
            if (!o) return;
            
            document.getElementById('vyajOrderID').value = o.id;
            document.getElementById('vyajCustomerID').value = o.customer_id;
            document.getElementById('vyajEmployeeID').value = o.employee_id;
            document.getElementById('vyajOrderDate').value = o.order_date;
            document.getElementById('vyajDueDate').value = o.due_date;
            document.getElementById('vyajWeight').value = o.weight;
            document.getElementById('vyajBaseAmount').value = o.base_amount;
            document.getElementById('vyajRate').value = o.vyaj_rate;
            document.getElementById('vyajAmount').value = o.vyaj_amount;
            document.getElementById('vyajMonth1').value = o.month1_payment;
            document.getElementById('vyajMonth2').value = o.month2_payment;
            document.getElementById('vyajMonth3').value = o.month3_payment;
            document.getElementById('vyajTotalPrice').value = o.total_price;
            document.getElementById('vyajPaidAmount').value = o.paid_amount;
            document.getElementById('vyajPaymentStatus').value = o.payment_status;
            
            editMode.vyajOrder = id;
            document.getElementById('vyajOrderSubmitBtn').textContent = 'Update Vyaj Order';
            window.scrollTo(0, 0);
        }

        async function deleteVyajOrder(id) {
            if (!confirm('Are you sure you want to delete this vyaj order?')) return;
            const result = await apiCall('deleteVyajOrder', {id});
            showAlert('order', result.message, result.success ? 'success' : 'danger');
            loadVyajOrders();
        }

        // GOLD SALES
        async function loadGoldSales() {
            const result = await apiCall('getGoldSales');
            if (result.success) {
                dataCache.goldSales = result.data;
                renderGoldsaleTable();
                await loadCustomers();
                await loadProducts();
            }
        }

        function renderGoldsaleTable() {
            const tbody = document.querySelector('#goldsaleTable tbody');
            tbody.innerHTML = dataCache.goldSales.map(g => `
                <tr>
                    <td>${g.id}</td>
                    <td>${g.customer_name}</td>
                    <td>${g.product_name}</td>
                    <td>${parseFloat(g.quantity).toFixed(2)}</td>
                    <td>${g.purity}K</td>
                    <td>${g.getting_date}</td>
                    <td>₹${parseFloat(g.total_amount).toFixed(2)}</td>
                    <td>₹${parseFloat(g.payment_to_customer).toFixed(2)}</td>
                    <td>${g.payment_method}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="editGoldsale('${g.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteGoldsale('${g.id}')">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function handleGoldsaleSubmit(e) {
            e.preventDefault();
            const data = {
                customerId: document.getElementById('goldCustomerID').value,
                productId: document.getElementById('goldProductID').value,
                quantity: document.getElementById('goldQuantity').value,
                purity: document.getElementById('goldPurity').value,
                gettingDate: document.getElementById('goldGettingDate').value,
                totalAmount: document.getElementById('goldTotalAmount').value,
                paymentCustomer: document.getElementById('goldPaymentCustomer').value,
                paymentMethod: document.getElementById('goldPaymentMethod').value
            };
            
            if (editMode.goldsale) {
                data.id = document.getElementById('goldSaleID').value;
                const result = await apiCall('updateGoldSale', data);
                showAlert('goldsale', result.message, result.success ? 'success' : 'danger');
            } else {
                const result = await apiCall('addGoldSale', data);
                showAlert('goldsale', result.message, result.success ? 'success' : 'danger');
            }
            
            cancelEdit('goldsale');
            loadGoldSales();
        }

        function editGoldsale(id) {
            const g = dataCache.goldSales.find(item => item.id === id);
            if (!g) return;
            
            document.getElementById('goldSaleID').value = g.id;
            document.getElementById('goldCustomerID').value = g.customer_id;
            document.getElementById('goldProductID').value = g.product_id;
            document.getElementById('goldQuantity').value = g.quantity;
            document.getElementById('goldPurity').value = g.purity;
            document.getElementById('goldGettingDate').value = g.getting_date;
            document.getElementById('goldTotalAmount').value = g.total_amount;
            document.getElementById('goldPaymentCustomer').value = g.payment_to_customer;
            document.getElementById('goldPaymentMethod').value = g.payment_method;
            
            editMode.goldsale = id;
            document.getElementById('goldsaleSubmitBtn').textContent = 'Update Gold Sale';
            window.scrollTo(0, 0);
        }

        async function deleteGoldsale(id) {
            if (!confirm('Are you sure you want to delete this gold sale?')) return;
            const result = await apiCall('deleteGoldSale', {id});
            showAlert('goldsale', result.message, result.success ? 'success' : 'danger');
            loadGoldSales();
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCustomers();
        });
    </script>
</body>
</html>