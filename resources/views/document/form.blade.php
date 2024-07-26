<x-main_page>
    <div class="flex justify-center" >
        <div class="w-[33%] mt-8 p-5 rounded-xl shadow-2xl shadow-[#00000063] border-solid border-gray-700 border-2" content="width=device-width, initial-scale=1.0">
            <h1 class="text-2xl font-bold text-center">Upload Document</h1>
            <form action="/store" method="post" enctype="multipart/form-data" onsubmit="return submit_checking()">
                @csrf
                <div class="form-group">
                    <div class="relative">
                        <input type="text" name="title" id="title" class="form-control" placeholder=" ">
                        <label for="title" class="form-label">Title</label>
                    </div>
                    @error('title')
                        <p class="text-red-500 text-x mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group ">
                    <div class="relative">
                        <input type="text" name="tags" id="tags" class="form-control" autocomplete="off" onkeyup="update()" placeholder=" ">
                        <label for="tags" class="form-label">Tags <span class="text-gray-500 opacity-50" >(add comma to complete a tag)</span></label>
                    </div>
                    @error('tags')
                        <p class="text-red-500 text-x mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div id="display_tags" ></div>
                <div class="form-group ">
                    <div class="relative">
                        <textarea name="description" id="description" class="form-control" rows="8" placeholder=" "></textarea>
                        <label for="description" class="form-label">Description</label>
                    </div>
                    @error('description')
                        <p class="text-red-500 text-x mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group ">
                    <div class="relative">
                        <input type="file" name="path" id="path" class="form-control" placeholder=" ">
                        <label for="path" class="form-label">Document</label>
                    </div>
                    @error('path')
                        <p class="text-red-500 text-x mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class=" flex justify-center mt-8">
                    <input type="submit" class="border-2 border-solid border-slate-600 p-1 rounded-md px-4">
                </div>
            </form>
        </div>
    </div>
</x-main_page>

<style>
    #display_tags{
        display: flex;
        flex-wrap: wrap;
        position: relative;
        div{
            margin: 0.25rem;
            padding: 0.25rem 0.75rem 0.25rem 0.75rem ;
            background-color: rgba(54, 51, 51, 0.644);
            color: white;
            font-weight: 700;
            border-radius: 0.75rem;
            cursor:pointer;
        }
    }
    #display_tags:not(:empty)::after {
        content: '( Click on tag to remove )';
        display: block;
        position: absolute;
        bottom: 0;
        right: 0;
        font-size: 0.75rem;
        color: rgb(107, 114, 128);
        /* margin-top: 5px; */
        opacity: 0.5;
    }
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
    function update(){
        let input_field = document.getElementById('tags');
        let output_div = document.getElementById('display_tags');
        let text = input_field.value;
        let current_input = output_div.innerText;
        let tags = text.split(',');

        // check there are more than on tags already added and only then add the commas 
        if(current_input.indexOf('\n')!=-1)
            current_input=current_input.replace('\n',',');

        // check if the comma is present 
        if(tags.length==1)
            return;

        // remove duplicates from the input of multiple tags
        let last = tags[tags.length-1];
        tags = Array.from(new Set(tags.slice(0,tags.length-1))).concat([last]);
        
        console.log(tags);
        console.log(current_input);
        for(let i=0;i<tags.length-1;i++){
            const new_tag = tags[i];
            const text_length = new_tag.length;
            
            // return if the tag is just all spaces
            if(new_tag == ' '.repeat(text_length)){
                alert("Empty tag (only spaces) detected and ignored")
                continue;
            }
            
            // check if the tag is already present 
            if(current_input.indexOf(new_tag,0)!=-1){
                alert('Tag = '+new_tag+' already exists !');
                continue;
            }
            // create a new div to show the tags
            let new_tag_div = document.createElement('div');
            new_tag_div.setAttribute('onclick','remove_tag(this)');
            new_tag_div.innerText = new_tag;
            output_div.appendChild(new_tag_div);
        }
        input_field.value = tags[tags.length-1];
    }
        function submit_checking(){
            if(confirm('Do you confirm the details entered?')){
            let output_div = document.getElementById('display_tags');
            let input_field = document.getElementById('tags');
            let tags_added = output_div.innerText;
            let tags = tags_added.split('\n').join(',');
            input_field.value=tags;
            console.log(tags);
            return true;
        }
        return false;
    }
    
    function remove_tag(ele){
        ele.remove();
    }
</script>