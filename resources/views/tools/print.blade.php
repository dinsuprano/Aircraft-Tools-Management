<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Barcode - {{ $tool->barcode }}</title>
    
    <!-- Using Tailwind via CDN for quick styling of the print layout -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Print-specific styling */
        @media print {
            @page {
                margin: 0;
                /* Optional: set explicit size for label printers, e.g. size: 2in 1in; */
            }
            body {
                margin: 0.5cm;
            }
            .no-print {
                display: none !important;
            }
        }

        /* Make sure SVG renders black for printing */
        svg {
            width: 100%;
            height: auto;
            max-height: 80px;
        }
        svg rect {
            fill: #000;
        }
    </style>
</head>
<body class="bg-white text-black font-sans antialiased min-h-screen flex flex-col items-center justify-center p-8">

    {{-- Print Controls (Hidden when printing) --}}
    <div class="no-print absolute top-8 text-center w-full max-w-sm">
        <div class="mb-4 text-slate-500 text-sm">
            Press the button below to print this label. Make sure your label printer is selected in the print dialog.
        </div>
        <div class="flex gap-3 justify-center">
            <button onclick="window.print()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-colors">
                Print Label
            </button>
            <button onclick="window.close()" class="px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-800 font-medium rounded-lg transition-colors">
                Close
            </button>
        </div>
    </div>

    {{-- The Actual Label to Print --}}
    <div class="border border-black p-4 inline-block w-full max-w-[250px] text-center">
        <div class="font-bold text-sm uppercase tracking-wide mb-2 truncate" title="{{ $tool->name }}">
            {{ $tool->name }}
        </div>
        
        <div class="mb-1 w-full flex justify-center">
            {!! $barcodeSvg !!}
        </div>
        
        <div class="font-mono text-xs tracking-widest mt-1 font-semibold">
            {{ $tool->barcode }}
        </div>
    </div>

    <script>
        // Automatically open the print dialog when the page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
