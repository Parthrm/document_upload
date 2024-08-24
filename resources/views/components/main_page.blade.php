<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document Upload</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <script src="jquery-3.7.1.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="flex justify-center bg-purple-400" >
        <nav class="w-3/4 flex justify-around m-2">
            <a href="/upload" class="text-lg bg-white rounded-lg transition-all duration-200  p-3 border-2 border-black border-solid font-bold hover:bg-black hover:text-white hover:scale-110">Create Document</a>
            <a href="/index" class="text-lg bg-white rounded-lg transition-all duration-200 p-3 border-2 border-black border-solid font-bold hover:bg-black hover:text-white hover:scale-110">All Documents</a>
            <a href="/successStory" class="text-lg bg-white rounded-lg transition-all duration-200 p-3 border-2 border-black border-solid font-bold hover:bg-black hover:text-white hover:scale-110">All Stories</a>
            <a href="/makeStory" class="text-lg bg-white rounded-lg transition-all duration-200 p-3 border-2 border-black border-solid font-bold hover:bg-black hover:text-white hover:scale-110">Create Story</a>
            <a href="/chart-editor" class="text-lg bg-white rounded-lg transition-all duration-200 p-3 border-2 border-black border-solid font-bold hover:bg-black hover:text-white hover:scale-110">Chart Editor</a>
            <a href="/generate-report" class="text-lg bg-white rounded-lg transition-all duration-200 p-3 border-2 border-black border-solid font-bold hover:bg-black hover:text-white hover:scale-110">Report Editor</a>
        </nav>
    </div>
    <div class="flex-row-reverse"></div>
    <main class="">
        {{$slot}}
    </main>
    <x-flash_message/>
</body>
</html>