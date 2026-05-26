<?php
require_once 'config.php';
// Don't require full authentication for invoice viewing
// This allows invoice to be opened in new browser window for printing/saving PDF
session_start();

$billId = isset($_GET['billId']) ? sanitizeInput($_GET['billId']) : '';

if (empty($billId)) {
    die('Bill ID is required');
}

$conn = getDBConnection();

// Get bill details
$sql = "SELECT b.*, c.name as customer_name, c.phone as customer_phone, c.email as customer_email, c.address as customer_address,
        e.name as employee_name
        FROM bills b 
        JOIN customers c ON b.customer_id = c.id 
        JOIN employees e ON b.employee_id = e.id 
        WHERE b.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $billId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Bill not found');
}

$bill = $result->fetch_assoc();

// Get bill items
$itemsSql = "SELECT * FROM bill_items WHERE bill_id = ?";
$itemsStmt = $conn->prepare($itemsSql);
$itemsStmt->bind_param("s", $billId);
$itemsStmt->execute();
$itemsResult = $itemsStmt->get_result();
$items = [];
while ($row = $itemsResult->fetch_assoc()) {
    $items[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice - <?php echo htmlspecialchars($bill['id']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #667eea;
            margin: 0 0 10px 0;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .bill-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        .info-section h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
        }
        .info-section p {
            margin: 5px 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        .totals {
            margin-top: 30px;
            text-align: right;
        }
        .totals table {
            margin-left: auto;
            width: 350px;
        }
        .totals td {
            padding: 8px;
        }
        .totals .total-row {
            font-weight: bold;
            font-size: 18px;
            background: #f0f0f0;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
        }
        .print-btn {
            background: #667eea;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px 0;
        }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>💎 GOLD SHOP</h1>
        <p>Complete Jewelry Business Management</p>
        <p>Phone: +91 98765 43210 | Email: info@goldshop.com</p>
    </div>
    <div style="text-align:center;margin-bottom:30px;">
        <h2 style="color:#667eea;margin:0;">INVOICE</h2>
        <p style="color:#666;">Bill ID: <?php echo htmlspecialchars($bill['id']); ?></p>
    </div>
    <div class="bill-info">
        <div class="info-section">
            <h3>Bill To:</h3>
            <p><strong><?php echo htmlspecialchars($bill['customer_name']); ?></strong></p>
            <p>Customer ID: <?php echo htmlspecialchars($bill['customer_id']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($bill['customer_phone']); ?></p>
            <p>Email: <?php echo htmlspecialchars($bill['customer_email']); ?></p>
            <p>Address: <?php echo htmlspecialchars($bill['customer_address']); ?></p>
        </div>
        <div class="info-section">
            <h3>Bill Details:</h3>
            <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($bill['bill_date'])); ?></p>
            <p><strong>Employee:</strong> <?php echo htmlspecialchars($bill['employee_name']); ?></p>
            <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($bill['employee_id']); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($bill['payment_method']); ?></p>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th style="text-align:center;">Weight</th>
                <th style="text-align:center;">Purity</th>
                <th style="text-align:right;">Gold Price/g</th>
                <th style="text-align:right;">Making/g</th>
                <th style="text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                <td style="text-align:center;"><?php echo number_format($item['weight'], 2); ?>g</td>
                <td style="text-align:center;"><?php echo htmlspecialchars($item['purity']); ?></td>
                <td style="text-align:right;">₹<?php echo number_format($item['gold_price'], 2); ?></td>
                <td style="text-align:right;">₹<?php echo number_format($item['making_charges'], 2); ?></td>
                <td style="text-align:right;">₹<?php echo number_format($item['item_total'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td style="text-align:right;">₹<?php echo number_format($bill['subtotal'], 2); ?></td>
            </tr>
            <tr>
                <td>GST (3%):</td>
                <td style="text-align:right;">₹<?php echo number_format($bill['gst'], 2); ?></td>
            </tr>
            <tr>
                <td>Discount:</td>
                <td style="text-align:right;">- ₹<?php echo number_format($bill['discount'], 2); ?></td>
            </tr>
            <tr class="total-row">
                <td>Net Payable:</td>
                <td style="text-align:right;">₹<?php echo number_format($bill['net_payable'], 2); ?></td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <p><strong>Thank you for your business!</strong></p>
        <p>This is a computer generated invoice.</p>
        <p style="margin-top:20px;font-size:12px;">Terms & Conditions Apply | For any queries, please contact us.</p>
    </div>
    <div style="text-align:center;">
        <button class="print-btn" onclick="window.print()">Print Bill</button>
        <button class="print-btn" onclick="saveAsPDF()" style="background:#22c55e;margin-left:10px;">Save as PDF</button>
    </div>
    
    <script>
        function saveAsPDF() {
            // Use browser's print dialog to save as PDF
            window.print();
        }
        
        // Auto-focus print dialog for better PDF saving experience
        window.onload = function() {
            // Optional: You can add any initialization here
        };
    </script>
</body>
</html>

