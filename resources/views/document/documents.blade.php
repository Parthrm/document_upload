<x-main_page>
    @if (count($document_list)==0)
    <div class="container">
        No documents found in DB
    </div>
    @else
        <div class=" flex justify-center">
            <div class="w-3/4" >
                <div>
                    <input  type="text" 
                            id="query_text" 
                            name="query_text" 
                            placeholder="Search of documents" 
                            onkeyup="searchAndPaginate()"
                            class="w-1/2 px-3 py-2 my-4 placeholder-gray-600 border border-gray-300"
                    >
                    <button class="bg-slate-300 text-slate-800 text-lg font-bold px-4 py-2 rounded-lg border-2 border-solid border-black" onclick="clear_query()" >Cancel</button>
                </div>
                <div class="mb-8">
                    <table id="doc_table" class="w-full">
                        <colgroup>
                            <col span="1" style="width: 3%;">
                            <col span="1" style="width: 22%;">
                            <col span="1" style="width: 50%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 10%;">
                         </colgroup>
                        <tr class="text-lg font-semibold bg-blue-200 ">
                            <th>Index</th>
                            <th class="px-4">Title</th>
                            <th >Description</th>
                            <th>Tags</th>
                            <th>Actions</th>
                        </tr>
                        
                        @foreach ($document_list as $document)
                            <x-document_card :document_info='$document' :index="$loop->index"/>
                        @endforeach
                    </table>
                </div>
                <div id="page_links" style="position: relative; ">
                </div>
                <div id="no_elements" class="hidden text-center" >
                    There are no documents for this search.<br><br> Please change the query. 
                </div>
            </div>
        </div>
    <script>
        let currentPage = 1;
        const rowsPerPage = 10;
        const no_elements = document.getElementById("no_elements");

        function searchAndPaginate() {
            // Perform search and then paginate the results
            let filteredRows = search();
            if(filteredRows.length==0){
                no_elements.style.display = "block";
            }
            else{
                no_elements.style.display = "none";
            }
            paginate(filteredRows, currentPage);
        }
        function search() {
            const input = document.getElementById("query_text");
            const filter = input.value.toUpperCase();
            const table = document.getElementById("doc_table");
            const tr = table.getElementsByTagName("tr");
            let filteredRows = [];

            for (let i = 1; i < tr.length; i++) {
                const tds = tr[i].getElementsByTagName("td");
                let flag = false;
                for (let j = 0; j < tds.length; j++) {
                    if (tds[j]) {
                        const txtValue = tds[j].textContent || tds[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            flag = true;
                            break;
                        }
                    }
                }
                if (flag) {
                    filteredRows.push(tr[i]);
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
            return filteredRows;
        }
        function paginate(filteredRows, page) {
            const table = document.getElementById("doc_table");
            const totalRows = filteredRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const pageLinks = document.getElementById("page_links");

            // Hide all rows first
            for (let i = 1; i < table.rows.length; i++) {
                table.rows[i].style.display = 'none';
                table.rows[i].classList.remove = 'bg-slate-300';
            }

            // Calculate the start and end index for the rows to display
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Display the rows for the current page
            for (let i = start; i < end && i < totalRows; i++) {
                filteredRows[i].style.display = '';
            }

            // Update pagination links
            updatePageLinks(page, totalPages);
        }
        function updatePageLinks(currentPage, totalPages) {
            const pageLinks = document.getElementById("page_links");
            pageLinks.innerHTML = '';

            if (currentPage > 1) {
                const prevLink = document.createElement("a");
                prevLink.href = "#";
                prevLink.id = "prev_link";
                prevLink.innerHTML = "Previous";
                prevLink.onclick = function () {
                    paginate(search(), currentPage - 1);
                    return false;
                };
                pageLinks.appendChild(prevLink);
            }

            if (currentPage < totalPages) {
                const nextLink = document.createElement("a");
                nextLink.href = "#";
                nextLink.id = "next_link";
                nextLink.innerHTML = "Next";
                nextLink.onclick = function () {
                    paginate(search(), currentPage + 1);
                    return false;
                };
                pageLinks.appendChild(nextLink);
            }
        }
        function clear_query() {
            let input_field = document.getElementById('query_text');
            input_field.value = '';
            searchAndPaginate();
        }
        function add_this(ele){
            let input_field = document.getElementById('query_text');
            input_field.value = ele.innerText;
            searchAndPaginate();
        }
        // Initial call to set up the table with pagination
        window.onload = function () {
            searchAndPaginate();
        };        
        function delete_doc(id){
            if (confirm('Are you sure you want to delete this document?')) {
                $.ajax({
                    url: `/delete/${id}`,
                    method:'DELETE',
                    success: function (data) {
                        console.log('success');
                    },
                    error: function (err){
                        console.log('error occurred');
                    }
                })
            }
        }
    </script>
    @endif

</x-main_page>
<style>
    table, th, td {border: 1px solid;}
    #page_links{
        height: 1rem;
    }
    #prev_link,#next_link{
        position: absolute;
        font-size: 1rem;
        font-weight: 500;
        transition:all;
        transition-duration: 300ms;
        background: #2563eb;
        padding: 0.5rem;
        color: white;
        border-radius: 0.5rem;
    };
    #prev_link{
        left: 0;
    }
    #prev_link::before,#next_link::after{
        font-size: 1.5rem;
        font-weight: 900;
    }
    #prev_link::before{
        content: "←";
    }
    #next_link{
        right: 0;
    }
    #next_link::after{
        content: '→';
    }

    #prev_link:hover{
        ;
    }
</style>