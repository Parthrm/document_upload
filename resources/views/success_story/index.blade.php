<x-main_page>
    <div class="flex flex-col items-center justify-center">
        <div class="text-center m-4 w-full bg-slate-300 text-xl font-bold p-3" >
            Success Stories
        </div>
    @if (count($story_list)==0)
        <h1 class="text-center font-bold text-2xl mt-11 text-gray-600">No Stories</h1>
    @else
        <section class="flex flex-wrap w-10/12 gap-3 justify-center" id="content_wrap">
            @foreach ($story_list as $story)
                <div class="shadow-lg transition-all ease-in-out duration-300 border-2 h-36 border-gray-200 rounded-xl min-[300px]:w-full lg:w-[45%] relative">
                    <div class="bg-blue-300 p-2 rounded-t-xl">
                        <div class="font-semibold w-[90%] overflow-hidden text-ellipsis text-nowrap">
                            {{$story->title}}
                        </div>
                        <div class="text-sm flex">
                            <div>
                                <span class="font-semibold">Author: </span>
                                <span>{{$story->author}}</span>
                            </div>
                            <div>
                                <span class="font-semibold">, Time: </span>
                                <span>{{$story->updated_at}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-sm p-2 overflow-hidden text-ellipsis text-nowrap"> 
                        {{$story->description}}
                    </div>
                    <div class="text-right p-2 text-blue-400 font-semibold underline absolute right-0 bottom-0">
                        <a href="story/{{$story->id}}">
                            Read More
                        </a>
                    </div>
                </div>
            @endforeach
        </section>
    @endif

    
</x-main_page>