@if (session()->has('success'))
    <div x-data="{show:true}" 
         x-init="setTimeout(()=> show = false,1200)" 
         x-show="show"
         class="fixed top-0 left-1/2 transform -translate-x-1/2 
         border-green-500 border-4 border-solid bg-white
         mt-4 p-5 shadow-xl shadow-[#00000067] rounded-2xl font-bold notification" >
         <p>
             {{session('success')}}
         </p>
    </div>
@endif

@if (session()->has('error'))
    <div x-data="{show:true}" 
         x-init="setTimeout(()=> show = false,1200)" 
         x-show="show"
         class="fixed top-0 left-1/2 transform -translate-x-1/2 
         border-red-500 border-4 border-solid bg-white
         mt-4 p-5 shadow-xl shadow-[#00000067] rounded-2xl font-bold notification" >
        <p>
            {{session('error')}}
        </p>
    </div>
@endif

<style>
    .notification{
        z-index: 999;
        animation: 1200ms 0ms ease-in-out pop_down;
        translate: 0 -100px;
    }
    @keyframes pop_down{
        0%{
            translate: 0 -100px;
        }
        20%{
            translate: 0 20px;
        }
        25%,85%{
            translate: 0 0;
        }
        90%{
            translate: 0 20px;
        }
        100%{
            translate: 0 -100px;
        }
    }
</style>