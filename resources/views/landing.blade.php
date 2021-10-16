<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@800&family=PT+Sans&display=swap"
        rel="stylesheet">

    <style>
        .open-sans {
            font-family: 'Open Sans', serif;
        }

        .pt-sans {
            font-family: 'PT Sans', serif;
        }

        .brand-text {
            color: white;
            text-shadow: 0 0 20px black, 0 0 20px black;
        }
    </style>
</head>
{{--  --}}
<body>
    <div class=" mx-auto h-screen bg-cover" style="background-image: url('{{ asset('images/landing-background-img-ii.jpg') }}');">
        <div class="
            flex flex-col justify-center items-center h-screen">
            <div class="
                open-sans brand-text text-6xl extra-bold text-center tracking-tighter
                md:text-8xl
                lg:text-9xl">
                La Restaurant
            </div>
            <div class="
                brand-text pt-sans italic text-center text-xl mt-6">Satisfy your cravings!</div>

            <a href="/signin" class="
                open-sans text-xl extra-bold tracking-widest bg-blue-500 text-white text-center px-16 py-4 mt-8 cursor-pointer
                hover:shadow-lg transition duration-500 ease-in-out transform hover:scale-105">
                ORDER NOW
            </a>
        </div>
    </div>
</body>

</html>
