<x-main_page>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.bubble.css" />
    <form action="/storeStory" method="post" onsubmit="return submit_function()">
        @csrf
        <div class="flex justify-center" >
            <div class="w-[85%] mt-8 p-5 rounded-xl shadow-2xl shadow-[#00000063] border-solid border-gray-700 border-2" content="width=device-width, initial-scale=1.0">
                <h1 class="text-2xl font-bold text-center">Create Success Story</h1>
                <div class="form-group">
                    <div class="relative">
                        <input type="text" name="title" id="title" class="form-control" placeholder=" ">
                        <label for="title" class="form-label">Title</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="relative">
                        <input type="text" name="author" id="author" class="form-control" placeholder=" ">
                        <label for="author" class="form-label">Author</label>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="relative">
                        <textarea name="description" id="description" class="form-control min-h-10" rows="3" placeholder=" "></textarea>
                        <label for="description" class="form-label">Description</label>
                    </div>
                </div>
                <div id="standalone-container" class="flex justify-center ">
                    <div class="w-[97%] relative">
                        <div id="toolbar-container" class="flex flex-wrap justify-center top-0 sticky bg-white z-[99999999]">
                            <!-- Toolbar options -->
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-indent" value="-1"></button>
                                <button class="ql-indent" value="+1"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-direction" value="rtl"></button>
                                <select class="ql-align"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-video"></button>
                                <button class="ql-formula"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean"></button>
                            </span>
                        </div>
                        <div class="flex justify-center">
                            <div id="editor" class="min-w-80 w-full"></div>
                        </div>
                        <input type="text" name="content" id="content" >
                    </div>
                </div>
                <div class=" flex justify-center mt-8">
                    <input type="submit" class="border-2 border-solid border-slate-600 p-1 rounded-md px-4">
                </div>
            </div>
        </div>
    </form>
    <button onclick="topFunction()" id="myBtn" class="hidden fixed bottom-5 right-7 z-[999] text-xl border-none outline-none font-semibold bg-blue-400 cursor-pointer px-4 py-3 rounded-3xl text-white transition-all duration-150 ease-in hover:scale-110 hover:shadow-lg hover:shadow-[#0000007a]" title="Go to top">Top ↑</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <style>
        .form-group {
            position: relative;
            margin: 1rem;
        }
    
        .form-control {
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            color: #000;
            outline: none;
            transition: border-color 0.3s;
        }
    
        .form-control:focus {
            border-color: rgb(14, 100, 180);
        }
    
        .form-label {
            position: absolute;
            top: 50%;
            left: 0.75rem;
            transform: translateY(-50%);
            background-color: transparent;
            transition: all 0.3s ease;
            pointer-events: none;
            font-size: 1rem;
            font-weight: 600;
            color: rgb(14, 100, 180);
        }
    
        .form-control:focus ~ .form-label,
        .form-control:not(:placeholder-shown) ~ .form-label {
            top: 0rem;
            left: 0.75rem;
            background-color: white;
            padding: 0 0.25rem;
            font-size: 0.75rem;
            
        }
    </style>
    <script>
        const quill = new Quill('#editor', {
            modules: {
            syntax: true,
            toolbar: '#toolbar-container',
            },
            placeholder: 'The success story to be told...',
            theme: 'snow',
        });
        function submit_function(){
            if(confirm('Have you check all the fields twice ?')){
                document.getElementById('content').value = document.getElementById('editor').innerHTML;
                return true;
            }

            return false;
        }
        window.onscroll = function() {scrollFunction()};
        let mybutton = document.getElementById("myBtn");
        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</x-main_page>