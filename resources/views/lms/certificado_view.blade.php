<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado - {{ $certificado->course->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Pinyon+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Playfair Display', serif;
        }
        .certificate-container {
            width: 1123px;
            height: 794px; /* A4 Landscape at 96 DPI */
            background-color: white;
            position: relative;
            box-sizing: border-box;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        /* Outer Blue Border */
        .border-outer {
            position: absolute;
            top: 30px;
            bottom: 30px;
            left: 30px;
            right: 30px;
            border: 20px solid #2953ff; /* Vivid blue */
            box-sizing: border-box;
        }
        /* Inner Gray Border with dashed line */
        .border-inner {
            position: absolute;
            top: 65px;
            bottom: 65px;
            left: 65px;
            right: 65px;
            border: 6px solid #8c8c8c;
            box-sizing: border-box;
        }
        .border-inner::before {
            content: '';
            position: absolute;
            top: 5px; bottom: 5px; left: 5px; right: 5px;
            border: 2px dashed #b3b3b3;
            pointer-events: none;
        }
        /* Corner Stars */
        .corner {
            position: absolute;
            width: 50px;
            height: 50px;
            background-color: #8c8c8c;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }
        .corner-tl { top: -6px; left: -6px; }
        .corner-tr { top: -6px; right: -6px; }
        .corner-bl { bottom: -6px; left: -6px; }
        .corner-br { bottom: -6px; right: -6px; }

        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 40px 80px;
            height: 100%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .badge-icon {
            color: #1b3d87;
            font-size: 45px;
            margin-bottom: 10px;
        }
        
        h1.title {
            font-size: 65px;
            font-weight: 700;
            color: #1b3d87;
            margin: 0;
            letter-spacing: 5px;
            text-transform: uppercase;
        }
        h2.subtitle {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin: 10px 0 30px 0;
            letter-spacing: 4px;
            text-transform: uppercase;
        }
        
        .certify-text {
            font-size: 22px;
            font-weight: 700;
            color: #000;
            margin-bottom: 20px;
        }
        
        .student-name {
            font-family: 'Pinyon Script', cursive;
            font-size: 80px;
            color: #1b3d87;
            margin: 0;
            line-height: 1;
            padding-bottom: 15px;
            border-bottom: 1px solid #1b3d87;
            display: inline-block;
            min-width: 60%;
        }
        
        .description {
            font-size: 22px;
            color: #000;
            margin: 30px auto;
            max-width: 80%;
            line-height: 1.5;
        }
        .description strong {
            font-weight: 700;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 0 40px;
        }

        .signature {
            text-align: center;
            width: 250px;
        }
        /* Fake signature fonts just to make it look like the image if we don't have images */
        .signature-img {
            font-family: 'Pinyon Script', cursive;
            font-size: 40px;
            color: #333;
            line-height: 0.5;
            margin-bottom: 5px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin: 0 auto 5px auto;
            width: 100%;
        }
        .signature p {
            margin: 0;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: bold;
            color: #000;
        }
        .signature span {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        .qr-code {
            text-align: center;
        }
        .qr-code img {
            width: 90px;
            height: 90px;
        }

        /* Faint Background Watermark Logo */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            font-size: 400px;
            color: #1b3d87;
            z-index: 0;
            pointer-events: none;
        }

        @media print {
            body { background: none; margin: 0; padding: 0; }
            .certificate-container { box-shadow: none; border: none; padding: 0; }
            @page { size: A4 landscape; margin: 0; }
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #1b3d87;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 1000;
        }
        @media print {
            .print-btn { display: none; }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()"><i class="fa-solid fa-print"></i> Imprimir / PDF</button>

    <div class="certificate-container">
        <!-- Background Logo Watermark -->
        <i class="fa-solid fa-graduation-cap watermark"></i>

        <div class="border-outer"></div>
        <div class="border-inner">
            <div class="corner corner-tl"><i class="fa-solid fa-star"></i></div>
            <div class="corner corner-tr"><i class="fa-solid fa-star"></i></div>
            <div class="corner corner-bl"><i class="fa-solid fa-star"></i></div>
            <div class="corner corner-br"><i class="fa-solid fa-star"></i></div>
        </div>

        <div class="content">
            <div class="badge-icon"><i class="fa-solid fa-award"></i></div>
            <h1 class="title">CERTIFICADO</h1>
            <h2 class="subtitle">DE CONCLUSÃO</h2>

            <div class="certify-text">Certificamos que:</div>
            
            <div class="student-name">{{ $certificado->user->name }}</div>
            
            <div class="description">
                Concluiu no dia {{ $certificado->created_at->format('d/m/Y') }} o Curso/Treinamento:<br>
                <strong>{{ $certificado->course->title }}</strong>, com uma carga<br>
                horária de {{ $totalHours }} horas.
            </div>

            <div class="footer">
                <div class="signature">
                    <!-- Simulando a assinatura esquerda -->
                    <div class="signature-img" style="transform: rotate(-10deg);">Magalhães</div>
                    <div class="signature-line"></div>
                    <p>Magalhães Lemos</p>
                    <span>Asoftmedia</span>
                </div>
                
                <div class="qr-code">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('lms.certificados.show', $certificado->certificate_code)) }}" alt="QR Code">
                </div>
                
                <div class="signature">
                    <!-- Simulando a assinatura direita -->
                    <div class="signature-img" style="transform: rotate(-15deg);">Pinheiro</div>
                    <div class="signature-line"></div>
                    <p>Laurindo Pinheiro</p>
                    <span>Asoftmedia</span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
