    <style>
        #wrapper {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            border-radius: 2rem;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th{
            padding: 0.5rem 0.75rem 0.5rem 0.75rem;
            text-align: left;
        }
        td{
            padding: 0rem 0.25rem 0rem 0.25rem;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        p {
            margin: 10px 0;
        }
        .heading{
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0.5rem 0px 0.5rem 0px ;
            text-align: center;
        }
    </style>

<div id="wrapper">
    {{-- report info div --}}
    <div>
        <h1 class="heading" >Report Information</h1>
        {{-- <h1 class="heading" >{{$distributionType?? "N/A"}}</h1> --}}
        <table>
            <tr><td><strong>Department:</strong> </td><td>{{ $departmentName ?? 'N/A' }}</td></tr>
            <tr><td><strong>Scheme:</strong> </td><td>{{ $schemeName ?? 'N/A' }}</td></tr>
            <tr><td><strong>Area:</strong> </td><td>{{ $area ?? 'N/A' }}</td></tr>
            <tr><td><strong>Area Selection:</strong></td> <td>{{ $areaSelection ?? 'N/A' }}</td></tr>
            <tr><td><strong>Aadhaar Seeded:</strong></td> <td>{{ $aadhaar ?? 'N/A' }}</td></tr>
            <tr><td><strong>Bank Linked:</strong></td> <td>{{ $bank ?? 'N/A' }}</td></tr>
            <tr><td><strong>Year From:</strong></td> <td>{{ $timeFrom ?? 'N/A' }}</td></tr>
            <tr><td><strong>Year To:</strong></td> <td>{{ $timeTo ?? 'N/A' }}</td></tr>
        </table>
    </div>
    {{-- distribution info div --}}
    <div>
        <h1 class="heading" >{{$distributionName?? "N/A"}}</h1>
        <table>
            <tr><td><strong>Department:</strong> </td><td>{{ $departmentName ?? 'N/A' }}</td></tr>
        </table>
    </div>
    @if(!empty($result))
        <h2 class="heading" >Data</h2>
        <table>
            <thead>
                <tr>
                    <th>Sr No.</th>
                    @foreach(array_keys((array) $result[0]) as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                
                </tr>
            </thead>
            <tbody>
            @php
                $i=0;
            @endphp
                @foreach($result as $row)
                <tr>
                    <td>{{ $i+=1 }}</td>
                    @foreach($row as $column => $value)
                        <td>{{ $value }}</td>
                    @endforeach
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h1 style="text-align: center;">No data available</h1>
    @endif
</div>
