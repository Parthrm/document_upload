<x-main_page>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.bubble.css" />
            
    <div class="flex justify-center m-4">
        <div class="w-[82%] max-w-7xl bg-white p-5 rounded-lg shadow-md shadow-[#00000048]">
            <div class="flex justify-between text-sm text-[#777]">
                <p class="m-0"><span class="text-black font-bold" >Author : </span>{{$story->author}}</p>
                <p class="m-0"><span class="text-black font-bold" >Last Updated : </span>{{$story->updated_at}}</p>
            </div>
            </div>
        </div>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    
    </div>
    <div class="flex justify-center" >
        <div id="editor" class="min-w-80 w-4/5"></div>
    </div>
    <button onclick="topFunction()" id="myBtn" class="hidden fixed bottom-5 right-7 z-[999] text-xl border-none outline-none font-semibold bg-blue-400 cursor-pointer px-4 py-3 rounded-3xl text-white transition-all duration-150 ease-in hover:scale-110 hover:shadow-lg hover:shadow-[#0000007a]" title="Go to top">Top ↑</button>
    
    <script>
        const options = {
            readOnly: true,
            modules: {
                toolbar: null
            },
            theme: 'snow'
        };
        const quill = new Quill('#editor', options);

    
        document.addEventListener('DOMContentLoaded',function(event){
            var content = `{!!$content!!}`;
            document.getElementById('editor').innerHTML = content;
        })
        window.onscroll = function() {scrollFunction()};
        let mybutton = document.getElementById("myBtn");
        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display= 'block';
            } else {
                mybutton.style.display= 'none';
            }
        }
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
        </script>
        
</x-main_page>