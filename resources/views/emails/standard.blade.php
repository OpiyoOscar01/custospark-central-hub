<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .email-header {
            background-color: #2451ce;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }

        .email-header img {
            max-height: 50px;
            margin-bottom: 8px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .email-body {
            padding: 36px 28px;
            font-size: 16px;
            line-height: 1.75;
            color: #111827;
        }

        .email-body p {
            margin-bottom: 1em;
        }

        .cta-button {
            display: inline-block;
            margin: 24px 0;
            padding: 12px 24px;
            background-color: #1d4ed8;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .cta-button:hover {
            background-color: #1e40af;
        }

        .email-tip {
            background-color: #f0f9ff;
            border-left: 4px solid #38bdf8;
            padding: 16px;
            margin: 24px 0;
            border-radius: 6px;
            font-size: 14px;
            color: #0369a1;
        }

        .email-footer {
            background-color:#2451ce ;
            padding: 24px;
            text-align: center;
            font-size: 13px;
            color: white;
            border-top: 1px solid #e5e7eb;
        }


        @media only screen and (max-width: 620px) {
            .email-container {
                margin: 20px 10px;
            }

            .email-body {
                padding: 24px 16px;
            }

            .email-header h1 {
                font-size: 20px;
            }
        }
        .logo-rounded {
            border-radius: 50%;
            max-height: 60px;
            margin-bottom: 8px;
            background-color: white;
        }

        .tagline-italic {
            font-style: italic;
            font-size: 13px;
            color: #dbeafe;
            margin-bottom: 5px;
        }
            .brand-name {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 4px;
    }

    </style>
</head>
<body>
 <div class="email-header">
    <img src="{{ $message->embed($logoPath) }}" alt="Custospark Logo" class="logo-rounded">
    <div class="brand-name">Custospark</div>
    <div class="tagline-italic">PowerHouse of Innovations</div>
    <h1>{{ $title }}</h1>
</div>



        <!-- Body -->
        <div class="email-body">
            <p>{!! nl2br(e($mailBody)) !!}</p>

            @isset($tip)
                <div class="email-tip">
                    {{ $tip }}
                </div>
            @endisset

            @isset($ctaUrl)
                <p style="text-align: center;">
                    <a href="{{ $ctaUrl }}" class="cta-button" target="_blank" rel="noopener noreferrer">
                        {{ $ctaLabel ?? 'Take Action' }}
                    </a>
                </p>
            @endisset
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>This message was sent to you by <strong>Custospark</strong> — the PowerHouse of Innovations.</p>
            <p>&copy; {{ now()->year }} Custospark Company Ltd. All rights reserved.</p>
        </div>
    </div>
</body>
</html>



