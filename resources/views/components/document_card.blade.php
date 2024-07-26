@props(['document_info','index'])
<tr>
    <td class="p-2 font-semibold text-center text-slate-500" >{{$index+1}}.</td>
    <td class="p-2 font-semibold" >{{$document_info->title}}</td>
    <td class="p-2 text-gray-500" >{{$document_info->description}}</td>
    <td>
        @php
            $tags = explode(',',$document_info->tags);
        @endphp
        <div class="flex flex-wrap" >
            @foreach ($tags as $item)
                @if ($item != ' ')
                    <div class="mx-2 m-1 px-2 text-sm bg-slate-700 text-white rounded-lg cursor-pointer" onclick="add_this(this)" > {{$item}} </div>
                @endif
            @endforeach
        </div>
        {{-- {{$document_info->tags}} --}}
    </td>
    <td>
        <div class="m-3">
            <div class="ml-2 mb-3" >

                <a href="show/{{$document_info->id}}"   
                    class="w-full transition-all duration-200 
                    bg-blue-600 font-extrabold text-white 
                    px-3 py-1 rounded-lg 
                    border-2 hover:border-solid border-blue-600
                    hover:bg-white hover:text-blue-600 " >Download</a>
            </div>
            <div class="ml-2 mt-3">
                {{-- <button onclick="delete_doc({{$document_info->id}})"   
                    class="w-full transition-all duration-200 
                    bg-red-600 font-extrabold text-white 
                    px-3 py-1 rounded-lg 
                    border-2 hover:border-solid border-red-600
                    hover:bg-white hover:text-red-600 " >Delete</button> --}}
                    <form action="delete/{{$document_info->id}}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full transition-all duration-200 
                                bg-red-600 font-extrabold text-white 
                                px-3 py-1 rounded-lg 
                                border-2 hover:border-solid border-red-600
                                hover:bg-white hover:text-red-600"
                                onclick="return confirm('Are you sure you want to delete this document?');">
                            Delete
                        </button>
                    </form>
                    
            </div>
        </div>
    </td>
</tr>
