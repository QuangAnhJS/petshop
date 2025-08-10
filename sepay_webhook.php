<?php

/* 
File sepay_webhook.php
File này dùng làm endpoint nhận webhook từ SePay. Mỗi khi có giao dịch SePay sẽ bắn webhook về và chúng ta sẽ lưu thông tin giao dịch vào CSDL. Đồng thời bóc tách ID đơn hàng từ nội dung thanh toán. Sau khi tìm được ID đơn hàng thì cập nhật trạng thái thanh toán của đơn hàng thành đã thanh toán (payment_status=Paid).
 Xem hướng dẫn tạo tích hợp Webhook phía SePay tại https://docs.sepay.vn/tich-hop-webhooks.html
 Endpoint nhận webhook sẽ là https://yourwebsite.tld/sepay_webhook.php
*/

// Include file config.php chứa kết nối CSDL
require_once './sytem/config.php';

// Lấy dữ liệu từ webhook (json body)
$data = json_decode(file_get_contents('php://input'));
if (!is_object($data)) {
    echo json_encode(['success' => false, 'message' => 'No data']);
    die('No data found!');
}

// Khởi tạo các biến từ dữ liệu webhook
$gateway = $data->gateway;
$transaction_date = $data->transactionDate;
$account_number = $data->accountNumber;
$sub_account = $data->subAccount;

$transfer_type = $data->transferType;
$transfer_amount = $data->transferAmount;
$accumulated = $data->accumulated;

$code = $data->code;
$transaction_content = $data->content;
$reference_number = $data->referenceCode;
$body = $data->description;

$amount_in = 0;
$amount_out = 0;

// Kiểm tra giao dịch tiền vào hay tiền ra
if ($transfer_type == "in") {
    $amount_in = $transfer_amount;
} else if ($transfer_type == "out") {
    $amount_out = $transfer_amount;
}

// Tạo câu SQL lưu giao dịch vào CSDL
$sql = "INSERT INTO tb_transactions (gateway, transaction_date, account_number, sub_account, amount_in, amount_out, accumulated, code, transaction_content, reference_number, body) 
        VALUES ('{$gateway}', '{$transaction_date}', '{$account_number}', '{$sub_account}', '{$amount_in}', '{$amount_out}', '{$accumulated}', '{$code}', '{$transaction_content}', '{$reference_number}', '{$body}')";

// Thực hiện lưu giao dịch
if ($conn->query($sql) !== TRUE) {
    echo json_encode(['success' => false, 'message' => 'Cannot insert record to MySQL: ' . $conn->error]);
    die();
}

// Biểu thức regex để khớp với mã đơn hàng (ví dụ: DH123456)
$regex = '/DH(\d+)/';

// Tìm mã đơn hàng trong nội dung chuyển tiền
if (preg_match($regex, $transaction_content, $matches)) {
    $pay_order_id = $matches[1];

    // Kiểm tra mã đơn hàng có phải số không
    if (!is_numeric($pay_order_id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid order ID format']);
        die();
    }

    // Tìm đơn hàng theo ID, số tiền và trạng thái chưa thanh toán
    $result = $conn->query("SELECT * FROM tb_orders WHERE id={$pay_order_id} AND total={$amount_in} AND payment_status='Unpaid'");

    if ($result && $result->num_rows > 0) {
        // Cập nhật trạng thái đơn hàng thành đã thanh toán
        $update = $conn->query("UPDATE tb_orders SET payment_status='Paid' WHERE id={$pay_order_id}");

        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found or already paid']);
    }
} else {
    // Không tìm thấy mã đơn hàng trong nội dung giao dịch
    echo json_encode(['success' => false, 'message' => 'Order ID not found in transaction content']);
}

die();
