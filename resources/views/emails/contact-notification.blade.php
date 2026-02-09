<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Sarabun', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .info {
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #d4af37;
        }
        .label {
            font-weight: bold;
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #555;
        }
        .details-box {
            background: white;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
            white-space: pre-wrap;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #eee;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">📧</div>
            <h2>ข้อความติดต่อใหม่</h2>
            <p>PJS Law and Accounting Co., Ltd.</p>
        </div>
        
        <div class="content">
            <p style="color: #2c3e50; font-size: 16px; margin-bottom: 20px;">
                <strong>มีลูกค้าส่งแบบฟอร์มติดต่อเข้ามาใหม่</strong>
            </p>
            
            <div class="info">
                <span class="label">👤 ชื่อ-นามสกุล:</span>
                <span class="value">{{ $contact->name }}</span>
            </div>
            
            <div class="info">
                <span class="label">📱 เบอร์โทรศัพท์:</span>
                <span class="value"><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></span>
            </div>
            
            @if($contact->email)
            <div class="info">
                <span class="label">📧 อีเมล:</span>
                <span class="value"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></span>
            </div>
            @endif
            
            <div class="info">
                <span class="label">📋 หัวข้อ:</span>
                <span class="value">{{ $contact->subject }}</span>
            </div>
            
            <div class="info">
                <span class="label">💬 รายละเอียด:</span>
                <div class="details-box">{{ $contact->details }}</div>
            </div>
            
            <div class="info">
                <span class="label">🕐 วันที่-เวลา:</span>
                <span class="value">{{ $contact->created_at->format('d/m/Y H:i น.') }}</span>
            </div>
        </div>
        
        <div class="footer">
            <p>อีเมลนี้ส่งอัตโนมัติจากระบบแบบฟอร์มติดต่อเว็บไซต์</p>
            <p><strong>PJS Law and Accounting Co., Ltd.</strong></p>
            <p>27/20 Soi Bang Bon 4, Soi 4, Bang Bon, Bangkok 10150</p>
        </div>
    </div>
</body>
</html>